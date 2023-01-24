<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	<?php $baseUrl = Yii::app()->request->baseUrl; ?>
	<?php $clientScript = Yii::app()->clientScript; ?>
	<?php $clientScript->registerCssFile($baseUrl.'/css/dashboard.css'); ?>
	
	<?php //start of header section ?>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"><?php echo CHtml::encode($this->pageTitle); ?></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Dashboard</a></li>
						<li><a href="#">Settings</a></li>
						<li><a href="#">Profile</a></li>
						<li><a href="#">Help</a></li>
					</ul>
				</div>
			</div>
		</div>
	<?php //end of header section ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2 sidebar">
				<?php $this->widget('SideNav', array('active' => $this->activeSideNav, 'openParent' => $this->openParentNav)); ?>
			</div>
			<div class="col-sm-10 col-sm-offset-2 main">
				<?php echo $content; ?>
			</div>
		</div>
	</div>

<?php $this->endContent(); ?>
