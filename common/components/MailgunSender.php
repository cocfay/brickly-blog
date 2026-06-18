<?php
namespace common\components;

use Yii;
use \Mailgun\Mailgun;


class MailgunSender extends \yii\web\Request {

    public $MG;
    public $key;
    public $domain;
    public $fromSender;
    private $inizialized;

    public function init(){

      $this->MG = Mailgun::create($this->key);
      $this->inizialized = true;

      return $this->MG;

    }

    public function getInfo(){

      $key = substr($this->key,0,8)."....".substr($this->key,-4,4);

      return ["Inizialized" => $this->inizialized, "Domain" => $this->domain, 'ApiKey' => $key];
    }

    public function setDomain($domain){

      $this->domain = $domain;
    }

    public function setApi($apiKey){

      $this->key = $apiKey;

      $this->setMG();
    }

    public function setMG(){

      $this->MG = Mailgun::create($this->key);
    }

    public function getMailgun(){

      return $this->MG;

    }
    public function Send($parms){

        // $this->SetMG();

        try{

        $_parms = [
                    'from'=> $this->fromSender?: 'no-responder@'.$this->domain,
                    'to' => "developer@".$this->domain,
                    'subject' => 'Subject not defined',
                    'html' => '<p>Hola Mundo</p>'
                  ];

         $nParms = array_merge($_parms,$parms);

       return $this->MG->messages()->send($this->domain,$nParms);
      }catch(\Throwable $e){
        return $e->getMessage();
      }
       
    }


} 