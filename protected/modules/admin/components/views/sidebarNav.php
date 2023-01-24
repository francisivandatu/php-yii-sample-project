<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<ul class="nav nav-sidebar">
	<?php
		foreach ( $this->navLinks as $navLink )
		{
			echo '<li class="'.$navLink['state'].'">';
				
				echo $navLink['link'];
				
				if ( isset($navLink['subLinks']) )
				{
					echo '<ul class="">';
					foreach( $navLink['subLinks'] as $subLink )
					{
						echo '<li>'.$subLink['link'].'</li>';
					}
					echo '</ul>';
				}
				
			echo '</li>';
		}
	?>
</ul>
