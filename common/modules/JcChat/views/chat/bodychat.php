<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<style>
/* Encabezado del chat */
.chat-header {
    background: #8533FC;
    color: white;
    padding: 12px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header button {
    background: transparent;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
}

/* Cuerpo de mensajes */
.chat-body-cli-wc {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    background: #f9f9f9;
}

.chat-msg {
    margin-bottom: 10px;
    max-width: 80%;
    padding: 8px 10px;
    border-radius: 8px;
    word-wrap: break-word;
    white-space: pre-line;
}

.chat-msg.me{
    background: #f4ffeb;
    align-self: flex-end;
    text-align: right;
     margin-left: auto;
}

.chat-msg.other {
    background: #ffffff;
    align-self: flex-start;
    text-align: left;
    margin-right: auto;
}

.chat-msg img {
    max-width: 100%;
    border-radius: 6px;
    margin-top: 4px;
}

/* Vista previa de imagen antes de enviar */
.chat-image-preview-cli-wc {
    padding: 8px;
    background: #f1f1f1;
    text-align: center;
    border-top: 1px solid #ddd;
}
.chat-image-preview-cli-wc img {
    max-width: 80px;
    border-radius: 6px;
}

/* Indicador escribiendo */
.typing-indicator {
    font-size: 12px;
    color: gray;
    padding: 4px 10px;
    font-style: italic;
}

/* Área de ingreso */
.chat-input-area-wc {
    display: flex;
    align-items: center;
    padding: 6px 10px;
    border-top: 1px solid #ddd;
    background: #fff;
}

.chat-input-area-wc textarea {
    flex: 1;
    resize: none;
    height: 38px;
    border: none;
    padding: 6px;
    border-radius: 6px;
    font-size: 14px;
    background: #f1f1f1;
}

.chat-input-area-wc textarea:focus {
    outline: none;
    background: #e8e8e8;
}

.chat-input-area-wc .send-btn-chat-wc,
.chat-input-area-wc .emoji-chat-btn-wc,
.chat-input-area-wc .btn-attach-chat-wc {
    background: none;
    border: none;
    font-size: 18px;
    margin-left: 6px;
    cursor: pointer;
}

/* Emoji picker */
.emoji-box-cli-wc {
    max-height: 100px;
    overflow-y: auto;
    padding: 6px;
    border-top: 1px solid #ddd;
    background: #fff;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    font-size: 18px;
    justify-content: start;
}
.emoji-box-cli-wc span {
    cursor: pointer;
    user-select: none;
}
.chat-start-btn-wc{
    width: 100%; 
    background: orange; 
    border: 1px solid orange; 
    color: white; 
    padding: 10px; 
    border-radius: 5px;
}
.welcome-wc-cli-chat{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
#btn-cancel-img-chat-cli-wc{
    position: absolute;
    right:0;
    top:0;
    border:0;
}
.chat-box-ct-on{
    height:600px;

}
.chat-body-cli-wc{
    border: solid 1px silver;
    height:90%;
    overflow:auto;
    background:#fff;
}
</style>

<div class="chat-box-ct-on">
    <div class="chat-header" style="border-radius: 10px 10px 0px 0px;">
        <span class="d-flex align-items-center gap-2"><i class="fa-solid fa-comments" style="position:relative;"><i class="fa fa-circle fa-sm circle-noty-chat-cli-wc"><span class="span-notify-chat-cli-wc"></span></i> </i> Chat Online</span>
            
            <div class="d-flex align-items-center gap-3">
                <button onClick="$('#chat-container-cli-wc').toggle();" class="d-flex align-items-center"><i class="fa fa-window-minimize" style="margin-bottom: 0.6rem;"></i></button>

                <button class="chat-close-cli-btn" id="chat-close-cli-btn"><i class="fa fa-times"></i></button>
            </div>
    </div>
    <div class="chat-body-cli-wc" id="chat-body-cli-wc" style="">
            <div id="chat-messages-cli-wc" class="chat-messages-cli-wc text-body" style="height:90%;overflow:auto;">
                <div class="welcome-wc-cli-chat" id="welcome-wc-cli-chat">
                    <img src="<?= Url::to('@raizweb'); ?>/images/logo.png" alt="" class="d-block my-3" style="height:40px;">
                    <i class="fs-6 mb-3"> Hola! que bueno que inicias una conversación con nosotros describenos tu duda para poder ayudarte.<br><span style="font-size:0.8rem;"><b>Nota:</b> Nuestros operadores ya fueron notificados de esta conversación para ayudarte cuanto antes.</span></i>
                </div>
                <div class="d-flex justify-content-center align-items-center mb-2 mt-2" style="height:215px;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div id="chat-typing-cli-wc" class="chat-typing-cli-wc" style="display: none;">Escribiendo...</div>

            <div class="chat-input-area-wc gap-2">
                <div class="d-flex align-items-center">
                    <!-- Emoji botón -->
                    <!-- Botón de emoji -->
                    <button id="emoji-trigger-cli-wc" class="emoji-chat-btn-wc">😊</button>

                    <!-- Carga de imagen -->
                    <label class="attach-btn btn-attach-chat-wc text-body">
                        <input type="file" id="chat-image-cli-wc" accept="image/*" hidden>
                        <i class="fa-solid fa-paperclip"></i>
                    </label>
                </div>

                <!-- Campo de texto -->
                <textarea type="text" id="chat-input-cli-wc" placeholder="Escribe tu mensaje..." ></textarea>

                <!-- Enviar -->
                <button  class="send-btn-chat-wc ms-0" id="btn-send-message-cli">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
            <!-- Vista previa imagen -->
            <div id="image-preview-chat-cli-wc" class="chat-image-preview-cli-wc" style="position:relative; display: none;"></div>
    </div>
</div>
