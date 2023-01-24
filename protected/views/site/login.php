<?php
	/* @var $this SiteController */
	/* @var $model LoginForm */
	/* @var $form CActiveForm  */
	$this->pageTitle=Yii::app()->name . ' - Login';
	$this->breadcrumbs=array('Login');
?>

<?php 
	if ( isset($_SESSION['applicationFormId']) AND isset($_GET['sendTo']) )
	{
		$this->renderPartial('//common/applicationCrumbs',array(
			'items' => array(
				'application' => 'active',
				'register' => 'active',
			)
		));
	}
	else
	{
		$this->widget('Breadcrumbs', array('crumbs' => array('Login' => null))); 
	}
?>

<div class="container" style="padding-top: 25px; ">
	
	<div class="row form">
		<div class="col-sm-6 col-md-5 col-sm-offset-3 col-md-offset-3">
			<?php 
				if( $model->hasErrors() )
					$this->widget('Flash', array('flashes' => array('warning' => CHtml::errorSummary($model))));
				$this->widget('Flash', array('flashes' => Yii::app()->user->getFlashes()));
			?>
			<?php $this->widget('Login'); 
			if ( $sendTo )
			{
			?>
			<div class="alert alert-info text-center">	
				<h3>Don't have an account?</h3>
				<?php echo CHtml::link('Click Here To Register', array('site/register', 'sendTo' => $sendTo), array('class' => 'btn btn-warning')) ;?>
			</div>
			<?php			
			}
			?>
		</div>
	</div>
</div> 
