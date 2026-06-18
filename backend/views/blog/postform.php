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
        <br><br><br>
        <center>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </center>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <br><br><br>
        <center>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <?= Yii::$app->session->getFlash('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </center>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if($ModelBlog->isNewRecord): ?>
                    <h2 class="fw-bold"><?= $createNewPost[$lang] ?></h2>
                <?php else: ?>
                    <h2 class="fw-bold"><?= $editPost[$lang] ?> <small><i><u>ID#<?= $ModelBlog->PostBlogID; ?></u></i></small></h2>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <?php $form = ActiveForm::begin([ 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- SELECCIÓN DE LA CATEGORÍA DE JUGUETES -->
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
                        <div class="col-md-6">
                            <!-- SELECCIÓN DE LA CATEGORÍA DE JUGUETES -->
                            <div class="backGround mb-3 collecionstoy d-block">
                                <?=
                                    $form->field($ModelBlog, 'Featured', ['labelOptions' => ['class' => 'form-label fw-bold']])->dropDownList(['1' => 'Si', '0' => 'No']);           
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="backGround mb-3 d-block">
                                <?php $labels = ($ModelBlog->isNewRecord) ? 'CollectionID' : 'Labels' ?>
                                <?=
                                    $form->field($Project, 'Project')->widget(Chosen::classname(), [                            
                                        'items' => $projectsList,
                                        'allowDeselect' => true,
                                        'disableSearch' => true, // Search input will be disabled
                                        'clientOptions' => [
                                            'search_contains' => true,
                                            'max_selected_options' => 3,
                                        ],
                                         'options'  => [
                                             'id' => 'ProjectCollectionID',
                                        ],
                                        'placeholder' => 'Seleccione',
                                        'multiple' => true,
                                    ])->label('Projectos', ['class' => 'fw-bold mb-2', 'data-section' => 'formdiscussion', 'data-value' => 'field3']);
                                    /* $form->field($ModelBlog, 'CollectionID', ['options' => ['class' => 'form-group col-md-12']])
                                    ->dropDownList($collectionList, ['prompt' => $selectCollection[$lang], 'class' => 'form-control'])
                                    ->label('Etiquetas', ['class' => 'form-label fw-bold', 'data-section' => 'form-post', 'data-value' => 'collection']); */ // Crea el Select Input con el array de opciones, clase CSS y label personalizado.                
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="backGround mb-3 d-block">
                                <?=
                                    $form->field($ModelBlog, 'CreateAT', ['labelOptions' => ['class' => 'form-label fw-bold']])->input('date', ['class' => 'form-control']);           
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- TITULO DEL POST -->
                            <div class="backGround mb-3">
                                <?= $form->field($ModelBlog, 'VTitle', ['labelOptions' => ['class' => 'form-label fw-bold', 'data-section' => 'form-post', 'data-value' => 't-post']])->textInput(["id" => "title_post", "class" => "form-control title_post", "aria-describedby" => "title_post", "maxlength" => true]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- TITULO DEL POST -->
                            <div class="backGround mb-3 d-flex flex-column justify-content-center align-items-center">
                                <img src=" <?= $ModelBlog->ImagePost ?: Yii::getAlias("@web").'/../images/upload-icon/upload-image.png' ?>" alt="Imagen principal" class="img-responsive img-circle" id="ViewpostImage"  style="margin: 0 auto 10px; max-width: 150px;">
                                <div class=""><?= $note[$lang] ?></div>
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <div class="backGround mb-3">
                                <?= $form->field($ModelBlog, 'RequestFile', ['labelOptions' => ['class' => 'form-label fw-bold']])->fileInput(['id' => 'postImage']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="formComponents mb-5">
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
                                <div class="container mt-3"style="background: #edeeff; border-radius:6px; padding: 20px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="fs-4 mb-2 d-flex justify-content-between align-items-center" data-section="form-post" data-value="textco">Componente de Texto</div> 
                                            <button type="button" style="float: right;" onclick="$(this).parent().parent().parent().remove();" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            <input type="hidden" name="Components[<?= $k; ?>][Type]" value="1">
                                        </div>
                                        <div class="col-md-12">
                                             <textarea name="Components[<?= $k; ?>][TextBox]" class="form-control ckeditorText" id="image-editor-<?= $k; ?>" data-item="<?= $k; ?>"><?= $Component->Description; ?></textarea>
                                             <input type="hidden" name="Components[<?= $k; ?>][MovilTextBox]" id="image-movil-description-<?= $k; ?>" value="<?= $Component->DescriptionMovil ?: ''; ?>">
                                        </div>
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
                                <div class="container mt-3" style="background: #edeeff; border-radius:6px; padding: 20px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="fs-4 mb-2 d-flex justify-content-between align-items-center"><?= $imageComponent[$lang] ?></div> 
                                            <button type="button" style="float: right;" onclick="$(this).parent().parent().parent().remove();" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            <input type="hidden" name="Components[<?= $k; ?>][Type]" value="2">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <img style="max-width: 100%;height: auto;" class="img-responsive" id="preview-image-up-<?= $k; ?>" src="<?= $Component->ImagePatch?: Url::to(['/']).'/images/upload-icon/upload-image.png'; ?>" alt="imagen de componente">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mt-4">
                                                    <input class="form-control upimage-component-img" id="imagecomponent-<?= $k; ?>" type="file" data-inf="<?= $k; ?>" data-comp="2" />
                                                    <input type="hidden" id='name-image-component-up-<?= $k; ?>' name="Components[<?= $k; ?>][ImageName]" value="<?= $Component->ImagePatch?:'' ?>">
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <label><?= $imageBy[$lang] ?></label>
                                                    <input type="text" class="form-control" id='image-by-<?= $k; ?>' name="Components[<?= $k; ?>][ImageBy]" value="<?= $Component->Imageby?:'' ?>">
                                                </div>
                                             </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label><?= $imageText[$lang] ?></label>
                                             <textarea name="Components[<?= $k; ?>][Description]" class="form-control ckeditorText" id="image-editor-<?= $k; ?>" data-item="<?= $k; ?>"><?= $Component->Description; ?></textarea>
                                             <input type="hidden" name="Components[<?= $k; ?>][MovilDescription]" id="image-movil-description-<?= $k; ?>" value="<?= $Component->DescriptionMovil ?: ''; ?>">
                                        </div>


                                        <div class="col-md-12 mt-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label><?= $imageTextPosition[$lang] ?></label>
                                                </div>
                                                <div class="col-md-4">
                                                    <img class="LogoCLT" src="<?= Yii::getAlias("@web").'/../images/icn/left.png' ?>" alt="Logo" style="width: 90px; height: 90px;"/>
                                                    <input type="radio" name="Components[<?= $k; ?>][Position]" value="0" <?= ($Component->Position == 0)? 'checked' : '' ?> ><?= $left[$lang] ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <img class="LogoCLT" src="<?= Yii::getAlias("@web").'/../images/icn/center.png' ?>" alt="Logo" style="width: 90px; height: 90px;">
                                                    <input type="radio" name="Components[<?= $k; ?>][Position]" value="1" <?= ($Component->Position == 1)? 'checked' : '' ?>><?= $center[$lang] ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <img class="LogoCLT" src="<?= Yii::getAlias("@web").'/../images/icn/right.png' ?>" alt="Logo" style="width: 90px; height: 90px;">
                                                    <input type="radio" name="Components[<?= $k; ?>][Position]" value="2" <?= ($Component->Position == 2)? 'checked' : '' ?>><?= $right[$lang] ?>
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
                                <div class="container mt-3" style="background: #edeeff; border-radius:6px; padding: 20px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <div class="fs-4 d-flex justify-content-between align-items-center" data-section="form-post" data-value="ytco">Componente de Video YT</div>
                                             <button type="button" style="float: right;" onclick="$(this).parent().parent().parent().remove();" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                             <input type="hidden" name="Components[<?= $k; ?>][Type]" value="3">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="previewvideo-<?= $k; ?>" style="display: flex; justify-content: center;align-items: center;">
                                                <?php if(!$Component->UrlVideo): ?>
                                                <img style="max-width: 100%;height: auto;" class="img-responsive" src="<?= Url::to(['/']).'images/upload-icon/videoytbad.jpg'; ?>" alt="imagen de componente">
                                                <?php else: ?>
                                                    <iframe width="560" height="315" src="<?= $Component->UrlVideo; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <label data-section="form-post" data-value="videolink">Enlace del video</label>
                                            <input type="text"  name="Components[<?= $k; ?>][UrlVideo]" data-inf="<?= $k; ?>" value="<?= $Component->UrlVideo?:''; ?>" class="form-control urlvideocamp">
                                        </div>
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
                    <div class="row">
                        <div class="col-md-12" style="border: 1px solid; box-sizing: border-box; padding: 16px;">
                            <div class="mb-2 fw-bold" data-section="form-post" data-value="addcomp">Agregar Componente</div>
                            <div data-section="form-post" data-value="compdes">Agregué el componente que desee en base en la estructura de su artículo.</div>
                            <div class="mt-5 mb-2 text-center">
                                <button type="button" class="addTextBoxComponent btn btn-violet"><i class="fa-solid fa-plus"></i> <span data-section="form-post" data-value="combu1">Texto</span></button>
                                <button type="button" class="addImageComponent btn btn-violet"><i class="fa-solid fa-plus"></i> <span data-section="form-post" data-value="combu2">Imagen</span></button>
                                <button type="button" class="addVideoComponent btn btn-violet"><i class="fa-solid fa-plus"></i> <span data-section="form-post" data-value="combu3">Video YT</span></button>
                                <!-- <button type="button" class="addCarouselComponent btn btn-violet"><i class="fa-solid fa-plus"></i> <span data-section="form-post" data-value="combu4">Carrusel</span></button> -->
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
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
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $('#postImage').change(function(){

            readURL(this,'#ViewpostImage');

        });


        function removeTags(str) {
            if ((str===null) || (str===''))
                return false;
            else
                str = str.toString();
            const regex1 = /&nbsp;/ig;
            const regex2 = /&nbsp/ig;

            return str.replace( /(<([^>]+)>)/ig, '').replaceAll(regex1, '').replaceAll(regex2, '').trim();
        }

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
                    let frameHtml = '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/'+IDVideo+'\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>';
                    $('.previewvideo-'+inf).html(frameHtml);
                }else{
                    $(this).val('');
                    let frameHtml = '<img style=\"max-width: 100%;height: auto;\" class=\"img-responsive\" src=\"".Url::to(['/'])."images/upload-icon/videoytbad.jpg\"/>';
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
                formdata.append('ChecklistFilesForm[ImageFile]', file);
                formdata.append('ChecklistFilesForm[ConditionID]', typComp);

                $.ajax({
                        url: '".Url::to(['/blog/picturecomponents'])."',
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                             if(!result.error){
                                $('#preview-image-up-'+inf).attr('src',result.urlabsolute);
                                $('#name-image-component-up-'+inf).val(result.url);
                             }else{
                                alert(result.message);
                             }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                             InpCh.val(null);

                        }
                    });

            }else{
                $('#preview-image-up-'+inf).attr('src','/CheckListToys/images/logos/Logo_CLT.png');
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
                            
                            $('#image-movil-description-'+codeid).val(removeTags(contentck));
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
            let HtmlCompText =     '<div class=\"container mt-3\"  style=\"background: #edeeff; border-radius:6px; padding: 20px;\">';
            HtmlCompText +=            '<div class=\"row\">';
            HtmlCompText +=                '<div class=\"col-md-12 mb-2\">';
            HtmlCompText +=                    '<div class=\"fs-4 d-flex justify-content-between align-items-center\"><div>$textComponent[$lang]</div> <button type=\"button\" style=\"float: right;\" onclick=\"$(this).parent().parent().parent().remove();\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i></button></div>';
            HtmlCompText +=                     '<input type=\"hidden\" name=\"Components[{{{CODE}}}][Type]\" value=\"1\">';
            HtmlCompText +=                '</div>';
            HtmlCompText +=                '<div class=\"col-md-12\">';
            HtmlCompText +=                     '<textarea name=\"Components[{{{CODE}}}][TextBox]\" class=\"form-control ckeditorText\" id=\"image-editor-{{{CODE}}}\" data-item=\"{{{CODE}}}\"></textarea>';
            HtmlCompText +=                     '<input type=\"hidden\" name=\"Components[{{{CODE}}}][MovilTextBox]\" id=\"image-movil-description-{{{CODE}}}\" value=\"\">';
            HtmlCompText +=                '</div>';
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
                            
                            $('#image-movil-description-'+AmountComponents).val(removeTags(contentck));
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

            let HtmlCompImage =    '<div class=\"container mt-3\"  style=\"background: #edeeff; border-radius:6px; padding: 20px;\">';
            HtmlCompImage +=            '<div class=\"row\">';
            HtmlCompImage +=                '<div class=\"col-md-12\">';
            HtmlCompImage +=                     '<div class=\"fs-4 d-flex justify-content-between align-items-center\"><div>$imageComponent[$lang]</div> <button type=\"button\" style=\"float: right;\" onclick=\"$(this).parent().parent().parent().remove();\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i></button></div>';

            HtmlCompImage +=                     '<input type=\"hidden\" name=\"Components[{{{CODE}}}][Type]\" value=\"2\">';
            HtmlCompImage +=                '</div>';
            HtmlCompImage +=                '<div class=\"col-md-6\">';
            HtmlCompImage +=                    '<div class=\"row\">';
            HtmlCompImage +=                        '<div class=\"col-md-12\">';
            HtmlCompImage +=                            '<img style=\"max-width: 100%;height: auto;\" class=\"img-responsive\" id=\"preview-image-up-{{{CODE}}}\" src=\"".Url::to('@raizweb')."images/upload-icon/upload-image.png\" alt=\"imagen de componente\">';
            HtmlCompImage +=                        '</div>';
            HtmlCompImage +=                    '</div>';
            HtmlCompImage +=                    '<div class=\"row\">';
            HtmlCompImage +=                        '<div class=\"col-md-12 mt-4\">';
            HtmlCompImage +=                            '<input class=\"form-control upimage-component-img\" id=\"imagecomponent-{{{CODE}}}\" type=\"file\" data-inf=\"{{{CODE}}}\" data-comp=\"2\"/>';
            HtmlCompImage +=                            '<input type=\"hidden\" id=\"name-image-component-up-{{{CODE}}}\" name=\"Components[{{{CODE}}}][ImageName]\">';
            HtmlCompImage +=                        '</div>';

            HtmlCompImage +=                        '<div class=\"col-md-12 mt-4\">';
            HtmlCompImage +=                        '<label>$imageBy[$lang]</label>';
            HtmlCompImage +=                            '<input type=\"text\" class=\"form-control\" id=\"image-by-{{{CODE}}}\" name=\"Components[{{{CODE}}}][ImageBy]\">';
            HtmlCompImage +=                        '</div>';

            HtmlCompImage +=                     '</div>';
            HtmlCompImage +=                '</div>';

            HtmlCompImage +=                '<div class=\"col-md-6\">';
            HtmlCompImage +=                    '<label>$imageText[$lang]</label>';
            HtmlCompImage +=                     '<textarea name=\"Components[{{{CODE}}}][Description]\" class=\"form-control ckeditorText\" id=\"image-editor-{{{CODE}}}\" data-item=\"{{{CODE}}}\"></textarea>';
            HtmlCompImage +=                     '<input type=\"hidden\" name=\"Components[{{{CODE}}}][MovilDescription]\" id=\"image-movil-description-{{{CODE}}}\" value=\"\">';
            HtmlCompImage +=                '</div>';

            HtmlCompImage +=                '<div class=\"col-md-12 mt-4\">';
            HtmlCompImage +=                    '<div class=\"row\">';
            HtmlCompImage +=                        '<div class=\"col-md-12\">';
            HtmlCompImage +=                            '<label>$imageTextPosition[$lang]</label>';
            HtmlCompImage +=                        '</div>';
            HtmlCompImage +=                        '<div class=\"col-md-4\">';
            HtmlCompImage +=                            '<img class=\"LogoCLT\" src=\"".Yii::getAlias('@web')."/../images/icn/left.png\" alt=\"Logo\" style=\"width: 90px; height: 90px;\"/>';
            HtmlCompImage +=                            '<input type=\"radio\" name=\"Components[{{{CODE}}}][Position]\" value=\"0\">$left[$lang]</input>';
            HtmlCompImage +=                        '</div>';
            HtmlCompImage +=                        '<div class=\"col-md-4\">';
            HtmlCompImage +=                            '<img class=\"LogoCLT\" src=\"".Yii::getAlias('@web')."/../images/icn/center.png\" alt=\"Logo\" style=\"width: 90px; height: 90px;\">';
            HtmlCompImage +=                            '<input type=\"radio\" name=\"Components[{{{CODE}}}][Position]\" checked value=\"1\">$center[$lang]</input>';
            HtmlCompImage +=                        '</div>';
            HtmlCompImage +=                        '<div class=\"col-md-4\">';
            HtmlCompImage +=                            '<img class=\"LogoCLT\" src=\"".Yii::getAlias('@web')."/../images/icn/right.png\" alt=\"Logo\" style=\"width: 90px; height: 90px;\">';
            HtmlCompImage +=                            '<input type=\"radio\" name=\"Components[{{{CODE}}}][Position]\" value=\"2\">$right[$lang]</input>';
            HtmlCompImage +=                        '</div>';
            HtmlCompImage +=                    '</div>';
            HtmlCompImage +=                '</div>';
                                            
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
                            
                            $('#image-movil-description-'+AmountComponents).val(removeTags(contentck));
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

            let HtmlCompVideo =    '<div class=\"container mt-3\"  style=\"background: #edeeff; border-radius:6px; padding: 20px;\">';
            HtmlCompVideo +=            '<div class=\"row\">';
            HtmlCompVideo +=                '<div class=\"col-md-12\">';
            HtmlCompVideo +=                     '<div class=\"fs-4 d-flex justify-content-between align-items-center\"><div>$videoComponent[$lang]</div><button type=\"button\" style=\"float: right;\" onclick=\"$(this).parent().parent().parent().remove();\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i></button></div>';

            HtmlCompVideo +=                     '<input type=\"hidden\" name=\"Components[{{{CODE}}}][Type]\" value=\"3\">';
            HtmlCompVideo +=                '</div>';
            HtmlCompVideo +=            '</div>';
            HtmlCompVideo +=            '<div class=\"row\">';
            HtmlCompVideo +=                '<div class=\"col-md-12\">';
            HtmlCompVideo +=                    '<div class=\"previewvideo-{{{CODE}}}\" style=\"display: flex; justify-content: center;align-items: center;\">';
            HtmlCompVideo +=                        '<img style=\"max-width: 100%;height: auto;\" class=\"img-responsive\" src=\" ".Url::to(['/'])."images/upload-icon/videoytbad.jpg\" alt=\"imagen de componente\">';
            HtmlCompVideo +=                    '</div>';
            HtmlCompVideo +=                '</div>';
            HtmlCompVideo +=            '</div>';
            HtmlCompVideo +=            '<div class=\"row mt-2\">';
            HtmlCompVideo +=                '<div class=\"col-md-12\">';
            HtmlCompVideo +=                    '<label data-section=\"form-post\" data-value=\"videolink\">$videoLink[$lang]</label>';
            HtmlCompVideo +=                    '<input type=\"text\"  name=\"Components[{{{CODE}}}][UrlVideo]\" data-inf=\"{{{CODE}}}\" class=\"form-control urlvideocamp\">';
            HtmlCompVideo +=                '</div>';
            HtmlCompVideo +=            '</div>';
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

        ");
?>
