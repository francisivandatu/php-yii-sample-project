<?php 
$baseUrl = Yii::app()->request->baseUrl; 
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/bootbox.min.js');
Yii::app()->clientScript->registerScript('manageScript',"
	$('body').on('click', '.btn-delete', function(e){
		e.preventDefault();
		var thisButton = $(this);
		
		bootbox.confirm('Are you sure you want to delete this record?', function(result){
			if ( result )
			{
				window.location = thisButton.attr('href');
			}
		}); 
	});
	
	$('body').on('click', '.read-comments-btn', function(){
		$('.modal-user-fullname').html( $('.user-fullname-'+$(this).data('id')).html() );
		$('.modal-user-comments').html( $('.user-comments-'+$(this).data('id')).html() );
		$('.comment-modal').modal({'backdrop':'static', 'show':true});
	});
");

$_filterText = array(
	'allRecords' => 'All Records',
	'withInfo' => 'With Complete Info',
	'withoutInfo' => 'W/O User Info',
); 

$urlParams = array('recordFilter' => $recordFilter);

$this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes(), 'hide'=>true)); ?>
<h1 class="page-header">Lease Calculator - <?php echo $_filterText[$recordFilter]; ?></h1>

<div class="row">
	<?php	echo CHtml::beginForm(array('/admin/leaseCalculator/index') + $urlParams,'get'); 	//START SEARCH FORM ?>
		  <div class="col-lg-6">
			<div class="input-group">
			  <span class="input-group-btn">
				<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
			  </span>
			  <?php echo CHtml::textField('searchQuery',$searchQuery,array('class'=>'form-control','placeholder'=>'Search')); ?>
			</div><!-- /input-group -->
		  </div><!-- /.col-lg-6 -->
	<?php	echo CHtml::endForm(); 		//END SEARCH FORM ?>
	
	<div class="col-lg-6 text-right">
		Filter By:
		<div class="dropdown" style="display:inline-block;">
			<button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
				<?php echo $_filterText[$recordFilter]; ?>
				<span class="caret"></span>
			</button>
			
			<ul class="dropdown-menu pull-right text-right" role="menu" aria-labelledby="dropdownMenu1">
				<?php
					foreach ( $_filterText as $keyValue => $_text )
					{
						echo '<li role="presentation">'.CHtml::link($_text, array('/admin/leaseCalculator/index', 'recordFilter' => $keyValue) + $urlParams).'</li>';
					}
				?>
			</ul>
		</div>
	</div>
</div>

<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider' => $dataProvider,
		'itemsTagName' => 'table',
		'itemsCssClass' => 'table table-hover',
		'summaryText' => "{start} - {end} of {count}",
		'template' => '{summary} {items} {summary} {pager}'   ,
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

<div class="modal fade comment-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Comments</h4>
      </div>
      <div class="modal-body">
        <p>From: <span class="modal-user-fullname"></span></p>
		<p class="modal-user-comments"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->