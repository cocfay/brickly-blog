<?php
    use yii\helpers\Url;
    use yii\widgets\LinkPager;
    $this->title = "Categorías";

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
    .marginY > div{
        margin: 12rem 0 2rem 0;
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
        .marginY > div{
            margin: 0;
        }
    }
</style>

<div class="container">
    <div class="menu-fixed d-none d-md-block"></div>
</div>

<div class="container marginY">
    <div class="row mx-0">
        <div class="col-12 px-2 px-md-3">
            <div class="mt-0 mt-md-5 mb-5" style="font-size: clamp(18px, 3vw, 50px)"><?= $model->$names ?></div>
        </div>
    </div>
    <div class="row mx-0 m-auto article">
        <?php foreach ($posts as $datos): ?>
            <div class="col-md-6 mb-5 px-2 px-md-3" style="margin-top: 0;">
                <a href="<?= Url::to(['blog/post', 'id' => $datos->PostBlogID]) ?>" class="text-decoration-none text-white">
                    <div class="position-relative"><img src="<?= $datos->ImagePost ?>" class="w-100" alt="image" style="border-radius: 18px;"></div>
                    <div class="my-3 lh-sm" style="font-size: clamp(1.5rem, 1.4vw, 24px)"><?= $datos->title ?></div>
                    <div class="text-limit-2" style="font-size: clamp(1rem, 1.1vw, 18px)">
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
    <?= LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'my-custom-pagination']]); ?>
</div>