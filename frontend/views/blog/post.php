<?php
    use yii\helpers\Url;
    
    $this->title = "Publicación";

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
        12 => 'Diciembre'
    ];

    $featuredProperties = $featuredProperties ?? [];
    $relatedPosts = $relatedPosts ?? ($more ?? []);
    $moreTopics = $moreTopics ?? [];
    $moreTopicsLoaded = $moreTopicsLoaded ?? (count($relatedPosts) + count($moreTopics));
    $moreTopicsTotal = $moreTopicsTotal ?? $moreTopicsLoaded;
    $hasMoreTopics = $moreTopicsLoaded < $moreTopicsTotal;

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

    $extractDescription = static function ($post) {
        if (!empty($post->centerComponents[0]) && (int) $post->centerComponents[0]->Type === 1) {
            return trim(strip_tags($post->centerComponents[0]->textBoxC->Description));
        }

        return '';
    };

    $articleUrl = $model->Slug ? Url::to(['post', 'slug' => $model->Slug], true) : Url::to(['post', 'id' => $model->PostBlogID], true);
    $articleExcerpt = $extractDescription($model);
    $articleImage = method_exists($model, 'PatchIMG') ? $model->PatchIMG() : $model->ImagePost;
?>

<div class="container">
    <div class="menu-fixed d-none d-md-block"></div>
</div>

<main class="brickly-blog-detail">
    <section class="container brickly-blog-detail__wrap">
        <div class="brickly-blog-detail__actions">
            <a href="<?= Url::to(['/blog']) ?>" class="brickly-category-back">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Atr&aacute;s</span>
            </a>
        </div>

        <div class="row g-4 g-xl-5 align-items-start">
            <article class="col-xl-8 brickly-article-main">
                <div class="mb-4">
                    <?= $categoryLink($model) ?>
                    <h1 class="brickly-article-title mt-4 mb-3"><?= $model->VTitle ?></h1>
                    <p class="brickly-article-date mb-3"><?= $formatDate($model) ?></p>
                    <?php if (!empty($articleImage)): ?>
                        <img src="<?= htmlspecialchars($articleImage, ENT_QUOTES, 'UTF-8') ?>" class="w-100 brickly-article-hero-image" alt="<?= htmlspecialchars($model->VTitle, ENT_QUOTES, 'UTF-8') ?>">
                    <?php endif; ?>
                </div>

                <div class="brickly-article-body">
                <?php foreach ($Components as $k => $c): ?>
                    <?php switch($c->Type): case 1:?>
                        <?php $Component = $c->textBoxC; ?>
                        <?= $Component->Description ?>
                        <?php break ?>
                        <?php case 2: ?>
                        <?php $Component = $c->imageC; ?>
                        <?php if($Component->Position === 0): ?>
                            <div class="mt-5 brickly-image-float-left clearfix">
                                <img src='<?= $Component->PatchIMG() ?>' tags='Image' class="brickly-float-img" alt="">
                                <?= $Component->Description ?>
                            </div>
                        <?php elseif($Component->Position === 2): ?>
                            <div class="mt-5 brickly-image-float-right clearfix">
                                <img src='<?= $Component->PatchIMG() ?>' tags='Image' class="brickly-float-img" alt="">
                                <?= $Component->Description ?>
                            </div>
                        <?php elseif($Component->Position === 1): ?>
                            <div class="row mt-5 listImagePosition">
                                <div class="col-12 my-3 px-0">
                                    <img src='<?= $Component->PatchIMG(); ?>' tags='Image' class="d-block m-auto" style='width: min(700px, 100%); object-fit: contain'>
                                </div>
                                <div class="col-12 my-3 px-0">
                                    <?= $Component->Description ?> 
                                </div>
                            </div>
                        <?php endif ?>
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

                <div class="brickly-share-bar d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
                    <h2 class="h4 mb-0">Compartir artículo</h2>
                    <div class="d-flex align-items-center justify-content-center gap-3 gap-md-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($articleUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="Compartir en Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://wa.me/?text=<?= urlencode($model->VTitle . ' ' . $articleUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="Compartir en WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($articleUrl) ?>&title=<?= urlencode($model->VTitle) ?>" target="_blank" rel="noopener noreferrer" aria-label="Compartir en LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="<?= $articleUrl ?>" onclick="navigator.clipboard && navigator.clipboard.writeText(this.href); return false;" aria-label="Copiar enlace"><i class="fa-solid fa-link"></i></a>
                    </div>
                </div>

            </article>

            <aside class="col-xl-4 brickly-blog-sidebar brickly-detail-sidebar">
                <?php if (!empty($relatedPosts)): ?>
                    <section class="brickly-sidebar-card">
                        <h3>Artículos relacionados</h3>
                        <div class="d-flex flex-column gap-4">
                            <?php foreach($relatedPosts as $datos): ?>
                                <article class="brickly-detail-related-post">
                                    <a href="<?= $datos->Slug ? Url::to(['post', 'slug' => $datos->Slug]) : Url::to(['post', 'id' => $datos->PostBlogID]) ?>" class="text-decoration-none text-reset">
                                        <div class="brickly-detail-related-post__inner">
                                            <img src="<?= $datos->ImagePost ?>" alt="<?= htmlspecialchars($datos->title, ENT_QUOTES, 'UTF-8') ?>" class="brickly-detail-related-post__img">
                                            <div class="brickly-detail-related-post__content">
                                                <?= $categoryLink($datos) ?>
                                                <h4 class="brickly-detail-related-post__title"><?= $datos->title ?></h4>
                                                <p class="fw-normal"><?= $formatDate($datos) ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            <?php endforeach ?>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="brickly-sidebar-card">
                    <h3>Propiedades destacadas</h3>
                    <?php if (!empty($featuredProperties)): ?>
                        <?php foreach ($featuredProperties as $property): ?>
                            <article class="brickly-property-mockup">
                                <a href="<?= htmlspecialchars($property['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="brickly-property-mockup__link text-decoration-none text-reset">
                                    <div class="position-relative">
                                        <img src="<?= htmlspecialchars(!empty($property['image']) ? $property['image'] : Yii::getAlias('@web') . '/images/logos/logo_negro.png', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($property['title'], ENT_QUOTES, 'UTF-8') ?>">
                                        <div class="position-absolute top-0 px-1 py-2">
                                            <img src="<?= Yii::getAlias('@web') . '/images/blogItems/diamond.png' ?>" style="width: 24px; height: 24px;" alt="Destacada">
                                        </div>
                                    </div>
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
            </aside>
        </div>

        <?php if (!empty($moreTopics)): ?>
            <section class="brickly-more-topics">
                <h2>Explora más temas de interés</h2>
                <div class="row g-4" id="brickly-post-more-topics-grid">
                    <?php foreach($moreTopics as $datos): ?>
                        <?= $this->render('_postCard', ['datos' => $datos]) ?>
                    <?php endforeach ?>
                </div>
                <?php if ($hasMoreTopics): ?>
                    <div class="brickly-blog-more text-center">
                        <button type="button" class="brickly-outline-button brickly-load-more-button brickly-post-more-topics-button" data-url="<?= Url::to(['post-more-topics', 'id' => $model->PostBlogID]) ?>" data-offset="<?= $moreTopicsLoaded ?>" data-limit="6">
                            <span>VER M&Aacute;S</span>
                            <i class="fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </section>
</main>

<?php
$this->registerJS(<<<JS
(function () {
    const button = document.querySelector('.brickly-post-more-topics-button');
    const grid = document.getElementById('brickly-post-more-topics-grid');

    if (!button || !grid) return;

    const originalText = button.innerHTML;

    button.addEventListener('click', async function () {
        if (button.classList.contains('is-loading')) return;

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
                return;
            }

            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('is-loading');
        } catch (error) {
            button.innerHTML = '<span>INTENTAR DE NUEVO</span><i class="fa-solid fa-rotate-right"></i>';
            button.disabled = false;
            button.classList.remove('is-loading');
        }
    });
})();
JS);
?>
