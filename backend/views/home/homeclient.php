<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
$names = [
  'en' => 'NameEn',
  'fr' => 'NameFr',
  'it' => 'NameIt',
  'es' => 'NameEs',
  'de' => 'NameDe',
  'pt' => 'NamePt'
];

$names = $names[$lang] ?? $names['en'];
$meses = [
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Septiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Diciembre'
];

$theme = isset($_COOKIE['styleTheme']) ? $_COOKIE['styleTheme'] : 'dark';


function tiempoTranscurrido($fechaPasada) {
    $fechaActual = new DateTime();
    $fechaPasada = new DateTime($fechaPasada);
    $diferencia = $fechaActual->diff($fechaPasada);
    
    if ($diferencia->y > 0) {
        return $diferencia->y . ' año' . ($diferencia->y > 1 ? 's' : '');
    } elseif ($diferencia->m > 0) {
        return $diferencia->m . ' mes' . ($diferencia->m > 1 ? 'es' : '');
    } elseif ($diferencia->d > 7) {
        $semanas = floor($diferencia->d / 7);
        return $semanas . ' semana' . ($semanas > 1 ? 's' : '');
    } elseif ($diferencia->d > 0) {
        return $diferencia->d . ' día' . ($diferencia->d > 1 ? 's' : '');
    } elseif ($diferencia->h > 0) {
        return $diferencia->h . ' hora' . ($diferencia->h > 1 ? 's' : '');
    } elseif ($diferencia->i > 0) {
        return $diferencia->i . ' minuto' . ($diferencia->i > 1 ? 's' : '');
    } else {
        return $diferencia->s . ' segundo' . ($diferencia->s > 1 ? 's' : '');
    }
}

?>

<style>
 /*  .modalservices input, .modalservices textarea, .modalservices textarea:focus {
    background-color: #fff;
    border-color: #FF0351 !important;
  }
  .modalservices input[type=checkbox]:checked{
    background-color: #FF0351 !important;
    border-color: #FF0351 !important;
    outline: 0;
    box-shadow: none;
  } */
  .modalservices .modal-body{
    color: var(--bs-dark);
  }
  .modalservices .btn-close{
    opacity: 1;
  }
  .modalservices textarea, .modalservices textarea:focus{
    background-color: var(--bs-modal);
    color: var(--bs-dark);
  }
  .servcard{
    background-color: var(--bg-catalog); 
    height: 100%;
  }
</style>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
<!-- <div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <strong>¡Super oferta!</strong> Dominios .COM por tan solo 5.99$. ¡Adquierelo ya!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div> -->

<div class="row">
  <div class="col-lg-8 mb-lg-5">
    <?php if(!empty($promo)): ?>
      <div class="alert alert-dismissible fade show d-flex align-items-center gap-2" style="background-color: var(--bg-notify); color: var(--bs-dark)" role="alert">
          <i class="fa-solid fa-circle-info fs-4" style="color: var(--color-notify)"></i>
          <?= $promo->Text ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif ?>

    <!-- #################################################### -->

    <?php if(!empty($Notification)):?>
      <div class="row d-block d-lg-none">
        <div class="col-md-12">
            <div style="background: var(--bg-catalog); border-radius: 4px;" class="p-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fs-3 mb-0" style="color: var(--bs-dark)">Notificaciones</div>
                <div class="position-relative">
                  <!-- <img src="<?= Url::to('@web'); ?>/images/site/notifi.png" style="width: 40px;" alt=""> -->
                  <div class="d-flex justify-content-center align-items-center"style="background: var(--bg-bell); width: 35px; height: 35px; border-radius: 50%">
                    <i class="fa-solid fa-bell fs-4" style="color: var(--bg-catalog);"></i>
                    <?php if( \Yii::$app->SystemNotifications->getUnreadCount($UserData->AccountID) > 0): ?>
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: var(--bg-bottom-primary);"><?= \Yii::$app->SystemNotifications->getUnreadCount($UserData->AccountID); ?></span>
                    <?php endif ?>
                  </div>
                </div>
              </div>
              <?php foreach(array_slice($Notification, 0, 3) as $noty): ?>
                  <a href="#" class="text-decoration-none">
                    <div class="d-flex justify-content-start flex-column align-items-start noticards">
                      <div class="d-flex gap-3 mb-3">
                        <img src="<?= Url::to('@raizweb'); ?>/images/logo.png" class="rounded" style="width: 50px;object-fit: cover;" alt="">
                        <div class="lh-sm">
                          <div class="fs-4 text-truncate" style="max-width: 200px; color: var(--bs-dark)"><?= $noty['Title'] ?></div>
                          <div style="color: var(--bg-bell); max-width: 230px;" class="text-truncate"><?= $noty['Body'] ?></div>
                        </div>
                      </div>
                      <div class="mb-auto">
                          <div style="color: var(--color-notify)">Hace <?= tiempoTranscurrido($noty['CreatedAt']) ?></div>
                      </div>
                    </div>
                  </a>
              <?php endforeach ?>
              <div class="d-flex justify-content-end">
                <a href="<?= Url::to(['/my-account#nav-notify']) ?>" class="text-decoration-none btn" style="background-color: var(--bg-bottom-primary); color: #fff; border-radius: 6px; width: fit-content;">
                  Ver más notificaciones
                </a>
              </div>
            </div>
        </div>
      </div>
    <?php endif ?>

    <!-- #################################################### -->

    <?php if(count($showMyServices) > 0): ?>
      <div class="row pt-3 pb-5 mt-4 mb-2">
        <div class="col-12 fs-3 lh-1 mb-3" style="color: var(--bs-dark)">
          Tus proyectos y servicios contratados
        </div>
        <?php foreach($showMyServices as $show): ?>
          <?php if(stripos($show['Type'], 'medida') !== false): ?>
            <div class="col-md-4 mb-4">
              <div class="p-3 servcard">
                <a href="<?= Url::to(['projects/personalized', 'id' => $show['ServiceID']]) ?>" class="text-decoration-none text-dark">
                  <div class="fs-4 lh-sm mb-2">Software a la medida</div>
                  <div class="fs-6 lh-sm">Sigue paso a paso el desarrollo de tus proyectos personalizados.</div>
                  <img src="<?= Yii::getAlias("@web") ?>/images/site/softmedida.png" class="d-block m-auto mt-4 mb-2" style="width: 100px;" alt="image">
                  <div class="mt-4 text-center fs-6 lh-sm" style="color: var(--color-notify)">Proyectos contratados: <?= $show['Cantidad'] ?></div>
                </a>
              </div>
            </div>
          <?php endif ?>
          <?php if(stripos($show['Type'], 'enlatado') !== false): ?>
            <div class="col-md-4 mb-4">
              <div class="p-3 servcard">
                <a href="<?= Url::to(['projects/personalized', 'id' => $show['ServiceID']]) ?>" class="text-decoration-none text-dark">
                  <div class="fs-4 lh-sm mb-2">Software enlatado</div>
                  <div class="fs-6 lh-sm">Software Predefinido y Empaquetado.</div>
                  <img src="<?= Yii::getAlias("@web") ?>/images/site/softwareenlatado.png" class="d-block m-auto mt-4 mb-2" style="width: 100px;" alt="image">
                  <div class="mt-4 text-center fs-6 lh-sm" style="color: var(--color-notify)">Servicios contratados: <?= $show['Cantidad'] ?></div>
                </a>
              </div>
            </div>
          <?php endif ?>
          <?php if(stripos($show['Type'], 'outsourcing') !== false): ?>
            <div class="col-md-4 mb-4">
              <div class="p-3 servcard">
                <a href="<?= Url::to(['projects/personalized', 'id' => $show['ServiceID']]) ?>" class="text-decoration-none text-dark">
                  <div class="fs-4 lh-sm mb-2">Servicio outsourcing</div>
                  <div class="fs-6 lh-sm">Revisas las tareas de tu equipo contratado.</div>
                  <img src="<?= Yii::getAlias("@web") ?>/images/site/outsourcing.png" class="d-block m-auto mt-4 mb-2" style="width: 100px;" alt="image">
                  <div class="mt-4 text-center fs-6 lh-sm" style="color: var(--color-notify)">Plazas contratadas: <?= $show['Cantidad'] ?></div>
                </a>
              </div>
            </div>
          <?php endif ?>
          <?php if(stripos($show['Type'], 'seguridad') !== false): ?>
            <div class="col-md-4 mb-4">
              <div class="p-3 servcard">
                <a href="<?= Url::to(['projects/personalized', 'id' => $show['ServiceID']]) ?>" class="text-decoration-none text-dark">
                  <div class="fs-4 lh-sm mb-2">Escaneo y seguridad</div>
                  <div class="fs-6 lh-sm">Visualiza el estatus de la remediación de las vulnerabilidades.</div>
                  <img src="<?= Yii::getAlias("@web") ?>/images/site/seguridad.png" class="d-block m-auto mt-4 mb-2" style="width: 100px;" alt="image">
                  <div class="mt-4 text-center fs-6 lh-sm" style="color: var(--color-notify)">Servicios contratados: <?= $show['Cantidad'] ?></div>
                </a>
              </div>
            </div>
          <?php endif ?> 
          <?php if(stripos($show['Type'], 'wordpress') !== false): ?>
            <div class="col-md-4 mb-4">
              <div class="p-3 servcard">
                <a href="#" class="text-decoration-none text-dark">
                  <div class="fs-4 lh-sm mb-2">Soporte wordpress</div>
                  <div class="fs-6 lh-sm">Revisa el mantenimiento y la optimización de tu proyecto.</div>
                  <img src="<?= Yii::getAlias("@web") ?>/images/site/wordpress.png" class="d-block m-auto mt-4 mb-2" style="width: 100px;" alt="image">
                  <div class="mt-4 text-center fs-6 lh-sm" style="color: var(--color-notify)">Servicios contratados: <?= $show['Cantidad'] ?></div>
                </a>
              </div>
            </div>
          <?php endif ?> 
          <?php if(stripos($show['Type'], 'diseño') !== false): ?>
            <div class="col-md-4 mb-4">
              <div class="p-3 servcard">
                <a href="<?= Url::to(['projects/personalized', 'id' => $show['ServiceID']]) ?>" class="text-decoration-none text-dark">
                  <div class="fs-4 lh-sm mb-2">Diseño web</div>
                  <div class="fs-6 lh-sm">Revisa las propuestas de diseño de tus proyectos.</div>
                  <img src="<?= Yii::getAlias("@web") ?>/images/site/dweb.png" class="d-block m-auto mt-4 mb-2" style="width: 100px;" alt="image">
                  <div class="mt-4 text-center fs-6 lh-sm" style="color: var(--color-notify)">Servicios contratados: <?= $show['Cantidad'] ?></div>
                </a>
              </div>
            </div>
          <?php endif ?> 
          <?php if(stripos($show['Type'], 'móvil') !== false): ?>
            <div class="col-md-4 mb-4">
              <div class="p-3 servcard">
                <a href="<?= Url::to(['projects/personalized', 'id' => $show['ServiceID']]) ?>" class="text-decoration-none text-dark">
                  <div class="fs-4 lh-sm mb-2">Aplicación móvil</div>
                  <div class="fs-6 lh-sm">Sigue paso a paso el proceso de desarrollo de tus aplicaciones.</div>
                  <img src="<?= Yii::getAlias("@web") ?>/images/site/aplicacionesmoviles.png" class="d-block m-auto mt-4 mb-2" style="width: 100px;" alt="image">
                  <div class="mt-4 text-center fs-6 lh-sm" style="color: var(--color-notify)">Plazas contratadas: <?= $show['Cantidad'] ?></div>
                </a>
              </div>
            </div>
          <?php endif ?>
        <?php endforeach ?>
      </div>
    <?php endif ?>

    <!-- #################################################### -->

    <div class="row mx-0 px-2 py-3 mb-lg-5" style="background: var(--bg-catalog);">
      <div class="col-12 fs-3 mb-3" style="color: var(--bs-dark)">Catálago de servicios</div>
      <?php foreach($services as $serv): 
        if(empty($UserData->CountryID) || empty($UserData->NumberPhone))
          $modal = '#completeInfo';
        else
          $modal = "#static-" . $serv->ServiceID;
      ?>
        <div class="col-md-6 col-lg-4 mb-4 mb-md-5" data-bs-toggle="modal" data-bs-target="<?= $modal ?>" style="cursor: pointer;">
          <img src="<?= is_null($serv->Image) ? Yii::getAlias("@web") . '/images/site/temporal.webp' : $serv->Image?>" class="w-100" alt="image">
          <div class="fs-5 mt-2" style="color: var(--bs-dark)"><?= $serv->Name ?></div>
            <?= Html::button('Adquirir', [
                  'class' => 'btn py-1 px-4 mt-2 require-btn', 
                  'type' => 'button',
                  'data-serviceid' => $serv->ServiceID, 
                  'data-name' => $serv->Name, 
                  'data-link' => $serv->LinkInSite, 
                  'data-img'=> is_null($serv->Image) ? Yii::getAlias("@web") . '/images/site/temporal.webp' : $serv->Image,
                  'style' => 'background-color: #4A4187;  border: none;color: #fff; border-radius: 4px; width: fit-content;'
              ]) ?>
        </div>
      <?php endforeach ?>
    </div>

  </div>
  <div class="col-lg-4">
    <?php if(!empty($Notification)):?>
      <div class="row d-none d-lg-block">
        <div class="col-md-12">
            <div style="background: var(--bg-catalog); border-radius: 4px;" class="p-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fs-3 mb-0" style="color: var(--bs-dark)">Notificaciones</div>
                <div class="position-relative">
                  <!-- <img src="<?= Url::to('@web'); ?>/images/site/notifi.png" style="width: 40px;" alt=""> -->
                  <div class="d-flex justify-content-center align-items-center"style="background: var(--bg-bell); width: 35px; height: 35px; border-radius: 50%">
                    <i class="fa-solid fa-bell fs-4" style="color: var(--bg-catalog);"></i>
                    <?php if( \Yii::$app->SystemNotifications->getUnreadCount($UserData->AccountID) > 0): ?>
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: var(--bg-bottom-primary);"><?= \Yii::$app->SystemNotifications->getUnreadCount($UserData->AccountID); ?></span>
                    <?php endif ?>
                  </div>
                </div>
              </div>
              <?php foreach(array_slice($Notification, 0, 3) as $noty): ?>
                  <a href="#" class="text-decoration-none">
                    <div class="d-flex justify-content-between align-items-center noticards">
                      <div class="d-flex gap-3">
                        <img src="<?= Url::to('@raizweb'); ?>/images/logo.png" class="rounded" style="width: 50px;object-fit: cover;" alt="">
                        <div class="lh-sm">
                          <div class="fs-4 text-truncate" style="max-width: 200px; color: var(--bs-dark)"><?= $noty['Title'] ?></div>
                          <div style="color: var(--bg-bell); max-width: 230px;" class="text-truncate"><?= $noty['Body'] ?></div>
                        </div>
                      </div>
                      <div class="mb-auto">
                          <div style="color: var(--color-notify)">Hace <?= tiempoTranscurrido($noty['CreatedAt']) ?></div>
                      </div>
        
                    </div>
                  </a>
              <?php endforeach ?>
              <div class="d-flex justify-content-end">
                <a href="<?= Url::to(['/my-account#nav-notify']) ?>" class="text-decoration-none btn" style="background-color: var(--bg-bottom-primary); color: #fff; border-radius: 6px; width: fit-content;">
                  Ver más notificaciones
                </a>
              </div>
            </div>
        </div>
      </div>
    <?php endif ?>

    <!-- #################################################### -->

    <div class="row mt-5">
      <div class="col-md-12">
        <div class="fs-3" style="color: var(--bs-dark);">Proyectos</div>
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner" style="height:250px;">
            <?php foreach($ItemsPorfolio as $itemPortfolio): ?>
              <div class="carousel-item active">
                <a href="<?= Url::to('@raizweb'); ?>/porfolio" target="_blank">
                  <img src="<?= Url::to('@raizweb').'/images/'. $itemPortfolio->Image; ?>" class="d-block w-100" alt="...">
                </a>
              </div>
            <?php endforeach; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>

    <!-- #################################################### -->

    <div class="row mt-5">
        <div class="fs-3" style="color: var(--bs-dark);">Noticias</div>
        <?php foreach($BlogPosts as $index => $post): ?>
          <div class="col-12 mt-2 article px-3 <?= $index > 0 ? 'py-4' : '' ?>" style="">
              <a href="<?= Url::to('@raizweb').'/blog/post/'.$post->PostBlogID; ?>" target="_blank" class="text-decoration-none ">
                  <div class="position-relative"><img src="<?= $post->ImagePost ?>" class="w-100 rounded" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover;"></div>
                  <div class="my-3 lh-sm text-limit-2" style="font-size: clamp(22px, 1.55vw, 24px); color: var(--bs-dark)"><?= $post->title ?></div>
                  <div class="text-limit-3 d-block" style="font-size: clamp(16px, 1.55vw, 18px); color: var(--color-text-descrip);">
                    <?php $c = $post->centerComponents[0] ?>
                    <?php if($c->Type == 1):?>
                            <?= strlen(strip_tags($c->textBoxC->Description)) >= 100 ? substr(strip_tags($c->textBoxC->Description), 0, 100) . '...' : strip_tags($c->textBoxC->Description) ?>
                    <?php endif ?>
                  </div>
              </a>
              <div class="d-flex gap mt-3 align-items-center tags-entry" style="flex-wrap: wrap;">
                   <?php foreach($post->blogBy as $tags): ?>
                        <a href="<?= Url::to('@raizweb').'/blog/categories/'.$tags->CollectionID; ?>" class="text-decoration-none">
                          <div style="background:#121256; border:1px solid white; border-radius: 10px; padding: 0 1.5rem; color:#fff;"><?= $tags->$names ?></div>
                        </a>
                    <?php break; endforeach ?>
                  <div class="m-2" style="color: var(--bs-dark)"><?= $meses[date("n", strtotime($post->CreateAT))] ?> <?= date("Y", strtotime($post->CreateAT)) ?></div>
              </div>
          </div>
        <?php endforeach; ?>
    </div>
    
  </div>
</div>


<!-- Modal 1-->
<div class="modal fade modalservices" id="static-1" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/softmedida.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Software a la medida</div>
            </div>
            <div class="mt-2">
              Desarrollamos soluciones totalmente personalizadas para tu negocio.<br>
              ¿Qué tipo de desarrollo necesitas?
            </div>
            <div class="row mt-3">
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check1')->checkbox(['value' => 'Sistema de gestión empresarial', 'class' => 'form-check-input validate-checkbox-1'])->label('Sistema de gestión empresarial') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check2')->checkbox(['value' => 'Soluciones e-Commerce', 'class' => 'form-check-input validate-checkbox-1'])->label('Soluciones e-Commerce') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check3')->checkbox(['value' => 'Software analítico', 'class' => 'form-check-input validate-checkbox-1'])->label('Software analítico') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check4')->checkbox(['value' => 'Plataforma de automatización', 'class' => 'form-check-input validate-checkbox-1'])->label('Plataforma de automatización') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check5')->checkbox(['value' => 'Herramienta de logística', 'class' => 'form-check-input validate-checkbox-1'])->label('Herramienta de logística') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check6')->checkbox(['value' => 'Otros', 'class' => 'form-check-input validate-checkbox-1'])->label('Otros') ?></div>
            </div>
            <div class="my-3 text-danger" id="checkbox-error-1">Debe seleccionar al menos un check</div>
            <div class="mt-4 mb-3">
              Coméntanos más sobre los requerimientos del proyecto que necesitas. Un asesor se pondrá en contacto contigo a la brevedad.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 1])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información', 'https://dev.mydesk.digital/NewWeclickUp/services/customsoftware', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn btnadquirir-1', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;', 'disabled' => true]);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>

<!-- Modal 2-->
<div class="modal fade modalservices" id="static-2" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/softwareenlatado.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Software enlatado</div>
            </div>
            <div class="mt-2">
              Soluciones rápidas prefabricadas para utilizarse con funcionalidades<br> predefinidas que reducen costos y tiempos de implementación.
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 mt-3 align-items-center">
                <img src="<?= Yii::getAlias("@web") ?>/images/site/zeni.png" style="width: 150px;" alt="">    
                <div class="d-flex flex-column gap-2">
                  <div class="d-flex align-items-end gap-3">
                    <img src="<?= Yii::getAlias("@web") ?>/images/site/<?= $theme == 'light' ? 'zenioscuro' : 'zeniclaro' ?>.png" style="width: 60px;" alt="">    
                    <div class="fs-5 lh-1">Punto de venta</div>
                  </div>
                  <div>Automatiza tu negocio con nuestro sistema Android para tablet.</div>
                  <a href="#" class="btn py-0 px-3" style="background: #FF6A00; color: #fff; border-radius: 4px; width: fit-content;">Más detalles</a>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 align-items-center mt-4">
                <img src="<?= Yii::getAlias("@web") ?>/images/site/novora.png" style="width: 150px;" alt="">    
                <div class="d-flex flex-column gap-2">
                  <div class="d-flex align-items-end gap-3">
                    <img src="<?= Yii::getAlias("@web") ?>/images/site/<?= $theme == 'light' ? 'novoraoscuro' : 'novoraclaro' ?>.png" style="width: 100px;" alt="">    
                    <div class="fs-5">Sistema médico </div>
                  </div>
                  <div>Optimiza tu consultorio médico con una solución todo en uno.</div>
                  <a href="#" class="btn py-0 px-3" style="background: #008394; color: #fff; border-radius: 4px; width: fit-content;">Más detalles</a>
                </div>
            </div>
            <div class="mt-5 mt-md-4 mb-3">
              Coméntanos más sobre los requerimientos del proyecto que necesitas. Un asesor se pondrá en contacto contigo a la brevedad.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 2])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información','https://dev.mydesk.digital/NewWeclickUp/services/cannedsoftware', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;']);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>

<!-- Modal 3-->
<div class="modal fade modalservices" id="static-3" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/outsourcing.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Servicio de outsourcing</div>
            </div>
            <div class="mt-2">
              Talento diverso y especializado en desarrollo de software. ¿Qué perfiles técnicos te interesan para impulsar tu proyecto?
            </div>
            <div class="row mt-3">
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check1')->checkbox(['value' => 'Project manager', 'class' => 'form-check-input validate-checkbox-3'])->label('Project manager') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check2')->checkbox(['value' => 'SysAdmin', 'class' => 'form-check-input validate-checkbox-3'])->label('SysAdmin') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check3')->checkbox(['value' => 'Desarrollador frontend', 'class' => 'form-check-input validate-checkbox-3'])->label('Desarrollador frontend') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check4')->checkbox(['value' => 'Desarrollador backend', 'class' => 'form-check-input validate-checkbox-3'])->label('Desarrollador backend') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check5')->checkbox(['value' => 'Desarrollador móvil', 'class' => 'form-check-input validate-checkbox-3'])->label('Desarrollador móvil') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check6')->checkbox(['value' => 'Quality Assurance', 'class' => 'form-check-input validate-checkbox-3'])->label('Quality Assurance') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check7')->checkbox(['value' => 'Desarrollador full stack', 'class' => 'form-check-input validate-checkbox-3'])->label('Desarrollador full stack') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check8')->checkbox(['value' => 'Arquitectos de software', 'class' => 'form-check-input validate-checkbox-3'])->label('Arquitectos de software') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check9')->checkbox(['value' => 'Diseño web', 'class' => 'form-check-input validate-checkbox-3'])->label('Diseño web') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check10')->checkbox(['value' => 'Base de datos', 'class' => 'form-check-input validate-checkbox-3'])->label('Base de datos') ?></div>
            </div>
            <div class="my-3 text-danger" id="checkbox-error-3">Debe seleccionar al menos un check</div>
            <div class="mt-4 mb-3">
              Coméntanos un poco más sobre tu proyecto.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 3])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información', 'https://dev.mydesk.digital/NewWeclickUp/services/outsoursing', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn btnadquirir-3', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;', 'disabled' => true]);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>

<!-- Modal 4-->
<div class="modal fade modalservices" id="static-4" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/seguridad.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Escaneo y seguridad</div>
            </div>
            <div class="mt-2">
              Somos partner oficial de Acunetix: soluciones avanzadas para detectar <br> y eliminar vulnerabilidades críticas en tiempo récord.
            </div>
            <div class="my-3">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/acunetix.png" class="d-block" style="width: 100%" alt="image">
            </div>
            <div class="mt-4 mb-3">
              Coméntanos más detalles de lo que necesitas para tu proyecto.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 4])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información','https://dev.mydesk.digital/NewWeclickUp/services/security', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;']);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>

<!-- Modal 5-->
<div class="modal fade modalservices" id="static-5" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/seguridad.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Servicio de monitoreo</div>
            </div>
            <div class="mt-2">
              Nextron7 es una solución de monitoreo integral para infraestructura IT, que supervisa servidores, redes, aplicaciones y servicios, garantizando su operatividad y disponibilidad.
            </div>
            <div class="my-3">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/nextron7.png" class="d-block" style="width: 100%" alt="image">
            </div>
            <div class="mt-4 mb-3">
              Coméntanos más detalles de lo que necesitas para tu proyecto.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 5])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información','https://dev.mydesk.digital/NewWeclickUp/services/monitoringservice', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;']);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>

<!-- Modal 5-->
<div class="modal fade modalservices" id="static-6" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/wordpress.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Soporte Wordpress</div>
            </div>
            <div class="mt-2">
              Te ofrecemos soluciones integrales para que tu CMS funcione perfectamente mientras tú te concentras en tu negocio.
            </div>
            <div class="my-3">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/bwordpress.jpg" class="d-block" style="width: 100%" alt="image">
            </div>
            <div class="mt-4 mb-3">
              Coméntanos más detalles de lo que necesitas para tu proyecto.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 6])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información','https://dev.mydesk.digital/NewWeclickUp/services/monitoringservice', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;']);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>

<!-- Modal 7-->
<div class="modal fade modalservices" id="static-7" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/dweb.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Diseño web</div>
            </div>
            <div class="mt-2">
              Planificamos, diseñamos e implementamos la apariencia visual y la experiencia de usuario de un sitio web.
            </div>
            <div class="my-3">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/ddweb.png" class="d-block" style="width: 100%" alt="image">
            </div>
            <div class="mt-4 mb-3">
              Coméntanos más detalles de lo que necesitas para tu proyecto.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 7])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información', 'https://dev.mydesk.digital/NewWeclickUp/services/webdesign', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;']);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>

<!-- Modal 8-->
<div class="modal fade modalservices" id="static-8" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 600px;">
    <?php $form =  Activeform::begin(['id'=>"require-service-form"]); ?>
      <div class="modal-content">
        <div class="modal-body" style="font-size: 16px;">
          <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <div class="d-flex gap-2 align-items-center mb-4 mb-md-0">
              <img src="<?= Yii::getAlias("@web") ?>/images/site/aplicacionesmoviles.png" class="d-block" style="width: 55px;" alt="image">
              <div class="fs-4">Aplicaciones móviles</div>
            </div>
            <div class="mt-2">
              Desarrollamos aplicaciones móviles personalizadas para empresas, organizaciones o usuarios. ¿Para qué área necesitas una app?
            </div>
            <div class="row mt-3">
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check1')->checkbox(['value' => 'Restaurantes y food delivery', 'class' => 'form-check-input validate-checkbox-8'])->label('Restaurantes y food delivery') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check2')->checkbox(['value' => 'Servicios profesionales', 'class' => 'form-check-input validate-checkbox-8'])->label('Servicios profesionales') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check3')->checkbox(['value' => 'Educación y capacitación', 'class' => 'form-check-input validate-checkbox-8'])->label('Educación y capacitación') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check4')->checkbox(['value' => 'e-Commerce', 'class' => 'form-check-input validate-checkbox-8'])->label('e-Commerce') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check5')->checkbox(['value' => 'Salud y bienestar', 'class' => 'form-check-input validate-checkbox-8'])->label('Salud y bienestar') ?></div>
              <div class="col-md-6"><?= $form->field($RequestServiceModel,'Check6')->checkbox(['value' => 'Otros', 'class' => 'form-check-input validate-checkbox-8'])->label('Otros') ?></div>
            </div>
            <div class="my-3 text-danger" id="checkbox-error-8">Debe seleccionar al menos un check</div>
            <div class="mt-4 mb-3">
              Coméntanos más detalles de lo que necesitas para tu proyecto.
            </div>
            <?= $form->field($RequestServiceModel,'Description')->textarea(['id'=>'description-require-service-modal','rows'=>6])->label(false); ?>
            <?= $form->field($RequestServiceModel,'ServiceID')->hiddenInput(['value' => 8])->label(false); ?>

            <div class="d-flex mb-3 gap-3 align-items-md-center flex-column flex-md-row justify-content-between mt-4">
              <?= Html::a('<i class="fa-solid fa-globe"></i> Más información','https://dev.mydesk.digital/NewWeclickUp/services/appsmovile', ['class' => 'btn', 'style' => 'background: #4161FF; border: none; color: #fff; padding: 0.3rem 1.5rem;', 'target' => '_blank', 'rel' => 'noopener noreferrer'])?>
              <?= Html::submitButton('Enviar',['class'=>'btn btnadquirir-8', 'style' => 'background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;', 'disabled' => true]);?>
            </div>
          </div>
          
        </div>
      </div>
    <?php Activeform::end(); ?>
  </div>
</div>



<!-- ##################################################################### -->

<!-- Modal completar datos faltantes -->
<div class="modal fade" id="completeInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin() ?>
      <div class="modal-content">
        <div class="modal-header d-flex juatify-content-end">
          <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3 fs-3 lh-sm" style="color: var(--bs-dark);">Termine de completar su información</div>
          <?php if(empty($UserData->CountryID)): ?>
            <?= $form->field($completeI, 'CountryID')->dropDownList($contryList, ['style' => 'background: var(--bs-modal); color: var(--bs-dark);', 'options' => [$countryCode => ['Selected' => true]]]) ?>
          <?php endif ?>
          <?php if(empty($UserData->NumberPhone)): ?>
            <?=  $form->field($completeI, 'NumberPhone')->textInput(['style' => 'background: var(--bs-modal); color: var(--bs-dark);', 'onkeypress' => 'return /\d/.test(event.key)']); ?>
          <?php endif ?>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="submit" class="btn m-auto" style="background: #FF0351; border: none; color: #fff; padding: 0.3rem 3.5rem;">Guardar</button>
        </div>
      </div>
    <?php ActiveForm::end() ?>
  </div>
</div>
<?php 

  //Activeform::end();
  //Modal::end(); 

$JS =<<<JS
/* $(".require-btn").click(function(e){
  let id =  $(this).data('serviceid');
  let name =  $(this).data('name');
  let img =  $(this).data('img');
  let link =  $(this).data('link');

  $("#description-require-service-modal").val("");
  $("#serviceid-require-service-modal").val(id);

  $("#title-require-service-modal").html(name);
  $("#img-require-service-modal").attr("src",img);
  $("#link-require-service-modal").attr("href",link);

  $("#Require-Service").modal('show')

}); */

JS;

$this->registerJS($JS);
?>
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
  $JS =<<<JS
    const btnA = document.querySelectorAll('.require-btn')
    btnA.forEach(b => {
      b.addEventListener('click', () =>{
        //alert(b.dataset.serviceid)
        var checkboxes = document.querySelectorAll('.validate-checkbox-'+b.dataset.serviceid);
        var errorDiv = document.getElementById('checkbox-error-'+b.dataset.serviceid);
        var btnAdquirir = document.querySelector('.btnadquirir-'+b.dataset.serviceid);
        
        function validateCheckboxes() {
            var atLeastOneChecked = Array.from(checkboxes).some(function(checkbox) {
                return checkbox.checked;
            });
            
            errorDiv.style.display = atLeastOneChecked ? 'none' : 'block';
            btnAdquirir.disabled = !atLeastOneChecked
        }
        
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', validateCheckboxes);
        });
        
        validateCheckboxes(); // Validación inicial
      })
    })
  JS;
    $this->registerJS($JS);
?>
