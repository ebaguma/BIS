<?php

require(dirname(__FILE__).'/../globals.php');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('chartjs', dirname(__FILE__).'/../extensions/yii-chartjs');
Yii::setPathOfAlias('booster', dirname(__FILE__).'/../components/YiiBooster-master/src');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'UETCL BIS',
	
	// preloading 'log' component
	'preload'=>array(
		'log',
		'booster',	
		'chartjs',
	),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.phpexcel.PHPExcel',
		'ext.yii-mail.YiiMailMessage',
		'ext.YiiMailer.YiiMailer',		
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'session' => array( 
			'class' => 'CDbHttpSession',
			'timeout' => 20000,
			//'autoCreateSessionTable '=> true,
			'connectionID' => 'db',
		),
		'mail' => array(  
					'class' => 'ext.yii-mail.YiiMail',  
					'transportType' => 'php', // change to 'php' when running in real domain.  
					'viewPath' => 'application.views.mail',  
					'logging' => true,  
					'dryRun' => false,  
					'transportOptions' => array(  
					'host' => 'mail.uetcl.com',  
					//'username' => 'myuser',  
					//'password' => 'mypass',  
					//'port' => '25',  
					//'encryption' => 'tls',  
					),  
				),		
		'chartjs' => array('class' => 'chartjs.components.ChartJs'),
		//'booster' => array('class' => 'booster.components.Booster'),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
		),
		
		
		
		'clientScript' => array(
		        'scriptMap' => array(
		            'jquery.js'=>false,  //disable default implementation of jquery
		            'jquery.min.js'=>false,  //desable any others default implementation
		      //      'core.css'=>true, //disable
		       //     'styles.css'=>true,  //disable
		       //     'pager.css'=>false,   //disable
		       //     'default.css'=>true,  //disable
		        ),
		        'packages'=>array(
		            'jquery'=>array(                             // set the new jquery
		                'baseUrl'=>'js',
		                'js'=>array('jquery-1.11.3.js'),
		            ),
		            'booster'=>array(                       //set others js libraries
		                'baseUrl'=>'bootstrap/',
		                'js'=>array('js/bootstrap.min.js'),
		                'css'=>array(                        // and css
		                    'css/bootstrap.min.css',
		                    'css/custom.css',
		                    'css/bootstrap-responsive.min.css',
		                ),
		                'depends'=>array('jquery'),         // cause load jquery before load this.
		            ),
		        ),
		    ),
			 'ePdf' => array(
			         'class'         => 'ext.yii-pdf.EYiiPdf',
			         'params'        => array(
			             'mpdf'     => array(
			                 'librarySourcePath' => 'application.vendors.mpdf.*',
			                 'constants'         => array(
			                     '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
			                 ),
			                 'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
			                 /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
			                     'mode'              => '', //  This parameter specifies the mode of the new document.
			                     'format'            => 'A4', // format A4, A5, ...
			                     'default_font_size' => 0, // Sets the default document font size in points (pt)
			                     'default_font'      => '', // Sets the default font-family for the new document.
			                     'mgl'               => 15, // margin_left. Sets the page margins for the new document.
			                     'mgr'               => 15, // margin_right
			                     'mgt'               => 16, // margin_top
			                     'mgb'               => 16, // margin_bottom
			                     'mgh'               => 9, // margin_header
			                     'mgf'               => 9, // margin_footer
			                     'orientation'       => 'P', // landscape or portrait orientation
			                 )*/
			             ),
			             'HTML2PDF' => array(
			                 'librarySourcePath' => 'application.vendor.html2pdf.*',
			                 'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
			                 /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
			                     'orientation' => 'P', // landscape or portrait orientation
			                     'format'      => 'A4', // format A4, A5, ...
			                     'language'    => 'en', // language: fr, en, it ...
			                     'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
			                     'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
			                     'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
			                 )*/
			             ),
			         ),
			     ),
		
		
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=192.168.7.3;dbname=BIS2',
			'emulatePrepare' => true,
			'username' => 'application',
			'password' => 'application',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, debug',
				),
				// uncomment the following to show log messages on web pages
				
			/*	array(
//					'levels'=>'error, warning, debug',
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),
	//'theme' => 'hebo',
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'wilson@dntconsults.com',
		'ldap' => array(
		 	'host' => '172.16.8.185',
			 'port'	=> '389',
		 	'domain' => 'UETCL'
		),
		
	),
);
