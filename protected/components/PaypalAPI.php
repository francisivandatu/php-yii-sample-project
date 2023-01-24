<?php
class PaypalAPI
{
	public $apiLive = true;
	// public $apiLive = false;
	 
	public $apiContext;

	CONST RETURN_URL = "https://essexfunding.com/index.php/checkout/executePaypalPayment?success=true";
	CONST CANCEL_URL = "https://essexfunding.com/index.php/checkout/executePaypalPayment?success=false";
	
	CONST PAYMENT_INTENT = "sale";
	CONST CURRENCY = "USD";
	
	
	// Hold an instance of the class
    private static $instance;
	
	public function __construct()
	{
		require_once('PayPal-PHP-SDK/autoload.php');
		
		/* 
		Sandbox Facilitator Account:
		rob-facilitator@essexfunding.com / zeniark_admin

		Sandbox Buyer Account:
		rob-buyer@essexfunding.com / zeniark_admin
		*/
		
		
		if( (bool)$this->apiLive === true )
		{
			# Live Account: rob@essexfunding.com
			$this->apiContext = new \PayPal\Rest\ApiContext(
					new \PayPal\Auth\OAuthTokenCredential(
						'222222222',     // ClientID
						'222222222'      // ClientSecret
					)
			);
			

		}
		else
		{
			$this->apiContext = new \PayPal\Rest\ApiContext(
					new \PayPal\Auth\OAuthTokenCredential(
							
						
						#Client Sandbox
						// '22222222',     // ClientID
						// '22222222'      // ClientSecret
					)
			);
		}
		
		$this->apiContext->setConfig( 
			  array(
				//comment this if sandbox
				'mode' => 'live',
				'cache.enabled' => true, 
				'cache.FileName' => 'protected/runtime/PayPal.cache',
		 
				// change this accordingly 
				'log.LogLevel' => 'FINE',	//prod    //FINE //DEBUG
				// 'log.LogLevel' => 'DEBUG',	//sandbox //FINE  //DEBUG
				
				//do not touch 
				'log.LogEnabled' => true,
				'log.FileName' => 'protected/runtime/PayPal.log',
				
			  )
		);
	}
	
	public static function getInstance()
	{
		if( !isset(self::$instance) )
			self::$instance = new PaypalAPI;
		return self::$instance;
	}
	
	public function getApprovalLink( $totalAmount, $applicationFormId )
	{
		
		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod('paypal');

		$skuAppFormId = "APPFORMID".$applicationFormId;
		
		/* Refactor - Item add setItem array */
		$item = new \PayPal\Api\Item;
		$item->setName('Funding Credit Application Processing Fee')
			->setCurrency(self::CURRENCY)
			->setQuantity(1)
			->setSku($skuAppFormId)
			->setPrice($totalAmount); 
			
		$itemList = new \PayPal\Api\ItemList;
		$itemList->setItems(array($item));

		$amount = new \PayPal\Api\Amount();
		$amount->setTotal($totalAmount);
		$amount->setCurrency(self::CURRENCY);

		$transaction = new \PayPal\Api\Transaction();
		$transaction->setAmount($amount)
					->setItemList($itemList)
					->setDescription('Funding Credit Application Processing Fee')
					->setInvoiceNumber(uniqid());

		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl(self::RETURN_URL)
			->setCancelUrl(self::CANCEL_URL);

		$payment = new \PayPal\Api\Payment();
		$payment->setIntent(self::PAYMENT_INTENT)
			->setPayer($payer)
			->setTransactions(array($transaction))
			->setRedirectUrls($redirectUrls);
			
		try 
		{
			$payment->create($this->apiContext);
			
			return $payment->getApprovalLink();
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) 
		{
			// This will print the detailed information on the exception.
			//REALLY HELPFUL FOR DEBUGGING
			return $ex->getData();
		}
		
	}
	
	
	public function getPayment($paymentId)
	{
		return $payment = \PayPal\Api\Payment::get($paymentId, $this->apiContext);
	}
	
	public function executePayment($paymentId, $payerID )
	{
		$payment = \PayPal\Api\Payment::get($paymentId, $this->apiContext);
		
		$execution = new \PayPal\Api\PaymentExecution();
		$execution->setPayerId( $payerID );
		
		$status = 'error';
		
		try 
		{
			
			$result = $payment->execute($execution, $this->apiContext);
			
			try 
			{
				$payment = \PayPal\Api\Payment::get($paymentId, $this->apiContext);
				
			} 
			catch (Exception $ex) 
			{
				$status = 'error';
				$data = $ex->getData( );
			}
			
			if( $payment->state== 'approved' )
			{
				$data = $payment;
				$status = 'success';
			}
			else
			{
				$data = json_encode(array('name' => 'UNVERIFIED_PAYPAL_ACC' ,
											'message' => 'Unverified Paypal account. Cannot process transaction, payment was not executed.'
											));
				$status = 'error';
			}
				
			
		}
		catch (Exception $ex) 
		{
			$status = 'error';
			$data = $ex->getData( );
			// Dev::pvx($ex); // Detailed error with codes
		}

		
		$return = array('status' => $status, 'data' => $data );
		return $return;
	}

	public static function getApplicationFormId($sku)
	{
		return str_replace('APPFORMID','',$sku);
	}
}
