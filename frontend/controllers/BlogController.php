<?php 
	namespace frontend\controllers;

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;

	use common\models\PostBlog;
	use common\models\PostBlogTitle;
	use common\models\ChecklistFilesForm;
	use common\models\BlogByProject;

	use yii\db\Expression;
	use yii\data\Pagination;
	use yii\helpers\Json;
	use yii\web\Response;

	use common\models\PostBlogCenterComponents;

	use common\models\TextBoxComponents;
	use common\models\TextBoxComponentsData;

	use common\models\ImagesComponents;
	use common\models\ImagesComponentsDescription;

	use common\models\YtVideoComponents;

	use common\models\Collections;

	class BlogController extends Controller
	{

		public function init(){
			parent::init();
			Yii::$app->language = 'es';
			// if(yii::$app->params['CounterPlatform'] > 0 ){
			// 	$this->redirect(Yii::$app->urlManager->createUrl('/'));
			// }
    	}

		public function actionIndex()
		{
			$data = [];
			$this->layout = "/lead"; //archivo para el header y footer, dentro de la carpeta layouts tiene que tener el mismo nombre

			$data['lang'] = 'es';

			// Obtener el artículo destacado (Featured = 1) como hero
			$data['featuredPost'] = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 1])
			->one();

			$excludeIds = [];
			if ($data['featuredPost']) {
				$excludeIds[] = $data['featuredPost']->PostBlogID;
			}
			
			$data['result'] = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 0])
			->andFilterWhere(['not in', 'PostBlogID', $excludeIds])
			->orderBy(['CreateAT' => SORT_DESC]);

			$data['pagination'] = new Pagination([
				'defaultPageSize' => 10,
				'totalCount' => $data['result']->count(),
			]);

			$data['result'] = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 0])
			->andFilterWhere(['not in', 'PostBlogID', $excludeIds])
			->orderBy(['CreateAT' => SORT_DESC])
			->offset($data['pagination']->offset)
			->limit($data['pagination']->limit)->all();

			$data['tendencia'] = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 1])
			->andFilterWhere(['not in', 'PostBlogID', $excludeIds])
			->orderBy(new Expression('RAND('.rand().')'))
			->limit(3)->all();

			$data['categories'] = Collections::find()
			->alias('c')
			->select([
				'c.CollectionID',
				'c.NameEs',
				'post_count' => new Expression('COUNT(DISTINCT p.PostBlogID)'),
			])
			->innerJoin('{{%CollectionByPost}} cbp', 'cbp.CollectionID = c.CollectionID')
			->innerJoin('{{%PostBlog}} p', 'p.PostBlogID = cbp.PostBlogID AND p.Verified = 1')
			->where(['c.Display' => 1])
			->groupBy(['c.CollectionID', 'c.NameEs'])
			->orderBy(['post_count' => SORT_DESC, 'c.NameEs' => SORT_ASC])
			->asArray()
			->all();

			$data['featuredProperties'] = $this->getFeaturedProperties();

			return $this->render('index', $data);

		}

		public function actionLoadMore($offset = 0, $limit = 6)
		{
			Yii::$app->response->format = Response::FORMAT_JSON;

			$offset = max(0, (int) $offset);
			$limit = max(1, min(12, (int) $limit));

			$query = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 0])
			->with(['blogBy'])
			->orderBy(['CreateAT' => SORT_DESC]);

			$total = (clone $query)->count();
			$posts = $query
			->offset($offset)
			->limit($limit)
			->all();

			$html = '';
			foreach ($posts as $post) {
				$html .= $this->renderPartial('_postCard', ['datos' => $post]);
			}

			$nextOffset = $offset + count($posts);

			return [
				'success' => true,
				'html' => $html,
				'nextOffset' => $nextOffset,
				'hasMore' => $nextOffset < $total,
			];
		}

		public function actionSearch($q = '')
		{
			$data = [];
			$this->layout = "/lead";
			$data['lang'] = 'es';

			$search = trim((string) $q);
			$postsQuery = $this->searchPostsQuery($search);

			$data['pagination'] = new Pagination([
				'defaultPageSize' => 6,
				'totalCount' => $postsQuery->count(),
			]);

			$data['posts'] = $postsQuery
			->offset($data['pagination']->offset)
			->limit($data['pagination']->limit)
			->all();
			$data['search'] = $search;

			return $this->render('search', $data);
		}

		public function actionSearchLoadMore($offset = 0, $limit = 6, $q = '')
		{
			Yii::$app->response->format = Response::FORMAT_JSON;

			$offset = max(0, (int) $offset);
			$limit = max(1, min(12, (int) $limit));
			$search = trim((string) $q);

			$query = $this->searchPostsQuery($search);
			$total = (clone $query)->count();
			$posts = $query
			->offset($offset)
			->limit($limit)
			->all();

			$html = '';
			foreach ($posts as $post) {
				$html .= $this->renderPartial('_postCard', ['datos' => $post]);
			}

			$nextOffset = $offset + count($posts);

			return [
				'success' => true,
				'html' => $html,
				'nextOffset' => $nextOffset,
				'hasMore' => $nextOffset < $total,
				'total' => $total,
			];
		}

		protected function getFeaturedProperties($limit = 3)
		{
			$limit = max(1, (int) $limit);
			$cacheKey = 'blog_featured_properties';
			$endpoint = 'https://ws-identity.bricklyhomes.com/properties?featured.isActive=true';
			$baseMediaUrl = 'https://ws-identity.bricklyhomes.com/';

			$cachedProperties = Yii::$app->cache->get($cacheKey);
			if (is_array($cachedProperties) && !empty($cachedProperties)) {
				shuffle($cachedProperties);

				return array_slice($cachedProperties, 0, $limit);
			}

			$context = stream_context_create([
				'http' => [
					'method' => 'GET',
					'timeout' => 10,
					'ignore_errors' => true,
					'header' => "Accept: application/json\r\n",
				],
			]);

			$response = @file_get_contents($endpoint, false, $context);

			if (($response === false || $response === '') && function_exists('curl_init')) {
				$curl = curl_init($endpoint);
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 5,
					CURLOPT_TIMEOUT => 10,
					CURLOPT_HTTPHEADER => ['Accept: application/json'],
				]);

				$response = curl_exec($curl);
				curl_close($curl);
			}

			if ($response === false) {
				return [];
			}

			$payload = Json::decode($response);
			if (empty($payload['data']) || !is_array($payload['data'])) {
				return [];
			}

			$properties = array_map(function ($property) use ($baseMediaUrl) {
				$photos = isset($property['media']['photos']) && is_array($property['media']['photos']) ? $property['media']['photos'] : [];
				$mainPhoto = null;

				foreach ($photos as $photo) {
					if (!empty($photo['isMain'])) {
						$mainPhoto = $photo;
						break;
					}
				}

				if ($mainPhoto === null && !empty($photos[0])) {
					$mainPhoto = $photos[0];
				}

				$imagePath = '';
				if (!empty($mainPhoto['thumbnail'])) {
					$imagePath = $mainPhoto['thumbnail'];
				} elseif (!empty($mainPhoto['path'])) {
					$imagePath = $mainPhoto['path'];
				}

				return [
					'id' => $property['_id'] ?? null,
					'title' => $property['market']['title'] ?? 'Propiedad destacada',
					'location' => trim(implode(', ', array_filter([
						$property['location']['zone'] ?? null,
						$property['location']['department'] ?? null,
					]))),
					'priceUSD' => $property['market']['priceUSD'] ?? null,
					'image' => $imagePath ? $baseMediaUrl . ltrim($imagePath, '/') : '',
					'url' => !empty($property['_id']) ? 'https://www.bricklyhomes.com/propiedad/' . $property['_id'] : 'https://www.bricklyhomes.com/',
				];
			}, $payload['data']);

			$properties = array_values(array_filter($properties, function ($property) {
				return !empty($property['id']);
			}));

			if (empty($properties)) {
				return [];
			}

			shuffle($properties);
			Yii::$app->cache->set($cacheKey, $properties, 600);

			return array_slice($properties, 0, $limit);
		}

		public function actionPost($id)
		{
			$data = [];
			$this->layout = "/lead"; //archivo para el header y footer, dentro de la carpeta layouts tiene que tener el mismo nombre

			$data['lang'] = 'es';

			$data['model'] = PostBlog::find()->where(['PostBlogID' => $id])->orderBy(['PostBlogID' => SORT_DESC])->one();
			$data['model']->VTitle = $data['model']->Title;
			$data['Components'] = $data['model']->centerComponents ?: [];
			$data['featuredProperties'] = $this->getFeaturedProperties();

			/* ######################################################################################################################### */

			$moreTopicsQuery = $this->postMoreTopicsQuery($id);
			$data['moreTopicsTotal'] = (clone $moreTopicsQuery)->count();
			$initialMoreTopics = $moreTopicsQuery
			->limit(6)
			->all();

			$data['relatedPosts'] = array_slice($initialMoreTopics, 0, 3);
			$data['moreTopics'] = array_slice($initialMoreTopics, 3, 3);
			$data['moreTopicsLoaded'] = count($initialMoreTopics);
			$data['more'] = $data['relatedPosts'];
			
			return $this->render('post', $data);

		}

		public function actionPostMoreTopics($id, $offset = 0, $limit = 6)
		{
			Yii::$app->response->format = Response::FORMAT_JSON;

			$offset = max(0, (int) $offset);
			$limit = max(1, min(12, (int) $limit));

			$query = $this->postMoreTopicsQuery($id);
			$total = (clone $query)->count();
			$posts = $query
			->offset($offset)
			->limit($limit)
			->all();

			$html = '';
			foreach ($posts as $post) {
				$html .= $this->renderPartial('_postCard', ['datos' => $post]);
			}

			$nextOffset = $offset + count($posts);

			return [
				'success' => true,
				'html' => $html,
				'nextOffset' => $nextOffset,
				'hasMore' => $nextOffset < $total,
			];
		}

		public function actionCategories($id){

			$data = [];
			$this->layout = "/lead"; //archivo para el header y footer, dentro de la carpeta layouts tiene que tener el mismo nombre

			$data['lang'] = 'es';

			$data['model'] = Collections::find()->where(['CollectionID' => $id])->one();
			if (!$data['model']) {
				throw new \yii\web\NotFoundHttpException('La categoría solicitada no existe.');
			}

			$search = trim((string) Yii::$app->request->get('q', ''));
			$postsQuery = $this->categoryPostsQuery($id, $search);

			$data['pagination'] = new Pagination([
				'defaultPageSize' => 6,
				'totalCount' => $postsQuery->count(),
			]);

			$data['posts'] = $postsQuery
			->offset($data['pagination']->offset)
			->limit($data['pagination']->limit)->all();
			$data['search'] = $search;

			return $this->render('categoria', $data);
		}

		public function actionCategoryLoadMore($id, $offset = 0, $limit = 6, $q = '')
		{
			Yii::$app->response->format = Response::FORMAT_JSON;

			$offset = max(0, (int) $offset);
			$limit = max(1, min(12, (int) $limit));
			$search = trim((string) $q);

			$query = $this->categoryPostsQuery($id, $search);
			$total = (clone $query)->count();
			$posts = $query
			->offset($offset)
			->limit($limit)
			->all();

			$html = '';
			foreach ($posts as $post) {
				$html .= $this->renderPartial('_postCard', ['datos' => $post]);
			}

			$nextOffset = $offset + count($posts);

			return [
				'success' => true,
				'html' => $html,
				'nextOffset' => $nextOffset,
				'hasMore' => $nextOffset < $total,
				'total' => $total,
			];
		}

		private function categoryPostsQuery($categoryId, $search = '')
		{
			$query = PostBlog::find()
			->alias('p')
			->innerJoin('{{%CollectionByPost}} cbp', 'cbp.PostBlogID = p.PostBlogID')
			->leftJoin('{{%PostBlogTitle}} pbt', "pbt.PostBlogID = p.PostBlogID AND pbt.Lang = 'es'")
			->where([
				'cbp.CollectionID' => (int) $categoryId,
				'p.Verified' => 1,
			])
			->select('p.*')
			->with(['blogBy', 'centerComponents'])
			->orderBy(['p.CreateAT' => SORT_DESC]);

			if ($search !== '') {
				$query->andWhere(['like', 'pbt.Data', $search]);
			}

			return $query;
		}

		private function postMoreTopicsQuery($postId)
		{
			return PostBlog::find()
			->where(['Verified' => 1])
			->andWhere(['!=', 'PostBlogID', (int) $postId])
			->with(['blogBy'])
			->orderBy(['CreateAT' => SORT_DESC]);
		}

		private function searchPostsQuery($search = '')
		{
			$query = PostBlog::find()
			->alias('p')
			->leftJoin('{{%PostBlogTitle}} pbt', "pbt.PostBlogID = p.PostBlogID AND pbt.Lang = 'es'")
			->leftJoin('{{%CollectionByPost}} cbp', 'cbp.PostBlogID = p.PostBlogID')
			->leftJoin('{{%Collection}} c', 'c.CollectionID = cbp.CollectionID')
			->leftJoin('{{%TextBoxComponents}} tbc', 'tbc.PostBlogID = p.PostBlogID')
			->leftJoin('{{%TextBoxComponentsData}} tbcd', "tbcd.TexBoxComponentID = tbc.TexBoxComponentID AND tbcd.Lang = 'es'")
			->where([
				'p.Verified' => 1,
				'p.Featured' => 0,
			])
			->select('p.*')
			->distinct()
			->with(['blogBy'])
			->orderBy(['p.CreateAT' => SORT_DESC]);

			if ($search === '') {
				$query->andWhere('1 = 0');

				return $query;
			}

			$query->andWhere([
				'or',
				['like', 'pbt.Data', $search],
				['like', 'c.NameEs', $search],
				['like', 'tbcd.Data', $search],
			]);

			return $query;
		}

		public function actionSubscribe()
		{
			Yii::$app->response->format = Response::FORMAT_JSON;

			if (!Yii::$app->request->isPost) {
				Yii::$app->response->statusCode = 405;
				return [
					'success' => false,
					'message' => 'Método no permitido',
				];
			}

			$email = trim((string) Yii::$app->request->post('email', ''));

			if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
				Yii::$app->response->statusCode = 422;
				return [
					'success' => false,
					'message' => 'Ingresa un correo válido',
				];
			}

			$endpoint = 'https://ws-identity.bricklyhomes.com/contact/subscribe';
			$payload = Json::encode([
				'email' => $email,
			]);

			$context = stream_context_create([
				'http' => [
					'method' => 'POST',
					'timeout' => 15,
					'ignore_errors' => true,
					'header' => implode("\r\n", [
						'Content-Type: application/json',
						'Accept: application/json',
						'Content-Length: ' . strlen($payload),
					]),
					'content' => $payload,
				],
			]);

			$response = @file_get_contents($endpoint, false, $context);
			$statusCode = 500;

			if (!empty($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $matches)) {
				$statusCode = (int) $matches[1];
			}

			$decoded = [];
			if ($response !== false && $response !== '') {
				try {
					$decoded = Json::decode($response);
				} catch (\Throwable $e) {
					$decoded = [];
				}
			}

			$message = isset($decoded['message']) && is_string($decoded['message'])
				? trim($decoded['message'])
				: '';

			if ($statusCode >= 200 && $statusCode < 300) {
				return [
					'success' => true,
					'message' => 'Gracias por suscribirte.',
				];
			}

			if ($message === 'Este correo ya está suscrito') {
				Yii::$app->response->statusCode = 409;
				return [
					'success' => false,
					'message' => 'Este correo ya está suscrito',
				];
			}

			Yii::$app->response->statusCode = $statusCode >= 400 ? $statusCode : 500;

			return [
				'success' => false,
				'message' => $message ?: 'No pudimos procesar tu suscripción en este momento',
			];
		}
    }
