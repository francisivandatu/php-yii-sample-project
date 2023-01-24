<?php	

$invoiceNumber = 'n/a';
if ( $data->payment_transaction_id )
{
	$paymentTransaction = PaymentTransaction::model()->find(array(
		'condition' => 'id = '.$data->payment_transaction_id
	));
	
	if ( $paymentTransaction )
	{
		$invoiceNumber = $paymentTransaction->invoice_number;
	}
}


if ($index == 0){ ?>
	<thead> 
		<tr>
			<th>Business Legal Name</th>
			<th>Date Submitted</th>
			<th>Date Updated</th>
			<th>Invoice Number</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php } ?>
	<tr>
		<td><?php echo $data->legal_name; ?></td>
		<td><?php echo ZCommon::formatDate($data->date_submitted, "M d, Y g:i a"); ?></td>
		<td><?php echo ZCommon::formatDate($data->date_updated, "M d, Y g:i a"); ?></td>
		<td><?php echo $invoiceNumber; ?></td>
		<td><?php echo $data->getTypeLabel($data->type); ?></td>
		<td>
			<?php
				echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>', array('/applicationForm/adminView', 'id' => $data->id, 'adminView' => 1), array('title' => 'View application form', 'target' => '_blank')).' ';
				
				 echo CHtml::link('<i class="glyphicon glyphicon-save"></i>', array('applicationForm/download', 'id' => $data->id), array('title' => 'View', 'class' => 'btn'));
			?>
		</td>
	</tr>
<?php	if ($index == 0){ ?>
	</tbody>
<?php } ?>
