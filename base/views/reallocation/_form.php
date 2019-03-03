<h1>Request a Budget Re-Allocation</h1>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'procurement-spending-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<table><tr><th>Re-allocation from:</th><th><table style='width:600px;border:0px solid'><tr>
	<th style='width:300px;border:1px solid'>Original Budget</th>
	<th style='width:300px;border:1px solid'>Current Budget</th>
	<th style='width:300px;border:1px solid'>Budget Subtract</th>
	<th style='width:300px;border:1px solid'>New Budget</th></tr></table></th></tr>
		<tr><td>
		<?php echo $form->dropDownList($model,'acfrom',Chtml::ListData(AccountCodes::model()->findAll("accountcode regexp '^4'"),'id','item'),array(
	'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('Reallocation/itemfrom'), 
	'update'=>'#ProcurementSpending_items_from',
	))); ?>
		<?php echo $form->error($model,'acfrom'); ?>
	</td><td id='ProcurementSpending_items_from'><table  istyle='width:600px;border:1px solid'><tr>
		<td style='width:300px;border:1px solid'>0</td>
		<td style='width:300px;border:1px solid'>0</td>
		<td style='width:300px;border:1px solid'>0</td>
		<td style='width:300px;border:1px solid'>0</td></tr></table></td></tr>
<tr><td colspan=2></td></tr>
<tr><th>Re-allocation To:</th><th><table style='width:600px;border:0px solid'><tr>
	<th style='width:300px;border:1px solid'>Original Budget</th>
	<th style='width:300px;border:1px solid'>Current Budget</th>
	<th style='width:300px;border:1px solid'>Budget Add</th>
	<th style='width:300px;border:1px solid'>New Budget</th></tr></table></th></tr>
		<tr><td>

		<?php echo $form->dropDownList($model,'acto',Chtml::ListData(AccountCodes::model()->findAll("accountcode regexp '^4'"),'id','item'),array(
	'id'	=>'hdhbjdhdj',
	'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('Reallocation/itemto'), 
	'update'=>'#ProcurementSpending_items_to',
	))); ?>
		<?php echo $form->error($model,'acto'); ?></td><td id='ProcurementSpending_items_to'>
	<table  istyle='width:600px;border:1px solid'><tr>
			<td style='width:300px;border:1px solid'>0</td>
			<td style='width:300px;border:1px solid'>0</td>
			<td style='width:300px;border:1px solid'></td>
			<td style='width:300px;border:1px solid'>0</td></tr></table></td></tr>
<tr><td colspan=2><input type='submit' value='Request Re-Allocation' /></td></tr>
</table>
<?php $this->endWidget(); ?></div>

