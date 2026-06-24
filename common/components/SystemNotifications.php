<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Notifications;
use common\models\NotificationByAccount;
use common\models\TopicsNotifications;
use yii\db\Transaction;

class SystemNotifications extends Component
{
    /**
     * Crea una notificación y la asigna a múltiples cuentas.
     */

    public function create(array $notificationData, array $accountIds,  array $options = []): bool
    {
        $_options = [
            'SendPush' => false,
            'SendEmail' => false,
        ];
        $options = array_merge($_options, $options);

        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);

        try {
            $notification = new Notifications([
                'Title' => $notificationData['Title'] ?? '',
                'Body' => $notificationData['Body'] ?? '',
                'UrlIcon' => $notificationData['UrlIcon'] ?? null,
            ]);

            if (!$notification->save()) {
                $transaction->rollBack();
                $this->logError('createNotification', 'Error al guardar notificación: ' . json_encode($notification->errors));
                return false;
            }

            foreach ($accountIds as $accountId) {
                $nba = new NotificationByAccount([
                    'NotificationID' => $notification->NotificationID,
                    'AccountID' => $accountId,
                    'Status' => 'unread',
                ]);
                if (!$nba->save()) {
                    // $transaction->rollBack();
                    $this->logError('createNotification', "Error al vincular cuenta ID $accountId: " . json_encode($nba->errors));
                    // continuar con las demás cuentas
                }
            }

            $transaction->commit();

            if($options['SendPush']){
                $this->sendPushNotification($notification,$options['SendPush']);
            }

            if($options['SendEmail']){
                $this->sendByEmail($notification,$accountIds);
            }

            
            return true;

        } catch (\Throwable $e) {
            $transaction->rollBack();
            $this->logError('createNotification', 'Excepción: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Marca como leída una notificación para una cuenta.
     */
    public function markAsRead(int $notificationId, int $accountId): bool
    {
        $model = NotificationByAccount::findOne([
            'NotificationID' => $notificationId,
            'AccountID' => $accountId,
        ]);

        if ($model && $model->Status !== 'read') {
            $model->Status = 'read';
            $model->ReadAt = date('Y-m-d H:i:s');
            return $model->save();
        }

        return false;
    }

    /**
     * Devuelve las notificaciones de un usuario, opcionalmente solo no leídas.
     */
    public function getNotificationsForAccount(int $accountId, int $limit = 20, bool $onlyUnread = false)
    {
        $query = Notifications::find()
            ->alias('n')
            ->select(['n.NotificationID','n.Title','n.Body','n.UrlIcon','n.CreatedAt','nba.Status'])
            ->innerJoinWith(['notificationsByAccount nba'])
            ->where(['nba.AccountID' => $accountId])
            ->orderBy(['n.CreatedAt' => SORT_DESC])
            ->limit($limit);

        if ($onlyUnread) {
            $query->andWhere(['nba.Status' => 'unread']);
        }
        // $query->groupBy(['n.Title','n.Body','n.UrlIcon']);

        return $query->asArray()->all();
    }
    /**
     * Devuelve una notificacion especifica.
     */
    public function getNotification(int $notificationId)
    {
        $model = NotificationByAccount::findOne([
            'NotificationID' => $notificationId,
        ]);

        return $model->notification ?? false;
    }

    /**
     * Devuelve la cantidad de notificaciones no leídas de un usuario.
     */
    public function getUnreadCount(int $accountId): int
    {
        return NotificationByAccount::find()
            ->where(['AccountID' => $accountId, 'Status' => 'unread'])
            ->count();
    }

    /**
     * Marcar todas las notificaciones no leídas de un usuario como leidas.
     */
    public function markAllAsRead(int $accountId): bool
    {
        try {
            $updated = NotificationByAccount::updateAll(
                ['Status' => 'read', 'ReadAt' => date('Y-m-d H:i:s')],
                ['AccountID' => $accountId, 'Status' => 'unread']
            );

            if ($updated === false) {
                $this->logError('markAllAsRead', "Falló el update para AccountID: $accountId");
                return false;
            }

            return true;

        } catch (\Throwable $e) {
            $this->logError('markAllAsRead', $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina todas las notificaciones leidas de un usuario.
     */
    public function deleteReadNotifications(int $accountId): bool
    {
        try {
            $deleted = NotificationByAccount::deleteAll([
                'AccountID' => $accountId,
                'Status' => 'read'
            ]);

            if ($deleted === false) {
                $this->logError('deleteReadNotifications', "Falló el delete para AccountID: $accountId");
                return false;
            }

            return true;

        } catch (\Throwable $e) {
            $this->logError('deleteReadNotifications', $e->getMessage());
            return false;
        }
    }
    /**
     * Elimina una notificacion especifica de un suuario.
     */
    public function deleteNotifications(int $accountId, int $notificationId): bool
    {
        try {
            $deleted = NotificationByAccount::deleteAll([
                'AccountID' => $accountId,
                'NotificationID' => $notificationId
            ]);

            if ($deleted === false) {
                $this->logError('deleteReadNotifications', "Falló el delete para AccountID: $accountId");
                return false;
            }

            return true;

        } catch (\Throwable $e) {
            $this->logError('deleteReadNotifications', $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar notificaciones por email.
     */
    protected function sendByEmail(Notifications $notification, array $accountIds)
    {
        $subject = $notification->Title;
        $body = $notification->Body;
        // TODO
        foreach($accountIds as $aid){
            $account = Account::findOne($aid);
            $to = $account->userAccount->Email;

            $MG = \Yii::$app->mg;
		    $MG->send(['to'=>$to,'subject'=>$subject,'html'=>$body]);

        }
    }

    /**
     * Enviar notificaciones push.
     */
    protected function sendPushNotification(Notifications $notification,array $topics = [])
    {
        try {
            $title = $notification->Title;
            $body = $notification->Body;
    
            $message = "{$title} : {$body}";

            foreach($topics as $topic ){
                // $channel = $topic;
                $topic = TopicsNotifications::find()->where(['ChannelKey' => $topic])->one();
                $channel = $topic->Channel ?? null;
                if($channel){
                    $ch = curl_init('http://noti.weclickdigital.com:2080/'.$channel);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: text/plain',
                    ]);
            
                    $response = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close($ch);
            
                    if ($error) {
                        $this->logError('sendPushNotification', "cURL error: $error");
                        return false;
                    }
                }
            }
    
            return true;
    
        } catch (\Throwable $e) {
            $this->logError('sendPushNotification', $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar notificaciones Generic.
     */
    public function sendPushNotificationGeneric($title,$body,array $topics = [])
    {
        try {
    
            $message = "{$title} : {$body}";
            foreach($topics as $topic ){
                // $channel = $topic;
                $topic = TopicsNotifications::find()->where(['ChannelKey' => $topic])->one();
                $channel = $topic->Channel ?? null;
                // return $channel;
                if($channel){
                    $ch = curl_init('http://noti.weclickdigital.com:2080/'.$channel);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: text/plain',
                    ]);
            
                    $response = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close($ch);
            
                    if ($error) {
                        $this->logError('sendPushNotificationGeneric', "cURL error: $error");
                        return false;
                    }
                }
            }
    
            return true;
    
        } catch (\Throwable $e) {
            $this->logError('sendPushNotificationGenric', $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar notificaciones por email Generic.
     */
    public function sendByEmailGeneric($title, $body, array $toEmail)
    {
        // TODO
        foreach($toEmail as $to){

            $MG = \Yii::$app->mg;
		    $MG->send(['to'=>$to,'subject'=>$title,'html'=>$body]);

        }
    }

    private function logError(string $action, string $message, string $module = 'PlatformNotifications')
    {
        $userName = Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->UserName;

        $log = new \common\models\LogData([
            'Module' => $module,
            'AppliedAction' => $action,
            'UserName' => $userName,
            'TextInfo' => $message,
        ]);
        $log->save(false); // Ignorar validaciones para que no falle el log también
    }
}