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
			<div class="col-sm-6 login text-right" style="font-size:14px;">
				<?php /* Hi <?php echo Yii::app()->user->account->getFullName(); ?> | */ ?>
				<?php echo CHtml::link('My Account', array('/account/index')); ?> | <?php echo CHtml::link('logout', array('site/logout')); ?>
				
				<?php 
				$excludedPages = array(
					'site/index',
					'checkout/success',
					'checkout/index',
					'checkout/dev',
					'applicationForm/creditApplication',
					'applicationForm/creditApplicationDev',
				);
				
				if ( in_array(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id,$excludedPages) ) { ?>
				<!--HomePage-->
				<?php }else{ ?>
				<div>
					<a style="margin-top:8px; margin-bottom:8px;" class="btn btn-primary btn-lg orange-btn hidden-xs col-md-10 col-sm-10 pull-right" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication?startNew=1">Apply Now</a>
				</div>
				<?php } ?>
			</div>
		</div>
		<Br />
	</div>
	<div class="container" style="padding:0;">
		<?php $this->widget('HeaderNavigation'); ?>
	</div>