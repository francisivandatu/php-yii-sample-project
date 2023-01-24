<?php

class WebUser extends CWebUser
{
	private $_model;
	
	function getAccount()
	{
		$model = $this->loadAccount(Yii::app()->user->id);
		if ($model === null && !Yii::app()->user->isGuest)
		{
			Yii::app()->user->logout();
			Yii::app()->controller->redirect(Yii::app()->homeUrl);
			Yii::app()->end();
		}
		return $model;
	}
	
	protected function loadAccount($id = null)
	{	
		if ($this->_model === null)
		{
			if ($id !== null)
			{
				$this->_model = Account::model()->find(array('condition'=>'username = "'.$id.'"'));
			}
		}
		
		return $this->_model;
	}
}
?>
