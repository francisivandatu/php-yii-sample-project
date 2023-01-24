<?php

class PromoCodeController extends Controller
{
    
        public function actionValidate()
        {
            $response = array();
            
            if(isset($_POST['PromoCode'])) {
               
                $promoCode = strtolower($_POST['PromoCode']);
                $promos = PaymentTransaction::promos();
                
                if(array_key_exists($promoCode, $promos)) {
                    $response = array(
                        'status' => 1,
                        'message' => 'Promo code is available.',
                        'content' => $this->renderPartial("_validated", array(
                            'promoCode' => $promoCode
                        ), true, false)
                    );
                }
                else {
                    $response = array(
                        'status' => 0,
                        'message' => "Promo Code Incorrect.",
                        'content' => ""
                    );
                }
               
                echo CJSON::encode($response);
                Yii::app()->end();
            }
        }
    
	/*public function actionIndex()
	{
		$this->render('index');
	}*/

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}