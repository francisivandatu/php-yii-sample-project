<?php
class Flash extends CWidget
{
	public $flashes = array();
	public $hide = false;
	public $hide_time = 5000;

	public function init()
	{
		
	}
	
	public function run()
	{
			$this->render('flash', array(
				'flashes'=>$this->flashes,
				'hide'=>$this->hide,
				'hide_time'=>$this->hide_time,
			));
	}
}
?>
