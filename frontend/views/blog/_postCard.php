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

$postUrl = $datos->Slug ? Url::to(['post', 'slug' => $datos->Slug]) : Url::to(['post', 'id' => $datos->PostBlogID]);
$primaryCategory = $datos->blogBy[0] ?? null;
$primaryTag = $primaryCategory ? $primaryCategory->$names : 'Blog';
$primaryTagId = $primaryCategory ? $primaryCategory->CollectionID : null;
$dateText = $meses[date('n', strtotime($datos->CreateAT))] . ', ' . date('Y', strtotime($datos->CreateAT));
?>

<div class="col-md-6 col-xl-4 brickly-post-card-item">
    <article class="brickly-post-card">
        <a href="<?= $postUrl ?>" class="brickly-post-card__image-link">
            <img src="<?= $datos->ImagePost ?>" alt="<?= htmlspecialchars($datos->title, ENT_QUOTES, 'UTF-8') ?>" class="brickly-post-card__image">
        </a>
        <div class="brickly-post-card__content">
            <?php if ($primaryTagId): ?>
                <a href="<?= Url::to(['categories', 'id' => $primaryTagId]) ?>" class="brickly-chip text-decoration-none"><?= htmlspecialchars($primaryTag, ENT_QUOTES, 'UTF-8') ?></a>
            <?php else: ?>
                <span class="brickly-chip"><?= htmlspecialchars($primaryTag, ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
            <h3 class="brickly-post-card__title">
                <a href="<?= $postUrl ?>"><?= $datos->title ?></a>
            </h3>
            <span class="brickly-post-card__date"><?= $dateText ?></span>
        </div>
    </article>
</div>
