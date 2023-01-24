<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<?php $clientScript = Yii::app()->clientScript; ?>

	<?php 
		if(isset($this->active))
			$active = $this->active;
		else
			$active = 'home';

		$this->widget('Header', array('active'=>$active)); 
	?>

		<div class="container content-container">
			<?php echo $content; ?>
		</div>

	<?php $this->widget('Footer'); ?>

<?php $this->endContent(); ?>
