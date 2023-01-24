<?php
	/*@var $this SiteController*/
	$baseUrl = Yii::app()->request->baseUrl;
?>
<div class="container" style="padding-bottom:30px;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 blue-container text-center">
			<h1>Forgot Password</h1>
			<p>Enter your email address and submit. You will receive an email with link to complete the reset password process.</p>
			<br />
			<?php $form = $this->beginWidget('CActiveForm', array(
				  'id'=>'registration-form',
				  // 'action' => array('/api/resetPassword', 'httpRequest' => 'webPage')
			  )); 
			  
			  $this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes()));
			  ?>
				
			  <div class="form-group">
				 <label> Email Address</label>
				 <?php echo CHtml::textField('PHP_AUTH_EMAIL',"", array('class' => 'form-control')); ?>
			  </div>

			  <div class="form-group">
				<?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary pull-right')); ?>
			  </div>
			<br style="clear:both;" />
			  <?php $this->endWidget(); ?>
		</div>
	</div>
</div>