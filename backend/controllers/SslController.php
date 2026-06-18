<?php

namespace backend\controllers;
    
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\ReminderSSL;
use yii\data\ActiveDataProvider;
use backend\models\Email;
use DateTime;
use DateInterval;

date_default_timezone_set('America/New_York'); // Para Nueva York

class SslController extends Controller{


    public function actionReminderSsl(){
        $this->layout = false;
        $query = ReminderSSL::find()->all();
        $items = [];
        foreach($query as $i){
            $data = $this->obtenerVencimientoSSL($i->Text);
            $model = ReminderSSL::findOne($i->RSSLID);
            if($model->ReminderDays != $data['days_left']){
                $model->ReminderDays = $data['days_left'];
                $model->save();
            }
            if($i->ReminderDays <= 7){
                $items[] = $i;
            }
        }

        if(count($items) > 0){
            $e = Email::find()->all();
            $mails = [];
            foreach($e as $eMail){
                $mails[] = $eMail->Mail;
            }
            $text = "Exiten ".count($items)." sitios webs con menos de 8 días por vencer";
            Yii::$app->Emails->sendReminderSsl($mails, $text);
            \Yii::$app->SystemNotifications->sendPushNotificationGeneric("Certificado SSL", $text, ['weclickdigital']);
        }

    }

    public function actionSslReminder(){
        $UserData =  Yii::$app->AccessControl->Verify();
        
        $data = [];
        $this->layout = $UserData->getLayout();

        $data['model'] = new ReminderSSL;


        if($data['model']->load(Yii::$app->request->post())){
            if($data['model']->validate()){
                $nueva_url = preg_replace('/^https:\/\/(.*?)\/?$/', '$1', $data['model']->Text);
                $res = $this->obtenerVencimientoSSL($nueva_url);
                if($res['ok']){
                    $data['model']->Text = $nueva_url;
                    $data['model']->IpHosting = $res['ip_resolved'];
                    $data['model']->Date = $res['valid_to'];
                    $data['model']->ReminderDays = $res['days_left'];
                    if($data['model']->save()){
                        Yii::$app->session->setFlash('success', 'Datos agregados con exito');
                        return $this->refresh();
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'Esta url no es valida');
                    return $this->refresh();
                }
            }
        }

        $model = ReminderSSL::find()->where(['not', ['IpHosting' => null]])->orderBy(['ReminderDays' => SORT_ASC]);
    
        $data['dataProvider']  = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('ssltable', $data);
    }

    public function actionDominioReminder(){
        $UserData =  Yii::$app->AccessControl->Verify();
        
        $data = [];
        $this->layout = $UserData->getLayout();

        $data['model'] = new ReminderSSL;
        $data['dominio'] = 1;

        if(isset(Yii::$app->request->post('ReminderSSL')['RSSLID'])){
            $data['model'] = ReminderSSL::findOne(Yii::$app->request->post('ReminderSSL')['RSSLID']);
        } 

        if($data['model']->load(Yii::$app->request->post())){
            if($data['model']->validate()){
                $nueva_url = preg_replace('/^https:\/\/(.*?)\/?$/', '$1', $data['model']->Text);
                $data['model']->Text = $nueva_url;
                
                $this->ReminderDays($data['model']->Date);
                $data['model']->ReminderDays = $this->ReminderDays($data['model']->Date);
                
                if($data['model']->save()){
                    Yii::$app->session->setFlash('success', 'Datos agregados con exito');
                    return $this->refresh();
                }
            }
        }
        $model = ReminderSSL::find()->where(['IpHosting' => NULL])->orderBy(['ReminderDays' => SORT_ASC]);
    
        $data['dataProvider']  = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('ssltable', $data);
    }

    public function actionDeleteUrl($id){
        $this->layout = false;
        $model = ReminderSSL::findOne($id);

        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Registro eliminado correctamente.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        
    }

    public function ReminderDays($date){

        $fechaObjetivo = new DateTime($date);
        $hoy = new DateTime(); // Fecha actual

        $diferencia = $hoy->diff($fechaObjetivo);
        $diasRestantes = $diferencia->days;

        return $diasRestantes;
    }

    /* // Ejemplo de uso
    $res = obtenerVencimientoSSL('example.com');
    if ($res['ok']) {
        echo "Válido hasta: " . $res['valid_to'] . PHP_EOL;
        echo "Días restantes: " . ($res['days_left'] ?? 'desconocido') . PHP_EOL;
    } else {
        echo "Error: " . $res['error'] . PHP_EOL;
    } */


     public function actionIndex($t = ""){

        $UserData =  Yii::$app->AccessControl->Verify([1]);
        // 1 = Users Admin
        // 2 = Users moderador
        // Verificar en tabla TypeUsers
        $data = [];
        $this->layout = $UserData->getLayout();
        $data['model'] = new Email();

        if(isset(Yii::$app->request->post()['Email']['EmailID'])){
            $data['model'] =  Email::findOne(Yii::$app->request->post()['Email']['EmailID']);
        }

        if($data['model']->load(Yii::$app->request->post())){

           
            if(isset($t) && !empty($t))
                $data['model']->Type = 1;

            if($data['model']->save()){
                Yii::$app->session->setFlash('success','Información registrada corectamente.');
                return $this->refresh();
            }else{
                
                Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                return $this->refresh();
            }

        }

        $where = isset($t) && !empty($t) ? ['Type' => 1] : ['Type' => 0];

        $projects = Email::find()->where($where);

        $data['ProjectsProvider']  = new ActiveDataProvider([
            'query' => $projects,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);   

        $data['t'] = $t;
        
        return $this->render('index', $data);

    }

    public function actionGetDataAjax(){
        $UserData =  Yii::$app->AccessControl->Verify([1]);

        $this->layout = false;

        $query = Email::find()->where(['EmailID' => $_POST['id']])->asArray()->one();
        echo json_encode($query);
    }

    public function actionGetDataAjax2(){
        $UserData =  Yii::$app->AccessControl->Verify([1]);

        $this->layout = false;

        $query = ReminderSSL::find()->where(['RSSLID' => $_POST['id']])->asArray()->one();
        echo json_encode($query);
    }

    public function actionDelete($id){
        $UserData =  Yii::$app->AccessControl->Verify([1]);

        $this->layout = false;

        $model = Email::findOne($id);
        
        if($model->delete()){
            Yii::$app->session->setFlash('success','Datos elimados corectamente.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

}