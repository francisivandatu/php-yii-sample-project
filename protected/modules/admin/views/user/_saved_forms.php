<?php	if ($index == 0){ ?>
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
		<td><?php echo $data->getTypeLabel($data->type); ?></td>
		<td>
			<?php
				echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>', array('/applicationForm/adminView', 'id' => $data->id, 'adminView' => 1), array('title' => 'View application form', 'target' => '_blank')).' ';
			?>
		</td>
	</tr>
<?php	if ($index == 0){ ?>
	</tbody>
<?php } ?>
