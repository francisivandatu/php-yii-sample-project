<?php 
	$baseUrl = Yii::app()->request->baseUrl; 
	date_default_timezone_set('America/New_York');

	$baseUrl = Yii::app()->request->baseUrl; 
	$clientScript = Yii::app()->clientScript;
	$clientScript->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile($baseUrl.'/js/holder.js', CClientScript::POS_HEAD);

	$clientScript->registerScript('mainJs', '
		yii = {                                                                                              
			urls: {
				baseUrl: ' . CJSON::encode(Yii::app()->request->baseUrl) . ',
				absoluteUrl: ' . CJSON::encode(Yii::app()->createAbsoluteUrl('')) . '
			}
		};
		var domainUrl = "'.Yii::app()->request->baseUrl.'";
	', CClientScript::POS_HEAD);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="">
		<meta name="google-site-verification" content="W0Do6DlU3WU30YJfro8UYQQlZ_8ZMqZgOEFUz-6nFCg" />
		<link rel="icon" type="image/ico" href="<?php echo $baseUrl; ?>/images/favicon/favicon.ico" >

		<!-- Bootstrap core CSS -->
		<link href="<?php echo $baseUrl; ?>/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo $baseUrl; ?>/css/styles.css?v=1.1" rel="stylesheet">
		<link href="<?php echo $baseUrl; ?>/css/responsive.css" rel="stylesheet">
		
		<link href="<?php echo $baseUrl; ?>/css/fonts.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
		
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<?php //<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> ?>
		<!-- Custom styles for this template -->
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
			<link href="<?php echo $baseUrl; ?>/css/ie8.css" rel="stylesheet">
		<![endif]-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>
	<body>
		<?php echo $content; ?>
		
	
