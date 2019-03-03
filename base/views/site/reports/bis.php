<?php
$path=dirname(__FILE__)."/reports/";	

$p = $_REQUEST['p'] && file_exists($path.$_REQUEST['p'].".php") ? $path.$_REQUEST['p'].".php" : dirname(__FILE__)."/index.php";
include($p);	
?>	