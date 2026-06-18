<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>

<style>
/* Estilos similares al cliente, puedes personalizarlos más */
.chat-header {
    background: #17a2b8;
    color: white;
    padding: 12px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chat-body-support {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    background: #f9f9f9;
    max-height: 400px;
}
.chat-msg {
    margin-bottom: 10px;
    max-width: 80%;
    padding: 8px 10px;
    border-radius: 8px;
    word-wrap: break-word;
    white-space: pre-line;
}
.chat-msg.me {
    background: #dcf8c6;
    text-align: right;
    margin-left: auto;
}
.chat-msg.other {
    background: #ffffff;
    text-align: left;
    margin-right: auto;
}
.chat-input-area {
    display: flex;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #ccc;
    background: #fff;
}
.chat-input-area textarea {
    flex: 1;
    resize: none;
    height: 38px;
    border: none;
    padding: 6px;
    border-radius: 6px;
    font-size: 14px;
    background: #f1f1f1;
}
.chat-input-area textarea:focus {
    outline: none;
    background: #e8e8e8;
}
.chat-input-area button {
    background: #17a2b8;
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    margin-left: 8px;
    cursor: pointer;
}
</style>

<!-- Contenedor principal del chat de soporte -->
<div class="chat-box-support">
    <div class="chat-header">
        <span><i class="fa fa-comments"></i> Sala de chat #<?= Html::encode($chatRoom->token) ?></span>
        <button class="btn btn-sm btn-light" id="btn-close-chat" data-room-id="<?= Html::encode($roomId) ?>">Cerrar Chat</button>
    </div>

    <div class="chat-body-support" id="chat-messages-support">
        <?php foreach ($messages as $msg): ?>
            <div class="chat-msg <?= $msg->sender == $sender ? 'me' : 'other' ?> <?= ($msg->sender != $sender && $msg->is_read == 0) ? 'not-read-msg-other-over-chat-cli-wc' : ''; ?>">
                <?= $msg->text? "<p>{$msg->text}</p>" : ''; ?>
                <?php if ($msg->image): ?>
                    <img src="<?= $UrlWeb  . $msg->image ?>" style="max-width:150px;border-radius:5px;"><br>
                <?php endif; ?>
                <span class="time"><?= date('H:i',$msg->created_at) ?></span><br>
                <span class="sender-msg"><i><?= $msg->sender; ?></i></span>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="typing-indicator-support" style="display:none;padding:5px;font-style:italic;color:gray;">
        Cliente está escribiendo...
    </div>

    <div class="chat-input-area">
        <button id="emoji-trigger-cli-wc" class="emoji-chat-btn-wc m-2">😊</button>

        <label class="attach-btn btn-attach-chat-wc m-2" style="cursor:pointer;">
            <input type="file" id="chat-image-cli-wc" accept="image/*" hidden>
            <i class="fa-solid fa-paperclip"></i>
        </label>

        <textarea id="chat-input-support" placeholder="Escribe tu mensaje..."></textarea>
        <button id="btn-send-support" data-room-id="<?= Html::encode($roomId) ?>">
            <i class="fa fa-paper-plane"></i> Enviar
        </button>
    </div>
    <div id="image-preview-chat-cli-wc" class="chat-image-preview-cli-wc" style="position:relative; display: none;"></div>
</div>
