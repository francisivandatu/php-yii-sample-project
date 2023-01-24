<?php	if ($index == 0){ ?>
	<thead> 
		<tr>
			<th>ID</th>
			<th>Client Name</th>
			<th>Email Address</th>
			<th>Date Created</th>
			<th>Date Updated</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php } ?>
	<tr>
		<td><?php echo $data->id; ?></td>
		<td class="data-client-name"><?php echo $data->client_name; ?></td>
		<td class="data-email-address"><?php echo $data->email_address ?></td>
		<td><?php echo ZCommon::formatDate($data->date_created); ?></td>
		<td><?php echo ZCommon::formatDate($data->date_updated); ?></td>
		<td>
			<div class="table-actions">
				<?php echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span>', '#', array('title' => 'Edit Client', 'data-id' => $data->id, 'data-status' => $data->status, 'class' => 'btn-edit-client', 'data-toggle' => 'modal','data-target' => '.modal-client-form'));  
				?>
				<div class="hide data-description"><?php echo $data->description; ?></div>
			</div>
		</td>
	</tr>
<?php	if ($index == 0){ ?>
	</tbody>
<?php } ?>
