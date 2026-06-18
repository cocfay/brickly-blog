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
			$infoUs = Yii::$app->LocationLang->info();
			$lang = $infoUs->language->LanguageCode;

			Yii::$app->language = $lang;
			// if(yii::$app->params['CounterPlatform'] > 0 ){
			// 	$this->redirect(Yii::$app->urlManager->createUrl('/'));
			// }
    	}

		public function actionIndex()
		{
			$data = [];
			$this->layout = "/lead"; //archivo para el header y footer, dentro de la carpeta layouts tiene que tener el mismo nombre

			$infoUs = Yii::$app->LocationLang->info();
			$data['lang'] = $infoUs->language->LanguageCode;
			
			$data['result'] = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 0])
			->orderBy(['CreateAt' => SORT_DESC]);

			$data['pagination'] = new Pagination([
				'defaultPageSize' => 7,
				'totalCount' => $data['result']->count(),
			]);

			$data['result'] = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 0])
			->orderBy(['CreateAt' => SORT_DESC])
			->offset($data['pagination']->offset)
			->limit($data['pagination']->limit)->all();

			$data['tendencia'] = PostBlog::find()
			->where(['Verified' => 1, 'Featured' => 1])
			->orderBy(new Expression('RAND('.rand().')'))
			->limit(3)->all();

			return $this->render('index', $data);

		}

		public function actionPost($id)
		{
			$data = [];
			$this->layout = "/lead"; //archivo para el header y footer, dentro de la carpeta layouts tiene que tener el mismo nombre

			$infoUs = Yii::$app->LocationLang->info();
			$data['lang'] = $infoUs->language->LanguageCode;

			$data['model'] = PostBlog::find()->where(['PostBlogID' => $id])->orderBy(['PostBlogID' => SORT_DESC])->one();
			$data['model']->VTitle = $data['model']->Title;
			$data['Components'] = $data['model']->centerComponents ?: [];

			/* ######################################################################################################################### */

			$seed = rand();
			$data['more'] = PostBlog::find()->where(['!=', 'PostBlogID', $id])->andWhere(['Verified' => 1])->orderBy(new Expression('RAND(' . $seed . ')'))->limit(3)->all();
			
			return $this->render('post', $data);

		}

		public function actionCategories($id){

			$data = [];
			$this->layout = "/lead"; //archivo para el header y footer, dentro de la carpeta layouts tiene que tener el mismo nombre

			$infoUs = Yii::$app->LocationLang->info();
			$data['lang'] = $infoUs->language->LanguageCode;

			$data['model'] = Collections::find()->where(['CollectionID' => $id])->one();
			$postsQuery = $data['model']->getPosts();

			$data['pagination'] = new Pagination([
				'defaultPageSize' => 6,
				'totalCount' => $postsQuery->count(),
			]);

			$data['posts'] = $postsQuery->orderBy(['PostBlogID' => SORT_DESC])
			->offset($data['pagination']->offset)
			->limit($data['pagination']->limit)->all();

			return $this->render('categoria', $data);
		}
    }