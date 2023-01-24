<?php
/* add variables or conditions if need */
class HeaderNavigation extends CWidget
{
	/* sample variables */
	public $active = 'home';
	public function init()
	{
		
	}
	
	public function run()
	{	
		if ( !Yii::app()->user->isGuest )
		{
			$renderFile = 'header_navigation';
		}
		else
		{
			$renderFile = 'header_navigation';
		}
		
		$this->render($renderFile, array(
			/* sample variable passing */
			'active' => $this->active,
		));
	}
}
?>
