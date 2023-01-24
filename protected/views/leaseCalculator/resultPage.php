<?php
Yii::app()->clientScript->registerCss('pageStyle',"
	#application-form .errorMessage {font-size:14px;}
");
?>

<div class="row">
		<?php 
			$form=$this->beginWidget('CActiveForm',array('id'=>'application-form', 
				'enableAjaxValidation'=>true,
				'htmlOptions'=>array(
						'enctype' => 'multipart/form-data',
				)
			)); 
			
			echo $form->errorSummary(array($leaseCalculatorModel, $leaseCalculatorUserModel), null, null, array('class' => 'alert alert-danger'));
			$this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes())); 
		?>
		
		<div class="col-md-5">
			<h2 class="title">Monthly Lease Estimate</h2>
			
			<div class="form-horizontal">
				<div>Total amount invoice to be leased:</div>
				<div> <Br /> <strong style="color:#f67d24; font-size:20px;">$<?php echo number_format($leaseCalculatorModel->initial_invoice_amount,2); ?></strong> </div>
			</div>
			 <Br />
			<div class="form-horizontal">
				<div> Term (years): </div>
				<div> <Br /> <strong style="color:#f67d24; font-size:20px;"><?php echo $leaseCalculatorModel->getPaymentTermLabel($leaseCalculatorModel->term); ?></strong> </div>
			</div>
			
			<br />
			
			<div class="row">
				<div class="col-md-12">
					<p>Depending on credit underwriting of your company's D+B rating and the owner's personal credit score, the monthly lease payment range you could expect is:</p>
					<br />
				</div>
				
				<div class="col-md-12 text-center" style="font-size:20px;">
					<?php $_result = $leaseCalculatorModel->getMonthlyInvoiceRange(); ?>
					
					<span style="font-size:20px;" class="label label-success text-center">
						<?php echo '$'.number_format($_result['rangeFrom']);?>
					</span>
					
					&nbsp;to&nbsp;
					
					<span style="font-size:20px;" class="label label-success text-center">
						<?php echo '$'.number_format($_result['rangeTo']); ?>
					</span>
				</div>
			</div>
			<br />
		</div>
		
		<div class="col-md-7">		
			<div class="row">
				<div class="col-md-12">
					<h2 class="title">Contact Us About This Lease Request</h2>
					
					If you are interested in learning more about lease financing, please <?php echo CHtml::link('apply here', array('/applicationForm/creditApplication', 'startNew' => 1)); ?> or complete the following form: 
					
					<Br /><Br />
					
					<div><?php echo $form->labelex($leaseCalculatorUserModel, 'first_name'); ?>:	</div>
					<div><?php echo $form->textField($leaseCalculatorUserModel, 'first_name', array('class' => 'form-control')); ?></div>
					
					<div><?php echo $form->labelex($leaseCalculatorUserModel, 'last_name'); ?>:</div>
					<div><?php echo $form->textField($leaseCalculatorUserModel, 'last_name', array('class' => 'form-control')); ?></div>
					
					<div><?php echo $form->labelex($leaseCalculatorUserModel, 'company'); ?>:</div>
					<div><?php echo $form->textField($leaseCalculatorUserModel, 'company', array('class' => 'form-control')); ?></div>
					
					<div><?php echo $form->labelex($leaseCalculatorUserModel, 'email_address'); ?>:</div>
					<div><?php echo $form->textField($leaseCalculatorUserModel, 'email_address', array('class' => 'form-control')); ?></div>
					
					<div><?php echo $form->labelex($leaseCalculatorUserModel, 'phone'); ?>:</div>
					<div><?php echo $form->textField($leaseCalculatorUserModel, 'phone', array('class' => 'form-control')); ?></div>
					
					<div><?php echo $form->labelex($leaseCalculatorUserModel, 'comments'); ?>:</div>
					<div><?php echo $form->textarea($leaseCalculatorUserModel, 'comments', array('class' => 'form-control')); ?></div>
					
					<Br />
					<?php echo CHtml::submitButton( 'Submit' , array('class' => 'btn btn-primary orange-btn pull-right', 'name' => 'app_submit')); ?>
				</div>
			</div>
		</div>
		
		<?php $this->endWidget(); ?>
</div>

<br /><br />