<?php
/* 
 *
 * WHEN UPDATING THIS FILE, MAKE SURE TO UPDATE "protected/components/view/header.php" and "protected/components/view/header_authenticated.php" as well
 *
 */
 // define('BASE_PATH', 'E:\websites\projects\bms-projects\essex-funding-dev');
 define('BASE_PATH', '/var/www/vhosts/essexfunding.com/httpdocs');		//live
require_once(BASE_PATH.'/framework/yii.php');
$config = require(BASE_PATH.'/protected/config/main.php');
Yii::createWebApplication($config);
$baseUrl = Yii::app()->baseUrl;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name = "format-detection" content = "telephone=no">
		<title>Essex Funding INC</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link href="css/fonts.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:600' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
		<link rel="icon" type="image/ico" href="/images/favicon/favicon.ico" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body>
		
		<div class="container header">
			<?php if ( Yii::app()->user->isGuest ) { ?>
			<div class="row">
				<div class="col-sm-6">
					<a href="index.php"><img src="images/logo.png"></a>
				</div>
				<div class="col-sm-6 login">
					<form class="navbar-form navbar-left hidden-xs" role="form" method="POST" action="index.php/site/login">
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class="form-group">
									<input type="text" placeholder="Enter Email" class="form-control" name="LoginForm[username]" style="width:100%;">
									<a href="<?php $baseUrl; ?>/site/register">Create New Account</a>
								</div>
							</div>
							<div class="col-md-5 col-sm-12">
								<div class="form-group">
									<input type="password" placeholder="Enter Password" class="form-control" name="LoginForm[password]" style="width:100%;">
									<a href="<?php $baseUrl; ?>/site/forgotPassword">Forgot Password?</a>
								</div>
							</div>
							<div class="col-md-2 col-sm-12">
								<button type="submit" class="btn-login">Login</button>
							</div>
						</div>
					</form>
					
					<div class="row">
						<div class="col-md-8col-sm-8 col-xs-12">
						<a class="btn btn-primary btn-lg orange-btn blue-border hidden-xs col-md-10 col-sm-10" style="margin-top:8px; margin-bottom:8px;" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication?startNew=1">Apply Now</a>
						<br class="hidden-lg hidden-md hidden-sm" />
						<a class="btn btn-primary btn-lg pull-right blue-border orange-btn hidden-lg hidden-md hidden-sm" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication?startNew=1" style="width:100%;">Apply Now</a>
						</div>
					</div>
					
				</div>
				
				
			</div>
			<?php }else{ ?>
			<div class="row">
				<div class="col-sm-6">
					<a href="<?php echo $baseUrl; ?>/index.php"><img src="<?php echo $baseUrl; ?>/images/logo.png"></a>
				</div>
				<div class="col-sm-6 login text-right" style="font-size:14px;">
					<a href="index.php/account/index">My Account</a> | <a href="index.php/site/logout">logout</a>
					<div>
						<a class="btn btn-primary btn-lg orange-btn hidden-xs col-md-10 col-sm-10 pull-right" style="margin-top:8px; margin-bottom:8px;" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication?startNew=1">Apply Now</a>
						<br class="hidden-lg hidden-md hidden-sm" />
						<a class="btn btn-primary btn-lg pull-right orange-btn hidden-lg hidden-md hidden-sm" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication?startNew=1" style="width:100%;">Apply Now</a>
					</div>
				</div>
			</div>
			<br />
			<?php } ?>
			
			
		</div>
		<div class="container" style="padding:0;">
			<?php include('includes/navigation.php'); ?>
		</div>
			
				