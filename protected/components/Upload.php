<?php

class Upload extends CWidget
{
	private $_id;
	public $allowedFileTypes = 'jpg,jpeg,gif,png,doc,docx,pdf,xls,xlsx,txt,mp4,3gp,mov,ogg,ogv,webm,wmv';
	public $maxFileCount = 1;
	public $controllerUrl;
	public $maxFileSizeAllowed = '10mb';
	public $model = null;
	public $formInput = null;
	
	public function init()
	{
		$this->_id = uniqid();
		$this->controllerUrl = Yii::app()->createAbsoluteUrl('fileUpload/upload');
	}
	
	public function run()
	{
		if ($this->maxFileCount > 1)
			$renderPage = "uploadMulti";
		else 
			$renderPage = "upload";

		$this->render($renderPage, array(
			'_id' => $this->_id,
			'allowedFileTypes' => $this->allowedFileTypes,
			'maxFileCount' => $this->maxFileCount,
			'controllerUrl' => $this->controllerUrl,
			'maxFileSizeAllowed' => $this->maxFileSizeAllowed,
			'formInput' => $this->formInput,
		));
	}
}
