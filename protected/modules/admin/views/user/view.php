<?php $this->pageTitle=Yii::app()->name . ' | Account Page'; 
$user = $account->user;
$userBilling = $account->userBillingInfo;
?>
<div class="main-page-content inside-pages">
	
	<h1>My Account</h1>
	<div class="row">
		<div class="col-sm-6">
			<h3>Account Info</h3>
			<table class="table">
				<tr>
					<td>Email Address</td>
					<td><?php echo $account->email_address; ?></td>
				</tr>
				<tr>
					<td>First Name</td>
					<td><?php echo $user->first_name; ?></td>
				</tr>
				<tr>
					<td>Middle Name</td>
					<td><?php echo $user->middle_name; ?></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td><?php echo $user->last_name; ?></td>
				</tr>
				<tr>
					<td>Contact Number</td>
					<td><?php echo $user->contact_number; ?></td>
				</tr>
			</table>
		</div>	
		
		<div class="col-sm-6">
			<h3>Billing Info</h3>
			<table class="table">
				<tr>
					<td><?php echo $userBilling->getAttributeLabel('billing_address1'); ?></td>
					<td><?php echo $userBilling->billing_address1; ?></td>
				</tr>
				<tr>
					<td><?php echo $userBilling->getAttributeLabel('billing_address2'); ?></td>
					<td><?php echo $userBilling->billing_address2; ?></td>
				</tr>
				<tr>
					<td><?php echo $userBilling->getAttributeLabel('city'); ?></td>
					<td><?php echo $userBilling->city; ?></td>
				</tr>
				<tr>
					<td><?php echo $userBilling->getAttributeLabel('state'); ?></td>
					<td><?php echo $userBilling->state; ?></td>
				</tr>
				<tr>
					<td><?php echo $userBilling->getAttributeLabel('zip'); ?></td>
					<td><?php echo $userBilling->zip; ?></td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<h3>Saved Application Forms</h3>
			<?php
				$this->widget('zii.widgets.CListView', array(
					'dataProvider' => $dataProvider,
					'itemsTagName' => 'table',
					'itemsCssClass' => 'table table-hover',
					'template' => ' {items} <br/> {pager}'   ,
					'itemView' => '_saved_forms',
					'pager' => array(
						// 'class' => 'BootstrapLinkPager', 
						'cssFile' => false, 
						'header' => false, 
						'firstPageLabel' => '&lt;&lt;',
						'prevPageLabel' => '&lt;',
						'nextPageLabel' => '&gt;',
						'lastPageLabel' => '&gt;&gt;',
					),
				));
			?>
		</div>
	</div>
</div>
