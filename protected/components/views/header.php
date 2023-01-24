	<?php 
	/* 
	 *
	 * WHEN UPDATING THIS FILE, MAKE SURE TO UPDATE "includes/header.php" and as well
	 *
	 */
	$baseUrl = Yii::app()->request->baseUrl; ?>
	<div class="container header">
		<div class="row">
			<div class="col-sm-6">
				<a href="<?php echo $baseUrl; ?>/index.php"><img src="<?php echo $baseUrl; ?>/images/logo.png"></a>
			</div>
			<div class="col-sm-6 login">
				<form class="navbar-form navbar-left" method="POST" role="form" action="<?php echo $baseUrl; ?>/index.php/site/login">
					<div class="row">
						<div class="col-md-5 col-sm-12">
							<div class="form-group">
								<input type="text" placeholder="Enter Email" name="LoginForm[username]" class="form-control" style="width:100%;">
								<?php echo CHtml::link('Create New Account', array('/site/register')); ?>
							</div>
						</div>
						<div class="col-md-5 col-sm-12">
							<div class="form-group">
								<input type="password" placeholder="Enter Password" name="LoginForm[password]" class="form-control" style="width:100%;">
								<?php echo CHtml::link('Forgot Password?', array('/site/forgotPassword')); ?>
							</div>
						</div>
						<div class="col-md-2 col-sm-12">
							<button type="submit" class="btn-login">Login</button>
						</div>
					</div>
				</form>
				
				<?php 
				$excludedPages = array(
					'site/index',
					'applicationForm/creditApplication',
					'applicationForm/creditApplicationDev',
				);
				if ( in_array(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id,$excludedPages) ) { ?>
				<!--HomePage-->
				<?php }else{ ?>
				<div class="row">
					<div class="col-md-8col-sm-8 col-xs-12">
					<a class="btn btn-primary btn-lg orange-btn hidden-xs col-md-10 col-sm-10" style="margin-top:8px; margin-bottom:8px;" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication?startNew=1">Apply Now</a>
					<br class="hidden-lg hidden-md hidden-sm" />
					<a class="btn btn-primary btn-lg pull-right orange-btn hidden-lg hidden-md hidden-sm" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication?startNew=1" style="width:100%;">Apply Now</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		
	</div>
	<div class="container" style="padding:0;">
		<?php $this->widget('HeaderNavigation'); ?>
	</div>