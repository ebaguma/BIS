<style>
.subtable {
 border: 1px #aaaaaa ridge;

}
.subtable tr {
	height:5px !important;
	padding-top: 10px !important;
}
div.background img {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: auto;
	opacity: 0.07;
	z-index:-1;
	background-color:#ffffff;
 -khtml-opacity:0.07;
 -moz-opacity:0.07;
  -ms-filter:”alpha(opacity=7)”;
   filter:alpha(opacity=7);
   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=7);

}

</style>

<div class=background>
	<img src='images/mast2.png' style='width:70%' />

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subsistence-form',
	'enableAjaxValidation'=>false,
));
if(budget_locked()) { $this->renderPartial('/site/locked_warning'); }
?>
	<span class="note">Fields with <span class="required">*</span> are required.</span>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'budget',array('value'=>Yii::app()->user->budget['id'])); ?>

 <table class='subtable'><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'Cost Item'); ?>
		<?php echo $form->dropDownList($model,'item',Chtml::ListData(Accountcodes::model()->findAll('id in (157,137,147,144,139,145)'),'id','item'),array(
	 'prompt'=>'- select -',
	'style'=>'width:250px;line-heighte:40px',
		'ajax' => array(
			'type'=>'POST',
			'success'=>"function(data){
				$('#Subsistence_site').html(data.sites);
				$('#om').html(data.om);
			}" ,
			'dataType' => 'json',
			//'update' =>'#om',
			'url'=>CController::createUrl('Subsistence/sites'),
		)
	)); ?>
		<?php echo $form->error($model,'item'); ?>
	</div>
    </td><td>
		<div class="row">
			<?php echo $form->labelEx($model,'site');
			$mlist = CHtml::listData(Sites::model()->findAll("id='".$model->site."'"), 'id', 'site');
			echo $form->dropDownList($model,'site',$mlist,array('style'=>'width:250px;line-heighte:40px')); ?>
			<?php echo $form->error($model,'site'); ?>
		</div>

    </td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'Number of Casuals'); ?>
		<?php echo $form->numberField($model,'casuals',array('style'=>'width:50px;line-heighte:40px')); ?>
		<?php echo $form->error($model,'casuals'); ?>
	</div>
</td></tr>
	<tr><td>
    <div class="row">

		<?php echo $form->labelEx($model,'startdate'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'Subsistence[startdate]',
    'options'=>array(
        'showAnim'=>'slide',
		'dateFormat'=>'yy-mm-dd',
		'yearRange'=>'2014:2015',
    ),
	 'value'	=>$model->startdate,
	 'htmlOptions'=>array(
		 'style'	=>'width:250px;line-heighte:40px'
    ),
));   ?>
		<?php echo $form->error($model,'startdate'); ?>

	</div></td><td><div class="row">
    <?php echo $form->labelEx($model,'End Date'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'Subsistence[enddate]',
    'options'=>array(
        'showAnim'=>'clip',
		'dateFormat'=>'yy-mm-dd',
		'yearRange'=>'2014:2015',
    ),
	 'value'	=>$model->enddate,
    'htmlOptions'=>array(
        'style'=>'width:250px;'
    ),
));   ?>
<?php echo $form->error($model,'enddate'); ?>
   </div>
   </td></tr>
<tr><td colspan=3>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>3, 'style'=>'width:634px;')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	</td></tr>
</table>

<fieldset><legend><b style='font-size:15px'>Operational Materials</b></legend>
<div class="grid-view row" id="om">

	<?php if($model->id)  {


		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where  accountcode=".$model->item." and budget='".Yii::app()->user->budget['id']."' and readonly='0'")->queryAll();
		for($i=0; $i<count($data);$i++) {
			$csz .="<option class=ew value=".$data[$i]['itemid'].">".strip($data[$i]['name'])."</option>";
			$jarray .="<div id='itemprice".$data[$i]['itemid']."'>".$data[$i]['price']."</div>";
			$jarrayc .="<div id='itemcur".$data[$i]['itemid']."'>".$data[$i]['currency']."</div>";
			$jarrayr .="<div id='itemrate".$data[$i]['itemid']."'>".$data[$i]['exrate']."</div>";
			$jbudget .="<div id='tbudget".$data[$i]['itemid']."'>".number_format($tbudget)."</div>";
		}
		$jarray .="<div id='itemprice0'></div><div id='itemcur0'>UGX</div><div id='itemrate0'>1</div>";




       $ht='<script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script>
        <script type="text/javascript">
		function test(dd,v) {
			document.getElementById("price"+dd).innerHTML=accounting.formatNumber(document.getElementById("itemprice"+v).innerHTML);
			document.getElementById("cur"+dd).innerHTML=document.getElementById("itemcur"+v).innerHTML;
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1;
			document.getElementById("total"+dd).innerHTML=accounting.formatNumber(document.getElementById("qty"+dd).value * accounting.unformat(document.getElementById("price"+dd).innerHTML)*document.getElementById("itemrate"+v).innerHTML);
			var maxd=document.getElementById(\'dkeeper\').innerHTML;
			var allt=0;
			for(i=1; i<=maxd;i++) {
				allt += parseFloat(accounting.unformat(document.getElementById("total"+i).innerHTML));
			}
			document.getElementById(\'alltotal\').innerHTML=accounting.formatMoney(allt);
		}
		function test2(dd) {
			//document.getElementById("price"+dd).innerHTML=document.getElementById("itemprice"+v).innerHTML;
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1;
//			alert();
			document.getElementById("total"+dd).innerHTML=accounting.formatNumber(document.getElementById("qty"+dd).value * accounting.unformat(document.getElementById("price"+dd).innerHTML)*document.getElementById("itemrate"+document.getElementById("it"+dd).value).innerHTML);
			var maxd=document.getElementById(\'dkeeper\').innerHTML;
			var allt=0;
			for(i=1; i<=maxd;i++) {
				allt += parseFloat(accounting.unformat(document.getElementById("total"+i).innerHTML));
			}
			document.getElementById(\'alltotal\').innerHTML=accounting.formatMoney(allt);
		}
		jQuery(function($) {
			var d=document.getElementById(\'dkeeper\').innerHTML;
			$("#additional-link").bind("click",function(){ //document.getElementById(\'price"+d+"\').innerHTML=this.class
			d++;
			var rown = d%2==0 ? "even" : "odd";
			$("#additional-inputs").append("\n<tr class="+rown+" id=sel"+d+"><td>"+d+".</td><td><select id=\'it"+d+"\' onchange=\'test("+d+",this.value);\' name=item[]><option value=0> - select -</option>'.$csz.'</select></td><td style=\'text-align:right\' id=price"+d+"></td><td id=cur"+d+"></td><td><input id=qty"+d+" onKeyUp=\'test2("+d+");\' onChange=\'test2("+d+")\'  style=\'width:60px\' type=number value=1 name=quantity[]></td><td style=\'text-align:right\' id=total"+d+"></td></tr>");
			document.getElementById(\'dkeeper\').innerHTML=d;
    	});
		$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById(\'dkeeper\').innerHTML=d;});
});
</script>

<div id=idbudget style=\'display:none;\'>'.$jbudget.'</div>
<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a><table class=items style=\'widthi:900px\'><tr><th>No.</th><th>Item</th><th>Price</th><th>Currency</th><th>Quantity</th><th>Total</th></tr><tbody id="additional-inputs">';

$d=$bigtot=0;
$da=app()->db->createCommand("select * from v_subsistence_details where activity='".$model->id."'")->queryAll();
$rtr="";
foreach($da as $dt) {
	$cz1 = "<option value=$dt[item]>$dt[detailname]</option>";
	$jarrayr.= "<div style='display:none'  id='itemrate".$dt['item']."'>".$dt['exrate']."</div>";

	$cl=$d%2==0 ? "even" : "odd";
	$d++;
	$www=$dt[price]*$dt[quantity]*$dt['exrate'];
	$bigtot+=$www;


	$ht .="<tr class=".$cl." id=sel".$d."><td>".$d."</td><td><select id='it".$d."' onblur='test(".$d.",this.value);' name=item[]>".$cz1."</select></td><td style='text-align:right' id=price".$d.">".number_format($dt[price])."</td><td id=cur".$d.">".$dt[currency]."</td><td><input id=qty".$d." onKeyUp='test2(".$d.")' onChange='test2(".$d.")' type=number style='width:60px' value=".$dt[quantity]." name=quantity[] /></td><td style='text-align:right' id=total".$d.">".number_format($www)."</td></tr>";
}

	$ht.="</tbody><tr><td colspan=5>Grand Total</td>UGX <td id=alltotal style='text-align:right;font-weight:bold'>".number_format($bigtot)."</td></table>
	<div id=id3 style='display:none;'>".$jarray.$jarrayc.$jarrayr."<div id=dkeeper>".$d."</div></div>";

	echo $ht;


	 }?>

	</div></fieldset>


<?php
	$cs=app()->db->createCommand("select * from v_employees_subsistence where accountcode=139 and  section='".Yii::app()->user->dept->id."' and budget=".budget())->queryAll();
  //echo "select * from v_employees_subsistence where section='".Yii::app()->user->dept->id."' and budget=".budget();
	$csz=$ciz="";
	$csz="<option></option>";
	foreach ($cs as $k)	{
		$csz .="<option value=".$k[id].">".$k[employee]."</option>";
		$ayr .="<div id='pscale".$k[id]."'>".$k[scalename]."</div>";
		$ayc .="<div id='prate".$k[id]."'>".$k[subsistence]."</div>";
	}

Yii::app()->clientScript->registerScript('textFieldAdder2','$("#additional-staff1").bind("click",function(){
	 var size=$("#amdditional-staffs > tr").size()+1;
	 var rown2= size%2==0 ? "even" : "odd";
    $("#amdditional-staffs").append("<tr class="+rown2+"><td>"+size+".</td><td><select name=employee[] onChange=\'empc(this.value,"+size+");\' >'.$csz.'</select></td><td id=escale"+size+"></td><td id=esub"+size+"></td><td id=etoti"+size+"><td id=etot"+size+" style=\'text-align:right\'></td></tr>");
    })')
?>
<script>
function empc(d,v) {
	var dt = new Date(document.getElementById('Subsistence_startdate').value);
	var dt1 = new Date(document.getElementById('Subsistence_enddate').value);
	var diff_date =  (dt1 -dt)/86400000;
	document.getElementById('escale'+v).innerHTML=document.getElementById('esub'+v).innerHTML=document.getElementById('etot'+v).innerHTML='';
	document.getElementById('escale'+v).innerHTML=document.getElementById('pscale'+d).innerHTML;
	document.getElementById('esub'+v).innerHTML=accounting.formatNumber(document.getElementById('prate'+d).innerHTML);
	document.getElementById('etot'+v).innerHTML=accounting.formatNumber(document.getElementById('prate'+d).innerHTML*diff_date);
	document.getElementById('etoti'+v).innerHTML=diff_date;
	var size=$("#amdditional-staffs > tr").size()+1;
	var it=0;
	for(i=1;i<size;i++)
		it += accounting.unformat(document.getElementById('etot'+i).innerHTML);
	document.getElementById('s1').innerHTML=accounting.formatNumber(it);
	//document.getElementById('s2').innerHTML=accounting.unformat(document.getElementById('alltotal').innerHTML);
}
</script>

<fieldset><legend><b style='font-size:15px'>Employees</b></legend>
<div class="grid-view row" style='width:100%'>
<?php echo CHtml::link('Add Staff to this Activity','#',array('id'=>'additional-staff1','onClick'=>'return false;')); ?>
<table class="items" ><tr><th>#</th><th>Employee Name</th><th>Scale</th><th>Rate</th><th>Days</th><th>Total</th></tr><tbody id="amdditional-staffs">
<?php
$date1=  strtotime($model->startdate);
$date2= 	strtotime($model->enddate);
$days=($date2-$date1)/86400;

$cs=app()->db->createCommand("select * from v_subsistence_staff where activity='".$model->id."'")->queryAll();
$csz=$ciz="";
for($i=1;$i<=count($cs);$i++)	{
	$rown2= $i%2==0 ? "even": "odd";
	$k=$cs[$i-1];
	$ttt+=$k[amount]*$days;
	$csz ="<option></option><option selected=selected value=".$k[employee].">".$k[employeename]."</option>";
	echo "<tr class=".$rown2."><td>".$i.".</td><td><select name=employee[] onChange='empc(this.value,".$i.");' >".$csz."</select></td><td id=escale".$i.">".$k[salaryscale]."</td><td id=esub".$i.">".$k[amount]."</td><td id=etoti".$i.">".$days."<td id=etot".$i." style='text-align:right'>".number_format($k[amount]*$days)."</td></tr>";
//	$ayr .="<div id='pscale".$k[id]."'>".$k[scalename]."</div>";
//	$ayc .="<div id='prate".$k[id]."'>".$k[subsistence]."</div>";
}
?>

</tbody>
</table>
<table width=100%><tr><td><strong>Subsistence:</strong></td><td id=s1 style='text-align:right;font-weight:bold'><?php echo number_format($ttt);?></td></tr>
	<!--<td><strong>Operational Materials:</strong></td><td id=s2 style='text-align:right'></td></tr>
	<td><strong>Casuals:</strong></td><td id=s3 style='text-align:right'></td></tr>
	<td><strong>Total:</strong></td><td id=s4 style='text-align:right'></td></tr>-->
</table>
</div></fieldset>
	<div class="row buttons"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?></div>

<?php echo "<div id=id23 style='display:none;'>".$ayc.$ayr."</div>";$this->endWidget(); ?>

</div><!-- form --></div>
