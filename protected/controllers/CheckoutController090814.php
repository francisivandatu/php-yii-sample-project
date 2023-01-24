<?php

class CheckoutController extends Controller
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
				'actions' => array('index', 'success', 'setApplicationForm', 'dev'),
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
	public function actionIndex($id)
	{
		$account = Yii::app()->user->account;
		$user = $account->user;
		$userBillingInfo = $account->userBillingInfo;
		$userBillingInfo->setScenario('paymentProcess');
                $promoCode = null;
                
                // remove any remaining sessioned promo code;
                unset($_SESSION['ap_frm_promo_code']);
		
		$paymentTransaction = new PaymentTransaction;
		
		/*if ( isset($_SESSION['applicationFormId']) )
		{
			$applicationFormId = $_SESSION['applicationFormId'];
			
			//look for the application form entry
			$applicationForm = ApplicationForm::model()->forPayment()->findByPk($applicationFormId);
			
			if ( $applicationForm === null )
			{
				$this->redirect(array('/applicationForm/creditApplication'));
			}
		}*/
        if ( $id )
		{
			//look for the application form entry
			$applicationForm = ApplicationForm::model()->forPayment()->findByPk($id);
			$applicationFormId = $applicationForm->id;
                        $promoCode = $applicationForm->promo_code;
			
			if ( $applicationForm === null )
			{
				$this->redirect(array('/applicationForm/creditApplication'));
			}
		}
		else
		{
			// $applicationFormId = 23;
			$this->redirect(array('/applicationForm/creditApplication'));
		}
		
		//do instant transaction complete redirect and do not proceed to billing page
		if ( !empty($applicationForm->promo_code) AND !isset($_GET['renderBillingInfo']) )
		{
			$paymentTransaction->attributes = $userBillingInfo->attributes;
			$paymentTransaction->promo_code = $applicationForm->promo_code;
			$paymentTransaction->invoice_number = $paymentTransaction->generateInvoiceId($applicationFormId);
			$paymentTransaction->status = PaymentTransaction::STATUS_COMPLETED;
			$paymentTransaction->payment_method = PaymentTransaction::METHOD_PROMO_CODE;
			$paymentTransaction->save(false);
			$PtransactionId = $paymentTransaction->getPrimaryKey();
			
			$applicationForm->payment_transaction_id = $PtransactionId;
			$applicationForm->type = ApplicationForm::TYPE_PAID;
			$applicationForm->account_id = $account->id;
			$applicationForm->save(false);
			$paymentAPI = new PaymentAPI;

			$res = $this->sendMails($applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction);

			if($res) {
				$redirectUrl = array('checkout/success', 'id' => $PtransactionId);
				Yii::app()->user->setFlash('success', 'Credit Application transaction was success.');
			}
			else {
				$redirectUrl = array('checkout/success', 'id' => $PtransactionId);
				Yii::app()->user->setFlash('error', 'Error sending emails');
			}
			
			$this->redirect($redirectUrl);
		}
		
		if ( isset($_POST['PaymentTransaction']) OR isset($_POST['validated_promo_code']))
		{
                        if(isset($_POST['PaymentTransaction']))
                           
                        
			$userBillingInfo->attributes = $_POST['UserBillingInfo'];
			$paymentTransaction->attributes = $userBillingInfo->attributes;
			
                        if(isset($_POST['validated_promo_code'])) {
                            
                            $validatedPromoCode = $_POST['validated_promo_code'];
                            $paymentTransaction->payment_method = PaymentTransaction::METHOD_PROMO_CODE;
                            $paymentTransaction->promo_code = $validatedPromoCode;
                            $userBillingInfo->attributes = $_POST['UserBillingInfo'];
                            $paymentTransaction->attributes = $userBillingInfo->attributes;
                            
                            $valid = $userBillingInfo->validate();
                            
                        }
                        else {
                            
                            $paymentTransaction->attributes = $_POST['PaymentTransaction'];
                            $userBillingInfo->attributes = $_POST['UserBillingInfo'];
                            $paymentTransaction->attributes = $userBillingInfo->attributes;
                            $paymentTransaction->setScenario('credit_card');
                            $valid = $paymentTransaction->validate() && $userBillingInfo->validate();
                            
                        }
			
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();			
			
			if ( $valid )
			{
				$paymentTransaction->invoice_number = $paymentTransaction->generateInvoiceId($applicationFormId);
				$paymentTransaction->status = PaymentTransaction::STATUS_PENDING;
				
				try
				{
					$paymentTransaction->save(false);
					$PtransactionId = $paymentTransaction->getPrimaryKey();
					
					// then update with the payment transaction id
					$applicationForm->account_id = $account->id;
					$applicationForm->payment_transaction_id = $PtransactionId;
					$applicationForm->save(false);
					
					$transaction->commit();
                                        
                                        if($paymentTransaction->payment_method == PaymentTransaction::METHOD_PROMO_CODE) {
                                            
                                            $paymentTransaction->status = PaymentTransaction::STATUS_COMPLETED;
                                            $paymentTransaction->save(false);

                                            $applicationForm->type = ApplicationForm::TYPE_PAID;
                                            $applicationForm->promo_code = $paymentTransaction->promo_code;
											$applicationForm->save(false);
                                            $paymentAPI = new PaymentAPI;

                                            $res = $this->sendMails($applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction);

                                            if($res) {
                                                $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                Yii::app()->user->setFlash('success', 'Credit Application transaction was success.');
                                            }
                                            else {
                                                $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                Yii::app()->user->setFlash('error', 'Error sending emails');
                                            }
                                            
                                        }
                                        else {
                                            
                                            $transactionParams = array(
                                                    'transtype' => 'SALE',
                                                    'cardnumber' => $paymentTransaction->card_number,
                                                    'expmonth' => $paymentTransaction->card_expiration_month,
                                                    'expyear' => $paymentTransaction->card_expiration_year,

                                                    'amount' => PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE,

                                                    'first_name' => $paymentTransaction->first_name,
                                                    'last_name' => $paymentTransaction->last_name,
                                                    'address' => $paymentTransaction->billing_address1,
                                                    'city' => $paymentTransaction->city,
                                                    'state' => $paymentTransaction->state,
                                                    'zip' => $paymentTransaction->zip,
                                                    'email' => $account->email_address,

                                                    'client_transref' => $paymentTransaction->invoice_number
                                            );

                                            //process payment
                                            $paymentAPI = new PaymentAPI;
                                            $paymentResponse = $paymentAPI->doPayment($transactionParams);
                                            $paymentResult = $paymentAPI->validateResponse($paymentResponse);

                                            if ( $paymentResult['status'] == true )
                                            {	
                                                    //payment was successfull, update the trasaction details
                                                    $paymentTransaction->attributes = $paymentAPI->getResponseToArray($paymentResponse);
                                                    $paymentTransaction->status = PaymentTransaction::STATUS_COMPLETED;
                                                    $paymentTransaction->save(false);

                                                    $applicationForm->type = ApplicationForm::TYPE_PAID;
                                                    $applicationForm->save(false);

                                                    $res = $this->sendMails($applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction);

                                                    if($res) {
                                                        $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                        Yii::app()->user->setFlash('success', 'Credit Application transaction was success.');
                                                    }
                                                    else {
                                                        $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                        Yii::app()->user->setFlash('error', 'Error sending emails');
                                                    }

                                            }
                                            else
                                            {
                                                    $paymentTransaction->remarks = $paymentResult['statusDesc'];
                                                    $paymentTransaction->save(false);

                                                    $redirectUrl = array('checkout/index', 'id' => $applicationFormId); 
                                                    Yii::app()->user->setFlash('danger', 'We can not process the transaction with the credit card information you provided. <br /> Please consider using a different credit card.');
                                            }
                                            
                                        }
					
					$this->redirect($redirectUrl);
					
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('danger', 'Error:' . $e);
				}	
			}
		}
		
		$this->render('index', array(
			'paymentTransaction' => $paymentTransaction,
			'account' => $account,
			'user' => $user,
			'userBillingInfo' => $userBillingInfo,
			'applicationFormId' => $applicationFormId,
			'promoCode' => $promoCode,
			'devMode' => true			
		));
	}
	
	public function loadModel($id)
	{
		$model=Account::model()->regularUser()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page is not available.');
		return $model;
	}
	
	public function actionSetApplicationForm( $id, $page = null )
	{	
		$applicationForm = ApplicationForm::model()->forPayment()->findByPk($id);
                
		if ( $applicationForm AND $applicationForm->account_id == Yii::app()->user->account->id )
		{
			$_SESSION['applicationFormId'] = $id;
                        
                        if($page == "checkout")
                            $this->redirect(array('/checkout/index', 'id' => $applicationForm->id));
                        else
                            $this->redirect(array('applicationForm/summary', 'id' => $id));
		}
		else
		{
			Yii::app()->user->setFlash('warning', 'The page that your trying to access is not available');
			$this->redirect(array('account/index'));
		}
	}
	
	public function actionSuccess($id)
	{
		$paymentTransactionModel = PaymentTransaction::model()->paymentComplete()->find(array(
			'condition' => 'id = :id AND account_id = :account_id',
			'params' => array(
				':id' => $id,
				':account_id' => Yii::app()->user->account->id
			)
		));
		
		if ( $paymentTransactionModel === null )
			throw new CHttpException(404,'The requested page is not available.');
		
		$this->render('success', array(
			'paymentTransactionModel' => $paymentTransactionModel
		));
	}
        
        private function sendMails($applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction)
        {
            //generate user email
            {
                    $emailWrapper = new EmailWrapper;
                    $emailWrapper->setSubject('Essex Funding Credit Application');
                    $emailWrapper->setReceivers(array(
                            Yii::app()->user->account->email_address,
                            // 'rnewgen@gmail.com'
                            // 'francis.zeniark@gmail.com'
                    ));

                    // .Yii::app()->user->account->user->getTitle().
                    $emailWrapper->setMessage('
                                    '.$userBillingInfo->first_name.', 
                                    <br/><br />

                                    Your credit application has been received by our underwriting department.<Br />
                                    We are reviewing your application, and we will be back to you as soon as the review is complete. <br /><br />

                                    Please feel free to contact us with any questions in the interim.<br /><br />

                                    <Br />
                                    Essex Funding, Inc. <br />
                                    <a href="www.essexfunding.com">www.essexfunding.com</a>
                    ');

                    $emailTemplate = 'blank';
                    // echo $emailWrapper->loadTemplate($emailTemplate); exit;

                    $resUser = $emailWrapper->sendMessage($emailTemplate);
            }


            //generate admin email
            {
                    if ( $paymentAPI->apiLive == true )
                    {
                            $emailReceivers = array(
                                    'francis.zeniark@gmail.com',
                                    'rnewgen@gmail.com',
                                    'rob@essexfunding.com',
                                    'bob@essexfunding.com'
                            );
                    }
                    else
                    {
                            $emailReceivers = array(
                                    'francis.zeniark@gmail.com',
                                    'krishap.zeniark@gmail.com',
                            );
                    }

                    $subjectTitle = $applicationForm->legal_name.' Lease Application';
                    $emailWrapper = new EmailWrapper;
                    $emailWrapper->setSubject($subjectTitle);
                    $emailWrapper->setReceivers($emailReceivers);

                    set_time_limit(0);

                    $urlPath = Yii::app()->createAbsoluteUrl('applicationForm/applicationWebView', array('id' => $applicationForm->id, 'accountId' => Yii::app()->user->account->id));
                    $filename = $subjectTitle.'.pdf';
                    $pdfPath = Yii::getPathOfAlias('webroot').'/file-uploads/'.$filename;

                    exec("wkhtmltopdf '".$urlPath."' '".$pdfPath."'");

                    $emailWrapper->setAttachment($pdfPath);

                    $principalInfos = PrincipalInfo::model()->findAll(array(
                            'condition' => 'form_id = '.$applicationForm->id
                    ));
                    
                    $principalNames = array();
                    
                    foreach ( $principalInfos as $principalInfo )
                    {
                            $principalNames[] = ' -'.$principalInfo->name_title;
                    }

                    if ( count($principalNames) == 0 )
                            $principalNames = 'n/a';
                    else
                            $principalNames = '<br />' . implode('<br />',$principalNames);

                    /* 
                            Amount: '.$paymentAPI->currencySymbol.''.number_format($paymentTransaction->total, 2).' <br />
                            Transaction ID: '.$paymentTransaction->txn_id.' <br />
                            Invoice #: '.$paymentTransaction->invoice_number.' <br />
                    */

                    $emailWrapper->setMessage('

                                    A new credit application has been submitted. <br /> <br />

                                    Name: '.$applicationForm->legal_name.' <Br />
                                    City, State: '.$applicationForm->getCityTextValue($applicationForm->city).', '.$applicationForm->getStateTextValue($applicationForm->state).' <Br />
                                    Principal Name(s): '.$principalNames.' <br />
                                    Work Phone #: '.((!empty($applicationForm->phone)) ? $applicationForm->phone : 'n/a').' <br />
                                    Email Address: '.Yii::app()->user->account->email_address.' <br />
                                    Date: '.$paymentTransaction->date_created.' <br/>

                                    <br /><br />
                                    You can login to the admin panel to view additional details <br />
                                    <a href="https://essexfunding.com/admin">essexfunding.com/admin</a>
                                    <br /><Br />

                                    Thank you,
                                    <br />

                                    <a href="https://essexfunding.com/">essexfunding.com</a>
                    ');

                    $emailTemplate = 'blank';
                    // echo $emailWrapper->loadTemplate($emailTemplate); exit;

                    $resAdmin = $emailWrapper->sendMessage($emailTemplate);

                    unlink($pdfPath);
            }
            
            if($resUser AND $resAdmin)
                return true;
            else
                return false;
            
        }
	
	public function actionDev($id)
	{
		$account = Yii::app()->user->account;
		$user = $account->user;
		$userBillingInfo = $account->userBillingInfo;
		$userBillingInfo->setScenario('paymentProcess');
                $promoCode = null;
                
                // remove any remaining sessioned promo code;
                unset($_SESSION['ap_frm_promo_code']);
		
		$paymentTransaction = new PaymentTransaction;
		
		/*if ( isset($_SESSION['applicationFormId']) )
		{
			$applicationFormId = $_SESSION['applicationFormId'];
			
			//look for the application form entry
			$applicationForm = ApplicationForm::model()->forPayment()->findByPk($applicationFormId);
			
			if ( $applicationForm === null )
			{
				$this->redirect(array('/applicationForm/creditApplication'));
			}
		}*/
        if ( $id )
		{
			//look for the application form entry
			$applicationForm = ApplicationForm::model()->forPayment()->findByPk($id);
			$applicationFormId = $applicationForm->id;
                        $promoCode = $applicationForm->promo_code;
			
			if ( $applicationForm === null )
			{
				$this->redirect(array('/applicationForm/creditApplication'));
			}
		}
		else
		{
			// $applicationFormId = 23;
			$this->redirect(array('/applicationForm/creditApplication'));
		}
		
		//do instant transaction complete redirect and do not proceed to billing page
		if ( !empty($applicationForm->promo_code) AND !isset($_GET['renderBillingInfo']) )
		{
			$paymentTransaction->attributes = $userBillingInfo->attributes;
			$paymentTransaction->promo_code = $applicationForm->promo_code;
			$paymentTransaction->invoice_number = $paymentTransaction->generateInvoiceId($applicationFormId);
			$paymentTransaction->status = PaymentTransaction::STATUS_COMPLETED;
			$paymentTransaction->payment_method = PaymentTransaction::METHOD_PROMO_CODE;
			$paymentTransaction->save(false);
			$PtransactionId = $paymentTransaction->getPrimaryKey();
			
			$applicationForm->payment_transaction_id = $PtransactionId;
			$applicationForm->type = ApplicationForm::TYPE_PAID;
			$applicationForm->account_id = $account->id;
			$applicationForm->save(false);
			$paymentAPI = new PaymentAPI;

			$res = $this->sendMails($applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction);

			if($res) {
				$redirectUrl = array('checkout/success', 'id' => $PtransactionId);
				Yii::app()->user->setFlash('success', 'Credit Application transaction was success.');
			}
			else {
				$redirectUrl = array('checkout/success', 'id' => $PtransactionId);
				Yii::app()->user->setFlash('error', 'Error sending emails');
			}
			
			$this->redirect($redirectUrl);
		}
		
		if ( isset($_POST['PaymentTransaction']) OR isset($_POST['validated_promo_code']))
		{
                        if(isset($_POST['PaymentTransaction']))
                           
                        
			$userBillingInfo->attributes = $_POST['UserBillingInfo'];
			$paymentTransaction->attributes = $userBillingInfo->attributes;
			
                        if(isset($_POST['validated_promo_code'])) {
                            
                            $validatedPromoCode = $_POST['validated_promo_code'];
                            $paymentTransaction->payment_method = PaymentTransaction::METHOD_PROMO_CODE;
                            $paymentTransaction->promo_code = $validatedPromoCode;
                            $userBillingInfo->attributes = $_POST['UserBillingInfo'];
                            $paymentTransaction->attributes = $userBillingInfo->attributes;
                            
                            $valid = $userBillingInfo->validate();
                            
                        }
                        else {
                            
                            $paymentTransaction->attributes = $_POST['PaymentTransaction'];
                            $userBillingInfo->attributes = $_POST['UserBillingInfo'];
                            $paymentTransaction->attributes = $userBillingInfo->attributes;
                            $paymentTransaction->setScenario('credit_card');
                            $valid = $paymentTransaction->validate() && $userBillingInfo->validate();
                            
                        }
			
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();			
			
			if ( $valid )
			{
				$paymentTransaction->invoice_number = $paymentTransaction->generateInvoiceId($applicationFormId);
				$paymentTransaction->status = PaymentTransaction::STATUS_PENDING;
				
				try
				{
					$paymentTransaction->save(false);
					$PtransactionId = $paymentTransaction->getPrimaryKey();
					
					// then update with the payment transaction id
					$applicationForm->account_id = $account->id;
					$applicationForm->payment_transaction_id = $PtransactionId;
					$applicationForm->save(false);
					
					$transaction->commit();
                                        
                                        if($paymentTransaction->payment_method == PaymentTransaction::METHOD_PROMO_CODE) {
                                            
                                            $paymentTransaction->status = PaymentTransaction::STATUS_COMPLETED;
                                            $paymentTransaction->save(false);

                                            $applicationForm->type = ApplicationForm::TYPE_PAID;
											$applicationForm->promo_code = $paymentTransaction->promo_code;
                                            $applicationForm->save(false);
                                            $paymentAPI = new PaymentAPI;

                                            $res = $this->sendMails($applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction);

                                            if($res) {
                                                $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                Yii::app()->user->setFlash('success', 'Credit Application transaction was success.');
                                            }
                                            else {
                                                $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                Yii::app()->user->setFlash('error', 'Error sending emails');
                                            }
                                            
                                        }
                                        else {
                                            
                                            $transactionParams = array(
                                                    'transtype' => 'SALE',
                                                    'cardnumber' => $paymentTransaction->card_number,
                                                    'expmonth' => $paymentTransaction->card_expiration_month,
                                                    'expyear' => $paymentTransaction->card_expiration_year,

                                                    'amount' => PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE,

                                                    'first_name' => $paymentTransaction->first_name,
                                                    'last_name' => $paymentTransaction->last_name,
                                                    'address' => $paymentTransaction->billing_address1,
                                                    'city' => $paymentTransaction->city,
                                                    'state' => $paymentTransaction->state,
                                                    'zip' => $paymentTransaction->zip,
                                                    'email' => $account->email_address,

                                                    'client_transref' => $paymentTransaction->invoice_number
                                            );

                                            //process payment
                                            $paymentAPI = new PaymentAPI;
                                            $paymentResponse = $paymentAPI->doPayment($transactionParams);
                                            $paymentResult = $paymentAPI->validateResponse($paymentResponse);

                                            if ( $paymentResult['status'] == true )
                                            {	
                                                    //payment was successfull, update the trasaction details
                                                    $paymentTransaction->attributes = $paymentAPI->getResponseToArray($paymentResponse);
                                                    $paymentTransaction->status = PaymentTransaction::STATUS_COMPLETED;
                                                    $paymentTransaction->save(false);

                                                    $applicationForm->type = ApplicationForm::TYPE_PAID;
                                                    $applicationForm->save(false);

                                                    $res = $this->sendMails($applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction);

                                                    if($res) {
                                                        $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                        Yii::app()->user->setFlash('success', 'Credit Application transaction was success.');
                                                    }
                                                    else {
                                                        $redirectUrl = array('checkout/success', 'id' => $PtransactionId);
                                                        Yii::app()->user->setFlash('error', 'Error sending emails');
                                                    }

                                            }
                                            else
                                            {
                                                    $paymentTransaction->remarks = $paymentResult['statusDesc'];
                                                    $paymentTransaction->save(false);

                                                    $redirectUrl = array('checkout/index', 'id' => $applicationFormId); 
                                                    Yii::app()->user->setFlash('danger', 'We can not process the transaction with the credit card information you provided. <br /> Please consider using a different credit card.');
                                            }
                                            
                                        }
					
					$this->redirect($redirectUrl);
					
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('danger', 'Error:' . $e);
				}	
			}
		}
		
		$this->render('index', array(
			'paymentTransaction' => $paymentTransaction,
			'account' => $account,
			'user' => $user,
			'userBillingInfo' => $userBillingInfo,
			'applicationFormId' => $applicationFormId,
			'promoCode' => $promoCode,
			'devMode' => true			
		));
	}
}
