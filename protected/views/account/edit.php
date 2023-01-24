<?php $this->pageTitle=Yii::app()->name . ' - Edit Account Info'; ?>
	
	<?php $this->widget('Breadcrumbs', array('crumbs' => array(
		'My Account' => array('account/index'),
		'Edit Account Info' => null
	))); ?>

	<?php
		Yii::app()->clientScript->registerScript('genderScript', "
			$('.gender').change(function(){
				var self = $(this);

				if(self.is(':checked')) {
					$('#User_gender').val(self.val());
				}
				
			});
		",CClientScript::POS_END);
	?>
	
	<h1>Edit Account Info</h1>
	
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
				<?php
					$male = false;
					$female= false;

					if($user->gender == User::GENDER_MALE)
						$male = true;
					else if($user->gender == User::GENDER_FEMALE)
						$female = true;
					else
						'';
				?>
				<div class="row hide">
					<div class="col-sm-1">
						<label>
							<?php echo CHtml::radioButton('gender', $male, array('class' => 'form-control gender', 'value' => User::GENDER_MALE)); ?>
							Mr.	
						</label>
					</div>
					<div class="col-sm-1">
						<label>
							<?php echo CHtml::radioButton('gender', $female, array('class' => 'form-control gender', 'value' => User::GENDER_FEMALE)); ?>
							Ms.	
						</label>
					</div>
				</div>
				<?php echo $form->hiddenField($user, 'gender'); ?>
				<?php echo $form->error($user,'gender'); ?>
			</div>
			
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
			
			<div class="form-group">	
				<?php echo $form->labelEx($user,'middle_name', array('class'=>'control-label')); ?>
				<?php echo $form->textField($user,'middle_name',array('class'=>'form-control')); ?>
				<?php echo $form->error($user,'middle_name'); ?>
			</div>
			
			<div class="form-group">	
				<?php echo $form->labelEx($user,'contact_number', array('class'=>'control-label')); ?>
				<?php echo $form->textField($user,'contact_number',array('class'=>'form-control')); ?>
				<?php echo $form->error($user,'contact_number'); ?>
			</div>
			
		</div>
	
		<div class="col-sm-6">
			<h3>Billing Info</h3>
			<?php $this->renderPartial('//site/_editBillingInfo', array('userBillingInfo' => $userBillingInfo, 'form' => $form, 'country' => $country)); ?>
		</div>
		
		<div class="col-sm-12 text-right">
			<hr />
			<?php echo CHtml::submitButton($account->isNewRecord ? 'REGISTER' : 'UPDATE', array('name'=>'submit', 'class'=>'btn btn-primary')); ?> 
			<?php echo CHtml::button('CANCEL', array('name'=>'submit', 'class'=>'btn btn-default', 'onclick'=>'js:history.go(-1);returnFalse;' )); ?>
		</div>
		
	<?php $this->endWidget(); ?>
	</div>
