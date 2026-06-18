<?php
namespace common\components\RecoverPass;

use Yii;
use yii\helpers\Url;


class RecoverPass extends \yii\web\Request {

     public function toRecoverPass($type = 'a', $class = ""){
        

        switch ($type) {
                  case 'a':
                    return '<a class="'.$class.' small-text recover-link" data-toggle="modal" data-target="#modal-recover-pass" href="javascript:void(0);">¿Olvido su contraseña?</a>';
                    break;

                  case 'button':
                    return '<button type="button" class="'.$class.' recover-link" data-toggle="modal" data-target="#modal-recover-pass" href="javascript:void(0);">¿Olvido su contraseña?</button>';
                    break;
                  
                  default:
                    return '<a class="'.$class.' small-text recover-link" data-toggle="modal" data-target="#modal-recover-pass" href="javascript:void(0);">¿Olvido su contraseña?</a>';
                    break;
                    break;
                }        
           
    }


    public function modal(){ 
        RecoverPassAsset::register(Yii::$app->getView());
        return \Yii::$app->view->renderFile(dirname(__FILE__). '/assets/view/modal.php');
                        
    }


} 