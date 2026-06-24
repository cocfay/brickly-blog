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

$primaryTag = !empty($datos->blogBy[0]) ? $datos->blogBy[0]->$names : 'Blog';
$dateText = $meses[date('n', strtotime($datos->CreateAT))] . ', ' . date('Y', strtotime($datos->CreateAT));
?>

<div class="col-md-6 col-xl-4 brickly-post-card-item">
    <article class="brickly-post-card">
        <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>" class="brickly-post-card__image-link">
            <img src="<?= $datos->ImagePost ?>" alt="<?= htmlspecialchars($datos->title, ENT_QUOTES, 'UTF-8') ?>" class="brickly-post-card__image">
        </a>
        <div class="brickly-post-card__content">
            <span class="brickly-chip"><?= htmlspecialchars($primaryTag, ENT_QUOTES, 'UTF-8') ?></span>
            <h3 class="brickly-post-card__title">
                <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>"><?= $datos->title ?></a>
            </h3>
            <span class="brickly-post-card__date"><?= $dateText ?></span>
        </div>
    </article>
</div>
