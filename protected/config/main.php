<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Essex Funding',
	'preload'=>array('log'),

	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'modules'=>array(
		'admin' => array(),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	'components'=>array(
		'input' => array(
			'class' => 'CmsInput',  
			'cleanPost' => false,  
			'cleanGet' => false,   
		),
		'user'=>array(
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// 'db'=>array(
			// 'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=essex_funding_db',
			'emulatePrepare' => true,
			'username' => 'essex_funding',
			'password' => '1cSa2m3^',
			'charset' => 'utf8',
			'tablePrefix' => 'essex_',
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	'params'=>array(
		'adminEmail'=>'webmaster@example.com',
	),
);