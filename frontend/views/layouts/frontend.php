<?php
    use frontend\assets\AppAsset;
    use frontend\assets\AppAssetLayoutAll;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use common\models\VisitCount;
    use \yii\web\Cookie;

    $visit = Yii::$app->AccessControl->VisitGet();
    $soymayor = Yii::$app->AccessControl->EdadGet();
    $OnModal = false;
    //Yii::$app->AccessControl->EdadRemove();
    if(!$soymayor){
        $OnModal = true;
    }


    if(!$visit){
        Yii::$app->AccessControl->VisitSet();
        $v = VisitCount::findOne('visits');
        $v->AmountTotal += 1;
        $v->save();
    }

    AppAsset::register($this);
    $this->beginPage()
?>	
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/home.css" rel="stylesheet">
        <link href="css/reembolso.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/5d79548a92.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" href="<?= Yii::getAlias('@web').'/images/icons/mountain.svg'?>"/>
        <meta name="facebook-domain-verification" content="hubi0crlzuec9nktnfl9fbg8at7t0d" />
        <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-NWHNH3W');</script>
        <!-- End Google Tag Manager -->

        
        <!-- Facebook Pixel Code -->
            <script>
                !function(f,b,e,v,n,t,s)
                {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '465787044366835');
                fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=465787044366835&ev=PageView&noscript=1" /></noscript>
        <!-- End Facebook Pixel Code -->
        
        <?php if($OnModal): ?> 
        <script>
        $(document).ready(function(){
            $("#ModalWelcomeValidate").modal({backdrop: 'static', keyboard: false})  
            $("#ModalWelcomeValidate").modal("show");
        });
            
            function confirmEdad(){

               let dd = $("#ddConf").val();
               let mm = $("#mmConf").val();
               let yy = $("#yyConf").val();

               if(dd.length < 2 || mm.length < 2 || yy.length < 4 ){
                return false;
               }

                let _Date = yy + '-' + mm + '-' + dd;

                let BDseconds = new Date(_Date).getTime() / 1000;
                let ActSeconds = new Date().getTime() / 1000;

                let AgeSeconds = ActSeconds - BDseconds;

                let AgesC = AgeSeconds / 31536000;

                if(AgesC >= 18 ){
                    $.get('<?= Url::to(['setedadcookie'])?>',function(r){

                        location.reload();
                    });
                }else{
                    return false;

                }
            }
        </script>
        <style type="text/css">
            .inp-c-e {
              height: 80px;
              width: 100%;
              background-color: #f9f8f8;
              border: solid #f9f8f8 1px; 
              text-align: center;
            }
            .inp-c-e::-webkit-input-placeholder {
              text-align: center;
              line-height: 100px;/* Centrado vertical */
              color :#dcd9d9;
            }
            
            .width-btn-resp{
                    width: 40%;
                }
            
            @media screen and (max-width: 767px){
                .width-btn-resp{
                    width: 70%;
                }
            
            }

        </style>
        <?php endif; ?>
        
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NWHNH3W"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php 
            $this->beginContent('@app/views/site/head.php'); 
            $this->endContent();
        ?>
        <?= $content ?>
        <?php 
            $this->beginContent('@app/views/site/footer.php'); 
            $this->endContent();
        ?>
        
        <div class="modal fade" id="ModalWelcomeValidate" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header modal-footer-border-1 d-flex justify-content-end">
                
              </div>
              <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <img src="<?= Yii::getAlias('@web').'/images/icon-register.png'?>" style="max-height: 150px;">
                            <img src="<?= Yii::getAlias('@web').'/images/productos/2.png'?>" style="max-height:100px; margin-left: -50px; margin-top:auto;">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center align-items-center mt-2" style="text-align: center;flex-direction: column;">
                            <h2 class="text-mc-3 font-bold blue">BIENVENIDO</h2>
                            <p class="grey" style="font-size:0.7rem;">Debes ser mayor de edad para ingresar a este sitio. <br> Ingresa tus datos:</p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="row" style="font-size: 1.5rem;">
                                <div class="col-4">
                                    <!-- <input type="number" name="" id="ddConf" placeholder="DD" class="inp-c-e"> -->
                                    <select id="ddConf" class="inp-c-e" placeholder="DD">
                                         <option value="01" >01</option>
                                         <option value="02" >02</option>
                                         <option value="03" >03</option>
                                         <option value="04" >04</option>
                                         <option value="05" >05</option>
                                         <option value="06" >06</option>
                                         <option value="07" >07</option>
                                         <option value="08" >08</option>
                                         <option value="09" >09</option>
                                         <option value="10" >10</option>
                                         <option value="11" >11</option>
                                         <option value="12" >12</option>
                                         <option value="13" >13</option>
                                         <option value="14" >14</option>
                                         <option value="15" >15</option>
                                         <option value="16" >16</option>
                                         <option value="17" >17</option>
                                         <option value="18" >18</option>
                                         <option value="19" >19</option>
                                         <option value="20" >20</option>
                                         <option value="21" >21</option>
                                         <option value="22" >22</option>
                                         <option value="23" >23</option>
                                         <option value="24" >24</option>
                                         <option value="25" >25</option>
                                         <option value="26" >26</option>
                                         <option value="27" >27</option>
                                         <option value="28" >28</option>
                                         <option value="29" >29</option>
                                         <option value="30" >30</option>
                                         <option value="31" >31</option>
                                     </select>
                                </div>
                                <div class="col-4">
                                     <select id="mmConf" class="inp-c-e" placeholder="MM">
                                         <option value="01" >Enero</option>
                                         <option value="02" >Febrero</option>
                                         <option value="03" >Marzo</option>
                                         <option value="04" >Abril</option>
                                         <option value="05" >Mayo</option>
                                         <option value="06" >Junio</option>
                                         <option value="07" >Julio</option>
                                         <option value="08" >Agosto</option>
                                         <option value="09" >Septiembre</option>
                                         <option value="10" >Octubre</option>
                                         <option value="11" >Noviembre</option>
                                         <option value="12" >Diciembre</option>
                                     </select>
                                </div>
                                <div class="col-4">
                                    <select id="yyConf" placeholder="AAAA" class="inp-c-e">
                                        <?php for ($i=2005; $i >= 1930  ; $i--):  ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button onclick="confirmEdad()" class="edad-analytics white button-mc-red font-bold button-mc-aux width-btn-resp" >ENTRAR</button>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer modal-footer-border-1 d-flex justify-content-center p-0">
                
                <div class="container-fluid" style="background-image: url(<?= Yii::getAlias('@web').'/images/wave-d-1.png'?>);background-repeat: no-repeat;background-position: center center;background-size: cover;height: 80px;">
                    </div>
                <div class="container-fluid" style="background-image: url(<?= Yii::getAlias('@web').'/images/footer-welcome.jpg'?>);background-repeat: no-repeat;background-position: center center;background-size: cover;height: 80px;">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="https://www.molsoncoors.com/privacy-policy" class="politicas-mayor-18" target="_blank">
                                <p class="m-0 text-mc-2-5 blue pointer">POLÍTICAS DE PRIVACIDAD <i class="fas fa-arrow-right blue"></i></p> 
                                <p class="m-0 grey text-mc-2-5-1 item-footer-a-2">Producto para mayores de 18 años. ©2021 Coors Brewing Company, Golden, CO</p>
                            </a>
                        </div>
                        <div class="col-md-6">
                            
                        </div>

                    </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>

        
           <?= $this->endBody() ?>
     
    </body>
</html>


<?php $this->endPage() ?>
