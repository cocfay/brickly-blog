<?php
use yii\helpers\Url;

$this->title = 'Buscar articulos';

$search = $search ?? '';
$loadedPosts = isset($pagination) ? $pagination->offset + count($posts) : count($posts);
$hasMorePosts = isset($pagination) && $loadedPosts < $pagination->totalCount;
$totalPosts = isset($pagination) ? (int) $pagination->totalCount : count($posts);
?>

<div class="container">
    <div class="menu-fixed"></div>
</div>

<main class="brickly-blog-page brickly-category-page brickly-search-page">
    <section class="container brickly-category-hero">
        <div class="brickly-category-hero__content">
            <span class="brickly-section-kicker">BUSQUEDA</span>
            <h1>Resultados de busqueda</h1>
            <p>
                <?php if ($search !== ''): ?>
                    Coincidencias para &quot;<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&quot;.
                <?php else: ?>
                    Escribe una palabra clave para encontrar articulos del blog.
                <?php endif; ?>
            </p>
        </div>

        <div class="brickly-category-hero__aside">
            <a href="<?= Url::to(['/blog']) ?>" class="brickly-category-back">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Atr&aacute;s</span>
            </a>
            <form action="<?= Url::to(['search']) ?>" method="get" class="brickly-search-form brickly-category-search-form">
                <input type="search" name="q" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar art&iacute;culos" aria-label="Buscar art&iacute;culos">
                <button type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </section>

    <section class="container brickly-category-results">
        <div class="brickly-category-results__meta" data-search-count>
            <?= $totalPosts ?> <?= $totalPosts === 1 ? 'art&iacute;culo encontrado' : 'art&iacute;culos encontrados' ?>
        </div>

        <div class="row g-4" id="brickly-search-posts-grid">
            <?php foreach ($posts as $datos): ?>
                <?= $this->render('_postCard', ['datos' => $datos]) ?>
            <?php endforeach; ?>
        </div>

        <div class="brickly-category-empty<?= empty($posts) ? ' is-visible' : '' ?>" data-search-empty>
            No encontramos art&iacute;culos para esta b&uacute;squeda.
        </div>

        <div class="brickly-blog-more text-center<?= $hasMorePosts ? '' : ' d-none' ?>" data-search-more>
            <button type="button" class="brickly-outline-button brickly-load-more-button" data-url="<?= Url::to(['search-load-more']) ?>" data-offset="<?= $loadedPosts ?>" data-limit="6" data-search="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                <span>VER M&Aacute;S</span>
                <i class="fa-solid fa-angle-right"></i>
            </button>
        </div>
    </section>
</main>

<?php
$this->registerJS(<<<JS
(function () {
    const grid = document.getElementById('brickly-search-posts-grid');
    const button = document.querySelector('.brickly-load-more-button');
    const moreWrap = document.querySelector('[data-search-more]');

    if (!grid || !button) return;

    const originalButtonText = button.innerHTML;

    button.addEventListener('click', async function () {
        if (button.classList.contains('is-loading')) return;

        const url = new URL(button.dataset.url, window.location.origin);
        url.searchParams.set('offset', button.dataset.offset || '0');
        url.searchParams.set('limit', button.dataset.limit || '6');
        url.searchParams.set('q', button.dataset.search || '');

        button.disabled = true;
        button.classList.add('is-loading');
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
                throw new Error('No se pudieron cargar los articulos.');
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
                moreWrap?.classList.add('d-none');
            }
        } catch (error) {
            button.innerHTML = '<span>INTENTAR DE NUEVO</span><i class="fa-solid fa-rotate-right"></i>';
            button.disabled = false;
            button.classList.remove('is-loading');
            return;
        }

        button.innerHTML = originalButtonText;
        button.disabled = false;
        button.classList.remove('is-loading');
    });
})();
JS);
?>
