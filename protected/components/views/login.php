<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<?php $form=$this->beginWidget('CActiveForm', array('id'=>'login-form','enableClientValidation'=>true,	'clientOptions'=>array('validateOnSubmit'=>true,),
	'htmlOptions'=>array('class'=>'form-signin','role'=>'form',), )); ?>
	<div class="panel panel-default">
		<div class="panel-heading"><h2 style="margin: 0; ">Please sign in</h2></div>
		<div class="panel-body">
			<p class="small">Please fill out the following form with your login credentials:</p>
			<?php //echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'Email Address','required'=>'true','autofocus'=>'true')); ?>
			<?php echo $form->error($model,'username'); ?>
			
			<?php //echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password', array('class'=>'form-control','placeholder'=>'Password','required'=>'true')); ?>
			<?php echo $form->error($model,'password'); ?>
			<br />
			 <label class="checkbox small">
				<?php echo $form->checkBox($model,'rememberMe'); ?> Remember me
				<?php echo $form->error($model,'rememberMe'); ?>
			</label>
			<?php echo CHtml::submitButton('Login', array('class'=>'btn btn-primary btn-block pull-right')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
