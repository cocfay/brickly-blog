<?php
namespace common\components\JcAwsTranslate;

use Yii;
use Aws\Translate\TranslateClient;
use Aws\Exception\AwsException;
use common\models\LogTranslate;

class JcAwsTranslate extends \yii\web\Request {

    public $currentLanguage;
    public $targetLanguage;
    public $textToTranslate;
    public $client;

    public function init(){

      $this->client = new TranslateClient([
          'profile' => 'default',
          'region' => 'us-east-1',
          'version' => 'latest'
      ]);

      return $this;

    }

    public function setCurrentLG($c){
      $this->currentLanguage = $c;
    }

    public function setTargetLG($t){
      $this->targetLanguage = $t;
    }

    public function translate($text="",$_options=[]){



     $modelLog = new LogTranslate([
                                  'ReferrerUrl'=> Yii::$app->request->referrer,
                                  'CurrentUrl' => Yii::$app->request->url
                              ]);

     $modelLog->save();
        
      $options = ['CurrentLG' => $this->currentLanguage, 'TargetLG' => $this->targetLanguage];
      if(is_array($_options)){
        $options = array_merge($options,$_options);
      }

      try {
          $result = $this->client->translateText([
              'SourceLanguageCode' => $options['CurrentLG'],
              'TargetLanguageCode' => $options['TargetLG'],
              'Text' => $text,
          ]);
          return (Object)['error'=> false, 'text'=> $result['TranslatedText']];
      } catch(AwsException $e) {
          // output error message if fails
          return (Object)['error' => true, 'message' => "Failed: ".$e->getMessage()];
      }


    }


} 