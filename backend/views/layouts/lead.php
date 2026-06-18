<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
$this->beginPage()
?>  


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"/>
        <!-- Add the new slick-theme.css if you want the default styling -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"/>
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/general.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/home.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/blog.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/foro.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/temaforo.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/foroCategorias.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/perfil.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/colecciones.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/Ranking.css">
        <link rel="stylesheet" href="<?=Url::to(['/css'])?>/post.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <?php $this->head() ?>
    </head>
    <body>
    
    <header>
        <div class="contenedorHeaderHome">
            <div class="headerRedes">
                <span data-section="topmenu" data-value="title">
                    ¡Suscríbete y mira lo que sigue! Únete a nuestras reddes sociales
                </span>
                <div class="contenedorIconosHeader">
                    <a href="" target="_blank" class="">
                        <img class="itemHeader" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoTiktok.png" alt="Tiktok">
                    </a>
                    <a href="" target="_blank" class="">
                        <img class="itemHeader" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoFB.png" alt="Facebook">
                    </a>
                    <a href="" target="_blank" class="">
                        <img class="itemHeader" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoTL.png" alt="Telegram">
                    </a>
                    <a href="" target="_blank" class="">
                        <img class="itemHeader" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoIG.png" alt="Instagram">
                    </a>
                </div>
            </div>
            <div class="container">
                <div class="ContenedorMenu">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?= Yii::getAlias('@web'); ?>/home">
                                <img class="Logo" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/LogoTemporal.png" alt="Logo">
                            </a>
                        </div>
                        <div class="col-md-4">
                            <ul class="menu">
                                <a href="<?= Yii::getAlias('@web'); ?>/blog">
                                    <li data-section="menu" data-value="blog">
                                        Blog
                                    </li>
                                </a>
                                <a href="<?= Yii::getAlias('@web'); ?>/ranking">
                                    <li>
                                        Ranking
                                    </li>
                                </a>
                               <!--  <a href="<?= Yii::getAlias('@web'); ?>/forum">
                                    <li>
                                        Foro
                                    </li>
                                </a> 
                                <a href="">
                                    <li>
                                        Tienda
                                    </li>
                                </a>-->
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="menuUser">
                                <a href="<?= Yii::getAlias('@web'); ?>/profile/profile" class="">
                                    <img class="itemMenu" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoUser.png" alt="Usuario">
                                </a>
                                <!-- <a href="#" class="">
                                    <img class="itemMenu" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoCarretilla.png" alt="Tienda">
                                </a>-->
                                <a href="#" class="">
                                    <img class="itemMenu" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoLupa.png" alt="Buscar">
                                </a>
                                <a href="#" class="">
                                    <img class="itemMenu IconosBanderas" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/BanderaInglés.png" alt="Idioma">
                                    <!-- <div id="google_translate_element"></div> -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?php $this->beginBody() ?>
        <?= $content ?> 
    <?php $this->endBody() ?>

    <footer>
        <div class="container">
            <div class="contenedorFooter">
                <div class="contenidoFooter">
                    <div class="correoFooter">
                        <p class="tituloFooter" data-section="footer" data-value="title">
                            MANTENTE INFORMADO
                        </p>
                        <form action="">
                            <div class="contenedorBotonCorreo">
                                <input name="subcription-email" data-section="footer" data-value="input-text" type="text" placeholder="Ingresa tú correo">
                                <button class="botonCorreo" type="submit" data-section="footer" data-value="button-tern">Continuar</button>
                            </div>
                            <div class="checkboxConfirmar">
                                <input type="checkbox" id="checkboxConfirmar" name="checkboxConfirmar" value="">
                                <label for="checkboxConfirmar" data-section="footer" data-value="term"> Al hacer clic en continuar, confirmo que deseo recibir noticias, ofertas epeciales y otras información de Check List Toys. Haz clic para leer la Declaración de privacidad de Check List Toys.</label>
                            </div>
                        </form>
                    </div>
                    <div class="menuFooter">
                        <div class="row">
                            <div class="col-md-4">
                                <ul>
                                    <li>
                                        <a href="">
                                            <p class="tituloMenuFooter" data-section="footer" data-value="list1">SERVICIOS</p>
                                        </a> 
                                    </li>
                                    <li>
                                         <a href="">
                                            <p class="textoMenuFooter" data-section="footer" data-value="item1a">PREGUNTAS FRECUENTES</p>
                                         </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <p class="textoMenuFooter" data-section="footer" data-value="item1b">ACERCA DE NOSOTROS</p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="">
                                            <p class="textoMenuFooter" data-section="footer" data-value="item1c">CONTACTANOS</p>
                                        </a> 
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul>
                                    <li>
                                        <a href="">
                                            <p class="tituloMenuFooter" data-section="footer" data-value="list2">MIENBROS</p>
                                        </a> 
                                    </li>
                                    <li>
                                         <a href="">
                                            <p class="textoMenuFooter" data-section="footer" data-value="item2a">ACERCA DE NUESTRAS MEMBRESIAS</p>
                                         </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <p class="tituloMenuFooter" data-section="footer" data-value="list3">LEGAL</p>
                                        </a> 
                                    </li>
                                    <li>
                                         <a href="<?=Yii::getAlias("@web");?>/legal/termsandconditions">
                                            <p class="textoMenuFooter" data-section="footer" data-value="item3a">TERMINOS Y CONDICIONES</p>
                                         </a>
                                    </li>
                                    <li>
                                        <a href="<?=Yii::getAlias("@web");?>/legal/privacystatement">
                                            <p class="textoMenuFooter" data-section="footer" data-value="item3b">DECLARACION DE PRIVACIDAD</p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="">
                                            <p class="textoMenuFooter" data-section="footer" data-value="item3c">POLITICA DE COOKIES</p>
                                        </a> 
                                    </li>
                                </ul>
                                <div class="contenedorIconosFooter">
                                    <a href="" target="_blank" class="iconosFooter">
                                        <img class="itemFooter" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoTiktok.png" alt="Tiktok">
                                    </a>
                                    <a href="" target="_blank" class="iconosFooter">
                                        <img class="itemFooter" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoFB.png" alt="Facebook">
                                    </a>
                                    <a href="" target="_blank" class="iconosFooter">
                                        <img class="itemFooter" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoTL.png" alt="Telegram">
                                    </a>
                                    <a href="" target="_blank" class="iconosFooter">
                                        <img class="itemFooter" src="<?=Url::to(['/images'])?>/Iconos-tiquetas/IconoIG.png" alt="Instagram">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="derechos">
                        <p class="textoFooter">
                            Check List Toys 2022. <span data-section="footer" data-value="copyright">Todos los derechos reservados.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="<?=Yii::getAlias("@web")?>/js/globals/app.js"></script>
    <!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.slick-carousel').slick({
                slidesToShow: 1,
                autoplay: true,
                autoplaySpeed: 2600
            });


            $('.imagenPerfil').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                arrows: false,
                asNavFor: '.verticalPerfil'
            });
            $(".verticalPerfil").slick({
                dots: false,
                vertical: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: false,
                focusOnSelect: true,
                asNavFor: '.imagenPerfil',
                responsive: [
                {
                    breakpoint: 769,
                    settings: {
                        vertical: false,
                        slidesToShow: 2
                    }
                    }
                ]
            });

            $('.MultiCarousel-slick').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                asNavFor: '.MultiCarousel-slick-nav',
                autoplay: true,
                autoplaySpeed: 5000,
                responsive: [
                {
                    breakpoint: 769,
                    settings: {
                        arrows: false
                    }
                    }
                ]
            });
            $('.MultiCarousel-slick-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.MultiCarousel-slick',
                dots: false,
                centerMode: true,
                arrows: false,
                focusOnSelect: true,
                responsive: [
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                    }
                ]
            });

            
            $(".animated-progress span").each(function () {
            $(this).animate(
                {
                width: $(this).attr("data-progress") + "%",
                },
                1000
            );
            $(this).text($(this).attr("data-progress") + "%");
            });


        });
    </script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    </body>
</html>
<?php $this->endPage() ?>
