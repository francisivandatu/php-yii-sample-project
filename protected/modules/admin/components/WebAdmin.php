<?php

class WebAdmin extends CWebUser
{
	private $_model;
	
	function getAccount()
	{
		$model = $this->loadAccount(Yii::app()->getModule('admin')->user->id);
		
		if ($model === null && !Yii::app()->getModule('admin')->user->isGuest)
		{
			Yii::app()->getModule('admin')->user->logout();
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
				$this->_model = Account::model()->findByPk($id);
			}
		}
		
		return $this->_model;
	}
}
?>
