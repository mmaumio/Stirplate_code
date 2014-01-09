<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// define path to assets
Yii::setPathOfAlias('assets', realpath(dirname(__FILE__) . '/../../assets'));

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'StirplateIO',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'stirplateio',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
//			'ipFilters'=>array('127.0.0.1','::1'),
		),
        //'demo' // Yii on Google App Engine demo module
	),

	// application components
	'components'=>array(
                'assetManager'=>array(
                    'class'=>'application.components.CGAssetManager',
                    'basePath'=>'gs://temp__dev',
                    'baseUrl'=> 'http://storage.cloud.google.com/temp__dev'
		// KG edited out on 1/4/13. Changes from f2fce44b001c4ec5dde1b76c84bd0345606eb751 commit  
        //            'basePath'=>Yii::getPathOfAlias('assets'),
        //           'baseUrl'=> '/assets'
                ),
                'request'=>array(
                    'baseUrl' => '/',
                    'scriptUrl' => '/',
                ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        'loginUrl'=>array('site/index'),
		),
       
		
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'baseUrl'=>'', // added to fix URL issues under Google App Engine
			'rules'=>array(
				'dashboard' => 'project/dashboard',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<user:\w+>'=>'user/profile',
			),
		),



//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		'db'=>array(
	//		KG comment: The following line connects the app w/ the cloudsql database, does not work w/ local copy
		//	'connectionString' => 'mysql:unix_socket=/cloudsql/stirplateio:db4;dbname=omniscience',
		// Uncomment the following to use a local copy of the DB(located in the repo)
			'connectionString' => 'mysql:host=localhost;dbname=omniscience',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'newpassword11',
			'charset' => 'utf8',
		),
		
		'session' => array (
			'class' => 'system.web.CDbHttpSession',
			'connectionID' => 'db',
			'sessionTableName' => 'omniscience.tempsession',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
//					'class'=>'CFileLogRoute', // default
					'class'=>'CSyslogRoute', // log errors to syslog (supported by Google App Engine)
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
            
                'mail' => array(
 			'class' => 'ext.yii-mail.YiiMail',
			'transportType' => 'php',
 			'viewPath' => 'application.views.mail',
 			'logging' => true,
 			'dryRun' => false
 		),
                   //added by KG 1/4/13
//                        'clientScript'=>array(
//                   'class' => 'CClientScript',
//                   'scriptMap' => array(
//                     'jquery.min.js' => false
//                   )
//                )
		
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'webengageLicenseCode' => '~99198d06',
		'gaId' => 'UA-42897925-2',
		'gaDomain' => 'appspot.com',
		'mandrilKey' => 'yCf02-rOhL7JGHEii0eqDg',
		//'filepickerioapikey' => 'APipHjEy4SYCn4SfbVvUzz',
		'filepicker'=>array('api_key'=>'Ak5y64NaQW4XUby4g17mgz','app_secret'=>'QU22TYAZRRAYHHFFIJUZVGTH24'),
		'emailNotifications' => true,
		//'boxfolderid' => 1302694889,
		//'boxclientid' => '58l43p0xw5nv4vqpakexbg4iajqsadfh',
		//'boxclientsecret' => 'NwDCRMooJATY9pFv5ROl3bWRjcEGpqvZ',
		'mailChimpApiKey' => 'dff5a7e5f0ef8a7c5b2d077b4c525def-us7',
		'mailChimpListId' => '64a24c221c',

        //constants
        'FAILURE' => 0,
        'SUCCESS' => 1,
        'ERROR' => 2,
    ),
);