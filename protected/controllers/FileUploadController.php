<?php

class FileUploadController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions' => array('upload'),
				'users' => array('*'),
			),
			array(
				'deny',
				'users' => array('*'),
			),
		);
	}
	
	public function actionUpload()
	{
		$authAccount = Yii::app()->user->account;
		$ret = array();
		set_time_limit(0);
		header('Content-type: application/octet-stream; charset=UTF-8');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$targetDir = "uploads";
		$cleanupTargetDir = false; // Remove old files
		$maxFileAge = 60 * 60; // Temp file age in seconds

		// 5 minutes execution time
		// @set_time_limit(5 * 60);
		// usleep(5000);

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._\s]+/', '', $fileName);

		// Create target dir
		if (!file_exists($targetDir))
				@mkdir($targetDir);

		// Remove old temp files
		if (is_dir($targetDir) && ($dir = opendir($targetDir))) 
		{
			while (($file = readdir($dir)) !== false) 
			{
				$filePath = $targetDir . DIRECTORY_SEPARATOR . $file;
				// Remove temp files if they are older than the max age
				if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
				{
					@unlink($_FILES['file']['tmp_name']);
				}
			}
			closedir($dir);
		} 
		else
		{
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
		}
		
		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		if (strpos($contentType, "multipart") !== false) 
		{
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$myFile = $_FILES['file']['tmp_name'];
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out) 
				{
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) 
					{
						while ($buff = fread($in, 4096))
						{
							fwrite($out, $buff);
						}
					} 
					else
					{
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					}
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				}
				else
				{
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
				}
			} 
			else
			{
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}
		} 
		else 
		{
			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) 
			{
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) 
				{
					while ($buff = fread($in, 4096))
					{
						fwrite($out, $buff);
					}
				}
				else
				{
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				}
				
				fclose($in);
				fclose($out);
			} 
			else
			{
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}
		}

		// After last chunk is received, process the file
		$ret = array('result' => '0');
		if (intval($chunk) + 1 >= intval($chunks)) 
		{
			$fileName = explode('.', $fileName);
			
			$fileUpload = new Fileupload;
			$fileUpload->name = $fileName[0];
			$fileUpload->original_filename = $_FILES['file']['name'];
			$fileUpload->extension = $fileName[1];
			$fileUpload->status = 1;
			$fileUpload->date_created = date("Y-m-d H:i:s");
			$fileUpload->save(false);
			
			Yii::import('application.vendors.wideImage.lib.WideImage');
			$imageExtensions = array("jpg","jpeg","gif","png");
			if (in_array(strtolower($fileUpload->extension),$imageExtensions))
			{
				$dir = 'uploads'.DIRECTORY_SEPARATOR;
				$fileName = $fileUpload;
				$image = WideImage::load($dir . $fileName->getFile());
			
				if ($image->getWidth() > 1000 || $image->getHeight() > 1000) 
					$image->resize(1000, 1000, 'inside')->saveToFile($dir . $fileName->name . '_l.' . $fileName->extension);
				else
					$image->saveToFile($dir . $fileName->name . '_l.' . $fileName->extension);
				
				if ($image->getWidth() > 500 || $image->getHeight() > 500) 
					$image->resize(500, 500, 'inside')->saveToFile($dir . $fileName->name . '_m.' . $fileName->extension);
				else
					$image->saveToFile($dir . $fileName->name . '_m.' . $fileName->extension);
					
				if ($image->getWidth() > 250 || $image->getHeight() > 250) 
					$image->resize(250, 250, 'inside')->saveToFile($dir . $fileName->name . '_s.' . $fileName->extension);
				else
					$image->saveToFile($dir . $fileName->name . '_s.' . $fileName->extension);
				
				if ($image->getWidth() > 170 || $image->getHeight() > 170) 
					$image->resize(170, 170, 'inside')->saveToFile($dir . $fileName->name . '_th.' . $fileName->extension);
				else
					$image->saveToFile($dir . $fileName->name . '_th.' . $fileName->extension);

			}	
			
			$ret = array(
				'result' => '1',
				'status'=> 1,
				'fileId' => $fileUpload->id,
				'filepath' => $fileUpload->getFilePath('thumb'),
				'filepath_s' => $fileUpload->getFilePath('small'),
			);
		}
		// Return response
		die(json_encode($ret));
	}

}
