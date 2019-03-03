<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Budget Locked';
$this->breadcrumbs=array(
	'Budget Locked',
);
?>

<h2>Budgeting is <span style='color:red'>LOCKED</span></h2>

<div class="error" style='color:red'>
	<br/>
The budget is locked, your changes have <strong>NOT</strong> been saved. If you still need more assistance, please contact the administratror.
<br/><br/><br/>
</div>