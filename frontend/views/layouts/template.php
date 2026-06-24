<?php
	use frontend\assets\AppAssetTemplate;
	use yii\helpers\Html;
	use yii\helpers\Url;

	AppAssetTemplate::register($this);
	$this->beginPage()
?>	
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="utf-8" />
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>

		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	    <meta name="viewport" content="width=device-width" />
        <?php $this->head() ?>

	    <!--     Fonts and icons     -->
	    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

	</head>
	<body>
	<?php $this->beginBody() ?>


	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>