<?php
use yii\helpers\Url;

$names = 'NameEs';
$categoryName = $model->$names;
$this->title = $categoryName;

$loadedPosts = isset($pagination) ? $pagination->offset + count($posts) : count($posts);
$hasMorePosts = isset($pagination) && $loadedPosts < $pagination->totalCount;
$search = $search ?? '';
?>

<div class="container">
    <div class="menu-fixed"></div>
</div>

<main class="brickly-blog-page brickly-category-page">
    <section class="container brickly-category-hero">
        <div class="brickly-category-hero__content">
            <span class="brickly-section-kicker">CATEGORÍA</span>
            <div style="font-size:clamp(24px, 3vw, 40px); font-weight: 500;"><?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?></div>
            <p class="fw-normal">Ideas, tendencias y consejos para transformar espacios con más valor.</p>
        </div>

        <div class="brickly-category-hero__aside">
            <a href="<?= Url::to(['/blog']) ?>" class="brickly-category-back">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Atrás</span>
            </a>
            <form action="#" method="get" class="brickly-search-form brickly-category-search-form" data-category-search>
                <input type="search" name="q" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar art&iacute;culos" aria-label="Buscar art&iacute;culos">
                <button type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </section>

    <section class="container brickly-category-results">
        <div class="brickly-category-results__meta" data-category-count>
            <?= (int) $pagination->totalCount ?> art&iacute;culos encontrados
        </div>

        <div class="row g-4" id="brickly-category-posts-grid">
            <?php foreach ($posts as $datos): ?>
                <?= $this->render('_postCard', ['datos' => $datos]) ?>
            <?php endforeach; ?>
        </div>

        <div class="brickly-category-empty<?= empty($posts) ? ' is-visible' : '' ?>" data-category-empty>
            No encontramos art&iacute;culos para esta b&uacute;squeda.
        </div>

        <div class="brickly-blog-more text-center<?= $hasMorePosts ? '' : ' d-none' ?>" data-category-more>
            <button type="button" class="brickly-outline-button brickly-load-more-button" data-url="<?= Url::to(['category-load-more', 'id' => $model->CollectionID]) ?>" data-offset="<?= $loadedPosts ?>" data-limit="6" data-search="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                <span>VER M&Aacute;S</span>
                <i class="fa-solid fa-angle-right"></i>
            </button>
        </div>
    </section>
</main>

<?php
$this->registerJS(<<<JS
(function () {
    const form = document.querySelector('[data-category-search]');
    const input = form ? form.querySelector('input[name="q"]') : null;
    const grid = document.getElementById('brickly-category-posts-grid');
    const button = document.querySelector('.brickly-load-more-button');
    const moreWrap = document.querySelector('[data-category-more]');
    const empty = document.querySelector('[data-category-empty]');
    const count = document.querySelector('[data-category-count]');

    if (!grid || !button) return;

    const originalButtonText = button.innerHTML;

    const setButtonLoading = function (loading) {
        button.disabled = loading;
        button.classList.toggle('is-loading', loading);
        button.innerHTML = loading
            ? '<span>CARGANDO</span><i class="fa-solid fa-spinner fa-spin"></i>'
            : originalButtonText;
    };

    const appendItems = function (html, replace) {
        const template = document.createElement('template');
        template.innerHTML = html || '';
        const items = Array.from(template.content.children);

        if (replace) {
            grid.innerHTML = '';
        }

        items.forEach((item, index) => {
            item.classList.add('brickly-post-card-item--new');
            item.style.transitionDelay = (index * 45) + 'ms';
            grid.appendChild(item);

            window.requestAnimationFrame(() => {
                item.classList.add('is-visible');
            });
        });
    };

    const loadPosts = async function (replace) {
        const url = new URL(button.dataset.url, window.location.origin);
        url.searchParams.set('offset', replace ? '0' : (button.dataset.offset || '0'));
        url.searchParams.set('limit', button.dataset.limit || '6');
        url.searchParams.set('q', input ? input.value.trim() : (button.dataset.search || ''));

        setButtonLoading(true);

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

            appendItems(result.html, replace);
            button.dataset.offset = result.nextOffset;
            button.dataset.search = input ? input.value.trim() : '';

            if (count) {
                count.innerHTML = result.total + (result.total === 1 ? ' art&iacute;culo encontrado' : ' art&iacute;culos encontrados');
            }

            if (empty) {
                empty.classList.toggle('is-visible', result.total === 0);
            }

            if (moreWrap) {
                moreWrap.classList.toggle('d-none', !result.hasMore);
            }
        } catch (error) {
            button.innerHTML = '<span>INTENTAR DE NUEVO</span><i class="fa-solid fa-rotate-right"></i>';
            button.disabled = false;
            button.classList.remove('is-loading');
            return;
        }

        setButtonLoading(false);
    };

    button.addEventListener('click', function () {
        loadPosts(false);
    });

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            loadPosts(true);
        });
    }
})();
JS);
?>
