<?php

class LeaseCalculatorController extends Controller
{
	public $activeSideNav = array('manage_leaseCalculator');
	
	public function actionIndex($searchQuery = null, $recordFilter = null)
	{
		{ /* Start Filters */
			$criteria = new CDbCriteria;
			
			$criteria->mergeWith(array(
				'join' => 'LEFT JOIN {{lease_calculator_user}} as lcu ON t.id = lcu.lease_calculator_id',
				'select' => 't.id, t.initial_invoice_amount, t.result_monthly_cost, t.term, t.date_created',
				'order' => 't.date_created DESC'
			));
			
			if($recordFilter === null)
				$recordFilter = 'allRecords';
			else
			{
				if ( $recordFilter == 'withInfo' )
				{
					$criteria->mergeWith(array(
						'condition' => 'lcu.lease_calculator_id IS NOT NULL'
					));
				}
				else if ( $recordFilter == 'withoutInfo' )
				{
					$criteria->mergeWith(array(
						'condition' => 'lcu.lease_calculator_id IS NULL'
					));
				}
			}
			
			if( $searchQuery )
			{
				$criteria->mergeWith(array(
					'condition' => ' CONCAT_WS(" ", lcu.first_name, lcu.last_name) LIKE :searchQuery OR lcu.email_address LIKE :searchQuery ',
					'params' => array(
						':searchQuery' => '%'.$searchQuery.'%'
					)
				));
			}
			
		} /* End Query Filters */
		
		$models = LeaseCalculator::model()->active()->findAll($criteria);
		
		$dataProvider = new CArrayDataProvider($models,array(
			'pagination'=>array(
				'pageSize' => 20,
			)
		));
		
		$this->render('manage',array(
			'dataProvider'=>$dataProvider,
			'searchQuery' => $searchQuery,
			'recordFilter' => $recordFilter
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
	
	public function actionDeleteRecord($id,$_token)
	{
		$response = array(
			'status' => 'danger',
			'message' => 'An error occurred. Please try again later.'
		);
		
		$model = LeaseCalculator::model()->findByPk($id);
		if ( $model AND strtotime($model->date_created) == $_token )
		{	
			$model->status = LeaseCalculator::STATUS_DELETED;
			if ( $model->save(false) )
			{
				$response['status'] = 'success';
				$response['message'] = 'Selected record has been successfully deleted.';
			}
			else
			{
				$response['status'] = 'danger';
				$response['message'] = 'An error occurred. Please try again later.';
			}
		}
		
		Yii::app()->user->setFlash($response['status'], $response['message']);
		$this->redirect(array('/admin/leaseCalculator/'));
	}
}
