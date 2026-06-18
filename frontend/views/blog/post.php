<?php
    use yii\helpers\Url;
    
    $this->title = "Publicación";

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

    if(!empty($model->project)){
        $col = "col-lg-8 pe-0 pe-md-4 ps-0 ps-md-2";
        $display = "";
    }else{
        $col = "col-lg-12";
        $display = "d-none";
    }
    $infoUs = Yii::$app->LocationLang->info();
    //if($data->Restriction == 1 && ($infoUs->country_code == 'PA' || $infoUs->country_code == 'ES') ){ continue; } 
?>

<style>
    .article a:hover > .position-relative::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ff04602c;
        border-radius: 18px;
    }
    .marginY{
        margin: 8rem auto 6rem auto;
    }
    .video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* Relación de aspecto 16:9 */
        height: 0;
        overflow: hidden;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    @media screen and (max-width: 834px) {
        .marginY{
            margin: 2rem auto;
        }
    }

    p, li{
        font-size: clamp(16px, 1.9vw, 1.1rem) !important;
    }
</style>

<div class="container">
    <div class="menu-fixed d-none d-md-block"></div>
</div>
<div class="d-none d-md-block"><br><br></div>
<div class="container marginY">
    <div class="row mx-0">
        <!-- <div class="col-12 mb-5">
            <div class="d-none d-lg-flex align-items-center flex-column flex-lg-row justify-content-center justify-content-lg-between mt-5">
                <div class="d-flex gap-4">
                    <div>Categorio 1</div>
                    <div>Categorio 2</div>
                    <div>Categorio 3</div>
                    <div>Categorio 4</div>
                </div>
                <div><i class="fa-solid fa-magnifying-glass text-white fs-3"></i></div>
            </div>
        </div> -->
        <div class="<?= $col ?>">
            <div class="mt-3 mb-5 lh-sm" style="font-size: clamp(24px, 2.8vw, 2.4rem)"><?= $model->VTitle ?></div>
            <div class="position-relative"><img src="<?= $model->ImagePost ?>" class="w-100" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover; border-radius: 30px;"></div>
            <div class="d-flex gap mt-3 align-items-center tags-entry mt-4 mb-5">
                <?php foreach($model->blogBy as $tags): ?>
                    <a href="<?= Url::to(['categories', 'id' => $tags->CollectionID]) ?>" class="text-decoration-none text-white"><div style="background:#0D0D22; border:1px solid white; border-radius: 10px; padding: 0 1.5rem;"><?= $tags->$names ?></div></a>
                <?php endforeach ?>
                <div><?= date("d/m/Y", strtotime($model->CreateAT)) ?></div>
            </div>
            <div class="">
                <?php foreach ($Components as $k => $c): ?>
                    <?php switch($c->Type): case 1:?>
                        <?php $Component = $c->textBoxC; ?>
                        <?= $Component->Description ?>
                        <?php break ?>
                        <?php case 2: ?>
                        <?php $Component = $c->imageC; ?>
                        <?php 
                            $right = "";
                            $left = "";
                            $column = "";
                            if($Component->Position === 0){
                                $left = "<img src='{$Component->PatchIMG()}' tags='Image' style='width: 100%; object-fit: contain'>";
                                $right = "<span>{$Component->Description}</span>";
                            }elseif($Component->Position === 2){
                                $left = "<span>{$Component->Description}</span>";
                                $right = "<img src='{$Component->PatchIMG()}' tags='Image' style='width: 100%; object-fit: contain'>";
                                $column = "position-column";
                            }
                        ?>
                        <div class="row mt-4 mb-4 <?= $column ?>listImagePosition">
                            <?php if($Component->Position === 0 || $Component->Position === 2): ?>
                                <div class="col-lg-6">
                                    <?= $left ?>    
                                </div>
                                <div class="col-lg-6">
                                    <?= $right ?>
                                </div>
                            <?php elseif($Component->Position === 1): ?>
                                <div class="col-12">
                                    <img src='<?= $Component->PatchIMG(); ?>' tags='Image' class="d-block m-auto" style='width: min(700px, 100%); object-fit: contain'>
                                </div>
                                <div class="col-12">
                                    <?= $Component->Description ?> 
                                </div>
                            <?php endif ?>
                        </div>
                        <?php break ?>
                        <?php case 3: ?>
                            <?php $Component = $c->ytVideoC ?>
                            <div class="row video-container">
                                <div class="col-12">
                                    <iframe width="100%" height="100%" src="<?= $Component->UrlVideo ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            </div>
                        <?php break ?>
                    <?php endswitch ?>
                <?php endforeach ?>
            </div>
        </div>
        <div class="col-lg-4 ps-0 ps-md-4 <?= $display ?>">
            <div class="mt-3 mb-5 lh-sm d-none d-lg-block text-limit" style="font-size: clamp(24px, 2.8vw, 1.7rem); color: transparent; -webkit-line-clamp: 5;"><?= $model->VTitle ?></div>
            <div class="fs-3 mt-5 mt-lg-0" data-section="blog" data-value="text5">Nuestras soluciones</div>
            <?php foreach ($model->project as $key => $data): ?>
                <div class="cubo my-5" style="background: #2e2b2b">
                    <div class="m-auto row align-items-center">
                        <div class="image col-12 px-0">
                            <a href="<?= !empty($data->Link) ? $data->Link : '#' ?>" target="_blank">
                                <img src="<?= Yii::getAlias('@web').'/images/'.$data->Image ?>" onerror="this.src='https://as1.ftcdn.net/v2/jpg/04/84/88/76/1000_F_484887682_Mx57wpHG4lKrPAG0y7Q8Q7bJ952J3TTO.jpg'" alt="ImagePorfolio" srcset="">
                            </a>
                        </div>
                        <div class="datacard col-12 px-3 pt-3 pb-3">
                            <div class="title fw-bold fs-4"><?= $data->Title ?></div>
                            <a href="<?= Url::to(['/porfolio/anexos', 'id' => $data->PorfolioID]) ?>" class="btn btn-lila my-2" style="font-size: 16px;" data-section="porfolio" data-value="text8">Ver proyecto</a>
                            <div style="font-size: 16px;">
                                <span class="fw-bold" style="font-size: 16px;" data-section="porfolio" data-value="text9">Cliente:</span> <?= $data->Client ?>
                            </div>
                            <?php $proyect = 'Proyect' . strtoupper($lang) ?>
                            <div class="shortdescription" style="font-size: 16px;"><span class="fw-bold" data-section="porfolio" data-value="text10">Proyecto:</span> <?= $data->$proyect ?></div>
                            <?php if(!empty($data->Link)): ?>
                                <div><a href="<?= $data->Link ?>" class="text-decoration-none" style="font-size: 16px;" target="_blank" data-section="porfolio" data-value="text11">Visitar sitio</a></div>
                            <?php endif ?>
                            <div class="longdescription mt-2" style="font-size: 16px;"><?= $data->Description ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <!-- <div class="col-12 fs-4 lh-sm my-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores consequuntur blanditiis tempora.</div>
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="<?= Yii::getAlias("@web") ?>/images/home/articulo.png" class="w-100" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover; border-radius: 30px;">
        </div>
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="<?= Yii::getAlias("@web") ?>/images/home/articulo.png" class="w-100" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover; border-radius: 30px;">
        </div>
        <div class="col-12 fs-4 lh-sm my-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores consequuntur blanditiis tempora.</div>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores consequuntur blanditiis tempora. Doloremque molestias, tempore eius repudiandae ut pariatur earum. Repellendus cumque illum culpa cum at animi labore beatae corporis! Quam a omnis at, nam sequi cupiditate modi labore odio atque quas deleniti odit amet non nemo doloribus pariatur enim nostrum aperiam, dolore praesentium quisquam? Debitis expedita magnam aliquid dolore. Deleniti vitae sint amet aperiam! Illo asperiores, iure quo earum ipsum magnam. Animi fugiat quia similique soluta libero sequi, voluptas fuga officia perspiciatis nam. Ipsum cum placeat harum eaque hic. Laboriosam qui eligendi nesciunt cumque consequuntur minima voluptatum! Quaerat molestias nam dolores commodi ipsam eveniet eum modi tempora dicta error odit rerum a, debitis quod explicabo sint quis, dolor nobis? Tempore cupiditate odio a laborum quaerat non, quos ullam laudantium velit rem magnam quidem eius explicabo consectetur veritatis vero deserunt nobis tenetur quod commodi, ex dolore quibusdam vel? Odit, minus!</div>
        </div> -->
    </div>
</div>
<div class="container">
    <hr class="my-5 opacity-100" style="border: 1px solid gray">
</div>
<div class="container my-5">
    <div class="row mx-0 related">
        <div class="col-12 fs-3 lh-sm my-4" data-section="blog" data-value="text6">Contenido relacionado</div>
        <?php foreach($more as $datos): ?>
            <div class="col-md-4 my-4">
                <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>" class="text-decoration-none text-white">
                    <div class="position-relative"><img src="<?= $datos->ImagePost ?>" class="w-100" alt="image" style="aspect-ratio: 16/ 9; object-fit: cover;"></div>
                    <div class="fs-4 my-3 lh-sm text-limit-3"><?= $datos->title ?></div>
                    <div class="d-flex gap mt-3 align-items-center tags-entry" style="font-size: 12px">
                        <?php foreach(array_slice($datos->blogBy, 0, 1) as $tags): ?>
                            <div style="background:#0D0D22; border:1px solid white; border-radius: 10px; padding: 0 0.8rem;"><?= $tags->$names ?></div>
                        <?php endforeach ?>
                        <div><?= $meses[date("n", strtotime($datos->CreateAT))] ?> <?= date("y", strtotime($datos->CreateAT)) ?></div>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
    <!-- <div class="row mx-0 my-5 vlog">
        <div class="col-md-8 position-relative mb-4 mb-lg-0">
            <a href="#" class="text-decoration-none">
                <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&amp;w=is&amp;k=20&amp;c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100 h-100" style="object-fit: cover;">
            </a>
        </div>
        <div class="col-md-4">
            <a href="#" class="text-decoration-none">
                <div class="position-relative">
                    <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                    <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                    <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&w=is&k=20&c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100 mb-4" style="object-fit: cover;">
                </div>
            </a>
            <a href="#" class="text-decoration-none d-none d-md-block">
                <div class="position-relative">
                    <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                    <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                    <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&w=is&k=20&c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100" style="object-fit: cover;">
                </div>
            </a>
        </div>
        <div class="col-12 position-relative d-block d-md-none">
            <a href="#" class="text-decoration-none">
                <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&amp;w=is&amp;k=20&amp;c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100 h-100" style="object-fit: cover;">
            </a>
        </div>
    </div> -->
</div>