<?php $this->pageTitle=Yii::app()->name; ?>    
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2 sidebar">
		<?php $this->widget('SideNav', array('active' => array('overview'),)); ?>
		</div>
		<div class="col-sm-10 col-sm-offset-2 main">
		
			<div class="row">
				<div class="col-xs-12">
					<?php echo CHtml::textField('imagefile', '', array('id'=>'imagefile1', 'class'=>'form-control', 'placeholder'=>'File ID holder (for single file upload)')); ?>
					<br />
					<?php $this->widget('Upload', array('allowedFileTypes' => 'jpg,jpeg,gif,png', 'maxFileCount' => 1, 'formInput' => '#imagefile1',)); 	?>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-xs-12">
					<?php echo CHtml::textField('imagefile', '', array('id'=>'imagefile2', 'class'=>'form-control', 'placeholder'=>'File ID holder (for single file upload)')); ?>
					<br />
					<?php $this->widget('Upload', array('allowedFileTypes' => 'jpg,jpeg,gif,png', 'maxFileCount' => 1, 'formInput' => '#imagefile2',)); 	?>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-xs-12">
					<br />
					<?php $this->widget('Upload', array('allowedFileTypes' => 'jpg,jpeg,gif,png', 'maxFileCount' => 2, 'formInput' => 'imagefile1',)); 	?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<br />
					<?php $this->widget('Upload', array('allowedFileTypes' => 'jpg,jpeg,gif,png', 'maxFileCount' => 2, 'formInput' => 'imagefile2',)); 	?>
				</div>
			</div>
			
			
		</div>
	</div>
</div>
