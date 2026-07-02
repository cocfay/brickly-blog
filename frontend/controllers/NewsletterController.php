<?php
    namespace frontend\controllers;

    use Yii;
    use yii\web\Controller;
    use yii\web\Response;
    use yii\helpers\Json;
    use common\models\SendsNL;

    class NewsletterController extends Controller
    {
        public function beforeAction($action)
        {
            if ($action->id === 'subscribe') {
                $this->enableCsrfValidation = false;
            }
            return parent::beforeAction($action);
        }

        public function actionIndex()
        {
            $this->layout = false;
            return $this->render('subscribe');
        }

        public function actionEmailPreview()
        {
            $this->layout = false;
            return $this->render('subscribe');
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

            $turnstileToken = Yii::$app->request->post('cf-turnstile-response', '');
            if ($turnstileToken !== '' && !$this->verifyTurnstile($turnstileToken)) {
                Yii::$app->response->statusCode = 403;
                return [
                    'success' => false,
                    'message' => 'Verificación de seguridad fallida',
                ];
            }

            $exists = SendsNL::find()->where(['Email' => $email])->exists();
            if ($exists) {
                Yii::$app->response->statusCode = 409;
                return [
                    'success' => false,
                    'message' => 'Este correo ya está suscrito',
                ];
            }

            $model = new SendsNL();
            $model->Email = $email;

            if (!$model->save()) {
                Yii::$app->response->statusCode = 500;
                return [
                    'success' => false,
                    'message' => 'No pudimos procesar tu suscripción en este momento',
                ];
            }

            // Capturar el HTML del correo antes de cerrar el request
            $htmlContent = $this->renderPartial('_email_welcome');
            $apiKey = Yii::$app->params['brevo.apiKey'] ?? '';

            // Enviar la respuesta al cliente inmediatamente y mandar el correo después
            register_shutdown_function(function () use ($email, $htmlContent, $apiKey) {
                if (function_exists('fastcgi_finish_request')) {
                    fastcgi_finish_request();
                }
                if ($apiKey === '') return;
                $payload = \yii\helpers\Json::encode([
                    'sender' => ['email' => 'no-reply@bricklyhomes.com', 'name' => 'Brickly Homes'],
                    'to' => [['email' => $email]],
                    'subject' => 'Suscripción al blog confirmada',
                    'htmlContent' => $htmlContent,
                ]);
                $context = stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'timeout' => 10,
                        'ignore_errors' => true,
                        'header' => implode("\r\n", [
                            'api-key: ' . $apiKey,
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($payload),
                        ]),
                        'content' => $payload,
                    ],
                ]);
                @file_get_contents('https://api.brevo.com/v3/smtp/email', false, $context);
            });

            return [
                'success' => true,
                'message' => 'Gracias por suscribirte a nuestro blog.',
            ];
        }

        private function verifyTurnstile($token)
        {
            $secret = Yii::$app->params['turnstile.secretKey'] ?? '';
            if ($secret === '') return false;

            $response = @file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => http_build_query([
                        'secret' => $secret,
                        'response' => $token,
                    ]),
                ],
            ]));

            if ($response === false) return false;

            $result = json_decode($response, true);
            return !empty($result['success']);
        }
    }
