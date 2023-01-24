<?php 
$baseUrl = Yii::app()->request->baseUrl; 
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/bootbox.min.js');
Yii::app()->clientScript->registerScript('manageScript',"
	$('body').on('click', '.btn-delete', function(e){
		e.preventDefault();
		var thisButton = $(this);
		
		bootbox.confirm('Are you sure you want to delete this content?', function(result){
			if ( result )
			{
				window.location = thisButton.attr('href');
			}
		}); 
	});
");

$this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes(), 'hide'=>true)); ?>
<h1 class="page-header">User Account List</h1>
<?php 
	
	$this->widget('zii.widgets.CListView', array(
		'dataProvider' => $dataProvider,
		'itemsTagName' => 'table',
		'itemsCssClass' => 'table table-hover',
		'template' => ' {items} <br/> {pager}'   ,
		'itemView' => '_manage',
		'pager' => array(
			// 'class' => 'BootstrapLinkPager', 
			'cssFile' => false, 
			'header' => false, 
			'firstPageLabel' => '&lt;&lt;',
			'prevPageLabel' => '&lt;',
			'nextPageLabel' => '&gt;',
			'lastPageLabel' => '&gt;&gt;',
		),
	));
	
?>