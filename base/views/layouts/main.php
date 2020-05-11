<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="css/tm_reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/tm_style.css"> <!-- Resource style -->
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
			display: block;
		}

		.invisible {
			display: none;
		}

		.no-js #loader {
			display: none;
		}

		.js #loader {
			display: block;
			position: absolute;
			left: 100px;
			top: 0;
		}

		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(images/loading.gif) center no-repeat #fff;
		}

		.topleft {
			max-width: 600px;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.topleft:after {
			display: block;
			font-weight: bold;
			content: " ... ";
			position: absolute;
			bottom: 0;
			right: 0;
			background: #fff;
		}
	</style>
</head>

<body>
	<div class="se-pre-con"></div>
	<table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td style="vertical-align:top;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" class="nav-table" height="25">

					<tr class="topbar">
						<td colspan="3">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<?php if (isset(Yii::app()->user->id) && isset(Yii::app()->user->dept)) { ?>
										<td title="<?php
													if (count(Yii::app()->user->roles)) {
														$rr = array();
														foreach (Yii::app()->user->roles as $r)
															$rr[] = $r['rolename'];
														echo implode($rr, ", ");
													} else echo "None"; ?>" class="topleft">

											<?php if (Yii::app()->user->details->username != Yii::app()->user->passwd)
												$d = "<strong>" . Yii::app()->user->passwd . "</strong> on behalf of ";
											?>
											Logged in as: <?php echo $d ?><?php echo Yii::app()->user->details->names; ?> (Section: <?php echo Yii::app()->user->dept->section; ?>)

											Roles:
											<?php
											if (count(Yii::app()->user->roles)) {
												$rr = array();
												foreach (Yii::app()->user->roles as $r)
													$rr[] = $r['rolename'];
												echo implode($rr, ", ");
											} else
												echo "None";

											$htt = "";
											$budts = app()->db->CreateCommand("select * from budgets")->queryAll();
											foreach ($budts as $bt) {
												if ($_POST['mybd'] == $bt[id]) user()->budget = $bt;
												$sel = $bt[id] == user()->budget['id'] ? "selected=selected" : "";
												$htt .= "<option value='$bt[id]' $sel>$bt[name]</option>";
											}
											?>

										</td>
										<td>Budget: <b><?php echo Yii::app()->user->budget['name']; ?></b> </td>
										<td>
											<form method='post' style='margin:0px;'>Change Budget View:<select name='mybd'><?php echo $htt; ?>
												</select><input type='submit' value='Change Budget' /></form>
										</td>
									<?php } ?>
									<td class="topright">
										<?php $this->widget('zii.widgets.CMenu', array(
											'items' => array(
												array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
												array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
											),
											'htmlOptions' => array('class' => 'menuClass')

										)); ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td style="padding:0 0 0 10px;vertical-align:bottom;background-color:#fff;border-top:1px solid #ccc;border-bottom:3px solid #3D89BB;" rowspan="2">
							<div class="logo">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/uetcl_logo.png" width="150" title="Uganda Electricity Transmission Company Limited (UETCL): Budget Information System (BIS)" />
							</div>
						</td>
						<td style="border-top:1px solid #aaa;background-color:#fff;">&nbsp;</td>
					</tr>
					<tr>
						<td style="vertical-align: bottom;background-color:#fff;border-bottom:3px solid #3D89BB;">
							<div id="tabbar">
								<?php require('menu.php'); ?>
							</div>

						</td>

					</tr>

				</table>
			</td>
		</tr>
		<!-- end of header -->
		<!-- begin body -->
		<tr>
			<td valign="top">
				<?php /* if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif */ ?>

				<style>
				</style>
				<table width=100% cellpadding="0" cellspacing="0">
					<tr>
						<td width=10% class=bg-left>&nbsp;</td>
						<td class=bg222><?php echo $content; ?></td>
						<td width=10% class=bg-right>&nbsp;</td>
				</table>
			</td>
		</tr>
		<tr class=bg-bottom style='padding:-70px'>
			<td style='margin:-70px'>
				<hr />
				<center> Powered by DNT Consults Ltd </center>
			</td>
		</tr>
	</table>
	<script src="js/tm_main.js"></script>
</body>

</html>