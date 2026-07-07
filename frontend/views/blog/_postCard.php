<?php
use yii\helpers\Url;

$names = 'NameEs';
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
    12 => 'Diciembre',
];

$postUrl = Url::to(['post', 'slug' => $datos->Slug ?: $datos->PostBlogID]);
$categories = $datos->blogBy ?? [];
$dateText = $meses[date('n', strtotime($datos->CreateAT))] . ', ' . date('Y', strtotime($datos->CreateAT));
?>

<div class="col-md-6 col-xl-4 brickly-post-card-item">
    <article class="brickly-post-card">
        <a href="<?= $postUrl ?>" class="brickly-post-card__image-link">
            <img src="<?= $datos->PatchIMG() ?>" alt="<?= htmlspecialchars($datos->title, ENT_QUOTES, 'UTF-8') ?>" class="brickly-post-card__image">
        </a>
        <div class="brickly-post-card__content">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= Url::to(['categories', 'slug' => $cat->Slug ?: $cat->CollectionID]) ?>" class="brickly-chip text-decoration-none"><?= htmlspecialchars($cat->$names, ENT_QUOTES, 'UTF-8') ?></a>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="brickly-chip">Blog</span>
            <?php endif; ?>
            <h3 class="brickly-post-card__title">
                <a href="<?= $postUrl ?>"><?= $datos->title ?></a>
            </h3>
            <span class="brickly-post-card__date"><?= $dateText ?></span>
        </div>
    </article>
</div>
