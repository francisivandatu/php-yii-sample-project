<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="container main-page-content">
	<div class="row">
		<div class="col-md-12">
			<h1>Error <?php echo $code; ?></h1>
			<?php echo CHtml::encode($message); ?>
			<br />
			<br />
		</div>
	</div>
</div>
