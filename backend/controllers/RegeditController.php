<?php

namespace backend\controllers;

use Yii;
use common\models\TopicsNotifications;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class RegeditController extends Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::class,
    //             'actions' => ['delete' => ['POST']],
    //         ],
    //     ];
    // }

    public function actionIndex()
    {
        $data['UserData'] = $UserData =  Yii::$app->AccessControl->Verify();
			
        $this->layout = $UserData->getLayout();
        // $this->layout = "/main";
        $data = [];

        $model = new TopicsNotifications();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => TopicsNotifications::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new TopicsNotifications();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_form', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        return TopicsNotifications::findOne($id);
    }
}