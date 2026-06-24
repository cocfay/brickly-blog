<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\JcChat\assets\ChatImageAsset;

$UrlChatInit = Url::to(['/jc-chat/chat']);
$bundleImg = ChatImageAsset::register($this);


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
$UrlChatInit = Url::to(['/jc-chat/chat']);

$this->registerJsFile('https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.1.1/dist/index.js', [
    'position' => \yii\web\View::POS_END
]);
?>

<!-- 🔵 Botón flotante de chat -->
<style>
    #chat-float-button-cli-wc {
        position: fixed;
        bottom: 175px;
        right: 20px;
        /* background-color: #007bff; */
        color: white;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        font-size: 24px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        z-index: 9999;
        cursor: pointer;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    #chat-container-cli-wc {
        position: fixed;
        width: 100%;
        max-width: 320px;
        height: 100vh;
        z-index: 10000;
        top : 10px;
        right:85px;
        display:flex;
        justify-content:center;
        align-items:center;
    }
    #chat-float-button-cli-wc:hover {
        background-color: #0056b3;
    }
    .span-notify-chat-cli-wc{
        color:#fff;
        font-size: 10px;
    }
    .circle-noty-chat-cli-wc{
        color:red; 
        position:absolute; 
        top:0; 
        right:0; 
        flex-direction:column;
        justify-content:center;
        align-items:center;
        display:none;
    }
    .chat-wc-cli-img-open{
        cursor:pointer;
    }

    @media screen and (max-width: 573px) {
        #chat-container-cli-wc {
            right:0 !important;
            top: 0 !important;
            
        }
        .chat-box-ct-on {
            height: 100vh !important;
        }
    }
</style>

<!-- Botón flotante -->
<div id="chat-float-button-cli-wc" onclick="$('#chat-container-cli-wc').toggle();">
    <i class="fa fa-circle fa-sm circle-noty-chat-cli-wc" style="display:none;"><span class="span-notify-chat-cli-wc"></span></i>
    <!-- 💬 -->
    <?= Html::img($bundleImg->baseUrl . '/Boton.png', ['alt' => 'My Image','style'=>'height:62px;']); ?>
</div>

<!-- Contenedor del chat (vía AJAX se inserta la vista correspondiente) -->
<div id="chat-container-cli-wc" style="display: none;">
    <!-- Aquí se cargará el inicio de chat o chat activo -->
</div>

<?php
$this->registerJs(<<<JS

var intervalPoll = false;
function loadChatBubble() {
    $.get("{$UrlChatInit}/init", function(html) {
            $('#chat-container-cli-wc').html(html);
            let isChatInit = $('#chat-container-cli-wc').find('.welcome-wc-cli-chat').length;

            if(isChatInit > 0){
                const picker = new EmojiButton({
                    position: 'top-start',
                    autoHide: true,
                    zIndex: 99999
                    });

                picker.on('emoji', emoji => {
                const input = document.getElementById('chat-input-cli-wc');
                input.value += emoji;
                });

                document.getElementById('emoji-trigger-cli-wc').addEventListener('click', () => {
                picker.togglePicker(document.getElementById('emoji-trigger-cli-wc'));
                });
                pollMessages('scrolling');
                intervalPoll = setInterval(pollMessages, 3000);
                $('#chat-container-cli-wc').show();
            }else{
                if(intervalPoll){
                    clearInterval(intervalPoll);
                }
            }
    });
}

// Ejecutar al cargar la página (verifica si hay chat activo)
$(document).ready(function() {
    loadChatBubble();
});


let typingTimeout;
var firstRequestPollMessaje = true;
var otherMsgs = 0;
var lastNotRead = 0;
// Cargar mensajes cada 3 segundos
function pollMessages(scrolling = false) {
    // return true;
    $.get("{$UrlChatInit}/fetch", function(data) {
        if(data.room_closed){
            loadChatBubble();
        }
        const container = $('#chat-messages-cli-wc');
        let webUrl = "{$UrlWeb}";
        let welcome = $('#welcome-wc-cli-chat').clone();
        container.empty();
        container.append(welcome);
        notReadPoll = 0;
        data.forEach(msg => {
            const msgHtml = '<div class="chat-msg ' + (msg.creator ? 'me' : 'other') + '  ' + ((!msg.creator && msg.is_read == 0) ? 'not-read-msg-other-over-chat-cli-wc' : '') + '" data-idmsg="'+msg.id+'">' +
                (msg.text ? '<div>' + msg.text + '</div>' : '') +
                (msg.image ? '<img src="' + webUrl + msg.image + '" class="chat-img chat-wc-cli-img-open">' : '') +
                '<span class="time">' + msg.time + '</span></div>';
            container.append(msgHtml);
            if(!msg.creator){
                if(msg.is_read == 0){
                    notReadPoll++;
                }

            }
        });
        if(scrolling){
            setTimeout(function(){
                container.scrollTop(container.prop('scrollHeight'));
            },500) 
        }

        if(notReadPoll > lastNotRead){
            console.log("Mostrar Notificación de nuevo mensaje");
            // 🔵 Comentario: Aquí se reproduce el sonido al recibir mensajes
            // const audio = new Audio('/sounds/new-message.mp3');
            // audio.play();
            $(".circle-noty-chat-cli-wc span").html(notReadPoll);
            $(".circle-noty-chat-cli-wc").css({display:'flex'});
            $('#chat-messages-cli-wc').scrollTop($('#chat-messages-cli-wc').prop('scrollHeight'));
        }else if(notReadPoll == 0){
            $(".circle-noty-chat-cli-wc span").html("");
            $(".circle-noty-chat-cli-wc").hide();

        }else if(notReadPoll < lastNotRead){
             $(".circle-noty-chat-cli-wc span").html(notReadPoll);
        }

        lastNotRead = notReadPoll;

    //    let newMessages =  $('.chat-msg.other').length;
    //    if(newMessages != 0 && newMessages > otherMsgs && firstRequestPollMessaje == false){
    //       console.log("Mostrar Notificación de nuevo mensaje");
    //        // 🔵 Comentario: Aquí se reproduce el sonido al recibir mensajes
    //       // const audio = new Audio('/sounds/new-message.mp3');
    //       // audio.play();
    //       $(".circle-noty-chat-cli-wc span").html(newMessages - otherMsgs);
    //       $(".circle-noty-chat-cli-wc").css({display:'flex'});
          
    //    }
      
       

       if(firstRequestPollMessaje){
        firstRequestPollMessaje = false;
       }
       
    });

    // $.get("{$UrlChatInit}/status", function(res) {
    //     if (res.typing) {
    //         $('#chat-typing-cli-wc').show();
    //     } else {
    //         $('#chat-typing-cli-wc').hide();
    //     }
    // });
}

// Iniciar chat
function startChat() {
    $.post("{$UrlChatInit}/start", function(res) {
        if (res.success) {
            location.reload();
        }
    });
}

// Enviar mensaje
function sendMessage() {
     if($('#btn-send-message-cli').hasClass('onsend')){
        return true;
     }
    const input = $('#chat-input-cli-wc');
    const formData = new FormData();
    formData.append('message', input.val());
    
    const fileInput = $('#chat-image-cli-wc')[0];
    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }

    if(fileInput.files.length < 1 && input.val().length < 1){

        setTimeout(function(e){
            $('#btn-send-message-cli').removeClass('onsend');
        },200);
        return true;
    }
    
    $.ajax({
        url: "{$UrlChatInit}/send",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if (res.success) {
                input.val('');
                $('#image-preview-chat-cli-wc').hide().empty();
                pollMessages('scrolling');
                cancelImgSend();
               
            }
             $('#btn-send-message-cli').removeClass('onsend');
        }
    });
}

// Detectar "escribiendo"
function setTyping() {
    markReadMessage();
    
    // clearTimeout(typingTimeout);
    // $.post("{$UrlChatInit}/typing");

    // typingTimeout = setTimeout(function() {
    //     // Inactividad después de escribir
    //     $('#chat-typing-cli-wc').hide();
    // }, 5000);
}

function markReadMessage(id=false){
        if(!id){
            $.post("{$UrlChatInit}/read-messages");
        }else{
            $.post("{$UrlChatInit}/read-messages?id="+id);
        }
}

// Mostrar/ocultar emojis
function toggleEmojiPanel() {
    $('#emoji-panel').toggle();
}


// Insertar emoji en input
function insertEmoji(emoji) {
    const input = document.getElementById('chat-input-cli-wc');
    input.value += emoji;
    input.focus();
}

// Vista previa de imagen
function previewImage(event) {
    const preview = $('#image-preview-chat-cli-wc');
    preview.empty().show();

    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
        preview.append('<img src="' + e.target.result + '" class="chat-img-preview">');

        preview.append('<button class="btn-cancel-img-chat-cli-wc" id="btn-cancel-img-chat-cli-wc">✖️</button>')
    };
    reader.readAsDataURL(file);
}

function cancelImgSend(){

    const preview = $('#image-preview-chat-cli-wc');
    preview.empty().hide();
    $('#chat-image-cli-wc').val(null);
}

// Finalizar chat
function endChat() {
    if (!confirm('¿Seguro que deseas finalizar el chat?')) return;

    $.post("{$UrlChatInit}/end", function(res) {
        if (res.success) {
            location.reload();

            // 🔵 Comentario: Cuando se finaliza el chat
        }
    });
}

$('#chat-container-cli-wc').on('click','#btn-init-chat-cli-wc',function(e){
    console.log('Click start')
    startChat();
});
$('#chat-container-cli-wc').on('change','#chat-image-cli-wc',function(e){
    previewImage(e);
});
$('#chat-container-cli-wc').on('click','#btn-cancel-img-chat-cli-wc',function(e){
    cancelImgSend();
});
$('#chat-container-cli-wc').on('click','#chat-close-cli-btn',function(e){
    endChat();
});
$('#chat-container-cli-wc').on('input','#chat-input-cli-wc',function(e){
    setTyping();
});
$('#chat-container-cli-wc').on('click','#btn-send-message-cli',function(e){
    sendMessage();
    $('#btn-send-message-cli').addClass('onsend');
});

$('#chat-container-cli-wc').on('keydown','#chat-input-cli-wc',function(e){
    // console.log('Preciono la tecla',e.keyCode);
     if((e.key == 'Enter' && !e.shiftKey) || (e.keyCode === 13 && !e.shiftKey)){
        e.preventDefault();
        sendMessage();
        $('#btn-send-message-cli').addClass('onsend');
    }
});


$('#chat-container-cli-wc').on( "mouseenter", ".not-read-msg-other-over-chat-cli-wc",function(e){
    let idMsg = $(this).data("idmsg");

    console.log(idMsg);
    if(idMsg){
        markReadMessage(idMsg);
    }
});
$('#chat-container-cli-wc').on('click','.chat-wc-cli-img-open',function(e){
    let imgUrl = $(this).attr('src');
    window.open(imgUrl, 'imgWindow');
});

    
JS);
?>