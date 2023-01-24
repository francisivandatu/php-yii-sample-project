<?php 
	$baseUrl = Yii::app()->request->baseUrl;
	Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/sidenav.css');
	echo $this->extractMenu($menu); 
?>
