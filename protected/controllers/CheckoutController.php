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
				'actions' => array('index', 'success', 'setApplicationForm','executePaypalPayment', 'dev','sendManualEmail'),
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
				/*
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
				*/
			}

            //generate admin email
            {
					$emailReceivers = array(
						Yii::app()->user->account->email_address => Yii::app()->user->account->email_address,
					);

					$principals = PrincipalInfo::model()->findAll(array(
						'condition' => 'form_id = :form_id',
						'params' => array(
							':form_id' => $applicationForm->id
						)
					));
					
					foreach ( $principals as $principal )
					{
						if ( filter_var($principal->email_address, FILTER_VALIDATE_EMAIL) )
						{
							$emailReceivers[$principal->email_address] = $principal->email_address;
						}
					}
					
					$emailReceivers = array_unique($emailReceivers);
					
					if ( $paymentAPI->apiLive == true )
                    {
						$testFlag = '';
						$emailBcc = array(
							
							
							// 'francis.zeniark@gmail.com' => 'francis.zeniark@gmail.com',
							// 'rochelleb.zeniark@gmail.com' => 'rochelleb.zeniark@gmail.com',
							// 'chrisl.zeniark@gmail.com' => 'chrisl.zeniark@gmail.com',
							// 'reynana.zeniark@gmail.com' => 'reynana.zeniark@gmail.com',
							
							'rnewgen@gmail.com' => 'rnewgen@gmail.com',
							'rob@essexfunding.com' => 'rob@essexfunding.com',
							'bob@essexfunding.com' => 'bob@essexfunding.com'
						);
						
                    }
                    else
                    {	
						$testFlag = '(TEST ONLY)';
						$emailBcc = array(
							// 'francis.zeniark@gmail.com',
							// 'markj.zeniark@gmail.com',
							// 'roseann.zeniark@gmail.com',
							'reynana.zeniark@gmail.com' => 'reynana.zeniark@gmail.com',
							// 'gracem@zeniark.com',
							// 'krishap.zeniark@gmail.com',
							// 'ricka.zeniark@gmail.com',
							'jayb.zeniark@gmail.com' => 'jayb.zeniark@gmail.com',
						);
                    }
					
					
					if( Yii::app()->user->account->id == 47 ) // for francis.zeniark - Testing view
					{
						$emailBcc = array(
							
							
							// 'francis.zeniark@gmail.com' => 'francis.zeniark@gmail.com',
							// 'rochelleb.zeniark@gmail.com' => 'rochelleb.zeniark@gmail.com',
							// 'chrisl.zeniark@gmail.com' => 'chrisl.zeniark@gmail.com',
							'reynana.zeniark@gmail.com' => 'reynana.zeniark@gmail.com',
							
							// 'rnewgen@gmail.com' => 'rnewgen@gmail.com',
							// 'rob@essexfunding.com' => 'rob@essexfunding.com',
							// 'bob@essexfunding.com' => 'bob@essexfunding.com'
						);
					}
					
					
                    $subjectTitle = $testFlag.$applicationForm->legal_name.' Lease Application';
                    $emailWrapper = new EmailWrapper;
                    $emailWrapper->setSubject($subjectTitle);
                    $emailWrapper->setReceivers($emailReceivers);
                    $emailWrapper->setBcc($emailBcc);

                    set_time_limit(0);

                    // $urlPath = Yii::app()->createAbsoluteUrl('applicationForm/applicationWebView', array('id' => $applicationForm->id, 'accountId' => Yii::app()->user->account->id), 'http');
					$urlPath = 'http://pdf.essexfunding.com/index.php/applicationForm/applicationWebView?id='.$applicationForm->id.'&accountId='.Yii::app()->user->account->id;
//                    echo $urlPath;exit;
                    $filename = $subjectTitle.'.pdf';
                    $pdfPath = Yii::getPathOfAlias('webroot').'/file-uploads/'.$filename;
					
                    passthru("wkhtmltopdf -B '5mm' -L '5mm' -R '5mm' -T '5mm' '".$urlPath."' '".$pdfPath."'");

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
					
					//'.$userBillingInfo->first_name.',  <Br /> <br />
					
					/* 
					$newMessage = '
						
						<br />
						Thank you for your lease submission.  Please review the attached application for accuracy. <br /> <br />

						Once reviewed, all principals must sign and date just above the "Credit Release" line, allowing us to pull their personal credit report. <Br /> <br />

						After executing, please reply back with the scanned document attached.  Alternatively, fax the signed application to (813)837-3502. <Br /><br />
						
						Upon receipt, we will be back to you within 48 hours with a credit decision.  <Br /> <br />

						In the interim, feel free to call us with any questions at (813)443-4632. <Br /> <br />
						
						Thank you, <br />
						
						<Br />
						Essex Funding, Inc. <br />
						<a href="www.essexfunding.com">www.essexfunding.com</a>
					'; */
					
					$newMessage = '<Br />
						Thank you for your lease application. <Br /> <br />
						
						<b style="color:red">ONE FINAL STEP NEEDED</b><br />
						
						<ul>
							<li>Please review the attached application for accuracy.</li>
							<li>Once reviewed, <b><u>all principals must sign and date just above the "Credit Release" line</u></b>, allowing us to pull their personal credit report.</li>
							<li>After executing, please reply back with the scanned document attached.
								<ul>
									<li>Alternatively, fax the signed application to (813) 837-3502.</li>
								</ul>
							</li>
						</ul>
						
						<br />
						
						Upon receipt, we will be back to you within 48 hours with a credit decision. <Br /> <br />
						
						In the interim, feel free to call us with any questions at (813) 443-4632. <br /><br />
						
						Thank you,  <br /><br />

						Essex Funding, Inc.  <Br />
						<a href="https://www.essexfunding.com">www.essexfunding.com</a>';
					
					$oldMessageAdmin = '
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
                    ';
					
                    $emailWrapper->setMessage($newMessage);

                    $emailTemplate = 'blank';
                    // echo $emailWrapper->loadTemplate($emailTemplate); exit;

                    // $resAdmin = $emailWrapper->sendMessage($emailTemplate);
                    $resAdmin = true;
					
					
					
					//send a separate copy to site admin
					$emailWrapper = new EmailWrapper;
                    $emailWrapper->setSubject($subjectTitle.'-'.$applicationForm->id);
                    $emailWrapper->setReceivers(array('francis.zeniark@gmail.com'));
					$emailWrapper->setMessage($newMessage);
					// $emailWrapper->sendMessage($emailTemplate);
					//do not comment  ^this on production. but this is safe to comment on testing
					
					
					{ 	//START - sendinBlue code block						
						$fileUrl = 'https://essexfunding.com/file-uploads/'.$filename;
						
						require(Yii::app()->basePath . '/extensions/sendinblue/Mailin.php');	
						$mailin = new Mailin('https://api.sendinblue.com/v2.0', 'ZfPtnFAUDvjbG90q');			
						$data = array(  
							"subject" => $subjectTitle.'-'.$applicationForm->id,							
							"to" => $emailReceivers,		//line code 365 - 384					 		
							// "to" => array('ninot.zeniark@gmail.com' => 'ninot.zeniark@gmail.com'),							
							// "to" => array('chrisl.zeniark@gmail.com' => 'chrisl.zeniark@gmail.com'),							
							"from" => array("rob@essexfunding.com", "EssexFunding"),
							"replyto" => array("rob@essexfunding.com" => "rob"),
							"bcc" => $emailBcc,			//line code 386 - 412
							"html" => $newMessage,
							"attachment" => array($fileUrl),
						);
						$send_email = $mailin->send_email($data);									
						
						// if( Yii::app()->user->account->id == 47 ) // for francis.zeniark - Testing view
						// {
							// Dev::pvx($send_email);
						// }
						
						if ( isset($send_email['code']) AND $send_email['code'] == 'success' )
						{	
							$resAdmin = true;
						}
						else
							$resAdmin = true;
					}	//END sendInBlue Code Block
					
                    // unlink($pdfPath);
            }
            
            // if($resUser AND $resAdmin)
			if($resAdmin)
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
		
		$hasSubmission = false;
		
		//do instant transaction complete redirect and do not proceed to billing page
		if ( !empty($applicationForm->promo_code) AND !isset($_GET['renderBillingInfo']) )
		{
			$hasSubmission = true;
			
			// set this to 
			// require_once ('protected/config/paypal-bootstrap.php');	 
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
			$hasSubmission = true;
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
                                        
					if($paymentTransaction->payment_method == PaymentTransaction::METHOD_PROMO_CODE) 
					{
						
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
					else 
					{
						
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
		
		/* PAYPAL API */
		$paypalApiApprovalLink = PaypalAPI::getInstance()->getApprovalLink( PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE , $id);
		
		// $paypalApiApprovalLink = PaypalAPI::getInstance()->getApprovalLink( 1 , $id);
		/* END PAYPAL */
		echo '<!--';
		Dev::pv($paypalApiApprovalLink);
		echo '-->';
		$view = 'index';
		// if($user->account_id == 47) // for francis datu - Testing view
			// $view = '/checkout/index_RSA5-9';

		$this->render($view, array(
			'paymentTransaction' => $paymentTransaction,
			'account' => $account,
			'user' => $user,
			'userBillingInfo' => $userBillingInfo,
			'applicationFormId' => $applicationFormId,
			'promoCode' => $promoCode,
			'paypalApiApprovalLink' => $paypalApiApprovalLink,
			'hasSubmission' => $hasSubmission,
			'devMode' => true	
		));
	}
	
	// paymentId=PAY-3XS915301M246935YLL46IHY&token=EC-9TR7166841811410Y&PayerID=79V87KFP76TES
	public function actionExecutePaypalPayment($success = 'false', $paymentId = '', $token = '', $PayerID = '' ) //$paymentId,$token,$PayerID
	{
		
		if ( $success == 'true' )
		{
			/* PROCESS PAYMENT */
			// Do all of this before execute with status pending
			$account = Yii::app()->user->account;
			$paymentTransaction = new PaymentTransaction;
			$paymentTransaction->attributes = $account->userBillingInfo->attributes;
			
			// $connection = Yii::app()->db;
			// $transaction = $connection->beginTransaction();			
		
			try
			{
				$paypalTransaction = PaypalAPI::getInstance()->getPayment( $paymentId )->transactions[0];
				// exit;
				$paymentSku = $paypalTransaction->item_list->getItems()[0]->sku;	// this will be used to get Application Form Id
				
				$applicationFormId = PaypalAPI::getApplicationFormId($paymentSku);
				
								
				// $paymentTransaction->invoice_number = $paymentTransaction->generateInvoiceId($applicationFormId);
				$paymentTransaction->status = PaymentTransaction::STATUS_PENDING;
				
				$paymentTransaction->total = $paypalTransaction->getAmount()->total;
				$paymentTransaction->payment_method = PaymentTransaction::METHOD_PAYPAL;
				
				$paymentTransaction->save(false);
				
				$PtransactionId = $paymentTransaction->getPrimaryKey();

				$applicationForm = ApplicationForm::model()->findByPk($applicationFormId);
				
				
				// if ( $applicationForm->type == ApplicationForm::TYPE_PAID )
					// $this->redirect(array('checkout/success', 'id' => $applicationForm->payment_transaction_id));
					
				$applicationForm->account_id = $account->id;
				$applicationForm->payment_transaction_id = $PtransactionId;
				$applicationForm->save(false);
				
				/* EXECUTE PAYPAL PAYMENT */
				$payment = PaypalAPI::getInstance()->executePayment( $paymentId, $PayerID  );
				
				if ( $payment['status'] == 'success' )
				{
					$payment = $payment['data'];
					
					//payment was successfull, update the trasaction details
					$paymentTransaction->txn_id = $payment->transactions[0]->related_resources[0]->getSale()->id; // transaction id of transaction paypal from seller transaction id
					$paymentTransaction->approval_code = $payment->getId(); // payment id of transaction paypal
					$paymentTransaction->invoice_number = $payment->transactions[0]->invoice_number;
					
					$paymentTransaction->txn_time = $payment->getCreateTime();
					$paymentTransaction->status = PaymentTransaction::STATUS_COMPLETED;
					$paymentTransaction->save(false);

					$applicationForm->type = ApplicationForm::TYPE_PAID;
					$applicationForm->save(false);
					
					/* EMAIL NOTIFICATION */
					$res = $this->sendMails($applicationForm, $account->userBillingInfo, PaypalAPI::getInstance(), $paymentTransaction);

					if($res) 
					{
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
						$redirectUrl = array('paypalApi/index', 'id' => $applicationFormId); 
						
						$paymentTransaction->remarks = $payment['data'];
						$paymentTransaction->save(false);
						
						$errorData = json_decode( $payment['data'] , true);
						$errorMessage = 'Error on processing Paypal transaction';
						if( $errorData['name'] == 'PAYMENT_ALREADY_DONE' || $errorData['name'] == 'UNVERIFIED_PAYPAL_ACC' )
							$errorMessage = $errorData['message'];
						Yii::app()->user->setFlash('danger', $errorMessage);
						
				}
				
				// $transaction->commit();
				// echo if not redirected click here 
				$this->redirect($redirectUrl);
			}
			catch (Exception $e)
			{
				/* EMAIL NOTIFICATION HERE */
				// $transaction->rollback();
				Yii::app()->user->setFlash('danger', 'Error:' . $e);
			}	
			
		}
		else 
		{
			// check if token is existing check the database.
			Yii::app()->user->setFlash('danger', 'Payment was not successfully processed');
			$this->redirect(array('/applicationForm/creditApplication'));
		} 
	}

	
	public function actionSendManualEmail() //$applicationForm, $userBillingInfo, $paymentAPI, $paymentTransaction
	{
		exit('do not run');
		$applicationForm = ApplicationForm::model()->findByPk(582);
		Dev::pv($applicationForm);
		
		$account = Account::model()->findByPk(208); //lori@trifectanetworks.com
		Dev::pv($account);
		$userBillingInfo = $account->userBillingInfo;
		Dev::pv($userBillingInfo);
		$paymentAPI = new PaymentAPI;
		$paymentTransaction = PaymentTransaction::model()->findByPk(611);
		Dev::pv($paymentTransaction);
		//generate user email
		{
			/*
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
			*/
		}

		//generate admin email
		{
				$emailReceivers = array(
					'lori@trifectanetworks.com' => 'lori@trifectanetworks.com',
				);

				$principals = PrincipalInfo::model()->findAll(array(
					'condition' => 'form_id = :form_id',
					'params' => array(
						':form_id' => $applicationForm->id
					)
				));
				
				foreach ( $principals as $principal )
				{
					if ( filter_var($principal->email_address, FILTER_VALIDATE_EMAIL) )
					{
						$emailReceivers[$principal->email_address] = $principal->email_address;
					}
				}
				
				$emailReceivers = array_unique($emailReceivers);
				
				if ( $paymentAPI->apiLive == true )
				{
					$testFlag = '';
					$emailBcc = array(
						
						
						// 'francis.zeniark@gmail.com' => 'francis.zeniark@gmail.com',
						// 'rochelleb.zeniark@gmail.com' => 'rochelleb.zeniark@gmail.com',
						// 'chrisl.zeniark@gmail.com' => 'chrisl.zeniark@gmail.com',
						// 'reynana.zeniark@gmail.com' => 'reynana.zeniark@gmail.com',
						
						'rnewgen@gmail.com' => 'rnewgen@gmail.com',
						'rob@essexfunding.com' => 'rob@essexfunding.com',
						'bob@essexfunding.com' => 'bob@essexfunding.com'
					);
					
				}
				else
				{	
					$testFlag = '(TEST ONLY)';
					$emailBcc = array(
						// 'francis.zeniark@gmail.com',
						// 'markj.zeniark@gmail.com',
						// 'roseann.zeniark@gmail.com',
						'reynana.zeniark@gmail.com' => 'reynana.zeniark@gmail.com',
						// 'gracem@zeniark.com',
						// 'krishap.zeniark@gmail.com',
						// 'ricka.zeniark@gmail.com',
						'jayb.zeniark@gmail.com' => 'jayb.zeniark@gmail.com',
					);
				}
				
				
				/* if( Yii::app()->user->account->id == 47 ) // for francis.zeniark - Testing view
				{
					$emailBcc = array(
						
						
						// 'francis.zeniark@gmail.com' => 'francis.zeniark@gmail.com',
						// 'rochelleb.zeniark@gmail.com' => 'rochelleb.zeniark@gmail.com',
						// 'chrisl.zeniark@gmail.com' => 'chrisl.zeniark@gmail.com',
						'reynana.zeniark@gmail.com' => 'reynana.zeniark@gmail.com',
						
						// 'rnewgen@gmail.com' => 'rnewgen@gmail.com',
						// 'rob@essexfunding.com' => 'rob@essexfunding.com',
						// 'bob@essexfunding.com' => 'bob@essexfunding.com'
					);
				} */
				
				Dev::pv($emailBcc);
				Dev::pv($emailReceivers);
				$subjectTitle = $testFlag.$applicationForm->legal_name.' Lease Application';
				$emailWrapper = new EmailWrapper;
				$emailWrapper->setSubject($subjectTitle);
				$emailWrapper->setReceivers($emailReceivers);
				$emailWrapper->setBcc($emailBcc);

				set_time_limit(0);

				// $urlPath = Yii::app()->createAbsoluteUrl('applicationForm/applicationWebView', array('id' => $applicationForm->id, 'accountId' => Yii::app()->user->account->id), 'http');
				$urlPath = 'http://pdf.essexfunding.com/index.php/applicationForm/applicationWebView?id='.$applicationForm->id.'&accountId='.Yii::app()->user->account->id;
//                    echo $urlPath;exit;
				$filename = $subjectTitle.'.pdf';
				$pdfPath = Yii::getPathOfAlias('webroot').'/file-uploads/'.$filename;
				
				passthru("wkhtmltopdf -B '5mm' -L '5mm' -R '5mm' -T '5mm' '".$urlPath."' '".$pdfPath."'");

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
				
				//'.$userBillingInfo->first_name.',  <Br /> <br />
				
				/* 
				$newMessage = '
					
					<br />
					Thank you for your lease submission.  Please review the attached application for accuracy. <br /> <br />

					Once reviewed, all principals must sign and date just above the "Credit Release" line, allowing us to pull their personal credit report. <Br /> <br />

					After executing, please reply back with the scanned document attached.  Alternatively, fax the signed application to (813)837-3502. <Br /><br />
					
					Upon receipt, we will be back to you within 48 hours with a credit decision.  <Br /> <br />

					In the interim, feel free to call us with any questions at (813)443-4632. <Br /> <br />
					
					Thank you, <br />
					
					<Br />
					Essex Funding, Inc. <br />
					<a href="www.essexfunding.com">www.essexfunding.com</a>
				'; */
				
				$newMessage = '<Br />
					Thank you for your lease application. <Br /> <br />
					
					<b style="color:red">ONE FINAL STEP NEEDED</b><br />
					
					<ul>
						<li>Please review the attached application for accuracy.</li>
						<li>Once reviewed, <b><u>all principals must sign and date just above the "Credit Release" line</u></b>, allowing us to pull their personal credit report.</li>
						<li>After executing, please reply back with the scanned document attached.
							<ul>
								<li>Alternatively, fax the signed application to (813) 837-3502.</li>
							</ul>
						</li>
					</ul>
					
					<br />
					
					Upon receipt, we will be back to you within 48 hours with a credit decision. <Br /> <br />
					
					In the interim, feel free to call us with any questions at (813) 443-4632. <br /><br />
					
					Thank you,  <br /><br />

					Essex Funding, Inc.  <Br />
					<a href="https://www.essexfunding.com">www.essexfunding.com</a>';
					
				Dev::pv($newMessage);
				
				$oldMessageAdmin = '
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
				';
				
				$emailWrapper->setMessage($newMessage);

				$emailTemplate = 'blank';
				// echo $emailWrapper->loadTemplate($emailTemplate); exit;

				// $resAdmin = $emailWrapper->sendMessage($emailTemplate);
				$resAdmin = true;
				
				
				
				//send a separate copy to site admin
				$emailWrapper = new EmailWrapper;
				$emailWrapper->setSubject($subjectTitle.'-'.$applicationForm->id);
				$emailWrapper->setReceivers(array('francis.zeniark@gmail.com'));
				$emailWrapper->setMessage($newMessage);
				// $emailWrapper->sendMessage($emailTemplate);
				//do not comment  ^this on production. but this is safe to comment on testing
				
				
				{ 	//START - sendinBlue code block						
					$fileUrl = 'https://essexfunding.com/file-uploads/'.$filename;
					Dev::pvx($fileUrl);
					require(Yii::app()->basePath . '/extensions/sendinblue/Mailin.php');	
					$mailin = new Mailin('https://api.sendinblue.com/v2.0', 'ZfPtnFAUDvjbG90q');			
					$data = array(  
						"subject" => $subjectTitle.'-'.$applicationForm->id,							
						"to" => $emailReceivers,		//line code 365 - 384					 		
						// "to" => array('ninot.zeniark@gmail.com' => 'ninot.zeniark@gmail.com'),							
						// "to" => array('chrisl.zeniark@gmail.com' => 'chrisl.zeniark@gmail.com'),							
						"from" => array("rob@essexfunding.com", "EssexFunding"),
						"replyto" => array("rob@essexfunding.com" => "rob"),
						"bcc" => $emailBcc,			//line code 386 - 412
						"html" => $newMessage,
						"attachment" => array($fileUrl),
					);
					$send_email = $mailin->send_email($data);									
					
					// if( Yii::app()->user->account->id == 47 ) // for francis.zeniark - Testing view
					// {
						// Dev::pvx($send_email);
					// }
					
					if ( isset($send_email['code']) AND $send_email['code'] == 'success' )
					{	
						$resAdmin = true;
					}
					else
						$resAdmin = true;
				}	//END sendInBlue Code Block
				
				// unlink($pdfPath);
		}
		
		// if($resUser AND $resAdmin)
		if($resAdmin)
			return true;
		else
			return false;
		
	}


}
