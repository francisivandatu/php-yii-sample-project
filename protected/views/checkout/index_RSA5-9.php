<?php 

$flashes = Yii::app()->user->getFlashes();

// Dev::pvx($flashes);

$this->pageTitle = 'Checkout | ' . Yii::app()->name; 

	$paymentAPI = new PaymentAPI;
    $clientScript = Yii::app()->clientScript;
    

    $clientScript->registerScript("promo_code_update_script", '
        function promoCodeUpdate(res){
           
		   // $(".total").css({"text-decoration":"line-through"}).after("<span> Free</span>");
           
		   $(".total").html("&nbsp;$0.00");
		   $(".payment-method-wrapper").empty();
            
			$(".second-item-row").removeClass("hide");
			$(".second-item-row strong").html($("#validated_promo_code").val());
			
            $(".submit-btn").val("Process Application");
			$("#checkout-headline").empty().remove();
			
			$(".payment-btn-container").empty();

			$(".process-application-wrapper").show();
        }
		
		$(document).ready(function(){
			// $(".pay-with-paypal").click(function(e){
				// $(".credit-card-container").slideUp();
			// });
			
			// $(".pay-with-credit-card").click(function(e){
				// $(".credit-card-container").slideDown();
				// e.preventDefault();
			// });
			
			
			// if("'.( $hasSubmission OR !empty($flashes) ).'")
			// {
				// $(".credit-card-container").show();
			// }
		})
		
    ');
            
    if(!empty($promoCode)) {
        $clientScript->registerScript("promo_code_update_script_autoActivate", '
            $(document).ready(function(){
                
				// $(".total").css({"text-decoration":"line-through"}).after("<span> Free</span>");
                $(".total").html("&nbsp;$0.00");
				$(".payment-method-wrapper").empty();
                
				$(".second-item-row").removeClass("hide");
				
                $(".payment-method-wrapper").append(\''.CHtml::hiddenField('validated_promo_code', $promoCode).'\');
                $(".submit-btn").val("Process Application");
            });
            
        ', CClientScript::POS_END);
    }
?>
<style>
.pay-with-credit-card 
{
	font-size: 17px;
    padding-top: 10px;
}

#payment-form_es_
{
	margin-top: 20px;
}

.alert-dismissable
{
	margin-top: 20px;
}
</style>
<div class="main-page-content inside-pages">
	<?php /* $this->widget('Breadcrumbs', array('crumbs' => array(
		'Application Form' => array('account/index'),
		'Checkout' => array('checkout/index'),
	))); */ 
	
		if ( $paymentAPI->apiLive == false)
		{
			echo '<div class="alert alert-danger"><strong>Heads up!</strong> This page is running sandbox mode.</div>';
		}
	?>
	
	<?php $this->renderPartial('//common/applicationCrumbs',array(
		'items' => array(
			'application' => 'active',
			'register' => 'active',
			'summary' => 'active',
			'checkout' => 'active'
		)
	)); ?>
	
	<h2 class="title">Order Summary</h2>
	<table class="table">
		<tr>
			<td>Item</td>
			<td>Description</td>
			<td>&nbsp;Cost</td>
		</tr>
		<tr class="first-item-row">
			<td>1</td>
			<td>Essex Funding Credit Application Processing Fee</td>
			<td>&nbsp;$<?php echo number_format(PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE,2); ?></td>
		</tr>
		<tr class="second-item-row hide">
			<td>2</td>
			<td>Promo Code: <strong><?php echo $promoCode; ?></strong></td>
			<td>-$<?php echo number_format(PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE,2); ?></td>
		</tr>
		<tr>
			<td colspan="2" class="text-right">Total:</td>
			<td>
				<span class="total" style="font-weight:bold;">&nbsp;$<?php echo number_format(PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE,2); ?></span>
			</td>
		</tr>
	</table>
	
	<?php $form=$this->beginWidget('CActiveForm', array('id'=>'payment-form', 'enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true,), 'htmlOptions'=>array( 'class'=>'form-signin', 'role'=>'form'))); ?>
	
	<?php if( empty($promoCode) ) { ?>
	<div class="row <?php echo  ($devMode == false) ? 'hide' : ''; ?> ">
		<div class="col-md-12">
			<div class="alert alert-info" style="border-left:5px solid #428BCA;">
				<div class="row">
				<div class="col-md-6">
					<?php 
						$this->widget('PromoCode', array(
							'promoCode' => $promoCode
						)); 
					?>
				</div>
				</div>
			</div>
		</div>
	</div>
	
	<h2 class="title" id="checkout-headline" style="margin-bottom:0px;">Checkout</h2>
	<?php } else { ?>
	
	<?php } ?>
	<!-- <div class="row">
		<div class="col-sm-12 payment-btn-container" style="margin-top: 20px;">
			<div style="width:385px;margin:0 auto">
				<button class="btn btn-default pay-with-credit-card" >Pay with Credit Card</button> | 
				
			</div>
		</div>
	</div> -->
	<div class="row credit-card-container" >
		<div class="col-sm-12">
			<?php $this->widget('Flash', array('flashes'=> $flashes )); ?>
			<?php echo $form->errorSummary(array($account, $user, $userBillingInfo, $paymentTransaction), null, null, array('class' => 'alert alert-danger')); ?>
		</div>
		
		<div class="col-sm-6">
			<h3 class="small-title">Billing Info</h3>
			<?php $this->renderPartial('//site/_editBillingInfo', array('showNameField' => true,'userBillingInfo' => $userBillingInfo, 'form' => $form, 'country' => Country::model()->findAll(array('condition'=>'status = 1')))); ?>
		</div>
		
		<div class="col-sm-6 payment-method-wrapper">
			<h3 class="small-title">Credit Card Information</h3>
			<div class="form-group">
				<?php echo $form->labelEx($paymentTransaction,'card_number', array('class'=>'control-label')); ?>
				<div>
					<?php echo $form->textField($paymentTransaction,'card_number', array('class'=>'form-control')); ?>
					<?php echo $form->error($paymentTransaction,'card_number'); ?>
				</div>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($paymentTransaction,'card_type', array('class'=>'control-label')); ?>
				<div>
					<?php echo $form->dropDownList($paymentTransaction,'card_type', UserBillingInfo::cardTypes(), array('class'=>'form-control', 'prompt' => 'Select', )); ?>
					<?php echo $form->error($paymentTransaction,'card_type'); ?>
				</div>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($paymentTransaction,'card_verification_number', array('class'=>'control-label')); ?>
				<div>
					<?php echo $form->textField($paymentTransaction,'card_verification_number', array('class'=>'form-control')); ?>
					<?php echo $form->error($paymentTransaction,'card_verification_number'); ?>
				</div>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($paymentTransaction,'card_expiration_month', array('class'=>'control-label')); ?>
				<div>
					<?php echo $form->dropDownList($paymentTransaction,'card_expiration_month', UserBillingInfo::cardExpirationMonths(), array('prompt' => 'Select', 'class'=>'form-control')); ?>
					<?php echo $form->error($paymentTransaction,'card_expiration_month'); ?>
				</div>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($paymentTransaction,'card_expiration_year', array('class'=>'control-label')); ?>
				<div>
					<?php echo $form->dropDownList($paymentTransaction,'card_expiration_year', UserBillingInfo::cardExpirationYears(), array('prompt' => 'Select', 'class'=>'form-control')); ?>
					<?php echo $form->error($paymentTransaction,'card_expiration_year'); ?>
				</div>
			</div>
			
			<?php echo CHtml::hiddenField('applicationFormId', $applicationFormId); ?>
			
			<div class="row">
				<div class="col-sm-12 text-right">
					<?php echo CHtml::submitButton('Process Payment Now', array('class' => 'btn btn-primary submit-btn')); ?>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-12 text-right">
					<a href="<?php echo $paypalApiApprovalLink; ?>" class="pay-with-paypal" ><img style="height: 40px;" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/paynow.png"/></a>
				</div>
			</div>
		</div>
	
		<div class="col-sm-12 text-right process-application-wrapper" style="display:none;">
			<?php echo CHtml::submitButton('Process Payment Now', array('class' => 'btn btn-primary submit-btn')); ?>
		</div>
		
		
	</div>
	
	<?php $this->endWidget(); ?>
</div>
