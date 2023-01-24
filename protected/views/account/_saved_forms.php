<?php	
	if($data->type == $data::TYPE_PAID AND !empty($data->promo_code)) 
	{
		$statusText = 'Free Promo Code';
	}
	else
	{
		$statusText = $data->getTypeLabel($data->type); 
	}
	
if ($index == 0){ ?>
	<thead> 
		<tr>
			<th>Form #</th>
			<th>Date Submitted</th>
			<th>Date Updated</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php } ?>
	<tr>
		<td><?php echo $data->id; ?></td>
		<td><?php echo ZCommon::formatDate($data->date_submitted, "M d, Y g:i a"); ?></td>
		<td><?php echo ZCommon::formatDate($data->date_updated, "M d, Y g:i a"); ?></td>
		<td><?php echo $statusText; ?></td>
		<td>
			<?php
				
				if ( $data->type == $data::TYPE_SAVED )
				{
					echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>', array('applicationForm/creditApplication', 'id' => $data->id), array('title' => 'View application form')).' ';
					echo CHtml::link('<i class="glyphicon glyphicon-shopping-cart"></i>', array('checkout/index', 'id' => $data->id, 'page' => 'checkout'), array('title' => 'Pay application form'));
				}
				elseif($data->type == $data::TYPE_PAID) 
				{
					echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>', array('applicationForm/view', 'id' => $data->id), array('title' => 'View', 'class' => 'btn'));
                                        echo CHtml::link('<i class="glyphicon glyphicon-save"></i>', array('applicationForm/download', 'id' => $data->id), array('title' => 'View', 'class' => 'btn'));
				}
				else
				{
					echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>', array('applicationForm/creditApplication', 'id' => $data->id), array('title' => 'View application form'));
				}
			?>
		</td>
	</tr>
<?php	if ($index == 0){ ?>
	</tbody>
<?php } ?>
