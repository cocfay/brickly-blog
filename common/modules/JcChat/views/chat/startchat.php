<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\modules\JcChat\assets\ChatImageAsset;

$bundleImg = ChatImageAsset::register($this);

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

.chat-start-btn-wc{
    width: 100%; 
    background: #fff; 
    border: 1.3px solid #9700FF; 
    color: #000000; 
    padding: 10px 6px; 
    border-radius: 5px;
    display: inline-block;
    text-align: center;
}
.chat-box-ct-on{
    height: 600px;

}
.chat-body-cli-wc{
     border: solid 1px silver;
    height:90%;
    overflow:auto;
    background:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
}
</style>

<div class="chat-box-ct-on">
    <div class="chat-header d-flex justify-content-between align-items-center" style="border-radius: 10px 10px 0px 0px;">
        <span><i class="fa-solid fa-headset me-2"></i> Soporte Online</span>
        <i class="fa-solid fa-xmark fs-5" style="cursor: pointer;" onclick="$('#chat-container-cli-wc').toggle();"></i>
    </div>

    <div class="chat-body-cli-wc fs-6" style="">
        <!-- 🔵 Comentario: Cuando se crea una nueva sala de chat -->
        <div class="chat-start-cli-wc px-4 pt-4 pb-5">
            <?php if($EnableChat): ?>
                <div class="mb-2 lh-sm" style="color: #000000;">¿Necesitas ayuda? Inicia un chat con nosotros.</div>
                <div class="m-auto mt-4 mb-5">
                    <?= Html::img($bundleImg->baseUrl . '/soporte.png', ['alt' => 'icon', 'style' => 'height: 100px;', 'class' => 'd-block m-auto']); ?>
                </div>
                <button class="chat-start-btn-wc position-relative" id="btn-init-chat-cli-wc">
                    <?= Html::img($bundleImg->baseUrl . '/message.png', ['alt' => 'icon', 'style' => 'height: 30px; left: 15%;', 'class' => 'position-absolute top-50 translate-middle-y']); ?>
                    INICIAR CHAT
                </button>
            <?php else: ?>
                <div class="mt-4 mb-2 lh-sm" style="color: #000000;">Consulta las preguntas frecuentes</div>
                <a target="_blank" href="javascript:void(0);" class="chat-start-btn-wc text-decoration-none" id="">PREGUNTAS FRECUENTES</a>
            <?php endif; ?>
        </div>
    </div>
</div>
