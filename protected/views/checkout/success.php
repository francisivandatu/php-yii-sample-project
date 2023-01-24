<?php $this->pageTitle = 'Checkout | ' . Yii::app()->name; 
$paymentAPI = new PaymentAPI;

if ( $paymentTransactionModel->total <= 0 )
{
	// $amountText = '<span style="text-decoration:line-through">'.$paymentAPI->currencySymbol.''.number_format(PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE,2).'</span> Free';
	$amountText = '$0.00';
}
else
{
	$amountText = $paymentAPI->currencySymbol.''.number_format($paymentTransactionModel->total,2);
}

if($paymentTransactionModel->payment_method == PaymentTransaction::METHOD_CREDIT_CARD)
	$firstLineMessage = 'Your payment transaction was successful, and your application has been submitted';
else
	$firstLineMessage = 'Your transaction was successful, and your application has been submitted';
	
?>

<div class="main-page-content inside-pages">
	<?php /* $this->widget('Breadcrumbs', array('crumbs' => array(
		'Application Form' => array('account/index'),
		'Transaction Success' => '#',
	))); */ ?>
	
	<?php $this->renderPartial('//common/applicationCrumbs',array(
		'items' => array(
			'application' => 'active',
			'register' => 'active',
			'summary' => 'active',
			'checkout' => 'active',
			'transactionSuccess' => 'active'
		)
	)); ?>
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2 unsubscribe">
				<div class="col-md-12">
					<p class="text unsubscribe_text text-center"><?php echo $firstLineMessage; ?></p>
					<p class="unsubscribe2">Reference information from your payment transaction:</p>
					<br />
					<table class="col-md-6">
						<tr>
							<td>Amount:</td>
							<td><?php echo $amountText; ?></td>
						</tr>
                                                <?php if($paymentTransactionModel->payment_method == PaymentTransaction::METHOD_CREDIT_CARD): ?>
						<tr>
							<td>Transaction ID:</td>
							<td><?php echo $paymentTransactionModel->txn_id; ?></td>
						</tr>
                                                <?php else: ?>
                                                <tr>
							<td>Promo Code:</td>
							<td><?php echo $paymentTransactionModel->promo_code; ?></td>
						</tr>
                                                <?php endif; ?>
						<tr>
							<td>Invoice #:</td>
							<td><?php echo $paymentTransactionModel->invoice_number; ?></td>
						</tr>
						<tr>
							<td>Date:</td>
							<td><?php echo ZCommon::formatDate($paymentTransactionModel->date_created); ?></td>
						</tr>
					</table>
				</div>
				<div class="col-md-12 text-right">
					<br />
					<?php echo CHtml::link('Return To My Account', array('account/index'), array('class' => 'btn btn-primary text-right')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
