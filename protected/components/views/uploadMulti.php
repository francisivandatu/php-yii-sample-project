<?php 
$baseUrl = Yii::app()->request->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/upload.css');
Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/plupload/plupload.full.js');

Yii::app()->clientScript->registerScript(uniqid(),'
	var uploader;
	var formInput = "'.$formInput.'";
	
	function myUploader()
	{
		uploader = new plupload.Uploader(
			{
				runtimes 				: 		"html5,flash,html4",
				browse_button 		: 		"pickfiles",
				container 				: 		"fileContainer",
				max_file_size  		:   	"' . $maxFileSizeAllowed. '",
				url 							: 		"' . $controllerUrl . '",
				chunk_size 			: 		"1MB",	
				unique_names 		: 		true,
				multi_selection		:		true,
				flash_swf_url 			: 		"' . $baseUrl . '/js/plupload/plupload.flash.swf",
				filters 						:		[
															{
																title : "All files", 
																extensions : "' . $allowedFileTypes . '"
															},
														],
			}
		);
		
		
		uploader.bind("Init", 
			function(up, params) 
			{
				
			}
		);

		uploader.init();

		uploader.bind("FilesAdded", 
			function(up, files) 
			{
				$.each(files, 
					function(i, file) 
					{
						$("#filelist").append("<div id=\'" + file.id + "\' class=\'fileContainer pull-left\'>" + file.name + " (" + plupload.formatSize(file.size) + ") <b></b>" + "<\/div>");
					}
				);
				uploader.start();
				up.refresh(); // Reposition Flash/Silverlight
			}
		);

		uploader.bind("UploadProgress", 
			function(up, file) 
			{
				$("#" + file.id + " b").html(file.percent + "%");
			}
		);

		uploader.bind("Error", 
			function(up, err) 
			{
				$("#imagePreview").append("<div>Error: " + err.code + ", Message: " + err.message + 	(err.file ? ", File: " + err.file.name : "") + "</div>");
				up.refresh(); // Reposition Flash/Silverlight
			}
		);

		uploader.bind("FileUploaded", 
			function(up, file, result) 
			{
				var res = JSON.parse(result.response);
				
				$("#" + file.id).html("<div class=\'uploadThumb\'><img src=\'"+res.filepath+"\' class=\'img-responsive img-thumbnail\' /></div>");
				$("#" + file.id + " .uploadThumb").append("<a class=\'btn delete-file\'><span class=\'glyphicon glyphicon-remove\'></span></a>");
				$("#" + file.id).append("<input type=\'hidden\' value=\'"+res.fileId+"\' name=\'file[]\' class=\'form-control\' />");
			}
		);

	}	
	myUploader();
');


?>

<div id="fileContainer" class="clearfix">
     <a id="pickfiles" href="#" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add File</a>
	<div id="filelist"></div>
</div>

