
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

<?php /* ?>	<link rel="stylesheet" href="css/tm_reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/tm_style.css"> <!-- Resource style -->
<?php */ ?>
	<script src="js/tm_modernizr.js"></script> <!-- Modernizr -->
  	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<script src="js/accounting.js"></script>
<?php /*
<!--
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.17/angular.min.js" data-semver="1.2.17" data-require="angular.js@1.2.17"></script>
<script src="js/formatNumber.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

<script src="js/crt.js"></script>-->
 */ ?>
	<!-- blueprint CSS framework -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" type="text/css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jq/colorbox.css" type="text/css">
<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/css/favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/gridview/styles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/detailview/styles.css" />
<script>	
$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
	$(document).ready(function() {
		if ($("body").height() > $(window).height()) {
	        $("#btt").addClass('visible');
	    } else
		 $("#btt").addClass('invisible');
	});
</script>
<style>
.visible {
	display:block;
}
.invisible {
	display:none;
}

.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(images/loading.gif) center no-repeat #fff;
}
.cd-timeline-img,hr {
	display:none;
}
.cd-timeline-block {
	border-bottom:1px solid black;
}
h2 {
	font-size:13px;
	font-weight:bold;
}
</style>
</head>
<body align='center' style='text-align:center'>

<table width=100% cellpadding="0" cellspacing="0" style='border:1px solid;text-align:center'>
	<tr><td width=1% class=bg-left>&nbsp;</td>
		<td style='background-color:#ffffff !important'><?php echo $content; ?></td>
		<td width=1% class=bg-right>&nbsp;</td>
	</tr>
</table>
<?php /* ?> <script src="js/tm_main.js"></script><?php */ ?>
</body>
</html>
