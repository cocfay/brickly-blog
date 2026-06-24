<style>
  /* input[type=text], input[type=email], input[type=password]{
      background-color: var(--bs-tertiary-bg) !important;
      color: var(--bs-dark) !important;
      border-color: #B690FF !important;
  } */
  .nav button{
    color: var(--bs-dark);
  }
  .nav button.active{
    background-color: var(--bg-navtap) !important;
    color: #fff !important;
  }
</style>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link" id="nav-summary-tab" data-bs-toggle="tab" data-bs-target="#nav-summary" type="button" role="tab" aria-controls="nav-summary" aria-selected="true">Resumen</button>
    <button class="nav-link" id="nav-security-tab" data-bs-toggle="tab" data-bs-target="#nav-security" type="button" role="tab" aria-controls="nav-security" aria-selected="false">Seguridad</button>
    <?php if($UserData->TypeUser == 1 || $UserData->TypeUser == 2): ?>
      <button class="nav-link" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-security" aria-selected="false">Usuarios</button>
    <?php endif ?>
    <button class="nav-link" id="nav-notify-tab" data-bs-toggle="tab" data-bs-target="#nav-notify" type="button" role="tab" aria-controls="nav-notify" aria-selected="false">Aviso y Notificaciones <?php if( \Yii::$app->SystemNotifications->getUnreadCount($UserData->AccountID) > 0): ?><i class="fa fa-circle" style="font-size:10px;position:absolute;color:red;"></i><?php endif; ?></button>
    <button class="nav-link" id="nav-activity-tab" data-bs-toggle="tab" data-bs-target="#nav-activity" type="button" role="tab" aria-controls="nav-activity" aria-selected="false">Actividad</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade" id="nav-summary" role="tabpanel" aria-labelledby="nav-summary-tab">
    <?= $summaryHtml; ?>
  </div>
  <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">
    <?= $securityHtml; ?>
  </div>
  <?php if($UserData->TypeUser == 1 || $UserData->TypeUser == 2): ?>
    <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
      <?= $usersHtml; ?>
    </div>
  <?php endif ?>
  <div class="tab-pane fade" id="nav-notify" role="tabpanel" aria-labelledby="nav-notify-tab">
    <?= $notifyHtml; ?>
  </div>
  <div class="tab-pane fade" id="nav-activity" role="tabpanel" aria-labelledby="nav-activity-tab">
    <?= $activityHtml; ?>
  </div>
</div>

<?= $modals; ?>
<?php 
if (Yii::$app->session->hasFlash('success')):
		$this->registerJS('
			$(document).ready(function(){
				_Message("success","¡Exito!","'.Yii::$app->session->getFlash('success').'");
			});

			');
	endif;

	if (Yii::$app->session->hasFlash('error')):

		$this->registerJS('
			$(document).ready(function(){
				_Message("error","¡Error!","'.Yii::$app->session->getFlash('error').'");
			});

			');
	endif;
 ?>
<?php
$this->registerJS("

  // Manejar el click en las pestañas
  $('.nav-link').click(function(){
    history.pushState({}, \"\", $(this).data('bs-target'));
  });
  
  // Inicializar la pestaña activa
  function initializeActiveTab() {
    var hash = window.location.hash;
    var targetTab;
    
    if (hash && $('.nav-link[data-bs-target=\"'+hash+'\"]').length > 0) {
      targetTab = $('.nav-link[data-bs-target=\"'+hash+'\"]');
    } else {
      // Por defecto mostrar summary
      targetTab = $('.nav-link[data-bs-target=\"#nav-summary\"]');
      hash = '#nav-summary';
    }
    
    // Usar Bootstrap Tab API para mostrar la pestaña correctamente
    var tab = new bootstrap.Tab(targetTab[0]);
    tab.show();
    
    $('.chat-conversation').animate({ scrollTop: 0 }, 'fast');
  }
  
  // Esperar un poco para asegurar que Bootstrap esté listo
  setTimeout(function() {
    initializeActiveTab();
  }, 100);
");
?>