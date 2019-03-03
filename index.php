<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/base/config/main.php';
date_default_timezone_set('Africa/Kampala');
setlocale(LC_MONETARY, 'en_US.UTF-8');
//Turn off notices
define("YII_ENABLE_ERROR_HANDLER",false);
define("YII_ENABLE_EXCEPTION_HANDLER",false);
error_reporting(E_ALL ^ E_NOTICE);
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',9);

require_once($yii);
$app = Yii::createWebApplication($config);

Yii::import('ext.yiiexcel.YiiExcel', true);
Yii::registerAutoloader(array('YiiExcel', 'autoload'), true);

// Optional:
//  As we always try to run the autoloader before anything else, we can use it to do a few
//      simple checks and initialisations
//PHPExcel_Shared_ZipStreamWrapper::register();

if (ini_get('mbstring.func_overload') & 2) {
	throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
}
//PHPExcel_Shared_String::buildCharacterSets();

// Define the constants
$sc=Yii::app()->db->createCommand("Select * from roles")->queryAll();
foreach($sc as $rl)
	define ($rl['constantname'], $rl['id']);

//Now you can run application
//echo "ok!";
$app->run();
