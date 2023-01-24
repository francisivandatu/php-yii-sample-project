<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/autoNumeric-min.js');

Yii::app()->clientScript->registerScript('autoNumericScript', "
	$('.field-total-invoice').autoNumeric('init');
");

Yii::app()->clientScript->registerCss('pageStyle',"
	#application-form .errorMessage {font-size:14px;}
");
?>

<h2 class="title">Lease Calculator</h2>

<div class="row">
		<?php 
			$form=$this->beginWidget('CActiveForm',array('id'=>'application-form', 
				'enableAjaxValidation'=>false,
				'htmlOptions'=>array(
						'enctype' => 'multipart/form-data',
				)
			)); 
			
			echo $form->errorSummary($leaseCalculatorModel, null, null, array('class' => 'alert alert-danger'));
			$this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes())); 
		?>
		
		<div class="col-md-6 col-md-offset-3">
			<div class="col-md-10 col-md-offset-1">
				<div class="form panel panel-primary">
					<div class="panel-body">
					
						<div class="col-md-12">
							<div class="form-horizontal">
								<label class="control-label">
									Total invoice amount to be leased: <Br />
									<span style="color:#999999;">Example $100,000</span>
								</label>
								<div>
									<div class="input-group">
										<span class="input-group-addon">$</span>
										<?php echo $form->textfield($leaseCalculatorModel, 'initial_invoice_amount', array('class' => 'form-control field-total-invoice', 'maxlength' => 20)); ?>
										</script>
									</div>
									<?php echo $form->error($leaseCalculatorModel,'initial_invoice_amount'); ?>
								</div>
							</div>
						</div>
						
						<div class="col-md-12"> <!--spacer--> <br /> </div>
						
						<div class="col-md-12">
							<div class="row form-horizontal">
								
								<div class="col-md-5">
									<label class="control-label"> Term (years): </label>
								</div>
								
								<div class="col-md-9 col-sm-offset-3">
									<label><?php echo CHtml::radioButton('LeaseCalculator[term]', false, array('value' => 35, 'class' => 'radio-term-3')); ?> 3 years </label> <Br />
									<label><?php echo CHtml::radioButton('LeaseCalculator[term]', false, array('value' => 47, 'class' => 'radio-term-4')); ?> 4 years </label> <Br />
									<label><?php echo CHtml::radioButton('LeaseCalculator[term]', false, array('value' => 59, 'class' => 'radio-term-5')); ?> 5 years </label>
									
									<script type="text/javascript">
										$('.radio-term-<?php echo $leaseCalculatorModel->term; ?>').attr('checked', true);
									</script>
									
									<?php echo $form->error($leaseCalculatorModel,'term'); ?>
								</div>
							</div>
						</div>
						
						<div class="col-md-12 text-center">
							<br />
							<?php echo CHtml::submitButton( 'Calculate' , array('class' => 'btn btn-primary orange-btn ', 'name' => 'app_submit')); ?>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<?php $this->endWidget(); ?>
</div>

