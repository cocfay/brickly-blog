<?php 
    use frontend\assets\AppAsset;

    use yii\bootstrap5\ActiveForm;
    use yii\helpers\Html;
    use yii\bootstrap\Dropdown;
    use yii\helpers\Url;
    use yii\bootstrap5\Button;
    use common\components\chosen\Chosen;

    $createNewPost = [
        'en' => 'Create a new Post',
        'fr' => 'Créer un nouveau Post',
        'it' => 'Crea un nuovo Post',
        'es' => 'Elaborar un nuevo Post',
        'de' => 'Einen neuen Beitrag erstellen',
        'pt' => 'Elaborar um novo Post'
    ];

    $editPost = [
        'en' => 'Edit the post',
        'fr' => 'Modifier le post',
        'it' => 'Modifica il post',
        'es' => 'Editas el post',
        'de' => 'Beitrag bearbeiten',
        'pt' => 'Editar o post'
    ];

    $select = [
        'en' => 'Select',
        'fr' => 'Sélectionner',
        'it' => 'Seleziona',
        'es' => 'Seleccione',
        'de' => 'Auswählen',
        'pt' => 'Selecionar'
    ];

    $selectCollection = [
        'en' => 'Select a collection',
        'fr' => 'Sélectionnez une collection',
        'it' => 'Seleziona una collezione',
        'es' => 'Seleccione una colección',
        'de' => 'Wählen Sie eine Sammlung',
        'pt' => 'Selecione uma coleção'
    ];

    $note = [
        'en' => '<b>Note:</b> the image must be at least 1080x720 resolution',
        'fr' => '<b>Note:</b> l\'image doit avoir une résolution minimale de 1080x720',
        'it' => '<b>Nota:</b> l\'immagine deve avere una risoluzione minima di 1080x720',
        'es' => '<b>Nota:</b> la imagen tiene que ser de una resolución mínima 1080x720',
        'de' => '<b>Hinweis:</b> Das Bild muss mindestens eine Auflösung von 1080x720 haben',
        'pt' => '<b>Nota:</b> a imagem deve ter uma resolução mínima de 1080x720'
    ];

    $textComponent = [
        'en' => 'Text Component',
        'fr' => 'Composant de texte',
        'it' => 'Componente di testo',
        'es' => 'Componente de Texto',
        'de' => 'Textkomponente',
        'pt' => 'Componente de Texto'
    ];

    $videoComponent = [
        'en' => 'YT Video Component',
        'fr' => 'Composant vidéo YT',
        'it' => 'Componente video YT',
        'es' => 'Componente de Video YT',
        'de' => 'YT-Videokomponente',
        'pt' => 'Componente de Vídeo YT'
    ];

    $videoLink = [
        'en' => 'Video Link',
        'fr' => 'Lien de la vidéo',
        'it' => 'Link del video',
        'es' => 'Enlace del video',
        'de' => 'Videolink',
        'pt' => 'Link do vídeo'
    ];

    $carouselComponent = [
        'en' => 'Carousel Component',
        'fr' => 'Composant de Carrousel',
        'it' => 'Componente del Carosello',
        'es' => 'Componente de Carrusel',
        'de' => 'Karussell-Komponente',
        'pt' => 'Componente de Carrossel'
    ];

    $carouselUpload = [
        'en' => 'Upload your carousel images (1x1) maximum 6.',
        'fr' => 'Téléchargez les images de votre carrousel (1x1) maximum 6.',
        'it' => 'Carica le immagini del tuo carosello (1x1) massimo 6.',
        'es' => 'Carga las imágenes de tu carrusel (1x1) máximo 6.',
        'de' => 'Laden Sie Ihre Karussellbilder hoch (1x1) maximal 6.',
        'pt' => 'Carregue as imagens do seu carrossel (1x1) no máximo 6.'
    ];

    $imageComponent = [
        'en' => 'Image Component',
        'fr' => 'Composant d\'image',
        'it' => 'Componente di immagine',
        'es' => 'Componente de Imagen',
        'de' => 'Bildkomponente',
        'pt' => 'Componente de Imagem'
    ];

    $imageText = [
        'en' => 'Text accompanying the image',
        'fr' => 'Texte accompagnant l\'image',
        'it' => 'Testo che accompagna l\'immagine',
        'es' => 'Texto acompañante de la imagen',
        'de' => 'Begleittext zum Bild',
        'pt' => 'Texto que acompanha a imagem'
    ];

    $imageBy = [
        'en' => 'Image by',
        'fr' => 'Image par',
        'it' => 'Immagine di',
        'es' => 'Imagen por',
        'de' => 'Bild von',
        'pt' => 'Imagem por'
    ];

    $imageTextPosition = [
        'en' => 'Position of the image and text.',
        'fr' => 'Position de l\'image et du texte.',
        'it' => 'Posizione dell\'immagine e del testo.',
        'es' => 'Posición de la imagen y el texto.',
        'de' => 'Position von Bild und Text.',
        'pt' => 'Posição da imagem e do texto.'
    ];
    
    $left = [
        'en' => 'Left',
        'fr' => 'Gauche',
        'it' => 'Sinistra',
        'es' => 'Izquierda',
        'de' => 'Links',
        'pt' => 'Esquerda'
    ];

    $center = [
        'en' => 'Center',
        'fr' => 'Centre',
        'it' => 'Centro',
        'es' => 'Centro',
        'de' => 'Zentrum',
        'pt' => 'Centro'
    ];

    $right = [
        'en' => 'Right',
        'fr' => 'Droite',
        'it' => 'Destra',
        'es' => 'Derecha',
        'de' => 'Rechts',
        'pt' => 'Direita'
    ];
    
    $this->title = $ModelBlog->isNewRecord ? $createNewPost[$lang] : $editPost[$lang];

    $this->registerCssFile(
        '@web/css/blog/estilos_banner_post.css', [
        'depends' => [\yii\web\JqueryAsset::class]
    ]);

    $this->registerCssFile(
        '@web/css/blog/estilos_blog.css', [
        'depends' => [\yii\web\JqueryAsset::class]
    ]);

 ?> 
    <style>
        .mb-3.field-file-portada {
            background-color: transparent !important;
        }
        .item-img-carousel-view{
            height: 200px; 
            display: flex;
            justify-content: center; 
            position: relative; 
            border: solid 1px #2a2f89; 
            border-radius: 5px;
        }
        .btndel-item-img-carousel{
            position:absolute;
            margin-right: 20px; 
            right: 0;
        }
        .image-item-carousel-component{
            height: 100%; 
            width: auto; 
            max-width: 100%;
        }
        .containercarousel-component{
            background: #edeeff; 
            border-radius:6px; 
            padding: 20px;
        }
        .containeritemcarousel-prev{
            min-height: 400px; 
            border-radius: 6px; 
            background: #fff;
        }
    </style>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <center>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </center>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <center>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <?= Yii::$app->session->getFlash('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </center>
    <?php endif; ?>
    <div class="container-fluid px-0 cpanel-post-form-page">
        <div class="cpanel-page-heading">
            <div>
                <h1><?= $ModelBlog->isNewRecord ? $createNewPost[$lang] : $editPost[$lang] ?></h1>
                <p class="cpanel-page-subtitle">Organiza la informaci&oacute;n principal, portada y componentes del art&iacute;culo.</p>
            </div>
            <div class="cpanel-post-heading-actions">
                <a href="<?= Url::to(['/blog']) ?>" class="cpanel-post-back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Atr&aacute;s</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php $form = ActiveForm::begin([ 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <section class="cpanel-post-section">
                        <div class="cpanel-post-section-heading">
                            <span class="cpanel-post-section-icon"><i class="fa-regular fa-newspaper"></i></span>
                            <div>
                                <h2>Datos del post</h2>
                                <p>Define clasificaci&oacute;n, fecha, estado destacado y t&iacute;tulo.</p>
                            </div>
                        </div>
                        <div class="row g-4">
                            <!-- SELECCIÓN DE LA CATEGORÍA DE JUGUETES -->
                            <div class="col-12">
                                <!-- TITULO DEL POST -->
                                <div class="backGround mb-3">
                                    <?= $form->field($ModelBlog, 'VTitle', ['labelOptions' => ['class' => 'form-label fw-bold', 'data-section' => 'form-post', 'data-value' => 't-post']])->textInput(["id" => "title_post", "class" => "form-control title_post", "aria-describedby" => "title_post", "maxlength" => true]); ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="backGround mb-3 collecionstoy d-block">
                                    <?php $labels = ($ModelBlog->isNewRecord) ? 'CollectionID' : 'Labels' ?>
                                    <?=
                                        $form->field($CbyB, $labels)->widget(Chosen::classname(), [                            
                                            'items' => $collectionList,
                                            'allowDeselect' => true,
                                            'disableSearch' => true, // Search input will be disabled
                                            'clientOptions' => [
                                                'search_contains' => true,
                                                'max_selected_options' => 2,
                                            ],
                                            'options'  => [
                                                'id' => 'UpdateCollectionID',
                                            ],
                                            'placeholder' => 'Seleccione',
                                            'multiple' => true,
                                        ])->label('Etiquetas', ['class' => 'fw-bold mb-2', 'data-section' => 'formdiscussion', 'data-value' => 'field3']);
                                        /* $form->field($ModelBlog, 'CollectionID', ['options' => ['class' => 'form-group col-md-12']])
                                        ->dropDownList($collectionList, ['prompt' => $selectCollection[$lang], 'class' => 'form-control'])
                                        ->label('Etiquetas', ['class' => 'form-label fw-bold', 'data-section' => 'form-post', 'data-value' => 'collection']); */ // Crea el Select Input con el array de opciones, clase CSS y label personalizado.                
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="backGround mb-3 d-block">
                                    <?=
                                        $form->field($ModelBlog, 'CreateAT', ['labelOptions' => ['class' => 'form-label fw-bold']])->input('date', ['class' => 'form-control']);           
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="cpanel-post-section">
                        <div class="cpanel-post-section-heading">
                            <span class="cpanel-post-section-icon"><i class="fa-regular fa-image"></i></span>
                            <div>
                                <h2>Portada</h2>
                                <p>Sube la imagen principal del art&iacute;culo.</p>
                            </div>
                            <span class="cpanel-post-section-line"></span>
                        </div>
                    <div class="row g-4">
                        <div class="col-12">
                            <?php $coverHasImage = !empty($ModelBlog->ImagePost); ?>
                            <div class="cpanel-post-cover-field">
                                <label id="postCoverDropzone" for="postImage" class="cpanel-post-upload cpanel-post-cover-upload <?= $coverHasImage ? 'has-preview' : '' ?>">
                                    <img src="<?= $coverHasImage ? $ModelBlog->ImagePost : '' ?>" alt="Imagen principal" id="ViewpostImage" class="cpanel-upload-preview">
                                    <span class="cpanel-upload-empty">
                                        <span class="cpanel-upload-icon"><i class="fa-regular fa-image"></i></span>
                                        <span class="cpanel-upload-title">Agregar foto de portada</span>
                                        <span class="cpanel-upload-help">Haz click o arrastra una imagen aqu&iacute;</span>
                                        <span class="cpanel-upload-format">PNG, JPG o WEBP</span>
                                    </span>
                                    <span class="cpanel-upload-overlay">
                                        <span class="cpanel-upload-file" id="postCoverFileName">Imagen de portada</span>
                                        <span class="cpanel-upload-action"><i class="fa-solid fa-rotate"></i> Cambiar</span>
                                    </span>
                                </label>
                                <?= $form->field($ModelBlog, 'ImagePost')->hiddenInput(['id' => 'postImageUrl'])->label(false); ?>
                                <?= $form->field($ModelBlog, 'RequestFile')->fileInput(['id' => 'postImage', 'class' => 'cpanel-file-input', 'accept' => 'image/*'])->label(false); ?>
                                <p class="cpanel-post-upload-note"><?= strip_tags($note[$lang]) ?></p>
                            </div>
                        </div>
                    </div>
                    </section>

                    <section class="cpanel-post-section">
                        <div class="cpanel-post-section-heading">
                            <span class="cpanel-post-section-icon"><i class="fa-solid fa-layer-group"></i></span>
                            <div>
                                <h2>Componentes del art&iacute;culo</h2>
                                <p>Construye el contenido con bloques de texto, imagen o video.</p>
                            </div>
                            <span class="cpanel-post-section-line"></span>
                        </div>
                    <div class="formComponents mb-4">
                        <?php $carouselItems = 0; foreach ($Components as $k => $c): ?>

                            <?php switch($c->Type):
                                 case 1: ?>
                                 <?php 
                                    $Component = $c->textBoxC; 
                                    /*
                                    $Component->Description;
                                    $Component->DescriptionMovil;
                                    */

                                 ?>
                                <div class="cpanel-post-component cpanel-post-component-text">
                                    <div class="cpanel-post-component-header">
                                        <div>
                                            <span class="cpanel-post-component-kicker">Bloque editorial</span>
                                            <h3 data-section="form-post" data-value="textco">Componente de Texto</h3>
                                        </div>
                                        <button type="button" onclick="$(this).closest('.cpanel-post-component').remove();" class="cpanel-post-component-remove" aria-label="Eliminar componente"><i class="fa-regular fa-trash-can"></i></button>
                                        <input type="hidden" name="Components[<?= $k; ?>][Type]" value="1">
                                    </div>
                                    <div class="cpanel-post-editor-wrap">
                                         <textarea name="Components[<?= $k; ?>][TextBox]" class="form-control ckeditorText" id="image-editor-<?= $k; ?>" data-item="<?= $k; ?>"><?= Html::encode($Component->Description); ?></textarea>
                                        <input type="hidden" name="Components[<?= $k; ?>][MovilTextBox]" id="image-movil-description-<?= $k; ?>" value="<?= Html::encode($Component->DescriptionMovil ?: ''); ?>">
                                    </div>
                                </div>

                            <?php break; ?>

                            <?php case 2: ?>
                                 <?php 

                                    $Component = $c->imageC; 
                                    /*
                                    $Component->ImagePatch;
                                    $Component->Description;
                                    $Component->DescriptionMovil;
                                    $Component->Position;
                                    */

                                 ?>
                                <div class="cpanel-post-component cpanel-post-component-image">
                                    <div class="cpanel-post-component-header">
                                        <div>
                                            <span class="cpanel-post-component-kicker">Media 4:3</span>
                                            <h3><?= $imageComponent[$lang] ?></h3>
                                        </div>
                                        <button type="button" onclick="$(this).closest('.cpanel-post-component').remove();" class="cpanel-post-component-remove" aria-label="Eliminar componente"><i class="fa-regular fa-trash-can"></i></button>
                                        <input type="hidden" name="Components[<?= $k; ?>][Type]" value="2">
                                    </div>

                                    <div class="cpanel-post-image-layout">
                                        <div class="cpanel-post-component-media">
                                            <label for="imagecomponent-<?= $k; ?>" class="cpanel-post-upload cpanel-post-component-upload <?= $Component->ImagePatch ? 'has-preview' : '' ?>">
                                                <img class="cpanel-upload-preview" id="preview-image-up-<?= $k; ?>" src="<?= $Component->ImagePatch?: ''; ?>" alt="imagen de componente">
                                                <span class="cpanel-upload-empty">
                                                    <span class="cpanel-upload-icon"><i class="fa-regular fa-image"></i></span>
                                                    <span class="cpanel-upload-title">Subir imagen</span>
                                                    <span class="cpanel-upload-help">Haz click o arrastra una imagen</span>
                                                </span>
                                                <span class="cpanel-upload-overlay">
                                                    <span class="cpanel-upload-file">Imagen del componente</span>
                                                    <span class="cpanel-upload-action"><i class="fa-solid fa-rotate"></i> Cambiar</span>
                                                </span>
                                            </label>
                                            <input class="cpanel-file-input upimage-component-img" id="imagecomponent-<?= $k; ?>" type="file" data-inf="<?= $k; ?>" data-comp="2" accept="image/*" />
                                            <input type="hidden" id='name-image-component-up-<?= $k; ?>' name="Components[<?= $k; ?>][ImageName]" value="<?= $Component->ImagePatch?:'' ?>">
                                        </div>

                                        <div class="cpanel-post-component-fields">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label><?= $imageBy[$lang] ?></label>
                                                    <input type="text" class="form-control" id='image-by-<?= $k; ?>' name="Components[<?= $k; ?>][ImageBy]" value="<?= $Component->Imageby?:'' ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><?= $imageTextPosition[$lang] ?></label>
                                                    <div class="cpanel-post-position-group">
                                                        <label><input type="radio" name="Components[<?= $k; ?>][Position]" value="0" <?= ($Component->Position == 0)? 'checked' : '' ?>><span><?= $left[$lang] ?></span></label>
                                                        <label><input type="radio" name="Components[<?= $k; ?>][Position]" value="1" <?= ($Component->Position == 1)? 'checked' : '' ?>><span><?= $center[$lang] ?></span></label>
                                                        <label><input type="radio" name="Components[<?= $k; ?>][Position]" value="2" <?= ($Component->Position == 2)? 'checked' : '' ?>><span><?= $right[$lang] ?></span></label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label><?= $imageText[$lang] ?></label>
                                                    <textarea name="Components[<?= $k; ?>][Description]" class="form-control ckeditorText" id="image-editor-<?= $k; ?>" data-item="<?= $k; ?>"><?= Html::encode($Component->Description); ?></textarea>
                                                    <input type="hidden" name="Components[<?= $k; ?>][MovilDescription]" id="image-movil-description-<?= $k; ?>" value="<?= Html::encode($Component->DescriptionMovil ?: ''); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php break; ?>

                            <?php case 3: ?>
                                <?php 
                                    $Component = $c->ytVideoC; 

                                    /*
                                    $Component->UrlVideo;
                                    
                                    <iframe width="560" height="315" src="<?= $Component->UrlVideo; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                                     */


                                 ?>
                                <div class="cpanel-post-component cpanel-post-component-video">
                                    <div class="cpanel-post-component-header">
                                        <div>
                                            <span class="cpanel-post-component-kicker">YouTube</span>
                                            <h3 data-section="form-post" data-value="ytco">Componente de Video YT</h3>
                                        </div>
                                        <button type="button" onclick="$(this).closest('.cpanel-post-component').remove();" class="cpanel-post-component-remove" aria-label="Eliminar componente"><i class="fa-regular fa-trash-can"></i></button>
                                        <input type="hidden" name="Components[<?= $k; ?>][Type]" value="3">
                                    </div>
                                    <div class="cpanel-post-video-preview previewvideo-<?= $k; ?>">
                                        <?php if(!$Component->UrlVideo): ?>
                                            <div class="cpanel-post-video-empty">
                                                <i class="fa-brands fa-youtube"></i>
                                                <span>Pega un enlace de YouTube para ver la vista previa</span>
                                            </div>
                                        <?php else: ?>
                                            <iframe src="<?= $Component->UrlVideo; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cpanel-post-video-field">
                                        <label data-section="form-post" data-value="videolink">Enlace del video</label>
                                        <input type="text" name="Components[<?= $k; ?>][UrlVideo]" data-inf="<?= $k; ?>" value="<?= $Component->UrlVideo?:''; ?>" class="form-control urlvideocamp" placeholder="https://youtube.com/watch?v=...">
                                    </div>
                                </div>

                            <?php break; ?>

                            <<!-- ?php case 4: ?>
                            <?php 
                                    $Component = $c->carouselC; 
                                    /*
                                    <div class="contenedor-carousel">
                                    foreach ($Component->imagesCarousel as $imgI) {
                                        <div class="item-carousel">
                                                <img src=" $imgI->ImagePatch;">
                                        </div>
                                    }
                                    </div> 
                                    */

                                 ?>

                                <div class="container mt-3 containercarousel-component">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <div class="fs-4 d-flex justify-content-between align-items-center">
                                                <div><?= $carouselComponent[$lang] ?></div> 
                                                <button type="button" style="float: right;" onclick="$(this).parent().parent().parent().parent().remove();" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                 <input type="hidden" name="Components[<?= $k; ?>][Type]" value="4">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="container containeritemcarousel-prev">
                                                <div class="row boxpreviecols-<?= $k; ?>">
                                                    <?php foreach ($Component->imagesCarousel as $imgI): $carouselItems++; ?>
                                                    <div class="col-md-4 item-img-carousel-view">
                                                        <button type="button" class="btndel-item-img-carousel" onclick="$(this).parent().remove();" class=""><i class="fa fa-trash"></i></button> 
                                                        <img src="<?= $imgI->ImagePatch; ?>" class="carousel-add-it-<?= $k; ?> image-item-carousel-component" />
                                                        <input type="hidden" name="Components[<?= $k; ?>][Image][<?= $carouselItems; ?>]" value="<?= $imgI->ImagePatch; ?>">
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <label><?= $carouselUpload[$lang] ?></label>
                                            <input class="form-control carousel-components-up" id="carouselcomponent-<?= $k; ?>" type="file" data-inf="<?= $k; ?>" data-comp="4" />
                                        </div>
                                    </div>

                                </div>

                            <?php break; ?> -->

                            <?php endswitch; ?>

                        <?php endforeach; ?>
                    </div>
                    <div class="cpanel-post-add-components">
                        <div>
                            <h3 data-section="form-post" data-value="addcomp">Agregar componente</h3>
                            <p data-section="form-post" data-value="compdes">Agrega bloques de contenido seg&uacute;n la estructura del art&iacute;culo.</p>
                        </div>
                        <div class="cpanel-post-component-toolbar">
                                <button type="button" class="addTextBoxComponent cpanel-post-tool-btn"><i class="fa-regular fa-file-lines"></i> <span data-section="form-post" data-value="combu1">Texto</span></button>
                                <button type="button" class="addImageComponent cpanel-post-tool-btn"><i class="fa-regular fa-image"></i> <span data-section="form-post" data-value="combu2">Imagen</span></button>
                                <button type="button" class="addVideoComponent cpanel-post-tool-btn"><i class="fa-brands fa-youtube"></i> <span data-section="form-post" data-value="combu3">Video YT</span></button>
                                <!-- <button type="button" class="addCarouselComponent btn btn-violet"><i class="fa-solid fa-plus"></i> <span data-section="form-post" data-value="combu4">Carrusel</span></button> -->
                        </div>
                    </div>
                    </section>

                    <div class="row mt-4">
                        <div class="col-md-12 cpanel-post-form-actions">
                            <!-- BOTÓN DE GUARDAR -->
                            <?php if($ModelBlog->isNewRecord): ?>
                                <?= /* Html::submitButton('<i class="fa-solid fa-save"></i> <span data-section="form-post" data-value="save">Guardar</span>', [
                                        'class' => 'btn btn-primary',
                                        'name' => 'typesave',
                                        'value' => 'g'
                                    ]); */
                                    Html::submitButton('<i class="fa-solid fa-circle-check"></i> <span data-section="form-post" data-value="publish-blog">Publicar el post</span>', [
                                        'class' => 'btn btn-primary', 
                                        'name' => 'typesave',
                                        'value' => 'p'
                                    ]) 
                                ?>
                                <?php if(!$ModelBlog->isNewRecord): ?>
                                    <?= Html::submitButton('<i class="fa-solid fa-trash"></i> Eliminar el post', [
                                            'class' => 'btn btn-danger', 
                                            'data-section' => 'form-post',
                                            'data-value' => 'save-blog',
                                            'name' => 'typesave',
                                            'value' => 'e'
                                        ]) 
                                    ?>
                                <?php endif; ?>
                            <?php elseif($ModelBlog->Verified == 1): ?>
                                    <?= /* Html::submitButton('<i class="fa-solid fa-save"></i> <span data-section="form-post" data-value="save">Guardar</span>', [
                                            'class' => 'btn btn-primary',
                                            'name' => 'typesave',
                                            'value' => 'g'
                                        ])  */
                                        Html::submitButton('<i class="fa-solid fa-circle-check"></i> <span data-section="form-post" data-value="publish-blog">Publicar el post</span>', [
                                            'class' => 'btn btn-primary',
                                            'name' => 'typesave',
                                            'value' => 'p'
                                        ]) 
                                    ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <br><br><br><br><br>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- <div class="col-xl-4">
                <div class="card">
                    <h5 class="card-header fw-bold" data-section="form-post" data-value="rulescom">
                        Normas de la Comunidad
                    </h5>
                    <div class="card-body">
                        <p class="card-title fw-bold" data-section="form-post" data-value="rulesallo">Reglas permitidas:</p>
                        <p class="card-text fw-bold" data-section="form-post" data-value="ruletone">1. Sé amable y cordial.</p>
                        <p class="card-text" style="text-align: justify" data-section="form-post" data-value="ruledone">Se debe de fomentar un entorno agradable y debemos tratarnos con respeto. Puedes debatir sobre diversos temas, siempre que seas cordial con los demás y con los demás administradores.</p>
                        <p class="card-text fw-bold" data-section="form-post" data-value="rulettwo">2. No hagas bullying ni uses lenguaje que incita al odio.</p>
                        <p class="card-text" style="text-align: justify" data-section="form-post" data-value="ruledtwo">Debes de asegurarte de que todos se sientan seguros. No se permite bullying ni comentarios degradantes sobre raza, religión, cultura, orientación sexual, sexo o identidad, y muy importante no ofendas a las empresas que fabrican los productos como juguetes, aparatos tecnológicos o cualquier otro producto.</p>
                        <p class="card-text fw-bold" data-section="form-post" data-value="ruletthree">3. No publiques promociones ni spam.</p>
                        <p class="card-text" style="text-align: justify" data-section="form-post" data-value="ruledthree">No está permitido hablar de tiendas de juguetes virtuales o físicas donde el objetivo es darle publicidad, ya que esto genera un impacto negativo en nuestra tienda de juguetes. En este grupo no se permite la autopromoción, el spam ni los enlaces irrelevantes.</p>
                        <p class="card-text fw-bold" data-section="form-post" data-value="ruletfour">4. Respeta la privacidad de los demás.</p>
                        <p class="card-text" style="text-align: justify" data-section="form-post" data-value="ruledfour">Para formar parte de Check List Toys se requiere confianza mutua. Las conversaciones sinceras y abiertas no dejan de ser confidenciales y privadas. Lo que se comparte en el blog o foro debe permanecer en él.</p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <!-- Modal -->
    <!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel" data-section="form-post" data-value="prev">Previsualizacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body minimo-height">
                    <div class="preview_desktop">
                        <div class="preview_desktop__title preview_escritorio__title"></div>
                        <div class="preview_desktop__cover preview_escritorio__cover"></div>
                        <div class="top_imagenes"></div>
                        <div class="preview_desktop__description preview_escritorio__description"></div>
                        <div class="bt_imagenes"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    
    <?php
    // $this->registerJsFile(
    //     '@web/js/blog/preview_photo.js',
    //     ['depends' => [\yii\web\JqueryAsset::class]]
    // );
    $this->registerJsFile(
        '@web/js/ckeditor5/build/ckeditor.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );
    // $this->registerJsFile(
    //     '@web/js/ckeditor5/build/translations/es.js',
    //     ['depends' => [\yii\web\JqueryAsset::class]]
    // );
    // $this->registerJsFile(
    //     '@web/js/blog/posts_blog.js',
    //     ['depends' => [\yii\web\JqueryAsset::class]]
    // );
    $this->registerJS("
        var AmountComponents = ".count($Components).";
        var componentsCarouselItems = ".$carouselItems.";
        var editores = {};

        function readURL(input,prev) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(prev).attr('src', e.target.result);
                    $(prev).closest('.cpanel-post-upload').addClass('has-preview');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $('#postImage').change(function(){
            readURL(this,'#ViewpostImage');
            if (this.files && this.files[0]) {
                $('#postCoverFileName').text(this.files[0].name);
            }
        });

        function bindImageDropzone(dropSelector, inputSelector) {
            $(document).on('dragenter dragover', dropSelector, function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('is-dragover');
            });

            $(document).on('dragleave dragend drop', dropSelector, function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('is-dragover');
            });

            $(document).on('drop', dropSelector, function(e) {
                var files = e.originalEvent.dataTransfer.files;
                if (!files || !files.length) {
                    return;
                }

                var input = inputSelector ? $(inputSelector)[0] : $('#' + $(this).attr('for'))[0];
                if (!input) {
                    return;
                }

                input.files = files;
                $(input).trigger('change');
            });
        }

        bindImageDropzone('#postCoverDropzone', '#postImage');
        bindImageDropzone('.cpanel-post-component-upload');

         $('.formComponents').on('change','.urlvideocamp',function(e){
               let CampText =  $(this).val();
               let inf = $(this).data('inf');
               let IDVideo = false;
               if(CampText.match(/watch\?v=/)){

                    IDVideo = CampText.split('watch?v=');
                    IDVideo = IDVideo[1];
               }
               if(CampText.match(/youtu\.be\//)){
                    IDVideo = CampText.split('youtu.be/');
                    IDVideo = IDVideo[1];
               }
               if(CampText.match(/youtube\.com\/embed\//)){
                    IDVideo = CampText.split('youtube.com/embed/');
                    IDVideo = IDVideo[1];
               }

               if(IDVideo){
                    let frameHtml = '<iframe src=\"https://www.youtube.com/embed/'+IDVideo+'\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>';
                    $('.previewvideo-'+inf).html(frameHtml);
                }else{
                    $(this).val('');
                    let frameHtml = '<div class=\"cpanel-post-video-empty\"><i class=\"fa-brands fa-youtube\"></i><span>Pega un enlace de YouTube para ver la vista previa</span></div>';
                    $('.previewvideo-'+inf).html(frameHtml);
                }
            });


        $('.formComponents').on('change', '.carousel-components-up', function(e){

            let inf = $(this).attr('data-inf');
            let typComp = $(this).attr('data-comp');
            let formdata = new FormData();
            let InpCh = $(this);

            if($(this).prop('files').length > 0 && $('.carousel-add-it-'+inf).length < 6)
            {

                let file = $(this).prop('files')[0];
                formdata.append('ChecklistFilesForm[ImageFile]', file);
                formdata.append('ChecklistFilesForm[ConditionID]', typComp);

                $.ajax({
                        url: '".Url::to(['/blog/picturecomponents'])."',
                        type: 'POST',
                        dataType: 'json',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                             if(!result.error){

                                componentsCarouselItems++;

                                let itemhtml = '<div class=\"col-md-4 item-img-carousel-view\">';
                                    itemhtml +=     '<button type=\"button\" class=\"btndel-item-img-carousel\" onclick=\"$(this).parent().remove();\"><i class=\"fa fa-trash\"></i></button>'; 
                                    itemhtml +=     '<img src=\"'+result.urlabsolute+'\" class=\"carousel-add-it-'+inf+' image-item-carousel-component\" />';
                                    itemhtml +=     '<input type=\"hidden\" name=\"Components['+inf+'][Image]['+componentsCarouselItems+']\" value=\"'+result.url+'\">';
                                    itemhtml += '</div>';
                                $('.boxpreviecols-'+inf).append(itemhtml);

                             }else{
                                alert(result.message);
                             }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                             InpCh.val(null);

                        }
                    });

            }else{
                if($('.carousel-add-it-'+inf).length >= 6){
                    alert('Solo puede subir 6 imagenes por carrusel');
                }
            }
             InpCh.val(null);

        });

        $('.formComponents').on('change','.upimage-component-img',function(e){
            let inf = $(this).attr('data-inf');
            let typComp = $(this).attr('data-comp');
            let formdata = new FormData();
            let InpCh = $(this);
            if($(this).prop('files').length > 0)
            {
                let file = $(this).prop('files')[0];
                readURL(this, '#preview-image-up-'+inf);
                formdata.append('ChecklistFilesForm[ImageFile]', file);
                formdata.append('ChecklistFilesForm[ConditionID]', typComp);

                $.ajax({
                        url: '".Url::to(['/blog/picturecomponents'])."',
                        type: 'POST',
                        dataType: 'json',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                             if(!result.error){
                                $('#preview-image-up-'+inf).closest('.cpanel-post-upload').addClass('has-preview');
                                $('#name-image-component-up-'+inf).val(result.url);
                             }else{
                                $('#name-image-component-up-'+inf).val('');
                                alert(result.message);
                             }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                             $('#name-image-component-up-'+inf).val('');
                             InpCh.val(null);

                        }
                    });

            }else{
                $('#preview-image-up-'+inf).attr('src','');
                $('#preview-image-up-'+inf).closest('.cpanel-post-upload').removeClass('has-preview');
                $('#name-image-component-up-'+inf).val('');
            }
             InpCh.val(null);

        });
        $(document).ready(function(){
            
             $('.ckeditorText').each(function () {

                let codeid = $(this).data('item');

                ClassicEditor.create( document.querySelector( '#image-editor-'+codeid ), {
                    language: 'es',
                  }).then( editor => {
                    editor.model.document.on( 'change:data', () => {
                        let contentck = editor.getData();
                        editores['item'+codeid] = editor;

                        if(contentck != ''){
                            
                            $('#image-movil-description-'+codeid).val(contentck);
                          }
                        else{
                            $('#image-movil-description-'+codeid).val('');
                        }
                    });
                }).catch( error => {
                    console.error( error );
                });



                });
        });
        
        $(document).on('click','.addTextBoxComponent', function(e){
            AmountComponents++;
            let HtmlCompText =     '<div class=\"cpanel-post-component cpanel-post-component-text\">';
            HtmlCompText +=            '<div class=\"cpanel-post-component-header\">';
            HtmlCompText +=                '<div><span class=\"cpanel-post-component-kicker\">Bloque editorial</span><h3>$textComponent[$lang]</h3></div>';
            HtmlCompText +=                '<button type=\"button\" onclick=\"$(this).closest(\\'.cpanel-post-component\\').remove();\" class=\"cpanel-post-component-remove\" aria-label=\"Eliminar componente\"><i class=\"fa-regular fa-trash-can\"></i></button>';
            HtmlCompText +=                '<input type=\"hidden\" name=\"Components[{{{CODE}}}][Type]\" value=\"1\">';
            HtmlCompText +=            '</div>';
            HtmlCompText +=            '<div class=\"cpanel-post-editor-wrap\">';
            HtmlCompText +=                '<textarea name=\"Components[{{{CODE}}}][TextBox]\" class=\"form-control ckeditorText\" id=\"image-editor-{{{CODE}}}\" data-item=\"{{{CODE}}}\"></textarea>';
            HtmlCompText +=                '<input type=\"hidden\" name=\"Components[{{{CODE}}}][MovilTextBox]\" id=\"image-movil-description-{{{CODE}}}\" value=\"\">';
            HtmlCompText +=            '</div>';
            HtmlCompText +=        '</div>';

            let AddHtml = HtmlCompText.replace(/\{{{CODE}}}/g, AmountComponents);
            $('.formComponents').append(AddHtml);

            ClassicEditor.create( document.querySelector( '#image-editor-'+AmountComponents ), {
                    language: 'es',
                  }).then( editor => {
                    editor.model.document.on( 'change:data', () => {
                        let contentck = editor.getData();
                        editores['item'+AmountComponents] = editor;
                        if(contentck != ''){
                            
                            $('#image-movil-description-'+AmountComponents).val(contentck);
                          }
                        else{
                            $('#image-movil-description-'+AmountComponents).val('');
                        }
                    });
                }).catch( error => {
                    console.error( error );
                });


        });

        $(document).on('click','.addImageComponent', function(e){
            AmountComponents++;

            let HtmlCompImage =    '<div class=\"cpanel-post-component cpanel-post-component-image\">';
            HtmlCompImage +=            '<div class=\"cpanel-post-component-header\">';
            HtmlCompImage +=                '<div><span class=\"cpanel-post-component-kicker\">Media 4:3</span><h3>$imageComponent[$lang]</h3></div>';
            HtmlCompImage +=                '<button type=\"button\" onclick=\"$(this).closest(\\'.cpanel-post-component\\').remove();\" class=\"cpanel-post-component-remove\" aria-label=\"Eliminar componente\"><i class=\"fa-regular fa-trash-can\"></i></button>';
            HtmlCompImage +=                '<input type=\"hidden\" name=\"Components[{{{CODE}}}][Type]\" value=\"2\">';
            HtmlCompImage +=            '</div>';
            HtmlCompImage +=            '<div class=\"cpanel-post-image-layout\">';
            HtmlCompImage +=                '<div class=\"cpanel-post-component-media\">';
            HtmlCompImage +=                    '<label for=\"imagecomponent-{{{CODE}}}\" class=\"cpanel-post-upload cpanel-post-component-upload\">';
            HtmlCompImage +=                        '<img class=\"cpanel-upload-preview\" id=\"preview-image-up-{{{CODE}}}\" src=\"\" alt=\"imagen de componente\">';
            HtmlCompImage +=                        '<span class=\"cpanel-upload-empty\"><span class=\"cpanel-upload-icon\"><i class=\"fa-regular fa-image\"></i></span><span class=\"cpanel-upload-title\">Subir imagen</span><span class=\"cpanel-upload-help\">Haz click o arrastra una imagen</span></span>';
            HtmlCompImage +=                        '<span class=\"cpanel-upload-overlay\"><span class=\"cpanel-upload-file\">Imagen del componente</span><span class=\"cpanel-upload-action\"><i class=\"fa-solid fa-rotate\"></i> Cambiar</span></span>';
            HtmlCompImage +=                    '</label>';
            HtmlCompImage +=                    '<input class=\"cpanel-file-input upimage-component-img\" id=\"imagecomponent-{{{CODE}}}\" type=\"file\" data-inf=\"{{{CODE}}}\" data-comp=\"2\" accept=\"image/*\"/>';
            HtmlCompImage +=                    '<input type=\"hidden\" id=\"name-image-component-up-{{{CODE}}}\" name=\"Components[{{{CODE}}}][ImageName]\">';
            HtmlCompImage +=                '</div>';
            HtmlCompImage +=                '<div class=\"cpanel-post-component-fields\"><div class=\"row g-3\">';
            HtmlCompImage +=                    '<div class=\"col-md-6\"><label>$imageBy[$lang]</label><input type=\"text\" class=\"form-control\" id=\"image-by-{{{CODE}}}\" name=\"Components[{{{CODE}}}][ImageBy]\"></div>';
            HtmlCompImage +=                    '<div class=\"col-md-6\"><label>$imageTextPosition[$lang]</label><div class=\"cpanel-post-position-group\"><label><input type=\"radio\" name=\"Components[{{{CODE}}}][Position]\" value=\"0\"><span>$left[$lang]</span></label><label><input type=\"radio\" name=\"Components[{{{CODE}}}][Position]\" checked value=\"1\"><span>$center[$lang]</span></label><label><input type=\"radio\" name=\"Components[{{{CODE}}}][Position]\" value=\"2\"><span>$right[$lang]</span></label></div></div>';
            HtmlCompImage +=                    '<div class=\"col-12\"><label>$imageText[$lang]</label><textarea name=\"Components[{{{CODE}}}][Description]\" class=\"form-control ckeditorText\" id=\"image-editor-{{{CODE}}}\" data-item=\"{{{CODE}}}\"></textarea><input type=\"hidden\" name=\"Components[{{{CODE}}}][MovilDescription]\" id=\"image-movil-description-{{{CODE}}}\" value=\"\"></div>';
            HtmlCompImage +=                '</div></div>';
            HtmlCompImage +=            '</div>';
            HtmlCompImage +=        '</div>';

            let AddHtml = HtmlCompImage.replace(/\{{{CODE}}}/g, AmountComponents);
            $('.formComponents').append(AddHtml);

            ClassicEditor.create( document.querySelector( '#image-editor-'+AmountComponents ), {
                    language: 'es',
                  }).then( editor => {
                    editor.model.document.on( 'change:data', () => {
                        let contentck = editor.getData();
                        editores['item'+AmountComponents] = editor;
                        if(contentck != ''){
                            
                            $('#image-movil-description-'+AmountComponents).val(contentck);
                          }
                        else{
                            $('#image-movil-description-'+AmountComponents).val('');
                        }
                    });
                }).catch( error => {
                    console.error( error );
                });
        
        });

        $(document).on('click','.addVideoComponent', function(e){
            AmountComponents++;

            let HtmlCompVideo =    '<div class=\"cpanel-post-component cpanel-post-component-video\">';
            HtmlCompVideo +=            '<div class=\"cpanel-post-component-header\">';
            HtmlCompVideo +=                '<div><span class=\"cpanel-post-component-kicker\">YouTube</span><h3>$videoComponent[$lang]</h3></div>';
            HtmlCompVideo +=                '<button type=\"button\" onclick=\"$(this).closest(\\'.cpanel-post-component\\').remove();\" class=\"cpanel-post-component-remove\" aria-label=\"Eliminar componente\"><i class=\"fa-regular fa-trash-can\"></i></button>';
            HtmlCompVideo +=                '<input type=\"hidden\" name=\"Components[{{{CODE}}}][Type]\" value=\"3\">';
            HtmlCompVideo +=            '</div>';
            HtmlCompVideo +=            '<div class=\"cpanel-post-video-preview previewvideo-{{{CODE}}}\"><div class=\"cpanel-post-video-empty\"><i class=\"fa-brands fa-youtube\"></i><span>Pega un enlace de YouTube para ver la vista previa</span></div></div>';
            HtmlCompVideo +=            '<div class=\"cpanel-post-video-field\"><label data-section=\"form-post\" data-value=\"videolink\">$videoLink[$lang]</label><input type=\"text\" name=\"Components[{{{CODE}}}][UrlVideo]\" data-inf=\"{{{CODE}}}\" class=\"form-control urlvideocamp\" placeholder=\"https://youtube.com/watch?v=...\"></div>';
            HtmlCompVideo +=        '</div>';

            let AddHtml = HtmlCompVideo.replace(/\{{{CODE}}}/g, AmountComponents);
            $('.formComponents').append(AddHtml);
        });

        /* $(document).on('click','.addCarouselComponent', function(e){
            AmountComponents++;

            let HtmlCompCarousel =  '<div class=\"container mt-3 containercarousel-component\">';
            HtmlCompCarousel +=         '<div class=\"row\">';
            HtmlCompCarousel +=             '<div class=\"col-md-12\">';
            HtmlCompCarousel +=                  '<div class=\"fs-4 d-flex justify-content-between align-items-center\"><div>$carouselComponent[$lang]</div> <button type=\"button\" style=\"float: right;\" onclick=\"$(this).parent().parent().parent().parent().remove();\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i></button> </div>';
            HtmlCompCarousel +=                  '<input type=\"hidden\" name=\"Components[{{{CODE}}}][Type]\" value=\"4\">';
            HtmlCompCarousel +=             '</div>';
            HtmlCompCarousel +=         '</div>';
            HtmlCompCarousel +=         '<div class=\"row mt-2\">';
            HtmlCompCarousel +=             '<div class=\"col-md-12\">';
            HtmlCompCarousel +=                 '<div class=\"container containeritemcarousel-prev\">';
            HtmlCompCarousel +=                     '<div class=\"row boxpreviecols-{{{CODE}}}\">';
            HtmlCompCarousel +=                     '</div>';
            HtmlCompCarousel +=                 '</div>';
            HtmlCompCarousel +=             '</div>';
            HtmlCompCarousel +=         '</div>';
            HtmlCompCarousel +=         '<div class=\"row mt-2\">';
            HtmlCompCarousel +=             '<div class=\"col-md-12\">';
            HtmlCompCarousel +=                 '<label>$carouselUpload[$lang]</label>';
            HtmlCompCarousel +=                 '<input class=\"form-control carousel-components-up\" id=\"carouselcomponent-{{{CODE}}}\" type=\"file\" data-inf=\"{{{CODE}}}\" data-comp=\"4\" />';
            HtmlCompCarousel +=             '</div>';
            HtmlCompCarousel +=         '</div>';
            HtmlCompCarousel +=     '</div>';

            let AddHtml = HtmlCompCarousel.replace(/\{{{CODE}}}/g, AmountComponents);
            $('.formComponents').append(AddHtml);

        }); */

        // Spinner en botón de guardar al enviar el formulario
        jQuery('form').on('submit', function() {
            var btn = jQuery(this).find('button[type=\"submit\"]');
            if (btn.length) {
                btn.prop('disabled', true);
                btn.html('<span class=\"spinner-border spinner-border-sm me-2\" role=\"status\" aria-hidden=\"true\"></span> Guardando...');
            }
        });

        // Limpiar HTML al pegar en CKEditor (paste a nivel DOM)
        document.addEventListener('paste', function(e) {
            var target = e.target;
            if (!target.closest) return;
            var editable = target.closest('.ck-editor__editable');
            if (!editable) return;
            e.preventDefault();
            var text = (e.clipboardData || window.clipboardData).getData('text/plain');
            if (text) {
                document.execCommand('insertText', false, text);
            }
        }, true);

        ");
?>
