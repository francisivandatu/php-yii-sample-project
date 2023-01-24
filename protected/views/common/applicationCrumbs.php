<?php
	Yii::app()->clientScript->registerCss('style',"
		.breadcrumb-steps .active {padding-right:2px;}
		.breadcrumb-steps .active.last a h4{padding-top:6px;}
	");
	
	$itemStatus = array(
		'application' => 'disabled',
		'register' => 'disabled',
		'summary' => 'disabled',
		'checkout' => 'disabled',
		'transactionSuccess' => 'disabled'
	);
	
	$itemStatus = array_merge($itemStatus, $items);
?>
<div class="row form-group">
	<div class="col-xs-12">
		<ul class="nav nav-pills nav-justified thumbnail setup-panel breadcrumb-steps" style="font-size:14px;">
			<li class="<?php echo $itemStatus['application']; ?>" id="step-nav1"><a class="back1">
				<h4 class="list-group-item-heading">Application <i class="glyphicon glyphicon-chevron-right"></i></h4>
			</a></li>
			<li class="<?php echo $itemStatus['register']; ?>" id="step-nav2" ><a class="back2">
				<h4 class="list-group-item-heading">Registration <i class="glyphicon glyphicon-chevron-right"></i></h4>
			</a></li>
			<?php /* <li class="<?php echo $itemStatus['summary']; ?>" id="step-nav3"><a class="back3">
				<h4 class="list-group-item-heading">Summary <i class="glyphicon glyphicon-chevron-right"></i></h4>
			</a></li> */?>
			<li class="<?php echo $itemStatus['checkout']; ?>" id="step-nav4"><a class="back4">
				<h4 class="list-group-item-heading">Checkout <i class="glyphicon glyphicon-chevron-right"></i></h4>
			</a></li>
			<li class="<?php echo $itemStatus['transactionSuccess']; ?> last" id="step-nav5"><a class="back5">
				<h4 class="list-group-item-heading">Transaction Success</h4>
			</a></li>
		</ul>
	</div>
</div>