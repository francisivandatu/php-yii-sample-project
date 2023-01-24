<?php	

if ( $data->leaseCalculatorUser )
{
	$otherInfo = $data->leaseCalculatorUser->first_name.' '.$data->leaseCalculatorUser->last_name;
	$otherInfo .= '<Br /><span class="user-fullname-'.$data->id.'">'.$data->leaseCalculatorUser->email_address.'</span>';
	$userComments = $data->leaseCalculatorUser->comments;
}
else
{
	$otherInfo = 'n/a';
	$userComments = '';
}

if ($index == 0){ ?>
	<thead> 
		<tr>
			<th>Total Invoice</th>
			<th>Terms</th>
			<th>Computed Monthly Cost</th>
			<th>Date Submitted</th>
			<th>Others Information</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php } ?>
	<tr>
		<td>$<?php echo number_format($data->initial_invoice_amount,2); ?></td>
		<td><?php echo $data->term; ?>mo - <?php echo $data->getPaymentTermLabel($data->term); ?></td>
		<td>$<?php echo number_format($data->result_monthly_cost, 2); ?></td>
		<td><?php echo ZCommon::formatDate($data->date_created, "M d, Y g:i a"); ?></td>
		<td><?php echo $otherInfo; ?></td>
		<td>
			<?php
			echo CHtml::link('<i class="glyphicon glyphicon-remove"></i>', array('/admin/leaseCalculator/deleteRecord', 'id' => $data->id, '_token' => strtotime($data->date_created)), array('title' => 'Delete', 'class' => 'btn-delete')).' '; 
			if ( trim($userComments) )
			{
				echo CHtml::link('<i class="glyphicon glyphicon-comment"></i>', '#', array('title' => 'Read Comments', 'class' => 'read-comments-btn', 'data-id' => $data->id)).' '; 	
			}
			?>
			
			<div class="hide user-comments-<?php echo $data->id; ?>">
				<?php echo nl2br($userComments); ?>
			</div>
		</td>
	</tr>
<?php	if ($index == 0){ ?>
	</tbody>
<?php } ?>