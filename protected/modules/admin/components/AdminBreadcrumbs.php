<?php
/* add variables or conditions if need */
class AdminBreadcrumbs extends CWidget
{
	/* sample variables */
	public $crumbs = array();
	
	public function init()
	{
		
	}
	
	public function run()
	{
	
		$this->render('breadcrumbs', array(
			'crumbs' => $this->crumbs,
		));
	}
}
?>
