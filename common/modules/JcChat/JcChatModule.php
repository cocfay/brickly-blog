<?php
namespace common\modules\JcChat;
use Yii;
class JcChatModule extends \yii\base\Module
{
    public $controllerNamespace = 'common\modules\JcChat\controllers';

    public function init()
    {
        parent::init();
        // inicializaciones personalizadas si es necesario

        if(Yii::$app->user->isGuest) {
            $IsSetUserKey = Yii::$app->session->get('user_guest_key');
            if(!$IsSetUserKey){
                $UserKey = Yii::$app->security->generateRandomString(12);
            }else{
                $UserKey = $IsSetUserKey;
            }

        }else{
            $UserKey = Yii::$app->user->identity->getPrimaryKey();
        }

        Yii::$app->session->set('user_guest_key', $UserKey);
    }

    public function ShowClient(){
        return \Yii::$app->runAction('jc-chat/chat/bubble-button-client',[]);
    }

    public function ShowPanel($token = false){
        $data = ['partial' => true, 'id' => $token];
        return \Yii::$app->runAction('jc-chat/chat/panel-support',$data);
    }

    public function PushNotification($msg, $keys){
        $keys = (array) $keys;
        $msg = (string) $msg;
        // if(\Yii::$app->SystemNotifications){
            if(!empty($msg) && count($keys) > 0){
                return \Yii::$app->SystemNotifications->sendPushNotificationGeneric('', $msg, $keys);
            }
        // }
    }
}
