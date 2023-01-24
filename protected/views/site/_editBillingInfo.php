	
	<?php	if ( isset($showNameField) )	{	?>
		<div class="form-group">	
			<?php echo $form->labelEx($userBillingInfo,'first_name', array('class'=>' control-label')); ?>
			<div >
				<?php echo $form->textField($userBillingInfo,'first_name',array('class'=>'form-control')); ?>
				<?php echo $form->error($userBillingInfo,'first_name'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<?php echo $form->labelEx($userBillingInfo,'last_name', array('class'=>' control-label')); ?>
			<div >
				<?php echo $form->textField($userBillingInfo,'last_name',array('class'=>'form-control')); ?>
				<?php echo $form->error($userBillingInfo,'last_name'); ?>
			</div>
		</div>
	<?php 	
	}	?>
	
	<div class="form-group">	
		<?php echo $form->labelEx($userBillingInfo,'billing_address1', array('class'=>' control-label')); ?>
		<div >
			<?php echo $form->textField($userBillingInfo,'billing_address1',array('class'=>'form-control')); ?>
			<?php echo $form->error($userBillingInfo,'billing_address1'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($userBillingInfo,'billing_address2', array('class'=>' control-label')); ?>
		<div >
			<?php echo $form->textField($userBillingInfo,'billing_address2',array('class'=>'form-control')); ?>
			<?php echo $form->error($userBillingInfo,'billing_address2'); ?>
		</div>
	</div>
		
	<div class="form-group">
		<?php echo $form->labelEx($userBillingInfo,'city', array('class'=>' control-label')); ?>
		<div >
			<?php echo $form->textField($userBillingInfo,'city',array('class'=>'form-control')); ?>
			<?php echo $form->error($userBillingInfo,'city'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($userBillingInfo,'state', array('class'=>' control-label')); ?>
		<div >
			<?php //echo $form->textField($userBillingInfo,'state',array('class'=>'form-control', 'required'=>true)); ?>
			<?php echo $form->dropDownList($userBillingInfo,'state',CHtml::listData(State::model()->findAll(),'abbrev','name'),array('prompt'=>'-Select State-', 'class'=>'form-control')); ?>
			
			<?php echo $form->error($userBillingInfo,'state'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($userBillingInfo,'zip', array('class'=>' control-label')); ?>
		<div >
			<?php echo $form->textField($userBillingInfo,'zip',array('class'=>'form-control')); ?>
			<?php echo $form->error($userBillingInfo,'zip'); ?>
		</div>
	</div>
