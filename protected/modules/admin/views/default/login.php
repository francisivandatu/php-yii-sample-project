<?php
	/* @var $this SiteController */
	/* @var $model LoginForm */
	/* @var $form CActiveForm  */
	$this->pageTitle=Yii::app()->name . ' - Login';
	$this->breadcrumbs=array('Login');
?>

<div class="container" style="padding-top: 25px; ">
	<div class="row form">
		<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
			<?php 
				if( $model->hasErrors() )
					$this->widget('Flash', array('flashes' => array('warning' => CHtml::errorSummary($model))));
				$this->widget('Flash', array('flashes' => Yii::app()->user->getFlashes()));
			?>
			<?php $this->widget('AdminLogin'); ?>
		</div>
	</div>
</div> 
