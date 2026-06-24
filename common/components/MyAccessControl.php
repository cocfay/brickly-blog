<?php
namespace common\components;

use Yii;


class MyAccessControl extends \yii\web\Request {

     public function Verify($Array = NULL){

            if(!Yii::$app->user->isGuest){
                Yii::$app->SessionActivity->set();
                if($Array == NULL)
                    return Yii::$app->user->identity;
                    
                if(in_array(Yii::$app->user->identity->TypeUser, $Array))
                    return Yii::$app->user->identity;
            }
       Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('/'));
        Yii::$app->end();
        return FALSE;
       
    }

    public function MenuOptiions(){

          $UserAccount = Yii::$app->user->identity;
          $ListM = [];
          foreach ($UserAccount->userByRoles as $ur) {

              foreach($ur->role->menuByRole as $m){
     
                if(!isset($ListM[$m->MenuID])){
                    $ListM[$m->MenuID] = $m->menu;
                }
              }
          }
        return $ListM;
       
    }


} 