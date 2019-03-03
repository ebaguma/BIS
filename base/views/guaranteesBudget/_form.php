<style>
.vvs td {
	font-weigiht:bold;
	font-size:14px;
}
.even {
	background-color:rgb(225,241,244);
}
.odd {
	background-color:rgb(248,248,248);
}

.vvs tr {
	line-height:10px;
	height:10px;
	padding:0px;
	margin:0px;
}
.t td {
	font-size:14px;
}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'guarantees-budget-form',
	'enableAjaxValidation'=>false,
)); 
if(budget_locked()) { $this->renderPartial('/site/locked_warning'); } 
?>

<script>
function icalcint() {
	var val=accounting.unformat(document.getElementById('dname').innerHTML);
	document.getElementById('darran').innerHTML=accounting.formatNumber(0.01*val*document.getElementById('GuaranteesBudget_arrangement').value);
	document.getElementById('dannu').innerHTML=accounting.formatNumber(0.01*val*document.getElementById('GuaranteesBudget_annualrenewal').value);
	document.getElementById('dquart').innerHTML=accounting.formatNumber(0.01*4*val*document.getElementById('GuaranteesBudget_quarterly').value);
	document.getElementById('destab').innerHTML=accounting.formatNumber(0.01*val*document.getElementById('GuaranteesBudget_establishment').value);
	document.getElementById('itot').innerHTML=accounting.formatNumber(val*(
		0.01*Number(document.getElementById('GuaranteesBudget_annualrenewal').value) +
		0.01*Number(document.getElementById('GuaranteesBudget_arrangement').value) +
		0.01*4*Number(document.getElementById('GuaranteesBudget_quarterly').value) +
		0.01*Number(document.getElementById('GuaranteesBudget_establishment').value)));
}
</script>
<table style='width:1000px' class=t>
	<tr>
		<th>Bank Guarantee</th>
		<th>Arrangement Fees (%)</th>
		<th>Establishment Fees</th>
		<th>Quarterly Fees (%)</th>
		<th>Annual Renewal Fees (%)</th>
		<th>Total</th>
	</tr>
	
<?php
$guar=ItemsPricesView::model()->findAll("budget=".budget()." and accountcode=201 and lower(name) not like '%fees%'");
$its=GuaranteesBudget::model()->findAll('budget='.budget());
foreach($its as $it) {
		$gb[$it[guarantee]]['arrangement']=$it[arrangement];
		$gb[$it[guarantee]]['establishment']=$it[establishment];
		$gb[$it[guarantee]]['quarterly']=$it[quarterly];
		$gb[$it[guarantee]]['annualrenewal']=$it[annualrenewal];
}
foreach($guar as $g) {
	$cls= $cl%2==0 ? "even" : "odd";$cl++;
?>
<tr class="<?php echo $cls; ?>"><td>
		<?php echo $g[name]; ?>
</td><td>
		<?php 
		echo Chtml::numberField('gb['.$g[itemid].'][arrangement]',$gb[$g[itemid]]['arrangement'],array('style'=>'width:45px;','step'=>'0.01','onkeyUp'=>'icalcint()','onBlur'=>'icalcint()')); ?>
		<span id=darran></span>
</td><td>
		<?php echo Chtml::numberField('gb['.$g[itemid].'][establishment]',$gb[$g[itemid]]['establishment'],array('style'=>'width:45px;','step'=>'0.01','onkeyUp'=>'icalcint()','onBlur'=>'icalcint()')); ?>
		<span id=destab></span>
</td><td>
		<?php echo Chtml::numberField('gb['.$g[itemid].'][quarterly]',$gb[$g[itemid]]['quarterly'],array('style'=>'width:45px;','step'=>'0.01','onkeyUp'=>'icalcint()','onBlur'=>'icalcint()')); ?>
		<span id=dquart></span>
</td><td>
		<?php echo Chtml::numberField('gb['.$g[itemid].'][annualrenewal]',$gb[$g[itemid]]['annualrenewal'],array('style'=>'width:45px;','step'=>'0.01','onkeyUp'=>'icalcint()','onBlur'=>'icalcint()')); ?>
		<span id=dannu></span>
</td></td><td>
		<span id=itot style='font-weight:bold'></span>
</td></tr>
<?php } ?>

</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->