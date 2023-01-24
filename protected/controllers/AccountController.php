<?php

class AccountController extends Controller
{
	// public $layout = 'dashboard';
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions' => array('edit', 'changePassword', 'index', 'saveApplicationForm'),
				'users' => array('@'),
			),
			/* array(
				'allow',
				'actions' => array('login', 'register', 'error'),
				'users' => array('*'),
			), */
			array(
				'deny',
				'users' => array('*'),
			),
		);
	}
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$account = Yii::app()->user->account;
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$models = ApplicationForm::model()->findAll(array(
			'condition' => 'account_id = '.Yii::app()->user->account->id,
			'order' => 'date_updated Desc'
		));
		
		$dataProvider = new CArrayDataProvider($models,array(
			'pagination'=>array(
				'pageSize' => 20,
			)
		));
		
		$this->render('index', array(
			'account' => $account,
			'models' => $models,
			'dataProvider' => $dataProvider
		));
	}

	public function actionEdit()
	{
		$account = Yii::app()->user->account;
		$user = $account->user;
		$userBillingInfo = $account->userBillingInfo;
		
		if (isset($_POST['submit']))
		{
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			$account->attributes = $_POST['Account'];
			$user->attributes = $_POST['User'];
			$userBillingInfo->attributes = $_POST['UserBillingInfo'];
			
			/* preset value */
			$account->username = $account->email_address;
			
			$userBillingInfo->country = Account::DEFAULT_COUNTRY;
			$userBillingInfo->first_name = $user->first_name;
			$userBillingInfo->last_name = $user->last_name;
			
			$valid = $account->validate();			
			$valid = $valid && $user->validate();
			$valid = $valid && $userBillingInfo->validate();

			if ($valid)
			{
				try
				{
					$errorModelTrace = 'account';
					if ($account->save(false))
					{
						$errorModelTrace = 'user';
						$user->account_id = $account->getPrimaryKey();
						if($user->save(false))
						{
							$errorModelTrace = 'UserBillingInfo';
							$userBillingInfo->account_id = $account->getPrimaryKey();
							if ( $userBillingInfo->save(false) )
							{
								//create a method to check if user
								if ( !isset($_SESSION['applicaitonFormId']) )
								{
									Yii::app()->user->setFlash("success", "You Information has been successfully updated.");
									Yii::app()->user->id = $account->email_address;
									$transaction->commit();
									$this->refresh();
								}
								else
								{
									//proceed to auto login + payment page
								}
							}
						}
					}
					
					//if one of the saving process failed display a default error message
					Yii::app()->user->setFlash("danger", "Registration error,".$errorModelTrace." failed to save.");
				}
				catch (Exception $e)
				{
					$transaction->rollBack();
					Yii::app()->user->setFlash("danger",  $e);
				}
			}
		}
		
		$this->render('edit', array(
			'account' => $account,
			'user' => $user,
			'userBillingInfo' => $userBillingInfo,
			'country' => Country::model()->findAll(array('condition'=>'status = 1'))
		));
	}
	
	public function actionChangePassword()
	{
		$account = Yii::app()->user->account;
		$account->scenario = 'changePassword';
		
		if ( isset($_POST['Account']) )
		{
			$account->attributes = $_POST['Account'];
			if($account->validateOldPassword($account->old_password))
			{ 
				if($account->new_password == $account->confirm_password)
				{
					$account->salt = $account->generateSalt();
					$account->password = $account->hashPassword($account->new_password,$account->salt);
					if ($account->save())
					{
						Yii::app()->user->setFlash("success", "Change password successful!");
						$this->redirect(array('account/changePassword'));
					}
					else
					{
						Yii::app()->user->setFlash("danger", "Change password failed!");
					}
				}	
				else
				{
					Yii::app()->user->setFlash("danger", "Change password failed. New password and Repeat password does not match!");
				}
			}
			else
			{
				Yii::app()->user->setFlash("danger", "Change password failed. Incorrect Old password!");
				$this->refresh();
			}
		}
		
		$this->render('changePassword', array(
			'account' => $account,
			'country' => Country::model()->findAll(array('condition'=>'status = 1'))
		));
	}
	
	public function actionSaveApplicationForm()
	{
		if ( isset($_SESSION['applicationFormId']) )
		{
			$applicationForm = ApplicationForm::model()->savePendingForm()->findByPk($_SESSION['applicationFormId']);
			if ( $applicationForm )
			{	
				$applicationForm->account_id = Yii::app()->user->account->id;
				$applicationForm->type = ApplicationForm::TYPE_SAVED;
				if($applicationForm->save(false))
				{
					Yii::app()->user->setFlash('success', 'Your credit application form was successfully saved. <Br />Visit My Account Page to complete saved application.');
					$this->redirect(array('account/index'));
				}
				else
				{
					Yii::app()->user->setFlash('danger', 'Your credit application form was not save. Please try again later.');
					$this->redirect(array('applicationForm/creditApplication'));
				}
			}
			else
			{
				Yii::app()->user->setFlash('warning', 'The application form that your trying to save does not exist. Please try again.');
				$this->redirect(array('applicationForm/creditApplication'));
			}
		}
		else
		{
			Yii::app()->user->setFlash('info', 'Please fill in the Credit Application form.');
			$this->redirect(array('applicationForm/creditApplication'));
		}
	}
	
	public function loadModel($id)
	{
		$model=Account::model()->regularUser()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page is not available.');
		return $model;
	}
}
