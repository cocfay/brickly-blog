<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = "Panel de Soporte";

$this->registerJsFile('https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.1.1/dist/index.js', [
    'position' => \yii\web\View::POS_END
]);
?>

<style>
.chat-panel-container {
    display: flex;
    height: 85vh;
    gap: 10px;
}

.chat-list,
.chat-closed {
    width: 25%;
    border: 1px solid #ccc;
    overflow-y: auto;
    padding: 10px;
    border-radius: 10px;
    background: #f9f9f9;
}

.chat-main-body {
    flex: 1;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 0;
    background: #fff;
}

.chat-room-item {
    padding: 8px;
    margin-bottom: 6px;
    background: #fff;
    border: 1px solid #ddd;
    cursor: pointer;
    border-radius: 6px;
    position: relative;
}

.chat-room-item:hover {
    background: #e6f7ff;
}

.chat-room-item .new-msg-indicator {
    position: absolute;
    top: 8px;
    right: 10px;
    background: red;
    color: white;
    font-size: 10px;
    border-radius: 50%;
    padding: 2px 6px;
}
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
#btn-cancel-img-chat-cli-wc{
    position: absolute;
    right:0;
    top:0;
    border:0;
}
</style>

<div class="chat-panel-container">
    <!-- 🔵 LISTA DE CHATS ACTIVOS -->
    <div class="chat-list">
        <h5>Chats Activos</h5>
        <div id="active-chat-rooms">
            <?php foreach ($activeRooms as $room): ?>
                <div class="chat-room-item" data-room-id="<?= $room->id ?>">
                    <strong>Sala #<?= $room->token ?></strong><br>
                    
                    <?php if($room->lastMessage){if($room->lastMessage->text){ echo $room->lastMessage->text; }else{ if($room->lastMessage->image){ echo '(Imagen)'; }else{ echo 'Sin mensajes aun.'; } } }else{ echo 'Sin mensajes aun.'; }?>
                    <span class="new-msg-indicator" style="display:none;">●</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 🟢 CUERPO DEL CHAT -->
    <div class="chat-main-body" id="chat-body-container">
        <div class="d-flex justify-content-center align-items-center" style="height:100%;">
            <div class="text-center">
                <i class="fa-solid fa-comments fa-2x mb-2 text-muted"></i>
                <p>Selecciona una conversación para empezar</p>
            </div>
        </div>
    </div>

    <!-- 🔴 LISTA DE CHATS CERRADOS -->
    <div class="chat-closed">
        <h5>Chats Cerrados</h5>
        <div id="closed-chat-rooms">
            <?php foreach ($closedRooms as $room): ?>
                <div class="chat-room-item text-muted" data-room-id="<?= $room->id ?>">
                    <strong>Sala #<?= $room->token ?></strong><br>
                    <?php if($room->lastMessage){if($room->lastMessage->text){ echo $room->lastMessage->text; }else{ if($room->lastMessage->image){ echo '(Imagen)'; }else{ echo 'Sin mensajes aun.'; } } }else{ echo 'Sin mensajes aun.'; }?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php

$UrlChatInit = Url::to(['/jc-chat/chat']);
$preactiveid = false;
if($PreActive){
   $preactiveid = $PreActive->id;
}

$preactiveid = json_encode($preactiveid);
$js = <<<JS

var rormIdCheck = false;
var actualChatNewMessages = 0;

var loadInterval = false;

var loadChatInit = $preactiveid;

if(loadChatInit){
    loadChat(loadChatInit);
}


function loadChat(roomId = false) {
    if(roomId){
        rormIdCheck = roomId;
    }
    $.get("{$UrlChatInit}/load-chat", { room_id: rormIdCheck }, function(res) {
        $('#chat-body-container').html(res);

        const picker = new EmojiButton({
            position: 'top-start',
            autoHide: true,
            zIndex: 99999
            });

        picker.on('emoji', emoji => {
        const input = document.getElementById('chat-input-support');
        input.value += emoji;
        });

        document.getElementById('emoji-trigger-cli-wc').addEventListener('click', () => {
        picker.togglePicker(document.getElementById('emoji-trigger-cli-wc'));
        });
    });
    
    if(loadInterval){
        clearInterval(loadInterval);
    }
    fetchMessage('scroll');

    loadInterval = setInterval(fetchMessage,3000);
}

function fetchMessage(scrolling = false){
        $.get("{$UrlChatInit}/fetch?id="+rormIdCheck, function(data) {
        const container = $('#chat-messages-support');
        let webUrl = "{$UrlWeb}";
        container.empty();
        notReadPoll = 0;
        data.forEach(msg => {
            const msgHtml = '<div class="chat-msg ' + (msg.creator ? 'me' : 'other') + '  ' + ((!msg.creator && msg.is_read == 0) ? 'not-read-msg-other-over-chat-cli-wc' : '') + '" data-idmsg="'+msg.id+'">' +
                (msg.text ? '<p>' + msg.text + '</p>' : '') +
                (msg.image ? '<img src="' + webUrl + msg.image + '" class="chat-img chat-wc-cli-img-open" style="max-width:150px;border-radius:5px;"><br>' : '') +
                '<span class="time">' + msg.time + '</span><br><span class="sender-msg"><i>'+ msg.sender +'</i></span></div>';
            container.append(msgHtml);
        });
        if(scrolling){
            setTimeout(function(){
                        $('#chat-messages-support').scrollTop($('#chat-messages-support').prop('scrollHeight'));
            },500) 
        }
       
    });
}

$('#active-chat-rooms, #closed-chat-rooms').on('click', '.chat-room-item', function() {
    let roomId = $(this).data('room-id');
    $('.chat-room-item').removeClass('active');
    $(this).addClass('active');
    $(this).find('.new-msg-indicator').hide();
    loadChat(roomId);
    markReadMessage(false,roomId)
});

// 🔄 Checar notificaciones cada 5 segundos
setInterval(function() {
    
    $.get("{$UrlChatInit}/check-new-messages", function(data) {
        $('#active-chat-rooms').empty();
         data.list_active.forEach(function(actives) {
            let activeListHtml = '';
            activeListHtml += '<div class="chat-room-item" data-room-id="' + actives.id + '">';
            activeListHtml += '<strong>Sala #' + actives.token + '</strong><br>';
            // activeListHtml += actives.lastMessage ? actives.lastMessage.text : 'Sin mensajes aun.' ;
            msgPrev = 'Sin mensajes aun.';
            if(actives.lastMessage){
                    if(actives.lastMessage.text){
                        msgPrev = actives.lastMessage.text;
                    }else{
                        if(actives.lastMessage.image){
                            msgPrev = '(Imagen)';
                        }
                    }
            }
            activeListHtml += msgPrev;
            activeListHtml += '<span class="new-msg-indicator" style="display:none;">●</span>';
            activeListHtml += '</div>';
            $('#active-chat-rooms').append(activeListHtml);

        });
        $('#closed-chat-rooms').empty();
         data.list_closed.forEach(function(closed) {
            let closedListHtml = '';
            closedListHtml += '<div class="chat-room-item" data-room-id="' + closed.id + '">';
            closedListHtml += '<strong>Sala #' + closed.token + '</strong><br>';
            // closedListHtml += closed.lastMessage ? closed.lastMessage.text : 'Sin mensajes aun.' ;

            // console.log('lastMessage', closed.lastMessage);
            msgPrev = 'Sin mensajes aun.';
            if(closed.lastMessage){
                    if(closed.lastMessage.text){
                        msgPrev = closed.lastMessage.text;
                    }else{
                        if(closed.lastMessage.image){
                            msgPrev = '(Imagen)';
                        }
                    }
            }
            closedListHtml += msgPrev;


            closedListHtml += '</div>';
            $('#closed-chat-rooms').append(closedListHtml);

        });
        data.notify.forEach(function(item) {
            let el = $('.chat-room-item[data-room-id="' + item.room_id + '"]');
            el.find('.new-msg-indicator').show();
        });
        if(rormIdCheck){
            let actualchatCheck = data.notify.find(obj => obj.room_id === rormIdCheck);
            if(actualchatCheck){
                if(actualChatNewMessages < actualchatCheck.not_read){
                    setTimeout(function(){
                        $('#chat-messages-support').scrollTop($('#chat-messages-support').prop('scrollHeight'));
                    },500) 
                }
                actualChatNewMessages = actualchatCheck.not_read;
            }else{
                actualChatNewMessages = 0;
            }
            
        }else{
            actualChatNewMessages = 0;
        }
    });



}, 5000);

function markReadMessage(id=false,token=false){
    if(!id){
        if(token){
            $.post("{$UrlChatInit}/read-messages?room="+token);
            actualChatNewMessages = 0;
        }
    }else{
        if(token){
            $.post("{$UrlChatInit}/read-messages?id="+id+'&room='+token);
        }
    }
}
function sendMessage() {

    if($('#btn-send-support').hasClass('onsend')){
        return true;
     }

    const input = $('#chat-input-support');
    const formData = new FormData();
    formData.append('message', input.val());
    
    const fileInput = $('#chat-image-cli-wc')[0];
    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }

    if(fileInput.files.length < 1 && input.val().length < 1){

        setTimeout(function(e){
            $('#btn-send-support').removeClass('onsend');
        },200);
        return true;
    }

    $.ajax({
        url: "{$UrlChatInit}/send?idroom="+rormIdCheck,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if (res.success) {
                input.val('');
                $('#image-preview-chat-cli-wc').hide().empty();
                 fetchMessage('scroll');
                 setTimeout(function(e){
                    $('#btn-send-support').removeClass('onsend');
                },200);
            }
        }
    });
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

    $.post("{$UrlChatInit}/end?room="+rormIdCheck, function(res) {
        if (res.success) {
        let html = '<div class="d-flex justify-content-center align-items-center" style="height:100%;">';
                html += '<div class="text-center">';
                    html += '<i class="fa-solid fa-comments fa-2x mb-2 text-muted"></i>';
                    html += '<p>Selecciona una conversación para empezar</p>';
                html += '</div>';
            html += '</div>';

            $('#chat-body-container').html(html);
            if(loadInterval){
                clearInterval(loadInterval);
            }
        rormIdCheck = false;

        }
    });
}

$('#chat-body-container').on( "mouseenter", ".not-read-msg-other-over-chat-cli-wc",function(e){
    let idMsg = $(this).data("idmsg");

    // console.log(idMsg);
    if(idMsg){
        markReadMessage(idMsg,rormIdCheck);
    }
});

$('#chat-body-container').on( "click", "#btn-send-support",function(e){
    sendMessage();
    $('#btn-send-support').addClass('onsend');
});
$('#chat-container-cli-wc').on('keydown','#chat-input-support',function(e){
    if((e.key == 'Enter' && !e.shiftKey) || (e.keyCode === 13 && !e.shiftKey)){
        e.preventDefault();
        sendMessage();
        $('#btn-send-support').addClass('onsend');
    }
});
$('#chat-body-container').on('change','#chat-image-cli-wc',function(e){
    previewImage(e);
});

$('#chat-body-container').on('click','.chat-wc-cli-img-open',function(e){
    let imgUrl = $(this).attr('src');
    window.open(imgUrl, 'imgWindow');
});
$('#chat-body-container').on('click','#btn-cancel-img-chat-cli-wc',function(e){
    cancelImgSend();
});
$('#chat-body-container').on('click','#btn-close-chat',function(e){
    endChat();
});
JS;

$this->registerJs($js);
?>
