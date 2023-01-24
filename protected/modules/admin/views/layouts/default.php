<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<?php $clientScript = Yii::app()->clientScript; ?>

	<?php $this->widget('Header'); ?>

		<section class="page-content">
			<?php echo $content; ?>
		</section>

	<?php $this->widget('Footer'); ?>

<?php $this->endContent(); ?>
