<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<?php $clientScript = Yii::app()->clientScript; ?>

			<?php echo $content; ?>


<?php $this->endContent(); ?>
