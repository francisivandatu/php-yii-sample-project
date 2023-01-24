<?php $this->pageTitle=Yii::app()->name . ' | Register'; ?>	
	
	<?php 
		if ( isset($_SESSION['applicationFormId']) AND isset($_GET['sendTo']) )
		{
			$sendToArray = array('sendTo' => $_GET['sendTo']);
			$this->renderPartial('//common/applicationCrumbs',array(
				'items' => array(
					'application' => 'active',
					'register' => 'active',
				)
			));
		}
		else
		{
			$sendToArray = array();
			$this->widget('Breadcrumbs', array('crumbs' => array('Register' => null))); 
		}
	?>
	
	<h1>Register</h1>
	<div class="row form">
	<?php $form=$this->beginWidget('CActiveForm', array('id'=>'register-form', 'enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true,), 'htmlOptions'=>array( 'class'=>'form-signin', 'role'=>'form'))); ?>
		<div class="col-sm-12">
			<?php $this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes())); ?>
			<?php echo $form->errorSummary(array($account, $user, $userBillingInfo), null, null, array('class' => 'alert alert-danger')); ?>
		</div>
		
		<div class="col-sm-6">
			
			<h3>Account Info</h3>
			<div class="form-group">
				<?php echo $form->labelEx($account,'email_address', array('class'=>'control-label')); ?>
				<?php echo $form->textField($account,'email_address',array('class'=>'form-control')); ?>
				<?php echo $form->error($account,'email_address'); ?>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($account,'password', array('class'=>'control-label')); ?>
				<?php echo $form->passwordField($account,'password',array('class'=>'form-control')); ?>
				<?php echo $form->error($account,'password'); ?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($account,'confirm_password', array('class'=>'control-label')); ?>
				<?php echo $form->passwordField($account,'confirm_password',array('class'=>'form-control')); ?>
				<?php echo $form->error($account,'confirm_password'); ?>
			</div>
			
		</div>
	
		<div class="col-sm-6">
			
			<h3>User Info</h3>
			<div class="form-group">
				<?php echo $form->labelEx($user,'first_name', array('class'=>'control-label')); ?>
				<?php echo $form->textField($user,'first_name',array('class'=>'form-control')); ?>
				<?php echo $form->error($user,'first_name'); ?>
			</div>
			
			<div class="form-group">	
				<?php echo $form->labelEx($user,'last_name', array('class'=>'control-label')); ?>
				<?php echo $form->textField($user,'last_name',array('class'=>'form-control')); ?>
				<?php echo $form->error($user,'last_name'); ?>
			</div>
			
			<?php /*
			<div class="form-group">	
				<?php echo $form->labelEx($user,'middle_name', array('class'=>'control-label')); ?>
				<?php echo $form->textField($user,'middle_name',array('class'=>'form-control')); ?>
				<?php echo $form->error($user,'middle_name'); ?>
			</div>
			
			<div class="form-group">	
				<?php echo $form->labelEx($user,'contact_number', array('class'=>'control-label')); ?>
				<?php echo $form->textField($user,'middle_name',array('class'=>'form-control')); ?>
				<?php echo $form->error($user,'middle_name'); ?>
			</div>
			*/ ?>
			
			<?php /*
			<h3>Billing Info</h3>
			<?php $this->renderPartial('_editBillingInfo', array('userBillingInfo' => $userBillingInfo, 'form' => $form, 'country' => $country)); ?>
			*/ ?>
            <div class="g-recaptcha" data-sitekey="6LdR62QUAAAAAGyFV2zS1SIb-0Lm5Ay9d5M3mLLG"></div>
		</div>
		
		<div class="col-sm-12"><hr /></div>
		
		<div class="col-sm-6">
			Already have an account? <?php echo CHtml::link('Login Here', array('site/login')+$sendToArray); ?>
		</div>
		
		<div class="col-sm-6">
			<?php echo CHtml::submitButton($account->isNewRecord ? 'REGISTER' : 'UPDATE', array('name'=>'submit', 'class'=>'btn btn-primary pull-right')); ?>
		</div>
		
		
	<?php $this->endWidget(); ?>
	</div>
