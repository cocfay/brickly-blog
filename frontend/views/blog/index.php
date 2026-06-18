<?php
    use yii\helpers\Url;
    use yii\widgets\LinkPager;
    
    $this->title = "Blog";

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
        1 => $lang == 'es' ? 'Enero' : 'January',
        2 => $lang == 'es' ? 'Febrero' : 'Febrary',
        3 => $lang == 'es' ? 'Marzo' : 'March',
        4 => $lang == 'es' ? 'Abril' : 'April',
        5 => $lang == 'es' ? 'Mayo' : 'May',
        6 => $lang == 'es' ? 'Junio' : 'June',
        7 => $lang == 'es' ? 'Julio' : 'July',
        8 => $lang == 'es' ? 'Agosto' : 'August',
        9 => $lang == 'es' ? 'Septiembre' : 'September',
        10 => $lang == 'es' ? 'Octubre' : 'October',
        11 => $lang == 'es' ? 'Noviembre' : 'November',
        12 => $lang == 'es' ? 'Diciembre' : 'Dicember'
    ];
?>

<style>
    .marginY{
        margin: 8rem auto 6rem auto;
    }
    .article:hover .lh-sm:not(.bg-lila){
        color: #FF0461 !important;
    }
    @media screen and (max-width: 834px) {
        .marginY{
            margin: 2rem auto;
        }
    }
    @media screen and (max-width: 576px) {
        .main-post .title{
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
            position: relative;
            line-height: 1.5em;
        }

        .main-post .description{
            -webkit-line-clamp: 3 !important;
        }
    }
</style>

<div class="container">
    <div class="menu-fixed d-none d-md-block"></div>
</div>
<div class="d-none d-md-block"><br><br></div>
<div class="container marginY">
    <div class="row mx-0">
        <div class="col-12" style="margin-bottom: clamp(1.5rem, 6vw, 5.3rem);">
            <div class="text-center">
                <div style="font-size: clamp(1.8rem, 2.6vw, 4rem)" class="mb-2" data-section="blog" data-value="text1">Software y desarrollo</div>
                <div class="lh-sm" style="font-size: clamp(16px, 1.6vw, 30px)" data-section="blog" data-value="text2">Las tendencias que están moldeando el futuro de la tecnología</div>
            </div>
            <!-- <div class="d-none d-lg-flex align-items-center flex-column flex-lg-row justify-content-center justify-content-lg-between mt-5">
                <div class="d-flex gap-4">
                    <div>Categorio 1</div>
                    <div>Categorio 2</div>
                    <div>Categorio 3</div>
                    <div>Categorio 4</div>
                </div>
                <div><i class="fa-solid fa-magnifying-glass text-white fs-3"></i></div>
            </div> -->
        </div>
        <div class="col-lg-8 pe-0 pe-md-4 ps-0 ps-md-2">
            <div class="row mx-0 px-0 vlog article main-post">
                <?php $leftPosts = array_slice($result, 0, 4); ?>
                <?php foreach($leftPosts as $index => $datos): ?>
                    <div class="col-12 px-2 px-md-0 my-4 mb-5">
                        <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>" class="text-decoration-none text-white">
                            <div class="position-relative"><img src="<?= $datos->ImagePost ?>" class="w-100" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover;"></div>
                            <div class="my-3 lh-sm title text-limit-2" style="font-size: clamp(22px, 1.55vw, 30px)"><?= $datos->title ?></div>
                            <div class="text-limit-2 description" style="font-size: clamp(1rem, 1.1vw, 18px)">
                                <?php $c = $datos->centerComponents[0] ?>
                                <?php if($c->Type == 1):?>
                                        <?= strip_tags($c->textBoxC->Description) ?>
                                <?php endif ?>
                            </div>
                        </a>
                        <div class="d-flex gap mt-3 align-items-center tags-entry">
                            <?php foreach($datos->blogBy as $tags): ?>
                                <a href="<?= Url::to(['categories', 'id' => $tags->CollectionID]) ?>" class="text-decoration-none text-white"><div style="background:#0D0D22; border:1px solid white; border-radius: 10px; padding: 0 1.5rem;"><?= $tags->$names ?></div></a>
                            <?php endforeach ?>
                            <div><?= $meses[date("n", strtotime($datos->CreateAT))] ?> <?= date("Y", strtotime($datos->CreateAT)) ?></div>
                        </div>
                    </div>
                    
                <?php endforeach ?>
            </div>
            <div class="d-none d-lg-block">
                <?= LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'my-custom-pagination']]); ?>
            </div>
        </div>
        <div class="col-lg-4 ps-0 ps-md-4 vlog">
            <?php $rightPosts = array_slice($result, 4, 7); ?>
            <?php foreach($rightPosts as $datos): ?>
                <div class="col-12 mt-4 mb-5 article">
                    <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>" class="text-decoration-none text-white">
                        <div class="position-relative"><img src="<?= $datos->ImagePost ?>" class="w-100" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover;"></div>
                        <div class="my-3 lh-sm text-limit-2" style="font-size: clamp(22px, 1.55vw, 24px)"><?= $datos->title ?></div>
                        <div class="text-limit-3 fs-6"><?php $c = $datos->centerComponents[0] ?>
                            <?php if($c->Type == 1):?>
                                    <?= strip_tags($c->textBoxC->Description) ?>
                            <?php endif ?></div>
                    </a>
                    <div class="d-flex gap mt-3 align-items-center tags-entry">
                        <?php foreach($datos->blogBy as $i => $tags): ?>
                            <?php if($i < 1): ?>
                                <a href="<?= Url::to(['categories', 'id' => $tags->CollectionID]) ?>" class="text-decoration-none text-white"><div style="background:#0D0D22; border:1px solid white; border-radius: 10px; padding: 0 1.5rem;"><?= $tags->$names ?></div></a>
                            <?php else: ?>
                            <div class="d-inline-block d-lg-none">
                                <a href="<?= Url::to(['categories', 'id' => $tags->CollectionID]) ?>" class="text-decoration-none text-white"><div style="background:#0D0D22; border:1px solid white; border-radius: 10px; padding: 0 1.5rem;"><?= $tags->$names ?></div></a>
                            </div>
                            <?php endif ?>
                        <?php endforeach ?>
                        <div><?= $meses[date("n", strtotime($datos->CreateAT))] ?> <?= date("Y", strtotime($datos->CreateAT)) ?></div>
                    </div>
                </div>
            <?php endforeach ?>
            <div class="d-block d-lg-none">
                <?= LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'my-custom-pagination']]); ?>
            </div>
            <div class="col-12" style="margin: clamp(3rem, 4rem + 1vw, 5rem) 0;">
                <div class="text-center" data-section="blog" data-value="text3">
                    ¡Síguenos!
                </div>
                <div class="d-flex justify-content-center align-items-center gap-5 my-4">
                   <div class="d-flex flex-column align-items-center">
                        <a href="https://www.youtube.com/@WeclickDigital" target="_blank">
                            <img src="<?= Yii::getAlias("@web") ?>/images/icons/YT.png" class="" style="width: 60px" alt="redes" srcset="">
                            <!-- <div class="mt-3 text-center">
                                <div>5K</div>
                                <div class="text-lila fs-6">Seguidores</div>
                            </div> -->
                        </a>
                   </div>
                   <div class="d-flex flex-column align-items-center">
                        <a href="https://www.instagram.com/weclick.digital/?igsh=YTJyYjMxaWNrNWsw#" target="_blank">
                            <img src="<?= Yii::getAlias("@web") ?>/images/icons/IG.png" class="" style="width: 60px" alt="redes" srcset="">
                            <!-- <div class="mt-3 text-center">
                                <div>5K</div>
                                <div class="text-lila fs-6">Seguidores</div>
                            </div> -->
                        </a>
                   </div>
                   <div class="d-flex flex-column align-items-center">
                        <a href="https://www.tiktok.com/@weclickdigital" target="_blank">
                            <img src="<?= Yii::getAlias("@web") ?>/images/icons/TT.png" class="" style="width: 60px" alt="redes" srcset="">
                            <!-- <div class="mt-3 text-center">
                                <div>5K</div>
                                <div class="text-lila fs-6">Seguidores</div>
                            </div> -->
                        </a>
                   </div>
                </div>
            </div>
            <hr class="opacity-100 m-auto my-5" style="border: 1.3px solid gray; width: 90%;">
            <div class="mt-5 pb-1 related" style="background-color: #232323; border-radius: 0 0 10px 10px;">
                <div class="col-12 fs-4 mb-5 py-2 lh-sm text-center bg-lila" data-section="blog" data-value="text4">
                    Publicaciones de tendencia
                </div>
                <?php foreach($tendencia as $datos): ?>
                    <div class="col-12 my-5 px-4">
                        <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>" class="text-decoration-none text-white">
                            <div class="position-relative"><img src="<?= $datos->ImagePost ?>" class="w-100" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover;"></div>
                            <div class="my-3 text-limit-2 fs-6"><?= $datos->title ?></div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
