<?php
/* add variables or conditions if need */
class Header extends CWidget
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
			$renderFile = 'header_authenticated';
		}
		else
		{
			$renderFile = 'header';
		}
		
		$this->render($renderFile, array(
			/* sample variable passing */
			'active' => $this->active,
		));
	}
}
?>
