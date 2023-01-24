<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<ol class="breadcrumb">
	<li><?php echo CHtml::link('Home', array('/')); ?></li>
	<?php 
		foreach($crumbs as $label => $url)
		{
			echo '<li>';
				if ($url)
					echo CHtml::link($label, $url);
				else
					echo $label;
			echo '</li>';
		}
	?>
</ol>
