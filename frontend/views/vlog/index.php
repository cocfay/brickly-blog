<?php
    $this->title = "Vlog";

?>

<style>
    @media screen and (max-width: 834px) {
        .marginY-8{
            margin: 2rem auto;
        }
    }
</style>

<div class="container">
    <div class="menu-fixed d-none d-md-block"></div>
</div>
<div class="d-none d-md-block"><br><br></div>
<div class="container marginY-8">
    <!-- <div class="text-center lh-sm animation-curtain mb-5 fw-light" style="font-size: clamp(1.8rem, 3vw, 4rem)">Vlog</div> -->
    <div class="d-none d-lg-flex align-items-center flex-column flex-lg-row justify-content-center justify-content-lg-between">
        <div style="font-size: clamp(1.8rem, 3vw, 4rem)" class="text-center lh-sm animation-curtain mb-2 mb-lg-5 fw-light visible">Vlog</div>
        <div class="d-flex gap-4">
            <div>Categorio 1</div>
            <div>Categorio 2</div>
            <div>Categorio 3</div>
            <div>Categorio 4</div>
        </div>
        <div><i class="fa-solid fa-magnifying-glass text-white fs-3"></i></div>
     </div>
    <div class="row mt-5 mx-0 justify-content-center vlog">
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
    </div>
</div>
<div class="container marginY-6">
    <hr style="background-color: #424242;">
    <div class="mt-5 px-2 lh-sm animation-curtain mb-5 fw-light" style="font-size: clamp(1.8rem, 3vw, 4rem)">Únete a nuestra comunidad de TikTok</div>
    <div class="row row-cols-auto row-cols-md-2 row-cols-lg-5 mx-0">
        <?php for($i = 0 ; $i <= 14 ; $i ++): ?>
            <div class="col mb-4"><img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&amp;w=is&amp;k=20&amp;c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100"></div>
        <?php endfor ?>
    </div>
    <div class="row mx-0 ">
        <div class="col-lg-8 ps-0 ps-md-2">
            <div class="row mx-0 px-0 vlog">
                <div class="col-md-6 ps-auto ps-md-0 my-4">
                    <a href="#" class="text-decoration-none text-white">
                        <div class="position-relative">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                            <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&w=is&k=20&c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100" style="object-fit: cover;">
                        </div>
                        <div class="my-2">
                            <div class="fs-5 lh-sm text-limit-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et, corrupti ducimus reiciendis.</div>
                            <div class="fs-6 mt-1 text-lila">Lorem ipsum.</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 pe-auto pe-md-0 my-4">
                    <a href="#" class="text-decoration-none text-white">
                        <div class="position-relative">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                            <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&w=is&k=20&c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100" style="object-fit: cover;">
                        </div>
                        <div class="my-2">
                            <div class="fs-5 lh-sm text-limit-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et, corrupti ducimus reiciendis.</div>
                            <div class="fs-6 mt-1 text-lila">Lorem ipsum.</div>
                        </div>
                    </a>
                </div>
                <div class="col-12 px-2 px-md-0 my-4">
                    <a href="#" class="text-decoration-none text-white">
                        <div class="position-relative">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                            <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&w=is&k=20&c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100" style="object-fit: cover;">
                        </div>
                        <div class="my-2">
                            <div class="fs-5 lh-sm text-limit-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et, corrupti ducimus reiciendis.</div>
                            <div class="fs-6 mt-1 text-lila">Lorem ipsum.</div>
                        </div>
                    </a>
                </div>
                <div class="col-12 px-2 px-md-0 my-4">
                    <a href="#" class="text-decoration-none text-white">
                        <div class="position-relative">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                            <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&w=is&k=20&c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100" style="object-fit: cover;">
                        </div>
                        <div class="my-2">
                            <div class="fs-5 lh-sm text-limit-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et, corrupti ducimus reiciendis.</div>
                            <div class="fs-6 mt-1 text-lila">Lorem ipsum.</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 vlog">
            <div class="col-12 my-4">
                <div class="text-center">
                    ¡Síguenos!
                </div>
                <div class="d-flex justify-content-center align-items-center gap-4 my-4">
                   <div class="d-flex flex-column align-items-center">
                        <img src="<?= Yii::getAlias("@web") ?>/images/icons/YT.png" class="" style="width: 60px" alt="redes" srcset="">
                        <!-- <div class="mt-3 text-center">
                            <div>5K</div>
                            <div class="text-lila fs-6">seguidores</div>
                        </div> -->
                   </div>
                   <div class="d-flex flex-column align-items-center">
                        <img src="<?= Yii::getAlias("@web") ?>/images/icons/IG.png" class="" style="width: 60px" alt="redes" srcset="">
                        <!-- <div class="mt-3 text-center">
                            <div>5K</div>
                            <div class="text-lila fs-6">seguidores</div>
                        </div> -->
                   </div>
                   <div class="d-flex flex-column align-items-center">
                        <img src="<?= Yii::getAlias("@web") ?>/images/icons/TT.png" class="" style="width: 60px" alt="redes" srcset="">
                        <!-- <div class="mt-3 text-center">
                            <div>5K</div>
                            <div class="text-lila fs-6">seguidores</div>
                        </div> -->
                   </div>
                </div>
            </div>
            <hr class="opacity-100 m-auto my-5" style="border: 1.3px solid gray; width: 90%;">
            <div class="col-12 my-5 fs-4 lh-sm">
                Publicaciones de<br> tendencia
            </div>
            <?php for($i = 0 ; $i <= 3 ; $i ++): ?>
                <div class="col-12 my-4">
                    <a href="#" class="text-decoration-none text-white">
                        <div class="position-relative">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play2.png" class="opacity-75 position-absolute top-50 start-50 translate-middle IconPlay1" style="width: 80px" alt="play" srcset="">
                            <img src="<?= Yii::getAlias("@web") ?>/images/home/play1.png" class="position-absolute top-50 start-50 translate-middle IconPlay2" style="width: 80px" alt="play" srcset="">
                            <img src="https://media.istockphoto.com/id/2166773378/photo/autumn-on-lake-gosau-in-salzkammergut-austria.jpg?s=1024x1024&w=is&k=20&c=7aQ4RNky5oVOk4ju1lDxu18_3m9sFziIYEEnafBt9XA=" alt="" srcset="" class="w-100" style="object-fit: cover;">
                        </div>
                        <div class="my-2">
                            <div class="fs-5 lh-sm text-limit-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam nobis et itaque. Ea blanditiis praesentium aliquid porro non architecto tenetur quas, officia laudantium nobis expedita provident reiciendis assumenda odit dolores!
                            Ab labore ut minima quisquam, voluptate, deleniti rerum consequuntur, tempore iste fugiat id impedit consequatur cumque? Quaerat placeat culpa voluptatibus deserunt voluptates harum, repellendus sed illo asperiores, eos consequuntur tempora.</div>
                            <div class="fs-6 mt-1 text-lila">Lorem ipsum.</div>
                        </div>
                    </a>
                </div>
            <?php endfor ?>
        </div>
    </div>
</div>
