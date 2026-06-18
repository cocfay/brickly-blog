<?php
use backend\assets\AppAssetTemplateNew;
use yii\helpers\Html;
use yii\helpers\Url;
\yii\web\YiiAsset::register($this);
AppAssetTemplateNew::register($this);
$MenuOptions = Yii::$app->AccessControl->MenuOptiions();
$arrayMes = ['','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];
$controllerM = Yii::$app->controller->id;
$UserData = Yii::$app->AccessControl->Verify([]);
?>	

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <link rel="shortcut icon" href="<?= Yii::getAlias("@web") ?>/images/favicon.png"/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weclick administrativo</title>
  <head>
  
    <?php $this->head() ?>
    <?= Html::csrfMetaTags(); ?>
  <style>
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
        color: unset !important;
    }
    .chat-conversation {
        height: calc(100vh - 100px);
        overflow:auto;
        /* height:unset !important; */
    }
    :root {
      --tooltipcolor: #1e90ff;
    }

    .tooltip-menu {
      position: relative;
      display: inline-block;
    }

    .tooltip-menu .tooltip-menu-text {
      visibility: hidden;
      width: 120px;
      background-color: var(--tooltipcolor);
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      position: absolute;
      z-index: 1;
      top: 12px;
      left: 110%;
    }

    .tooltip-menu .tooltip-menu-text::after {
      content: "";
      position: absolute;
      top: 50%;
      right: 100%;
      margin-top: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: transparent var(--tooltipcolor) transparent transparent;
    }
    .tooltip-menu:hover .tooltip-menu-text {
      visibility: visible;
    }
    .themeActive{
      border: 2.5px solid #af46af;
      border-radius: 8px;
    }
    .custom-modal-size.modal-dialog {
      max-width: 650px; /* o el tamaño que prefieras */
    }
  </style>
</head>
<?php $this->beginBody() ?>
<body style="min-height: 100vh;">

  <!-- MENU MOVIL -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="menuMovil" aria-labelledby="offcanvasExampleLabel" style="background-color: var(--bs-white);">
    <div class="offcanvas-header d-flex justify-content-between align-items-center">
      <!-- <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5> -->
      <img src="<?= Url::to('@raizweb') ?>/images/logo.png" style="width: 80px;" alt="logo">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex justify-content-between flex-column h-100">
      <div class="d-flex flex-column gap-2">
        <a class="fs-5 d-flex align-items-center gap-2 mb-2 nav-link px-0 <?= ($controllerM == 'home')? 'active':''; ?>" href="<?= Url::to(['/home']);?>" style="border-radius: 0px; color: var(--bs-dark)">
          <i class="fa fa-house" style="width: 21px; text-align: center;"></i>
          <div class="label-menu text-nowrap">Inicio</div>
        </a>
        <?php foreach($MenuOptions as $menu): ?>
          <?php if($menu->Type == 1): ?>
            <a id="pills-user-tab" href="<?= Url::to([$menu->ControllerUse.'/'.$menu->Path]); ?>" class="mb-2 fs-5 nav-link d-flex align-items-center gap-2 px-0 <?= ($controllerM == $menu->ControllerUse)? 'active':''; ?>" style="border-radius: 0px; color: var(--bs-dark)">
              <i class="<?= $menu->ClassIcon ?>" style="width: 21px; text-align: center;"></i>
              <div class="label-menu text-nowrap" style="max-width: 140px; text-overflow: ellipsis; overflow: hidden;"><?= $menu->MenuName; ?></div>
            </a>
          <?php else: ?>
            <a aria-haspopup="true" href="javascript:void(0);" class="fs-5 tooltip-menu nav-link px-0 <?= ($controllerM == $menu->ControllerUse)? 'active':''; ?>" aria-expanded="false" style="color: var(--bs-dark);">
              <i class="<?= $menu->ClassIcon ?>" style="width: 21px; text-align: center;"></i>
              <!-- <span class="tooltip-menu-text" style="font-size:15px; padding: 6px 0; line-height: 1.1;"><?= $menu->MenuName; ?></span> -->
              <div class="label-menu text-nowrap" style="max-width: 140px; text-overflow: ellipsis; overflow: hidden;"><?= $menu->MenuName; ?></div>
            </a>
            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-end dropdown-menu" data-bs-popper="static">
              <?php foreach ($menu->page as $key => $page): ?>
                <a href="<?= Url::to([$menu->ControllerUse.'/'.$page->PagePath]); ?>" tabindex="0" role="menuitem" class="dropdown-item tooltip-menu" style="color: var(--bs-dark);">
                  <i class="<?= $page->ClassIcon; ?> float-end text-muted" style="width: 21px; text-align: center;"></i>
                  <div class="label-menu text-nowrap" style="max-width: 140px; text-overflow: ellipsis; overflow: hidden;"><?= $page->PageName; ?></div>
                  <!-- <span class="tooltip-menu-text"><?= $page->PageName; ?></span> -->
                </a>
                <div tabindex="-1" class="dropdown-divider"></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <div>
        <ul class="side-menu-nav justify-content-center flex-column nav">
          <li class="profile-user-dropdown dropup dropdown nav-item px-0" data-bs-toggle="modal" data-bs-target="#changeTheme">
            <a id="light-dark" class="nav-link d-flex align-items-center gap-2 px-0 fs-5">
              <i class="fa fa-circle-half-stroke" style="width: 21px;"></i>
              <div class="label-menu text-nowrap d-block">Cambiar tema</div>
            </a>
          </li>
          <li class="nav-item">
            <a id="pills-user-tab" href="<?= Url::to(['/site/logout']); ?>" class="nav-link d-flex align-items-center gap-2 px-0 fs-5">
              <i class="fa-solid fa-right-from-bracket" style="width: 21px;"></i>
              <div class="label-menu text-nowrap d-block">Cerrar sesión</div>
              <!-- <span class="tooltip-menu-text" style="font-size:15px;padding:0px; line-height: 2.1;">Cerrar sesión</span> -->
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div id="root">
    <div class="layout-wrapper d-lg-flex">
      <!-- Menu -->
        <div class="side-menu flex-lg-column px-2 d-none d-lg-flex" style="z-index:100;">
          <div class="position-absolute start-100 translate-middle fixed-menu" style="top: 5%; z-index: 999; cursor: pointer;">
            <div class="pin-background" style="width: 30px; height: 30px; background: var(--menu-color); display: grid; place-items:center;">
              <i class="fa-solid text-white ms-2" style="color: var(--color-items-menu) !important;"></i>
              <!-- <i class="fa-solid fa-angle-left fa-thumbtack"></i> -->
            </div>
          </div>
          <div class="navbar-brand-box" style="padding:10px;font-size:1.1rem;font-weight:bold;">
            <!-- <a class="logo logo-dark" href="/">
              <span class="logo-sm"><img src="/Medic2/images/logo.png" alt="logo" height="30"></span>
            </a>
            <a class="logo logo-light" href="/">
              <span class="logo-sm"><img src="/Medic2/images/logo.png" alt="logo" height="30"></span>
            </a> -->
            <img src="<?= Url::to('@raizweb') ?>/images/logo.png" alt="logo" class="d-none">
            <div class="logoMenu mt-3" style="height: 41px;"><a href="https://www.weclickdigital.com/" target="_blank" rel="noopener noreferrer"><img src="<?= Url::to('@raizweb') ?>/images/logo.png" alt="logo"></a></div>
          </div>
          <div class="mb-auto mt-5" style="overflow-y: auto; overflow-x: hidden;">
            <ul role="tablist" class="side-menu-nav nav-pills justify-content-center flex-column nav">
              <li class="nav-item">
                <a class="d-flex align-items-center mb-2 nav-link px-0 <?= ($controllerM == 'home')? 'active':''; ?>" href="<?= Url::to(['/home']);?>" style="border-radius: 0px;">
                  <i class="fa fa-house"></i>
                  <div class="label-menu text-nowrap" style="font-size: 16px;">Inicio</div>
                </a>
              </li>
              <?php foreach($MenuOptions as $menu): ?>
                <?php if($menu->Type == 1): ?>
                <li class="nav-item">
                  <a id="pills-user-tab" href="<?= Url::to([$menu->ControllerUse.'/'.$menu->Path]); ?>" class="mb-2 nav-link d-flex align-items-center px-0 <?= ($controllerM == $menu->ControllerUse)? 'active':''; ?>" style="border-radius: 0px;">
                    <i class="<?= $menu->ClassIcon ?>"></i>
                    <div class="label-menu text-nowrap" style="font-size: 16px; max-width: 140px; text-overflow: ellipsis; overflow: hidden;"><?= $menu->MenuName; ?></div>
                  </a>
                </li>
                <?php else: ?>
                  <li class="profile-user-dropdown dropup dropdown nav-item">
                    <a aria-haspopup="true" href="javascript:void(0);" class="tooltip-menu d-flex align-items-center nav-link px-0 <?= ($controllerM == $menu->ControllerUse)? 'active':''; ?>" aria-expanded="false">
                      <i class="<?= $menu->ClassIcon ?>"></i>
                      <!-- <span class="tooltip-menu-text" style="font-size:15px; padding: 6px 0; line-height: 1.1;"><?= $menu->MenuName; ?></span> -->
                      <div class="label-menu text-nowrap" style="font-size: 16px; max-width: 140px; text-overflow: ellipsis; overflow: hidden;"><?= $menu->MenuName; ?></div>
                    </a>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-end dropdown-menu" data-bs-popper="static">
                      <?php foreach ($menu->page as $key => $page): ?>
                        <a href="<?= Url::to([$menu->ControllerUse.'/'.$page->PagePath]); ?>" tabindex="0" role="menuitem" class="dropdown-item tooltip-menu d-flex flex-row-reverse align-items-center justify-content-between">
                          <i class="<?= $page->ClassIcon; ?> float-end text-muted"></i>
                          <div class="label-menu text-nowrap"><?= $page->PageName; ?></div>
                          <!-- <span class="tooltip-menu-text"><?= $page->PageName; ?></span> -->
                        </a>
                        <div tabindex="-1" class="dropdown-divider"></div>
                      <?php endforeach; ?>
                    </div>
                  </li>

                <?php endif; ?>
              <?php endforeach; ?>
              <!-- <li id="profile" class="nav-item">
                <a id="pills-user-tab" class="mb-2 nav-link"><i class="fa fa-user"></i></a>
              </li>
              <li id="Chats" class="nav-item">
                <a id="pills-chat-tab" class=" mb-2 nav-link"><i class="fa fa-cogs"></i></a>
              </li>
              <li id="Groups" class="nav-item">
                <a id="pills-groups-tab" class=" mb-2 nav-link"><i class="fa fa-box"></i></a>
              </li>
              <li id="Contacts" class="nav-item">
                <a id="pills-contacts-tab" class=" mb-2 nav-link"><i class="fa fa-list"></i></a>
              </li>
              <li id="Settings" class="nav-item">
                <a id="pills-setting-tab" class="nav-link"><i class="fa fa-arrow-left"></i></a>
              </li>
              <li class="profile-user-dropdown d-inline-block dropup dropdown nav-item">
                <a aria-haspopup="true" href="javascript:void(0);" class="nav-link" aria-expanded="false">
                  <img src="/Medic2/images/logo.png" alt="chatvia" class="profile-user rounded-circle">
                </a>
                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-end dropdown-menu" data-bs-popper="static">
                  <button type="button" tabindex="0" role="menuitem" class="dropdown-item">Profile <i class="fa fa-user float-end text-muted"></i></button>
                  <button type="button" tabindex="0" role="menuitem" class="dropdown-item">Setting <i class="fa fa-lock float-end text-muted"></i></button>
                  <div tabindex="-1" class="dropdown-divider"></div>
                  <a href="/logout" tabindex="0" role="menuitem" class="dropdown-item">Log out <i class="fa fa-circle float-end text-muted"></i></a>
                </div>
              </li> -->
            </ul>
          </div>
          <div class="flex-lg-column d-none d-lg-block overflow-hidden">
            <ul class="side-menu-nav justify-content-center flex-column nav">
              <!-- <li class="profile-user-dropdown dropup dropdown nav-item px-0" data-bs-toggle="modal" data-bs-target="#changeTheme">
                <a id="light-dark" class="mb-2 nav-link d-flex align-items-center px-0">
                  <i class="fa fa-circle-half-stroke"></i>
                  <div class="label-menu text-nowrap" style="font-size: 16px;">Cambiar tema</div>
                </a>
              </li> -->
              <li class="nav-item">
                <a id="pills-user-tab" href="<?= Url::to(['/site/logout']); ?>" class="mb-2 nav-link d-flex align-items-center px-0">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  <div class="label-menu text-nowrap" style="font-size: 16px;">Cerrar sesión</div>
                  <!-- <span class="tooltip-menu-text" style="font-size:15px;padding:0px; line-height: 2.1;">Cerrar sesión</span> -->
                </a>
              </li>
              <!-- <li class="nav-item btn-group dropup profile-user-dropdown dropdown nav-item">
                <a aria-haspopup="true" class="nav-link mb-2" aria-expanded="false">
                  <img src="<?= $UserData->PhotoUrl? Url::to('@raizweb').'/images/profile/'.$UserData->PhotoUrl : Url::to('@raizweb').'/images/profile/avatar1.png'; ?>" alt="perfil" class="profile-user rounded-circle">
                   <i class="fa-solid fa-gear fs-2"></i>
                   <i class="fa-solid fa-user-gear fs-2"></i>
                </a>
                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" data-bs-popper="static">
                  <a href="<?= Url::to(['/my-account']); ?>" tabindex="0" role="menuitem" class="dropdown-item" style="font-size:0.7rem;">Gestionar cuenta <i class="fa fa-user float-end text-muted"></i></button>
                  <a href="button" tabindex="0" role="menuitem" class="dropdown-item">Setting <i class="fa fa-cogs float-end text-muted"></i></button>
                  <div tabindex="-1" class="dropdown-divider"></div>
                  <a href="<?= Url::to(['/site/logout']); ?>" tabindex="0" role="menuitem" style="font-size:0.7rem;" class="dropdown-item click-confirm" tittle-alert="Cerraras la sesión" text-alert="¿Estas seguro de continuar?">Cerrar Sesión <i class="fa fa-lock float-end text-muted"></i></a>
                </div>
              </li> -->
            </ul>
          </div>
          
        </div>
        <!-- End Menu -->
        <div class="w-100">
        <div class="w-100 position-relative">
          <!-- TOP BAR -->
          <div class="p-3 p-lg-4 me-3 border-bottom user-chat-topbar d-flex justify-content-between justify-content-lg-end align-items-center px-3 position-sticky top-0" style="background-color: var(--bs-white); z-index: 2;">
            <div class="d-block d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#menuMovil" aria-controls="offcanvasExample"><i class="fa-solid fa-bars" style="color: var(--bs-dark)"></i></div>
            <div class="d-flex align-items-center justify-content-end">
              <div class="me-3 ms-0">
                <a href="<?= Url::to(['/my-account']); ?>">
                  <img src="<?= !empty($UserData->PhotoUrl) ? Url::to('@raizweb').'/images/profile/'.$UserData->PhotoUrl : Url::to('@raizweb').'/images/profile/avatar1.png'; ?>" class="rounded-circle avatar-xs" alt="prerfil">
                </a>
              </div>
              <div class="flex-grow-1 ">
                <h5 class="font-size-16 mb-0 text-truncate">
                  <a class="text-reset user-profile-show" href="<?= Url::to(['/my-account']); ?>"><?= (!empty($UserData->Name)) ? $UserData->Name : $UserData->UserName; ?> </a>
                </h5>
              </div>
            </div>
          </div>
          <!-- END Top Bar -->
          <!-- BODY CHAT -->
          <div class="main-content mb-5">
            <?= $content; ?>
          </div>
        </div>
      </div>
  </div>

<!-- Modal -->
<!-- <div class="modal fade mt-5" id="changeTheme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal-size">
    <div class="modal-content">
      <div class="modal-body">
        <h1 class="fs-5 text-center mb-4" id="staticBackdropLabel">Cambiar tema</h1>
        <div class="row selectorTheme">
          <div class="col-4 select-theme-auto pe-0" style="cursor: pointer;">
            <img src="<?= Yii::getAlias("@web"); ?>/images/site/automatico.png" class="w-100" alt="" srcset="">
            <div class="text-center mt-2" style="color: var(--bs-dark)">Automatico</div>
          </div>
          <div class="col-4 select-theme-light" style="cursor: pointer;">
            <img src="<?= Yii::getAlias("@web"); ?>/images/site/claro.png" class="w-100" style="min-height: 211.5px;" alt="" srcset="">
            <div class="text-center mt-2" style="color: var(--bs-dark)">Claro</div>
          </div>
          <div class="col-4 select-theme-dark ps-0" style="cursor: pointer;">
            <img src="<?= Yii::getAlias("@web"); ?>/images/site/oscuro.png" class="w-100" alt="" srcset="">
            <div class="text-center mt-2" style="color: var(--bs-dark)">Oscuro</div>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn mb-2 mt-3 fs-5 choosetheme-close" style="width: fit-content; background-color: var(--bg-bottom-primary); color: #fff; border: none; padding: 0.3rem 4.2rem;" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div> -->
      

     

</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>