<?php
use yii\helpers\Url;

$this->title = 'Blog';

$featuredProperties = $featuredProperties ?? [];

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

$extractDescription = static function ($post) {
    if (!empty($post->centerComponents[0]) && (int) $post->centerComponents[0]->Type === 1) {
        return trim(strip_tags($post->centerComponents[0]->textBoxC->Description));
    }

    return '';
};

$primaryTag = static function ($post) use ($names) {
    return !empty($post->blogBy[0]) ? $post->blogBy[0]->$names : 'Blog';
};

$categoryLink = static function ($post) use ($names) {
    $cat = $post->blogBy[0] ?? null;
    if (!$cat) {
        return '<span class="brickly-chip">Blog</span>';
    }
    $name = htmlspecialchars($cat->$names, ENT_QUOTES, 'UTF-8');
    return '<a href="' . Url::to(['categories', 'id' => $cat->CollectionID]) . '" class="brickly-chip text-decoration-none">' . $name . '</a>';
};

$formatDate = static function ($post) use ($meses) {
    return $meses[date('n', strtotime($post->CreateAT))] . ', ' . date('Y', strtotime($post->CreateAT));
};

// Si no hay artículo destacado definido en el controlador, usar el primero del listado
if (!isset($featuredPost) || !$featuredPost) {
    $featuredPost = $result[0] ?? null;
}
$sidePosts = array_slice($result, 0, 3);
$gridPosts = array_slice($result, 3);

$gridPosts = array_slice($gridPosts, 0, 6);
$loadedPosts = isset($pagination) ? $pagination->offset + count($result) : count($result);
$hasMorePosts = isset($pagination) && $loadedPosts < $pagination->totalCount;

$categoryIcons = [
    'inversión' => 'fa-solid fa-seedling',
    'remodelación' => 'fa-solid fa-hammer',
    'diseño inteligente' => 'fa-solid fa-gear',
    'diseño de interiores' => 'fa-solid fa-couch',
    'alta inversión' => 'fa-regular fa-gem',
    'bienes raíces' => 'fa-solid fa-house',
    'arquitectura' => 'fa-solid fa-compass-drafting',
    'tendencias' => 'fa-solid fa-arrow-trend-up',
];
?>

<div class="container">
    <div class="menu-fixed"></div>
</div>

<div class="brickly-blog-page">
    <section class="container brickly-blog-hero">
        <div class="row align-items-center g-1 mb-5">
            <div class="col-lg-5 px-xl-0">
                <span class="brickly-section-kicker">BLOG</span>
                <h1 class="brickly-blog-hero__title">Ideas, tendencias y oportunidades inmobiliarias</h1>
                <p class="brickly-blog-hero__text">Contenido útil para tomar mejores decisiones al comprar, vender o invertir en propiedades.</p>
            </div>
            <div class="col-lg-7">
                <div class="brickly-blog-hero__image-wrap">
                    <img src="<?= Yii::getAlias('@web') . '/images/blogItems/banner_blog.png' ?>" alt="Blog Brickly" class="brickly-blog-hero__image">
                </div>
            </div>
        </div>
    </section>

    <section class="container brickly-blog-mobile-search">
        <div class="brickly-mobile-search-card">
            <h3>Buscar artículos</h3>
            <form action="<?= Url::to(['search']) ?>" method="get" class="brickly-search-form">
                <input type="search" name="q" placeholder="Buscar artículos" aria-label="Buscar artículos">
                <button type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </section>

    <section class="container brickly-blog-featured">
        <div class="row g-4 g-xl-5 align-items-start">
            <div class="col-xl-7">
                <?php if ($featuredPost): ?>
                    <article class="brickly-featured-card">
                        <a href="<?= Url::to(['post', 'id' => $featuredPost->PostBlogID]) ?>" class="brickly-post-card__image-link">
                            <img src="<?= $featuredPost->ImagePost ?>" alt="<?= htmlspecialchars($featuredPost->title, ENT_QUOTES, 'UTF-8') ?>" class="brickly-featured-card__image">
                        </a>
                        <div class="brickly-featured-card__content">
                            <?= $categoryLink($featuredPost) ?>
                            <h2 class="brickly-featured-card__title">
                                <a href="<?= Url::to(['post', 'id' => $featuredPost->PostBlogID]) ?>"><?= $featuredPost->title ?></a>
                            </h2>
                            <p class="brickly-featured-card__excerpt"><?= $extractDescription($featuredPost) ?></p>
                            <div class="brickly-featured-card__footer">
                                <span><?= $formatDate($featuredPost) ?></span>
                                <a href="<?= Url::to(['post', 'id' => $featuredPost->PostBlogID]) ?>" class="brickly-read-more">Leer artículo <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </article>
                <?php endif; ?>
            </div>

            <div class="col-xl-5">
                <div class="brickly-post-list">
                    <?php foreach ($sidePosts as $datos): ?>
                        <article class="brickly-list-post">
                            <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>" class="brickly-list-post__thumb-link">
                                <img src="<?= $datos->ImagePost ?>" alt="<?= htmlspecialchars($datos->title, ENT_QUOTES, 'UTF-8') ?>" class="brickly-list-post__thumb">
                            </a>
                            <div class="brickly-list-post__body">
                                <?= $categoryLink($datos) ?>
                                <h3 class="brickly-list-post__title">
                                    <a href="<?= Url::to(['post', 'id' => $datos->PostBlogID]) ?>"><?= $datos->title ?></a>
                                </h3>
                                <span class="brickly-list-post__date"><?= $formatDate($datos) ?></span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="container brickly-blog-content">
        <div class="row g-4 g-xl-5 align-items-start">
            <div class="col-xl-8">
                <div class="brickly-content-heading">
                    <h2>Explora más temas de interés</h2>
                </div>

                <div class="row g-4" id="brickly-more-posts-grid">
                    <?php foreach ($gridPosts as $datos): ?>
                        <?= $this->render('_postCard', ['datos' => $datos]) ?>
                    <?php endforeach; ?>
                </div>

                <?php if ($hasMorePosts): ?>
                    <div class="brickly-blog-more text-center">
                        <button type="button" class="brickly-outline-button brickly-load-more-button" data-url="<?= Url::to(['load-more']) ?>" data-offset="<?= $loadedPosts ?>" data-limit="6">
                            <span>VER MÁS</span>
                            <i class="fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-xl-4">
                <aside class="brickly-blog-sidebar">
                    <section class="brickly-sidebar-card brickly-sidebar-card--search">
                        <h3>Buscar artículos</h3>
                        <form action="<?= Url::to(['search']) ?>" method="get" class="brickly-search-form">
                            <input type="search" name="q" placeholder="Buscar artículos" aria-label="Buscar artículos">
                            <button type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </section>

                    <section class="brickly-sidebar-card">
                        <h3>Categorías</h3>
                        <ul class="brickly-sidebar-list">
                            <?php foreach (($categories ?? []) as $category): ?>
                                <?php
                                    $categoryName = htmlspecialchars($category['NameEs'], ENT_QUOTES, 'UTF-8');
                                    $categoryKey = mb_strtolower(trim($category['NameEs']), 'UTF-8');
                                    $categoryIcon = $categoryIcons[$categoryKey] ?? 'fa-solid fa-tag';
                                ?>
                                <li>
                                    <a href="<?= Url::to(['categories', 'id' => $category['CollectionID']]) ?>" class="brickly-sidebar-list__link text-decoration-none">
                                        <span class="brickly-sidebar-list__label"><i class="<?= $categoryIcon ?> brickly-sidebar-list__icon" aria-hidden="true"></i> <?= $categoryName ?></span>
                                        <strong><?= (int) $category['post_count'] ?></strong>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>

                    <section class="brickly-sidebar-card">
                        <h3>Propiedades destacadas</h3>
                        <?php if (!empty($featuredProperties)): ?>
                            <?php foreach ($featuredProperties as $property): ?>
                                <article class="brickly-property-mockup">
                                    <a href="<?= htmlspecialchars($property['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="brickly-property-mockup__link text-decoration-none text-reset">
                                        <img src="<?= htmlspecialchars(!empty($property['image']) ? $property['image'] : Yii::getAlias('@web') . '/images/logos/logo_negro.png', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($property['title'], ENT_QUOTES, 'UTF-8') ?>">
                                        <div class="brickly-property-mockup__content">
                                            <h4 class="brickly-property-mockup__title"><?= htmlspecialchars($property['title'], ENT_QUOTES, 'UTF-8') ?></h4>
                                            <p><?= htmlspecialchars($property['location'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <strong><?= $property['priceUSD'] !== null ? '$' . number_format((float) $property['priceUSD'], 0, '.', ',') : 'Consultar' ?></strong>
                                        </div>
                                    </a>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </section>

                    <section class="brickly-sidebar-card brickly-sidebar-card--subscribe">
                        <h3>Suscríbete al blog</h3>
                        <p style="font-size: 16px" class="fw-normal">Recibe contenido exclusivo sobre el mercado inmobiliario directo en tu correo.</p>
                        <form action="#" method="post" onsubmit="return false;" class="brickly-subscribe-form">
                            <input type="email" placeholder="Tu correo electrónico" style="font-size: 16px" aria-label="Tu correo electrónico">
                            <button type="submit" class="btn">Suscribirme</button>
                        </form>
                    </section>
                </aside>
            </div>
        </div>
    </section>
</div>

<?php
$this->registerJS(<<<JS
(function () {
    const button = document.querySelector('.brickly-load-more-button');
    const grid = document.getElementById('brickly-more-posts-grid');

    if (!button || !grid) return;

    button.addEventListener('click', async function () {
        if (button.classList.contains('is-loading')) return;

        const originalText = button.innerHTML;
        const url = new URL(button.dataset.url, window.location.origin);
        url.searchParams.set('offset', button.dataset.offset || '0');
        url.searchParams.set('limit', button.dataset.limit || '6');

        button.classList.add('is-loading');
        button.disabled = true;
        button.innerHTML = '<span>CARGANDO</span><i class="fa-solid fa-spinner fa-spin"></i>';

        try {
            const response = await fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error('No se pudieron cargar mas posts.');
            }

            const template = document.createElement('template');
            template.innerHTML = result.html || '';
            const items = Array.from(template.content.children);

            items.forEach((item, index) => {
                item.classList.add('brickly-post-card-item--new');
                item.style.transitionDelay = (index * 45) + 'ms';
                grid.appendChild(item);

                window.requestAnimationFrame(() => {
                    item.classList.add('is-visible');
                });
            });

            button.dataset.offset = result.nextOffset;

            if (!result.hasMore) {
                button.closest('.brickly-blog-more')?.remove();
            } else {
                button.innerHTML = originalText;
                button.disabled = false;
                button.classList.remove('is-loading');
            }
        } catch (error) {
            button.innerHTML = '<span>INTENTAR DE NUEVO</span><i class="fa-solid fa-rotate-right"></i>';
            button.disabled = false;
            button.classList.remove('is-loading');
        }
    });
})();
JS);
?>
