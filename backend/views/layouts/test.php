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
<body data-bs-theme="<?= isset($_COOKIE['styleTheme'])? $_COOKIE['styleTheme'] : 'dark'; ?>">
  <div id="root">
    <div class="layout-wrapper d-lg-flex">
      <!-- Menu -->
        <div class="side-menu flex-lg-column px-2" style="z-index:100;">
          <div class="position-absolute start-100 translate-middle fixed-menu" style="top: 5%; z-index: 999; cursor: pointer;">
            <div class="pin-background" style="width: 30px; height: 30px; border-radius: 50%; background: #FF0351; display: grid; place-items:center;">
              <i class="fa-solid text-white"></i>
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
            <div><?= date('d'); ?></div>
            <span><?= $arrayMes[date('n')]; ?></span>
          </div>
          <div class="mb-auto mt-4 overflow-hidden">
            <ul role="tablist" class="side-menu-nav nav-pills justify-content-center flex-column nav">
              <li class="nav-item">
                <a class="d-flex align-items-center gap-2 mb-2 nav-link <?= ($controllerM == 'home')? 'active':''; ?>" href="<?= Url::to(['/home']);?>">
                  <i class="fa fa-house"></i>
                  <div class="label-menu text-nowrap" style="font-size: 16px;">Inicio</div>
                </a>
              </li>
              <?php foreach($MenuOptions as $menu): ?>
                <?php if($menu->Type == 1): ?>
                <li class="nav-item">
                  <a id="pills-user-tab" href="<?= Url::to([$menu->ControllerUse.'/'.$menu->Path]); ?>" class="mb-2 nav-link d-flex align-items-center gap-2 <?= ($controllerM == $menu->ControllerUse)? 'active':''; ?>">
                    <i class="<?= $menu->ClassIcon ?>"></i>
                    <div class="label-menu text-nowrap" style="font-size: 16px;"><?= $menu->MenuName; ?></div>
                  </a>
                </li>
                <?php else: ?>
                  <li class="profile-user-dropdown d-inline-block dropup dropdown nav-item">
                    <a aria-haspopup="true" href="javascript:void(0);" class="tooltip-menu nav-link <?= ($controllerM == $menu->ControllerUse)? 'active':''; ?>" aria-expanded="false">
                      <i class="<?= $menu->ClassIcon ?>"></i>
                      <!-- <span class="tooltip-menu-text" style="font-size:15px; padding: 6px 0; line-height: 1.1;"><?= $menu->MenuName; ?></span> -->
                      <div class="label-menu text-nowrap"><?= $menu->MenuName; ?></div>
                    </a>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-end dropdown-menu" data-bs-popper="static">
                      <?php foreach ($menu->page as $key => $page): ?>
                        <a href="<?= Url::to([$menu->ControllerUse.'/'.$page->PagePath]); ?>" tabindex="0" role="menuitem" class="dropdown-item tooltip-menu">
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
          <div class="flex-lg-column d-none d-lg-block">
            <ul class="side-menu-nav justify-content-center flex-column nav">
              <li class="profile-user-dropdown dropup dropdown nav-item" data-bs-toggle="modal" data-bs-target="#changeTheme">
                <a id="light-dark" class="mb-2 nav-link d-flex align-items-center gap-2">
                  <i class="fa fa-circle-half-stroke"></i>
                  <div class="label-menu text-nowrap" style="font-size: 16px;">Cambiar tema</div>
                </a>
              </li>
              <li class="nav-item">
                  <a id="pills-user-tab" href="<?= Url::to(['/site/logout']); ?>" class="mb-2 nav-link d-flex align-items-center gap-2">
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
        <div class="user-chat w-100 overflow-hidden user-chat-show">
          <div class="d-lg-flex">
            <div class="w-100 overflow-hidden position-relative">
              <!-- TOP BAR -->
              <div class="p-3 p-lg-4 border-bottom user-chat-topbar">
                <div class="align-items-center row">
                  <div class="col-8 col-sm-4">
                    <div class="d-flex align-items-center">
                      <!-- <div class="d-block d-lg-none me-2 ms-0">
                        <a class="user-chat-remove text-muted font-size-16 p-2" href="#"><i class="ri-arrow-left-s-line"></i></a>
                      </div> -->
                      <div class="me-3 ms-0">
                        <a href="<?= Url::to(['/my-account']); ?>">
                          <img src="<?= $UserData->PhotoUrl? Url::to('@raizweb').'/images/profile/'.$UserData->PhotoUrl : Url::to('@raizweb').'/images/profile/avatar1.png'; ?>" class="rounded-circle avatar-xs" alt="prerfil">
                        </a>
                      </div>
                      <div class="flex-grow-1 overflow-hidden">
                        <h5 class="font-size-16 mb-0 text-truncate">
                          <a class="text-reset user-profile-show" href="<?= Url::to(['/my-account']); ?>"><?= (!empty($UserData->Name))? $UserData->Name : $UserData->UserName; ?> </a>
                          <!-- <a href="<?= Url::to(['/site/logout']); ?>" class="text-reset click-confirm" tittle-alert="Cerraras la sesión" text-alert="¿Estas seguro de continuar?" ><i class="fa fa-right-from-bracket font-size-10 text-danger d-inline-block ms-2"></i></a> -->
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-4 col-sm-8">
                    <ul class="list-inline user-chat-nav text-end mb-0">
                      <li class="list-inline-item">
                        <img src="<?= Url::to('@raizweb') ?>/images/logo.png" alt="logo" height="40">
                      </li>
                      <!-- <li class="list-inline-item">
                        <div class="dropdown">
                          <button type="button" aria-haspopup="true" aria-expanded="false" class="btn nav-btn  btn btn-none">
                            <i class="fa fa-search"></i>
                          </button>
                          <div tabindex="-1" role="menu" aria-hidden="true" class="p-0 dropdown-menu-end dropdown-menu-md dropdown-menu" data-bs-popper="static">
                            <div class="search-box p-2">
                              <input placeholder="Search.." type="text" class="form-control bg-light border-0 form-control">
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="list-inline-item">
                        <div class="dropdown">
                          <button type="button" aria-haspopup="true" aria-expanded="false" class="btn nav-btn  btn btn-none"><i class="fa fa-cogs"></i></button>
                          <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-end show dropdown-menu" data-bs-popper="static">
                            <button type="button" tabindex="0" role="menuitem" class="d-block d-lg-none user-profile-show dropdown-item">View profile <i class="fa fa-user float-end text-muted"></i></button>
                            <button tabindex="0" role="menuitem" class="dropdown-item">Archive <i class="fa fa-box float-end text-muted"></i></button>
                            <button tabindex="0" role="menuitem" class="dropdown-item">settigns <i class="fa fa-lock float-end text-muted"></i></button>
                            <button type="button" tabindex="0" role="menuitem" class="dropdown-item">Delete <i class="fa fa-trash float-end text-muted"></i></button>
                          </div>
                        </div>
                      </li> -->
                    </ul>
                  </div>
                </div>
              </div>
              <!-- END Top Bar -->
               <!-- BODY CHAT -->
              <div data-simplebar="init" class="chat-conversation p-5 p-lg-4" id="messages" style="max-height: 100%;">
                <?= $content;  ?>
              </div>
              <!-- END Body CHat -->
              <!-- FOOOTER -->
              <!-- <div class="chat-input-section p-3 p-lg-4 border-top mb-0 ">
                <form class="">
                  <div class="g-0 row">
                    <div class="col">
                      <div>
                        <input placeholder="Enter Message..." type="text" class="form-control form-control-lg bg-light border-light form-control" value="">
                      </div>
                    </div>
                    <div class="col-auto">
                      <div class="chat-input-links ms-md-2">
                        <ul class="list-inline mb-0 ms-0">
                          <li class="list-inline-item">
                            <button type="submit" class="font-size-16 btn-lg chat-send waves-effect waves-light btn btn-primary"><i class="ri-send-plane-2-fill"></i></button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </form>
              </div> -->
              <!-- END FOOTER -->
            </div>
          </div>
        </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="changeTheme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal-size">
    <div class="modal-content">
      <div class="modal-header d-block">
        <h1 class="fs-5 text-center mb-0" id="staticBackdropLabel">Cambiar tema</h1>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <div class="row selectorTheme">
          <div class="col-4 select-theme-auto pe-0" style="cursor: pointer;">
            <img src="<?= Yii::getAlias("@web"); ?>/images/site/automatico.png" class="w-100" alt="" srcset="">
            <div class="text-center mt-2" style="color: var(--bs-dark)">Automatico</div>
          </div>
          <div class="col-4 select-theme-light px-3" style="cursor: pointer;">
            <img src="<?= Yii::getAlias("@web"); ?>/images/site/claro.png" class="w-100" style="min-height: 211.5px;" alt="" srcset="">
            <div class="text-center mt-2" style="color: var(--bs-dark)">Claro</div>
          </div>
          <div class="col-4 select-theme-dark ps-0" style="cursor: pointer;">
            <img src="<?= Yii::getAlias("@web"); ?>/images/site/oscuro.png" class="w-100" alt="" srcset="">
            <div class="text-center mt-2" style="color: var(--bs-dark)">Oscuro</div>
          </div>
        </div>
        <button type="button" class="btn btn-secondary mb-2 mt-3 w-100 fs-5" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

  <?php
  $this->registerJS("

  const ST = document.querySelectorAll('.selectorTheme img') 
 
  $('.select-theme-dark').click(function(e){
      setThemeMode('dark');
      ST.forEach(i => i.classList.remove('themeActive'))
      e.target.classList.add('themeActive')
  })
  $('.select-theme-light').click(function(e){
      setThemeMode('light');
      ST.forEach(i => i.classList.remove('themeActive'))
      e.target.classList.add('themeActive')
  });
  $('.select-theme-auto').click(function(e){
      setThemeMode('auto');
      ST.forEach(i => i.classList.remove('themeActive'))
      e.target.classList.add('themeActive')
  })
  let themeUse = window.localStorage.getItem('themeUse');
 
  if(themeUse){
    setThemeMode(themeUse);
  }else{
    setThemeMode('auto');
  }

  function setThemeMode(theme){
  let iconS = $('#light-dark').find('i');
    switch(theme){
      case 'dark':
        document.querySelector('.select-theme-dark img').classList.add('themeActive')
        window.localStorage.setItem('themeUse', 'dark');
        iconS.removeClass('fa-circle-half-stroke');
        iconS.removeClass('fa-sun');
        iconS.addClass('fa-moon');
        $('body').attr('data-bs-theme','dark');
        var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=dark;' + expires + ';path=/';
        break;
      case 'light':
        document.querySelector('.select-theme-light img').classList.add('themeActive')
        window.localStorage.setItem('themeUse', 'light');
        iconS.removeClass('fa-circle-half-stroke');
        iconS.removeClass('fa-moon');
        iconS.addClass('fa-sun');
        $('body').attr('data-bs-theme','light');
        var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=light;' + expires + ';path=/';
        break;
      case 'auto':
        document.querySelector('.select-theme-auto img').classList.add('themeActive')
        window.localStorage.setItem('themeUse', 'auto');
        iconS.removeClass('fa-moon');
        iconS.removeClass('fa-sun');
        iconS.addClass('fa-circle-half-stroke');
         let dt = new Date();
        let isHour = dt.getHours();
        if(isHour < 17){
          $('body').attr('data-bs-theme','light');
          var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=light;' + expires + ';path=/';
        }else{
          $('body').attr('data-bs-theme','dark');
          var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=dark;' + expires + ';path=/';
        }

        break;
    }

  }
  $('.nav-item').click(function(e){
       if(!$(this).hasClass('show')){
          $('.nav-item').each((i,el)=>{
            $(el).removeClass('show');
            console.log(el)
            $(el).find('.dropdown-menu').removeClass('show');
          })

          $(this).addClass('show');
          let subM = $(this).find('.dropdown-menu');
          if(subM.length > 0){
            subM.addClass('show');
          }
       }else{
        $('.nav-item').each((i,el)=>{
            $(el).removeClass('show');
            console.log(el)
            $(el).find('.dropdown-menu').removeClass('show');
          })
       
       }
  });
  
  document.querySelector('.pin-background i').classList.add('fa-thumbtack')
  document.querySelector('.fixed-menu').addEventListener('click', () => {
      document.querySelector('.side-menu').classList.toggle('pin')
      document.querySelector('.user-chat.w-100.overflow-hidden.user-chat-show').classList.toggle('pin')
      if(document.querySelector('.side-menu').classList.contains('pin')){
        document.querySelector('.pin-background i').classList.remove('fa-thumbtack')
        document.querySelector('.pin-background i').classList.add('fa-angle-left')
        document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
          d.style.display = 'block'
        })
      }
      else{
        document.querySelector('.pin-background i').classList.remove('fa-angle-left')
        document.querySelector('.pin-background i').classList.add('fa-thumbtack')
        document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
          d.style.display = 'none'
        })
      }
  })

  const sideMenu = document.querySelector('.side-menu')
  const navLinks = document.querySelectorAll('ul.side-menu-nav')
 
  document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
      d.style.display = 'none'
  })

 /*  document.querySelector('.pin-background i').addEventListener() */

  navLinks.forEach(i =>{
    i.addEventListener('mouseenter', () =>{
      if(!sideMenu.classList.contains('pin')){
        document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
          d.style.display = 'block'
        })
        sideMenu.classList.add('open')
      }
    })
    i.addEventListener('mouseout', (e) => {
      if(!i.contains(e.relatedTarget)) {
        if(!sideMenu.classList.contains('pin')){
          document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
            d.style.display = 'none'
          })
          sideMenu.classList.remove('open');
        }
      }
    })
  });

"); ?>

<?= Yii::$app->getModule('jc-chat')->ShowClient(); ?>

</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>

