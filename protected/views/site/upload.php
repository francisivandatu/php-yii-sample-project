<?php
	$baseUrl = Yii::app()->request->baseUrl; 
	$this->pageTitle=Yii::app()->name . ' - Upload';
	$this->breadcrumbs=array('Upload');
?>
<div class="container">
	<div class="row form">
		<div class="col-sm-6">
			<h1>Upload Widget</h1>
			<code>
				$this->widget('Upload', array( <br />
					<span class="tab"></span>'allowedFileTypes' => 'jpg,jpeg,gif,png', <br />
					<span class="tab"></span> 'maxFileCount'=> 1, <br />
					<span class="tab"></span> 'formInput'=> '#imagefile', <br />
					<span class="tab"></span> 'maxFileSizeAllowed'=> '10mb', <br />
				)); 
			</code>
			
			<hr />
			<?php echo CHtml::textField('imagefile', '', array('id'=>'imagefile', 'class'=>'form-control', 'placeholder'=>'File ID holder (for single file upload)')); ?>
			<br />
			<?php 
				$this->widget('Upload', array(
					'allowedFileTypes' => 'jpg,jpeg,gif,png', 
					'maxFileCount' => 1, 
					'formInput' => '#imagefile',
				)); 
			?>
			
		</div>
		<div class="col-sm-6">	
			<h3>Widget Attributes</h3>
			<ul class="attr">
				<li><i>'allowedFileTypes'</i> = (<i>string</i>)<br />
					<p>Default Value: 'jpg,jpeg,gif,png,doc,docx,pdf,xls,xlsx,txt,mp4,3gp,mov,ogg,ogv,webm,wmv'</p>
					<p>Allowable files for the widget to accept for.</p>
					<small>NOTE: please with no spacing in listing for each file extension just a "," to separate each one of it.</small>
				</li>
				<li><i>'maxFileCount'</i> = (<i>positive int</i>)<br />
					<p>Default Value: 1</p>
					<p>Maximum number in single upload of file. We have 2 different view for upload component, 'upload' and  'uploadMulti', if the value is greater than one, the view to call is 'uploadMulti'. </p>
				</li>
				<li><i>'maxFileSizeAllowed'</i> = (<i>string</i>)<br />
					<p>Default Value: '10mb'</p>
					<p>Maximum file size for EACH file to be uploaded.</p>
				</li>
				<li><i>'formInput'</i> = (<i>string</i>) => '#inputID'<br />
					<p>Default Value: null</p>
					<p>After the file uploaded, the file ID produce will be the value for the input (recommend to be a hidden field)</p>
					<p>if not used, the uploader will create a hidden input with the name of 'file' and value of 'file ID from fileupload table'</p>
					<small>NOTE: only usable for single file upload</small>
				</li>
			</ul>
		</div>
	</div><!-- form -->
</div>
<style>
	ul.attr li { margin-bottom: 15px; }
</style>
