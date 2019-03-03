<?php
if(user()->isGuest) {
	header("Location: index.php?r=site/login");
	echo "<script>document.location.href='index.php?r=site/login'</script>";
	exit;
}
if($_REQUEST['print']==1) {
?>
<link rel="stylesheet" type="text/css" href="css/gridview/styles.css">
<link rel="stylesheet" href="css/styles.css" type="text/css">
<center><h1><img src='images/uetcl_logo.png' width=200 /><br/>Uganda Electricity Transmission Company Limited</h1></center>
<hr>
<?php	
}
$path=dirname(__FILE__)."/reports/";	
$p = $_REQUEST['p'] && file_exists($path.$_REQUEST['p'].".php") ? $path.$_REQUEST['p'].".php" : dirname(__FILE__)."/index.php";
if($_REQUEST['old']==1) include($p);	 else include($path.'r.php');	
?>	