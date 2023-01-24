<div class="container">
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-3"></div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<h1>Reset Password</h1>

			<?php $form = $this->beginWidget('CActiveForm', array(
			  'id'=>'registration-form',
			)); ?>

			<?php
			
				$errorSummary =  $form->errorSummary($account);

				if(!empty($errorSummary)): 
			?>
					<div class="alert alert-danger">
						<?php echo $form->errorSummary($account); ?>
					</div>
			<?php endif; ?>

			<div class="form-group">
			 <?php echo $form->labelEx($account,'new_password'); ?>
			 <?php echo $form->passwordField($account,'new_password', array('class' => 'form-control')); ?>
			</div>

			<div class="form-group">
			 <?php echo $form->labelEx($account,'confirm_password'); ?>
			 <?php echo $form->passwordField($account,'confirm_password', array('class' => 'form-control')); ?>
			</div>

			<div class="form-group">
			<?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary pull-right')); ?>
			</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-3"></div>
	<br />
</div>