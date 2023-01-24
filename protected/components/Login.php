<?php
/* add variables or conditions if need */
class Login extends CWidget
{
	public function init()
	{
		
	}
	
	public function run()
	{	
		$model=new LoginForm;
		$this->render('login', array(
			'model' => $model,
		));
		
	}
}
?>
