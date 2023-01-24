<?php 
	$classhide = '';
	if ($hide)
	{
		Yii::app()->clientScript->registerScript('zenflashScript','
			$(".alert-box.class-hide").delay('.$hide_time.').fadeOut(1000, function() { $(".alert-box.class-hide").remove(); });
		');
		$classhide = 'class-hide';
	}

	foreach($flashes as $key => $message) 
	{
		echo '<div class="alert-box alert alert-'.$key.' alert-dismissable '.$classhide.'">';
			echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			echo  $message;
		echo '</div>';
	}
?>

