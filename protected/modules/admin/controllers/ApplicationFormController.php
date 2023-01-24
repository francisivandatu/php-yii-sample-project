<?php

class ApplicationFormController extends Controller
{
	public $activeSideNav = array('manage_applicationForm');
	
	public function actionView($id)
	{	
		$account = $this->loadModel($id);
		
		$models = ApplicationForm::model()->findAll(array(
			'condition' => 'account_id = '.$account->id
		));
		
		$dataProvider = new CArrayDataProvider($models,array(
			'pagination'=>array(
				'pageSize' => 20,
			)
		));
		
		$this->render('view',array(
			'account' => $account,
			'dataProvider' => $dataProvider
		));
	}
	
	public function actionIndex($searchQuery = null)
	{
		$criteria = new CDbCriteria;
		$criteria->mergeWith(array(
			'condition' => 'type IN ('.ApplicationForm::TYPE_PAID.', '.ApplicationForm::TYPE_SAVED.')',
			'order' => 'date_updated DESC'
		));		
		
		$models = ApplicationForm::model()->findAll($criteria);
		
		$dataProvider = new CArrayDataProvider($models,array(
			'pagination'=>array(
				'pageSize' => 20,
			)
		));
		
		$this->render('manage',array(
			'models'=>$models,
			'dataProvider'=>$dataProvider,
			'searchQuery' => $searchQuery
		));
	}
	
	public function loadModel($id)
	{
		$model=Account::model()->regularUser()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='content-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionSetViewApplicationForm($id)
	{
		$_SESSION['applicationFormId'] = $id;
		$this->redirect(array('/applicationForm/creditApplication'));
	}
}
