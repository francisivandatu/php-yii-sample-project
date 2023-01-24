<?php
class PaymentAPI
{
	CONST PAYMENT_CREDIT_APPLICATION_PRICE = "95";
	// CONST PAYMENT_CREDIT_APPLICATION_PRICE = "5";
	public $apiLive = true;
	// public $apiLive = false;
	
	public $apiCredentials;
	public $apiPostHeader = '/wswebservices/transact.asmx HTTP/1.1';
	public $apiServiceUrl = 'https://trans.slimcd.com/wswebservices/transact.asmx/PostXML';
	public $currencySymbol = '$';
	
	public function __construct()
	{
		if( (bool)$this->apiLive === true )
		{
			$this->apiCredentials = array(
				'clientid' => 2222222,
				'siteid' => 222222,
				'priceid' => 222222, 
				'password' => '222222',
				'ver' => 'v1.0',
				'product' => 'Funding Credit Application',
				'key' => '222222',
			);
		}
		else
		{
			$this->apiCredentials = array(
				'clientid' => 222222,
				'siteid' => 22222,
				'priceid' => 222222, 
				'password' => '222222',
				'ver' => 'v1.0',
				'product' => 'Funding Credit Application',
				'key' => '222222',
			);
		}
	}
	
	public function doPayment ( $dataFields = array() )
	{	
		{//start building the complete xml formatted string
			$xmlData = '<request>'.self::arrayToXMLFormat($dataFields).'</request>';
			// $xmlData = $this->soapPostStructure($xmlData);
			$xmlData = $this->formPostStructure($xmlData);
		}//end format
		
		$serviceUrl = $this->apiServiceUrl;
		
		$xmlResponse = $this->postXML($serviceUrl, $xmlData);
		// Dev::pvx($xmlResponse);
		return $xmlResponse;
	}
	
	/* 
	 * Pass the complete data to the api service url
	*/
	public function postXML ($serviceUrl, $xmlPostFields = '' )
	{
		//headers
		$headers = array(
			'POST '.$this->apiPostHeader,
			'Host: trans.slimcd.com',
			// 'Content-Type: application/soap+xml; charset=utf-8',
			'Content-Type: application/x-www-form-urlencoded',
			'Content-Length: '.strlen($xmlPostFields),			
		);
		
		//cURL call
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_URL, $serviceUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPostFields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch); 
		curl_close($ch);
		
		// echo $response; exit;
		
		//clean to make in xml readable
		// $response = str_replace(array("<reply>","</reply>"),"",$response);
		
		// echo $response;exit;
		
		// converting to XML
		$xmlResponse = simplexml_load_string($response);
		// Dev::pvx($xmlResponse);
		
		// $_SESSION['temptrans'] = $xmlResponse;	
		return $xmlResponse;
	}
	
	/* 
	 * build complete xml post main structure 
	*/
	public function soapPostStructure($xmlData)
	{
		$returnString = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><PostXML xmlns="http://tempuri.org/TransGateway/Transact">';
	
		$returnString .= '<clientid>'.$this->apiCredentials['clientid'].'</clientid>';
		$returnString .= '<siteid>'.$this->apiCredentials['siteid'].'</siteid>';
		$returnString .= '<priceid>'.$this->apiCredentials['priceid'].'</priceid>';
		$returnString .= '<password>'.$this->apiCredentials['password'].'</password>';
		$returnString .= '<ver>'.$this->apiCredentials['ver'].'</ver>';
		$returnString .= '<product>'.$this->apiCredentials['product'].'</product>';
		$returnString .= '<key>'.$this->apiCredentials['key'].'</key>';
		$returnString .= '<XMLData>'.$xmlData.'</XMLData>';
		
		$returnString .= '</PostXML></soap12:Body></soap12:Envelope>';
		return $returnString;
	}
	
	/* 
	 * build complete form post main structure 
	*/
	public function formPostStructure($fieldData)
	{
		return 'clientid='.$this->apiCredentials['clientid'].'&siteid='.$this->apiCredentials['siteid'].'&priceid='.$this->apiCredentials['priceid'].'&password='.$this->apiCredentials['password'].'&ver='.$this->apiCredentials['ver'].'&product='.$this->apiCredentials['product'].'&key='.$this->apiCredentials['key'].'&XMLData='.$fieldData;
	}
	
	/* 
	 * builds a xml string query from a key => value pair array
	*/
	public function arrayToXMLFormat($data, $prime = null)
	{
		$return = '';
		foreach($data as $key=>$raw)
		{
			$stringData = '';
			$keyString = $key;
			$headeBool = true;
			if(is_numeric($key) && $prime != null)
			{
				$keyString = $prime;
			}
			if(is_array($raw))
			{
				if(!empty($raw) && array_key_exists(0,$raw))
				{
					//for multiple layers of the same keystring
					$stringData .= self::buildQuery($raw,$keyString);
					$headeBool = false;
				}
				else
				{
					$stringData .= self::buildQuery($raw);
				}
			}
			else
			{
				$stringData .= $raw;					
			}
			if($headeBool)
			{
				$return .= '<'.$keyString.'>';
					$return .= $stringData;
				$return .= '</'.$keyString.'>';
			}
			else
			{
				$return .= $stringData;
			}
		}
		return $return;
	}
	
	public function getResponseToArray($xmlObjData)
	{
		$dataBlock = $xmlObjData->{'datablock'};
		return array(
			'txn_id' => (string)$dataBlock->{'gateid'},
			'approval_code' => (string)$dataBlock->{'authcode'},
			'total' => (string)$dataBlock->{'approvedamt'},
		);
	}
	
	public function validateResponse( $xmlObjData )
	{
		$result = array(
			'status' => false,
			'statusDesc' => 'Invalid Transaction',
		);
		
		if ( $xmlObjData->{'response'} == 'Success' )
		{
			$result['status'] = true;
			$result['statusDesc'] = 'OK';
		}
		else
		{
			$result['statusDesc'] = $xmlObjData->{'description'};
		}
		
		return $result;
	}
}
