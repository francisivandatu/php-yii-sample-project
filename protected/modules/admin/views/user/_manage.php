<?php	if ($index == 0){ ?>
	<thead> 
		<tr>
			<th width="5%">ID</th>
			<th width="">Name</th>
			<th width="">Email Address</th>
			<th>Date Register</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php } ?>
	<tr>
		<td><?php echo $data->id; ?></td>
		<td><?php echo $data->getFullName(); ?></td>
		<td><?php echo $data->email_address; ?></td>
		<td><?php echo ZCommon::formatDate($data->date_created, "M d, Y g:i a"); ?></td>
		<td>
			<?php
				echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>', array('user/view', 'id' => $data->id));
			?>
		</td>
	</tr>
<?php	if ($index == 0){ ?>
	</tbody>
<?php } ?>
