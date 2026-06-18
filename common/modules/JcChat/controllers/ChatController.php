<?php

namespace common\modules\JcChat\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\JcChat\models\ChatRoom;
use common\modules\JcChat\models\ChatMessage;

date_default_timezone_set('America/Guatemala');
class ChatController extends Controller
{
    public $enableCsrfValidation = false;

     public function actionTest(){

        return var_dump($this->module->PushNotification("Cliente en linea, se ha iniciado chat en elinea: ","Chat"));
    }

    public function actionBubbleButtonClient(){
        $data = [];
        return $this->renderPartial('chat-main-button');
    }


    public function actionInit()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $token = Yii::$app->session->get('chat_token');
        $room = null;

        if ($token) {
            $room = ChatRoom::findOne(['token' => $token, 'status' => 'active']);
        }

        if($room){
            return $this->renderPartial('bodychat', ['room' => $room]);
        }else{
            $data = [];

            $data['EnableChat'] = (date('H') >= 8 && date('H') < 18)? true : false; 
            return $this->renderPartial('startchat',$data);

        }
    }

    public function actionStart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $room = new ChatRoom();
        $room->token = Yii::$app->security->generateRandomString(16);
        $room->created_at = time();
        $room->updated_at = $room->created_at;
        $room->status = 'active';

        if ($room->save()) {
            Yii::$app->session->set('chat_token', $room->token);
            // 🔵 Comentario: Sala de chat recién creada
            $urlChat = Url::to(['/jc-chat/chat/panel-support','id'=>$room->token],true);
            $this->module->PushNotification("Cliente en linea, se ha iniciado chat en elinea: ".$urlChat,"Chat");
            return ['success' => true];
        }

        return ['success' => false];
    }

    public function actionSend($idroom = false)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!$idroom){
            $token = Yii::$app->session->get('chat_token');
            $room = ChatRoom::findOne(['token' => $token, 'status' => 'active']);
        }else{
            $room = ChatRoom::findOne(['id' => $idroom, 'status' => 'active']);
        }

        $sender = Yii::$app->session->get('user_guest_key');

        if (!$room) return ['success' => false];

        $token = $room->token;

        $message = new ChatMessage();
        $message->room_id = $room->id;
        $message->text = Html::encode(Yii::$app->request->post('message'));
        $message->created_at = time();
        $message->sender = $sender;

        // Imagen adjunta
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {

            $baseChatPath =  $filePath = Yii::$app->basePath.'/../images/chats/';

            if (!is_dir($baseChatPath)) {
                if (!mkdir($baseChatPath, 0775, true) && !is_dir($baseChatPath)) {
                    return ['success' => false];
                }
            }

            $baseChatPath =  $filePath = Yii::$app->basePath.'/../images/chats/' . $token.'/';
            if (!is_dir($baseChatPath)) {
                if (!mkdir($baseChatPath, 0775, true) && !is_dir($baseChatPath)) {
                    return ['success' => false];
                }
            }

            $fileName = 'chat_' . time() . '.' . $file->extension;
            $filePath = $baseChatPath . $fileName;
            if ($file->saveAs($filePath)) {
                $message->image = '/images/chats/' . $token . '/' . $fileName;
            }
        }

        // 🔵 Comentario: Cuando se envía un mensaje luego de 3 minutos del último
        $last = ChatMessage::find()->where(['room_id' => $room->id])
            ->orderBy(['created_at' => SORT_DESC])->one();

        if ($last && (time() - $last->created_at) > 180) {
            // enviar notificiacion: el usuario {$message->sender} ha reanudado el chat id : {$room->id}
            $urlChat = Url::to(['/jc-chat/chat/panel-support','id'=>$room->token],true);
            $this->module->PushNotification("Se ha reanudado un chat en linea: ".$urlChat,"chat-reanudado");

        }

        if ($message->save()) {
            $room->updated_at = time();
            $room->save(false);
            return ['success' => true];
        }else{
            return $message->getErrors();
        }

        return ['success' => false];
    }

    public function actionFetch($id=false)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!$id){
            $token = Yii::$app->session->get('chat_token');
            $room = ChatRoom::findOne(['token' => $token, 'status' => 'active']);
            if (!$room) return ['room_closed'=>true];
        }else{
            $token = $id;
             $room = ChatRoom::findOne(['id' => $token]);
            if (!$room) return ['room_closed'=>true];;
        }
        $sender = Yii::$app->session->get('user_guest_key');

        $messages = ChatMessage::find()->where(['room_id' => $room->id])->orderBy('created_at ASC')->all();
        $response = [];

        foreach ($messages as $msg) {
            $response[] = [
                'id' => $msg->id,
                'text' => $msg->text,
                'image' => $msg->image,
                'time' => date('H:i', $msg->created_at),
                'creator' => $msg->sender == $sender? 1 : 0,
                'is_read' => $msg->is_read,
                'sender' => $msg->sender
            ];
        }

        return $response;
    }

    public function actionTyping()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $token = Yii::$app->session->get('chat_token');
        $room = ChatRoom::findOne(['token' => $token, 'status' => 'active']);
        if ($room) {
            $room->is_typing = 1;
            $room->save(false);
        }
        return ['success' => true];
    }

    public function actionReadMessages($id=false,$room=false)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!$room){
            $token = Yii::$app->session->get('chat_token');
            $chatsNotRead = ChatMessage::find()->joinWith(['room'])->where(["chat_room.token" => $token, "chat_message.is_read" => 0]);
        }else{
            $chatsNotRead = ChatMessage::find()->joinWith(['room'])->where(["chat_room.id" => $room, "chat_message.is_read" => 0]);
        }
        
        $sender = Yii::$app->session->get('user_guest_key');

        
        $chatsNotRead->andWhere(['<>','chat_message.sender', $sender]);


        if($id){
            $messages = $chatsNotRead->andWhere(['chat_message.id' => $id])->all();
        }else{
            $messages = $chatsNotRead->all();
        }

        // var_dump($messages); exit();
        foreach($messages as $message){
            $message->is_read = 1;
            $message->save();
        }
        return ['success' => true];
    }

    public function actionStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $token = Yii::$app->session->get('chat_token');
        $room = ChatRoom::findOne(['token' => $token]);
        return ['typing' => $room ? (bool)$room->is_typing : false];
    }
    public function actionEnd($room = false)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!$room){
            $token = Yii::$app->session->get('chat_token');
            $room = ChatRoom::findOne(['token' => $token]);
        }else{
            $room = ChatRoom::findOne(['id' => $room]);
        }
        if ($room) {
            $room->status = 'closed';
            $room->save(false);

            Yii::$app->session->remove('chat_token');

            // 🔵 Comentario: Cuando se finaliza el chat
            return ['success' => true];
        }
        return ['success' => false];
    }


    public function actionPanelSupport($partial = false,$id=false)
    {
        $activeChats = ChatRoom::find()->where(['status' => 'active'])->orderBy(['updated_at'=>SORT_DESC])->all();
        $closedChats = ChatRoom::find()->where(['status' => 'closed'])->orderBy(['updated_at'=>SORT_DESC])->limit(10)->all();

        $pathValid = Yii::$app->basePath;
        $webValid = \Yii::getAlias('@web');

        $pathBase = explode('/',$pathValid);
        $webBase = explode('/',$webValid);

        $raizFolder =  $pathBase[(count($pathBase) - 2)] ?? null;

        $raizFolderWeb =  $webBase[(count($webBase) - 2)] ?? null;

        $UrlWeb = $webValid; 
        if($raizFolder && $raizFolderWeb && $raizFolder == $raizFolderWeb){
            $UrlWeb .= '/..';
        }

        $PreActiveChat = false;
        if($id){
            $PreActiveChat = ChatRoom::findOne(['token' => $id]);
        }


        if($partial){
            return $this->renderPartial('panel-support', [
                'activeRooms' => $activeChats,
                'closedRooms' => $closedChats,
                'UrlWeb' => $UrlWeb,
                'PreActive' => $PreActiveChat
            ]);

        }else{
            $this->layout = "@webroot/common/modules/JcChat/views/layouts/simpleCpanel";
            return $this->render('panel-support', [
                'activeRooms' => $activeChats,
                'closedRooms' => $closedChats,
                'UrlWeb' => $UrlWeb,
                'PreActive' => $PreActiveChat
            ]);
        }
    }

    public function actionLoadChat($room_id)
    {
        $chatRoom = ChatRoom::findOne($room_id);
        if (!$chatRoom) {
            return "Chat no encontrado.";
        }

        $sender = Yii::$app->session->get('user_guest_key');

        $messages = ChatMessage::find()
            ->where(['room_id' => $room_id])
            ->orderBy(['created_at' => SORT_ASC])
            ->all();


        $pathValid = Yii::$app->basePath;
        $webValid = \Yii::getAlias('@web');

        $pathBase = explode('/',$pathValid);
        $webBase = explode('/',$webValid);

        $raizFolder =  $pathBase[(count($pathBase) - 2)] ?? null;

        $raizFolderWeb =  $webBase[(count($webBase) - 2)] ?? null;

        $UrlWeb = $webValid; 
        if($raizFolder && $raizFolderWeb && $raizFolder == $raizFolderWeb){
            $UrlWeb .= '/..';
        }

        return $this->renderPartial('chat-body-support', [
            'chatRoom' => $chatRoom,
            'messages' => $messages,
            'roomId' => $chatRoom->id,
            'sender' => $sender,
            'UrlWeb' => $UrlWeb
        ]);
    }

    public function actionCheckNewMessages()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $sender = Yii::$app->session->get('user_guest_key');

        // Puedes cambiar este criterio según tu lógica de "nuevo mensaje"
        $roomsWithNewMessages = [];

        $activeRooms = ChatRoom::find()->where(['status' => 'active'])->all();

        foreach ($activeRooms as $room) {
            $NotreadMessages = ChatMessage::find()
                ->where(['room_id' => $room->id])
                ->andWhere(['<>','sender', $sender])
                ->andWhere(['is_read' => 0 ])
                ->count();

            if ($NotreadMessages > 0) {
                $roomsWithNewMessages[] = ['room_id' => $room->id, 'not_read'=> $NotreadMessages];
            }
        }

        $activeChats = ChatRoom::find()->select(['id','token'])
        ->with(['lastMessage' => function($query){  $query->select(['room_id','text','image']); } ])
        ->where(['status' => 'active'])
        ->orderBy(['updated_at'=>SORT_DESC])
        ->asArray()->all();

        $closedChats = ChatRoom::find()->select(['id','token'])
        ->with(['lastMessage' => function($query){  $query->select(['room_id','text','image']); } ])
        ->where(['status' => 'closed'])
        ->orderBy(['updated_at'=>SORT_DESC])
        ->limit(10)
        ->asArray()->all();

        $data = [

            'notify' => $roomsWithNewMessages,
            'list_active' => $activeChats ,
            'list_closed' => $closedChats,
        ];

        return $data;
    }




}
