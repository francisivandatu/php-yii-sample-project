<?php

class DefaultController extends Controller
{	
	// public $layout='/layouts/dashboard';
	public $activeSideNav = array('default');
	public $lang;
	
	public function actionIndex()
	{
		$this->render('dashboard');
	}
	
	public function actionLogin()
	{
		$this->layout = "main";
	
		$model = new AdminLoginForm;

		// if it is ajax validation request
		// if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		// {
			// echo CActiveForm::validate($model);
			// Yii::app()->end();
		// }

		// collect user input data
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes = $_POST['AdminLoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login())
			{
				// Yii::app()->user->setFlash('success', 'Login Successful.');
				// Update user location
				$this->redirect(array('/admin/default/index'));
			}
		}
		
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionLogout()
	{
		if(isset($_SESSION['token']))
			unset($_SESSION['token']);
			
		Yii::app()->getModule('admin')->user->logout(false);
		// Yii::app()->user->setFlash('success', 'Logout Successful.');
		$this->redirect(Yii::app()->getModule('admin')->user->loginUrl);
	}
	
	public function actionError()
	{
		$this->layout = "main"; 
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
					echo $error['message'];
			else {
				$this->render('admin/default/error', $error);
			}
		}
	}

}
