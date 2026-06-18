<?php
namespace common\components\JcLocationLang;

use Yii;

use common\models\ActivitySession;
use common\models\UserAccount;


date_default_timezone_set('America/Guatemala');

class SessionActivity extends \yii\web\Request {

    public $UserData;
    public $info;

    function __construct() {
        $this->UserData = Yii::$app->user->identity;
        $this->info =  Yii::$app->LocationLang->info();
    }

    public function setUserData(UserAccount $UserData){
            $this->UserData = $UserData;
            return $this;
    }

    public function current(){

        return $this->currentSession();
    }

    public function set($data=[]){
        return $this->setActivity($data);
    }

    public function list($limit = false){
        return $this->getLastSessions($limit);
    }
    public function listActive($limit = false){
        return $this->getSessionsActive();
    }
    public function out(){

        return $this->LogoutSession();
    }

    private function setActivity($data=[]){
        // $session = Yii::$app->session;
        // if ( !$session->isActive) { $session->open(); }

        $IdSession = Yii::$app->session->getId();

        $Activity = ActivitySession::find()->where([
                                                    'AccountID' => $this->UserData->AccountID,
                                                    'Status' => 1,
                                                    'SessionID' => $IdSession,
                                                    ])->orderBy(['SessionStart'=>SORT_DESC])->one();

        if($Activity){
            if($Activity->IP != $this->info->ip){
                $Activity->Status = 0;
                $Activity->save();
                $Activity = false;
            }
        }
        
        
        if(isset($data['login'])){
            if($Activity){
               if( date('Y-m-d',strtotime($Activity->SessionStart)) == date('Y-m-d')){
                    $Activity->Activity = $data['Activity'];
                    $Activity->ActivityStatus = $data['ActivityStatus'];
                    $Activity->SessionStart = date('Y-m-d H:i:s');
                    $Activity->save();
               }else{
                    $Activity->Status = 0;
                    $Activity->save();
                    $Activity = false;
               }
            }
        }
        if(!$Activity){
            $ActivityData = [
                'IP' => $this->info->ip,
                'AccountID' => $this->UserData->AccountID,
                'UserName' => $this->UserData->UserName,
                'Device' => $this->info->device->device_type,
                'Browser' => $this->info->browser->browser_name,
                'OS'=>$this->info->Os->os_name,
                'Country' => $this->info->country_name,
                'SessionStart' => date('Y-m-d H:i:s'),
                'SessionID' => $IdSession,
                'Activity' => 'Login OK',
                'ActivityStatus' => 1
            ];
            
            $Activity = new ActivitySession($ActivityData);
        }
        if(isset($data['Status'])){
            $Activity->Status = $data['Status'];
        }

        if(isset($data['Activity']) && isset($data['ActivityStatus'])){
            $Activity->Activity = $data['Activity'];
            $Activity->ActivityStatus = $data['ActivityStatus'];
        }
        $Activity->DateActivity = date('Y-m-d H:i:s');
        if($Activity->save()){
            return true;
        }else{
            return false;
        }

    }


    private function getLastSessions($limit = false){

        $Activity = ActivitySession::find()->where(['AccountID' => $this->UserData->AccountID])->orderBy(['DateActivity'=>SORT_DESC]);

        if($limit){
            $Activity->limit($limit);
        }
        return $Activity->all();

    }
    private function getSessionsActive($limit = false){

        $Activity = ActivitySession::find()->where(['AccountID' => $this->UserData->AccountID,'Status'=>1])->orderBy(['DateActivity'=>SORT_DESC]);

        if($limit){
            $Activity->limit($limit);
        }
        return $Activity->all();

    }

    private function currentSession(){

        return (Object) [
            'IP' => $this->info->ip,
            'AccountID' => $this->UserData->AccountID,
            'UserName' => $this->UserData->UserName,
            'Device' => $this->info->device->device_type,
            'Browser' => $this->info->browser->browser_name,
            'OS'=>$this->info->Os->os_name,
            'CountyLocation' => $this->info->country_name,
            'SessionID' => Yii::$app->session->getId()
        ];

    }

    private function LogoutSession(){
        $Activity = ActivitySession::find()->where([
            'AccountID' => $this->UserData->AccountID,
            'SessionID' => Yii::$app->session->getId(),
            'Status' => 1
            ])->orderBy(['SessionStart'=>SORT_DESC])->one();

        if($Activity){
            $Activity->Status = 0;
            $Activity->save();
        }

    }




} 