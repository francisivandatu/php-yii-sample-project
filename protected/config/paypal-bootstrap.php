<?php 

require_once('PayPal-PHP-SDK/autoload.php');		//this path is in the outside part of the app root

$apiLive = false;
 
$apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'Ae5LYsuN5BtittGEbtbpsmtdvb0UKJbcm_mg4l_tXLN3FLTYyYUVakOh-SS8crFqYDpznGrGAqRZFGIN',     // ClientID
            'EJqxHCTrBPSPr0PlSGQysgnh1xjok_lQv6wgz0PMkGKKo9Ff2gHYI6A87KODPgPhT5I9QynDuwjy6PgT'      // ClientSecret
        )
);

/* $apiContext->setConfig( 
	  array(
		//comment this if sandbox
		'mode' => 'test',
		'cache.enabled' => true,
 
		// change this accordingly 
		// 'log.LogLevel' => 'FINE',	//prod    //FINE //DEBUG
		'log.LogLevel' => 'DEBUG',	//sandbox //FINE  //DEBUG
		
		//do not touch 
		'log.LogEnabled' => true,
		'log.FileName' => 'protected/runtime/PayPal.log',
		
	  )
); */