<?php

class LeaseCalculatorController extends Controller
{
	// public $layout = 'dashboard';
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	/* public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions' => array('upload', 'logout'),
				'users' => array('@'),
			),
			array(
				'allow',
				'actions' => array('login', 'register', 'forgotPassword', 'resetPassword', 'error', 'index', 'testEmail'),
				'users' => array('*'),
			),
			array(
				'deny',
				'users' => array('*'),
			),
		);
	} */
	
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
		$leaseCalculatorModel = new LeaseCalculator;
		
		if ( isset($_POST['LeaseCalculator']) )
		{
			$leaseCalculatorModel->attributes = $_POST['LeaseCalculator'];
			$leaseCalculatorModel->status = LeaseCalculator::STATUS_ACTIVE;
			
			$valid = $leaseCalculatorModel->validate();
			
			if ( $valid )
			{
				//do computation here
				$leaseCalculatorModel->computeMonthlyCost();
				
				if ( $leaseCalculatorModel->save(false) )
				{
					$this->redirect(array('/leaseCalculator/result', 'requestId' => $leaseCalculatorModel->getPrimaryKey(), 'token' => strtotime($leaseCalculatorModel->date_created)));
				}
			}
		}
		
		$this->render('index', array(
			'leaseCalculatorModel' => $leaseCalculatorModel
		));
	}
	
	public function actionResult ( $requestId, $token )
	{
		$leaseCalculatorModel = LeaseCalculator::model()->findByPk($requestId,array(
			'condition' => 'date_created = :date_created',
			'params' => array(
				':date_created' => date('Y-m-d H:i:s', (int)$token)
			)
		));
		
		if ( !$leaseCalculatorModel )
		{
			Yii::app()->user->setFlash('danger','Invalid request. Please try again.');
			$this->redirect(array('/leaseCalculator/'));
		}
			
		$leaseCalculatorUserModel = new LeaseCalculatorUser;
		
		if ( isset($_POST['LeaseCalculatorUser']) )
		{
			//check if the user already submitted the form and already has a record
			$_leaseCalculatorUserModel = LeaseCalculatorUser::model()->find(array('condition' => 'lease_calculator_id = '.$requestId));
			if ( $_leaseCalculatorUserModel )
				$leaseCalculatorUserModel = $_leaseCalculatorUserModel;
			else
				$leaseCalculatorUserModel->lease_calculator_id = $leaseCalculatorModel->id;
		
			$leaseCalculatorUserModel->attributes = $_POST['LeaseCalculatorUser'];
			$leaseCalculatorUserModel->status = LeaseCalculatorUser::STATUS_ACTIVE;	
			
			$validate = $leaseCalculatorUserModel->validate();
			
			if ( $validate )
			{
				if ( $leaseCalculatorUserModel->save(false) )
				{
					$leaseMonthlyCost = $leaseCalculatorModel->getMonthlyInvoiceRange();
					
					{  //generate user email
					
						$emailWrapper = new EmailWrapper;
						$emailWrapper->setSubject('Essex Funding Lease Calculator');
						$emailWrapper->setReceivers(array(
								$leaseCalculatorUserModel->email_address,
						));
						
						$emailWrapper->setBcc(array(
							'francis.zeniark@gmail.com'
						));
						
						$emailMessage = 'Hi '.$leaseCalculatorUserModel->first_name.', <br /><Br />
							Thank you for inquiring about lease financing with Essex Funding. <Br />
							Here\'s an overview of details you provided us:
							
							<ul>
								<li>Total Invoice amount to be leased: <strong>$'.number_format($leaseCalculatorModel->initial_invoice_amount, 2).'</strong></li>
								<li>Desired Term of Lease: <strong>'.$leaseCalculatorModel->getPaymentTermLabel($leaseCalculatorModel->term).'</strong></li>
							</ul>
							 
							We estimate that monthly lease payment on this invoice would range from <u>$'.number_format($leaseMonthlyCost['rangeFrom']).'</u> to <u>$'.number_format($leaseMonthlyCost['rangeTo']).'</u> depending on your business and personal credit. <Br />
							<Br />
							An account representative is reviewing your information and will contact you shortly. <br />
							
							<Br />
							Essex Funding, Inc. <br />
							<a href="www.essexfunding.com">www.essexfunding.com</a>
						';
					
						$emailWrapper->setMessage($emailMessage);

						$emailTemplate = 'blank';
						// echo $emailWrapper->loadTemplate($emailTemplate);

						$resUser = $emailWrapper->sendMessage($emailTemplate);
					}
					
					{	//generate admin email
						
						$emailWrapper = new EmailWrapper;
						$emailWrapper->setSubject('Essex Funding Lease Calculator - Admin Notification');
						$emailWrapper->setReceivers(array(
								// 'gracem.zeniark@gmail.com',
								
								// 'francis.zeniark@gmail.com',
								// 'reynana.zeniark@gmail.com',
								// 'rnewgen@gmail.com',
								
								'rob@essexfunding.com',
								'bob@essexfunding.com'
								
						));
						$emailWrapper->setBcc(array(
							'reynana.zeniark@gmail.com',
							'francis.zeniark@gmail.com'
						));

						$emailMessage = 'Hi Admin, <br /><Br />
							Someone submitted the Lease Calculator Web Form: <br />
							
							<table>
								<tr>
									<td>First Name:</td>
									<td>'.$leaseCalculatorUserModel->first_name.'</td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td>'.$leaseCalculatorUserModel->last_name.'</td>
								</tr>
								<tr>
									<td>Company:</td>
									<td>'.$leaseCalculatorUserModel->company.'</td>
								</tr>
								<tr>
									<td>Email Address:</td>
									<td>'.$leaseCalculatorUserModel->email_address.'</td>
								</tr>
								<tr>
									<td>Phone:</td>
									<td>'.$leaseCalculatorUserModel->phone.'</td>
								</tr>
								<tr valign="bottom">
									<td>Total Invoice Amount: </td>
									<td>$'.number_format($leaseCalculatorModel->initial_invoice_amount,2).'</td>
								</tr>
								<tr>
									<td>Term (years): </td>
									<td>'.$leaseCalculatorModel->getPaymentTermLabel($leaseCalculatorModel->term).'</td>
								</tr>
								<tr>
									<td>Generated Monthly Cost: </td>
									<td>$'.number_format($leaseCalculatorModel->result_monthly_cost,2).'</td>
								</tr>
								<tr>
									<td>Estimated Range:</td>
									<td>$'.number_format($leaseMonthlyCost['rangeFrom']).' to $'.number_format($leaseMonthlyCost['rangeTo']).'</td>
								</tr>
								<tr>
									<td colspan="2">Comments: <Br /> '.nl2br($leaseCalculatorUserModel->comments).'</td>
								</tr>
							</table>
							
							<Br />
							Essex Funding, Inc. <br />
							<a href="www.essexfunding.com">www.essexfunding.com</a>
						';
					
						$emailWrapper->setMessage($emailMessage);
						
						$emailTemplate = 'blank';
						// echo $emailWrapper->loadTemplate($emailTemplate); exit;

						$resUser = $emailWrapper->sendMessage($emailTemplate);
					}
					
					Yii::app()->user->setFlash('success', 'Your message has been successfully sent! We will get back to you soon.');
					$this->redirect(array('/leaseCalculator/result', 'requestId' => $requestId, 'token' => $token));
				}
			}
			
		}
		
		$this->render('resultPage', array(
			'leaseCalculatorModel' => $leaseCalculatorModel,
			'leaseCalculatorUserModel' => $leaseCalculatorUserModel,
		));
	}
	
	public function actionTestEmail()
	{
		
		$emailWrapper = new EmailWrapper;
		$emailWrapper->setSubject('EZ Mulch, Inc. Lease Application');
		// $emailWrapper->setReceivers(array('francis.zeniark@gmail.com'));
		$emailWrapper->setReceivers(array('dickcompton@hotmail.com'));
		// $emailWrapper->setReceivers($emailReceivers);
		// $emailWrapper->setBcc($emailBcc);

		set_time_limit(0);

		$urlPath = Yii::app()->createAbsoluteUrl('applicationForm/applicationWebView', array('id' => 389, 'accountId' => 124));
//                    echo $urlPath;exit;
		$filename = 'EZ Mulch, Inc. Lease Application'.'.pdf';
		$pdfPath = Yii::getPathOfAlias('webroot').'/file-uploads/'.$filename;
		
		  passthru("wkhtmltopdf -B '5mm' -L '5mm' -R '5mm' -T '5mm' '".$urlPath."' '".$pdfPath."'");
		
		$emailWrapper->setAttachment($pdfPath);
		
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
		
		echo $newMessage;
		
		 $emailWrapper->setMessage($newMessage);

		$emailTemplate = 'blank';
		// echo $emailWrapper->loadTemplate($emailTemplate); exit;

		$resAdmin = $emailWrapper->sendMessage($emailTemplate);
		
		// unlink($pdfPath);
	}
}
