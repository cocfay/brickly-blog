<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use common\models\PostBlog;
use common\models\SendsNL;

/**
 * Notificador de nuevos posts del blog.
 *
 * Recorre la tabla de suscriptores (suscribe) y envía un correo
 * anunciando la nueva entrada, junto con 3 artículos aleatorios
 * (que no incluyen el post recién creado).
 */
class NewPostNotifier extends Component
{
    /** Cantidad de artículos sugeridos al final del correo. */
    const RELATED_POSTS_COUNT = 3;

    /** @var string Plantilla de correo a renderizar. */
    public $viewPath = '@frontend/views/newsletter/new-post.php';

    /** @var string Remitente del correo. */
    public $fromEmail = 'no-reply@bricklyhomes.com';

    /** @var string Nombre del remitente. */
    public $fromName = 'Brickly Homes';

    /** @var string Asunto del correo. */
    public $subject = 'Nueva entrada en el blog de Brickly Homes';

    /**
     * Envía la notificación a todos los suscriptores de un nuevo post.
     *
     * @param PostBlog $post Post recién creado (con su ID persistido).
     * @return int Cantidad de correos enviados (o que se intentó enviar).
     */
    public function notifyNewPost(PostBlog $post)
    {
        if (!$post || empty($post->PostBlogID)) {
            Yii::warning('NewPostNotifier: el post no tiene ID, se omite el envío.', __METHOD__);
            return 0;
        }

        $relatedPosts = $this->fetchRelatedPosts((int)$post->PostBlogID);
        $readingTime = $this->calculateReadingTime($post);
        $htmlContent = $this->renderEmail($post, $relatedPosts, $readingTime);

        $apiKey = Yii::$app->params['brevo.apiKey'] ?? '';
        if ($apiKey === '') {
            Yii::warning('NewPostNotifier: BREVO_API_KEY no configurada, se omite el envío.', __METHOD__);
            return 0;
        }

        $subscribers = SendsNL::find()
            ->select(['Email'])
            ->where(['not', ['Email' => null]])
            ->andWhere(['<>', 'Email', ''])
            ->asArray()
            ->all();

        $sent = 0;
        foreach ($subscribers as $row) {
            $email = trim((string)($row['Email'] ?? ''));
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            if ($this->sendViaBrevo($apiKey, $email, $htmlContent)) {
                $sent++;
            }
        }

        Yii::info("NewPostNotifier: correos enviados {$sent}/" . count($subscribers) . " para el post #{$post->PostBlogID}.", __METHOD__);

        return $sent;
    }

    /**
     * Obtiene N posts aleatorios verificados, excluyendo el indicado.
     *
     * @param int $excludeId ID del post recién creado.
     * @return PostBlog[]
     */
    protected function fetchRelatedPosts($excludeId)
    {
        $query = PostBlog::find()
            ->where(['Verified' => 1])
            ->andWhere(['<>', 'PostBlogID', (int)$excludeId]);

        $total = (clone $query)->count();
        if ($total <= 0) {
            return [];
        }

        $limit = (int)min(self::RELATED_POSTS_COUNT, $total);
        $offset = $total > $limit ? random_int(0, $total - $limit) : 0;

        return $query
            ->orderBy(['PostBlogID' => SORT_DESC])
            ->offset($offset)
            ->limit($limit)
            ->all();
    }

    /**
     * Renderiza el HTML del correo.
     */
    protected function renderEmail(PostBlog $post, array $relatedPosts, $readingTime = 1)
    {
        $blogBaseUrl = Yii::$app->params['blogBaseUrl'] ?? 'https://www.bricklyhomes.com/blog';

        return Yii::$app->view->renderFile(Yii::getAlias($this->viewPath), [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'readingTime' => $readingTime,
            'blogBaseUrl' => $blogBaseUrl,
        ]);
    }

    /**
     * Calcula el tiempo de lectura estimado (en minutos) a partir del
     * contenido del post. Se consideran las descripciones de los
     * componentes de texto e imagen a una velocidad de 200 ppm.
     */
    protected function calculateReadingTime(PostBlog $post)
    {
        $words = 0;

        try {
            $components = $post->centerComponents;
            if ($components) {
                foreach ($components as $center) {
                    if ((int)$center->Type === 1 && $center->textBoxC) {
                        $words += $this->countWords($center->textBoxC->Description);
                    } elseif ((int)$center->Type === 2 && $center->imageC) {
                        $words += $this->countWords($center->imageC->Description);
                    }
                }
            }
        } catch (\Exception $e) {
            Yii::warning('NewPostNotifier: no se pudo calcular el tiempo de lectura - ' . $e->getMessage(), __METHOD__);
        }

        $minutes = (int)ceil($words / 200);
        return max(1, $minutes);
    }

    /**
     * Cuenta las palabras de un texto, eliminando etiquetas HTML.
     */
    protected function countWords($text)
    {
        $text = trim(strip_tags((string)$text));
        if ($text === '') {
            return 0;
        }
        return str_word_count($text, 0, 'áéíóúÁÉÍÓÚñÑüÜ');
    }

    /**
     * Envía un correo individual a través de la API HTTP de Brevo.
     */
    protected function sendViaBrevo($apiKey, $toEmail, $htmlContent)
    {
        $payload = Json::encode([
            'sender' => ['email' => $this->fromEmail, 'name' => $this->fromName],
            'to' => [['email' => $toEmail]],
            'subject' => $this->subject,
            'htmlContent' => $htmlContent,
        ]);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'timeout' => 15,
                'ignore_errors' => true,
                'header' => implode("\r\n", [
                    'api-key: ' . $apiKey,
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($payload),
                ]),
                'content' => $payload,
            ],
        ]);

        $result = @file_get_contents('https://api.brevo.com/v3/smtp/email', false, $context);
        if ($result === false) {
            $err = error_get_last();
            Yii::error("NewPostNotifier: error al enviar a {$toEmail} - " . ($err['message'] ?? 'desconocido'), __METHOD__);
            return false;
        }

        $statusCode = 0;
        if (!empty($http_response_header) && preg_match('/\s(\d{3})\s/', $http_response_header[0] ?? '', $m)) {
            $statusCode = (int)$m[1];
        }
        if ($statusCode < 200 || $statusCode >= 300) {
            Yii::error("NewPostNotifier: respuesta HTTP {$statusCode} al enviar a {$toEmail} - {$result}", __METHOD__);
            return false;
        }

        return true;
    }
}
