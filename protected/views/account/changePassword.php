<?php $this->pageTitle=Yii::app()->name . ' - Edit Account Info'; ?>
	
	<?php $this->widget('Breadcrumbs', array('crumbs' => array(
		'My Account' => array('account/index'),
		'Change Password' => null
	))); ?>
	
	<h1>Change Password</h1>
	
	<div class="row form">
	<?php $form=$this->beginWidget('CActiveForm', array('id'=>'register-form', 'enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true,), 'htmlOptions'=>array( 'class'=>'form-signin', 'role'=>'form'))); ?>
		<div class="col-sm-12">
			<?php $this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes())); ?>
			<?php echo $form->errorSummary(array($account), null, null, array('class' => 'alert alert-danger')); ?>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
				<?php echo $form->labelEx($account,'old_password', array('class'=>'control-label')); ?>
				<?php echo $form->passwordField($account,'old_password',array('class'=>'form-control')); ?>
				<?php echo $form->error($account,'old_password'); ?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($account,'new_password', array('class'=>'control-label')); ?>
				<?php echo $form->passwordField($account,'new_password',array('class'=>'form-control')); ?>
				<?php echo $form->error($account,'new_password'); ?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($account,'confirm_password', array('class'=>'control-label')); ?>
				<?php echo $form->passwordField($account,'confirm_password',array('class'=>'form-control')); ?>
				<?php echo $form->error($account,'confirm_password'); ?>
			</div>
		</div>
		
		<div class="col-sm-12 text-right">
			<hr />
			<?php echo CHtml::submitButton($account->isNewRecord ? 'REGISTER' : 'UPDATE', array('name'=>'submit', 'class'=>'btn btn-primary')); ?> 
			<?php echo CHtml::button('CANCEL', array('name'=>'submit', 'class'=>'btn btn-default', 'onclick'=>'js:history.go(-1);returnFalse;' )); ?>
		</div>
		
	<?php $this->endWidget(); ?>
	</div>
