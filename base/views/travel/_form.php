<?php
/* @var $this TravelController */
/* @var $model Travel */
/* @var $form CActiveForm */
?>
<style>
.subtable {
 border: 1px #aaaaaa ridge;

}
.subtable tr {
	height:5px !important;
	padding-top: 10px !important;
}
div.background {
   border: 0px solid black;

}
div.background img.bg {
		position: absolute;
	    left: 20%;
	    top: 20%;
	    width: 60%;
	    height: auto;
	    opacity: 0.09;
		 z-index:-1;
		 -khtml-opacity:0.09; 
		 -moz-opacity:0.09; 
		  -ms-filter:”alpha(opacity=9)”;
		   filter:alpha(opacity=9);
		   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=9);
		 
}
#myform {
	padding:20px;
}
</style>

<div class=background>
	<img src='images/plane_PNG5256.png' class='bg'/>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'travel-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); 
if(budget_locked()) { $this->renderPartial('/site/locked_warning'); } 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
		echo $form->errorSummary($model); 
		echo $form->hiddenField($model,'mission',array('value'=>$_REQUEST['m']));
		echo $form->hiddenField($model,'budget',array('value'=>Yii::app()->user->budget['id']));
	?>
   <style>
	.mytabl td {
		padding:0px;
	}
	</style>
<table class='mytabl'><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'employee'); ?>
		<?php echo $form->dropDownList($model,'employee',Chtml::ListData(Employees::model()->findAll("budget=".budget()." and enddate is null and (department='".Yii::app()->user->dept->id."' or  section='".Yii::app()->user->dept->id."' or unit='".Yii::app()->user->dept->id."')"),'id','employee'),array('prompt'=>'- Select -',style=>'width:265px')); ?>
		<?php echo $form->error($model,'employee'); ?>
	</div>
</td><td>
	<div class="row">
		<?php
			$c=$_REQUEST['m'] == "TrainingTravel" ? "Course" : "Mission"; 
			echo $form->labelEx($model,$c); ?>
		<?php echo $form->textField($model,'course',array('size'=>45,'maxlength'=>100,style=>'width:265px')); ?>
		<?php echo $form->error($model,'course'); ?>
	</div>
</td></tr>
	<tr><td>
	<div class="row">
		<?php
			$c=$_REQUEST['m'] == "TrainingTravel" ? "Training Centre" : "Destination"; 
			echo $form->labelEx($model,$c); ?>
		<?php echo $form->textField($model,'centre',array('size'=>45,'maxlength'=>100,style=>'width:265px')); ?>
		<?php echo $form->error($model,'centre'); ?>
	</div>
</td>
<td>
		<div class="row" id="redate" style="display:block">
	    <?php  echo $form->labelEx($model,'traveldate'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'Travel[traveldate]',
	    // additional javascript options for the date picker plugin
	    'options'=>array(
	        'showAnim'=>'clip',
			'dateFormat'=>'yy-mm-dd',
			'yearRange'=>'2014:2015',
	    ),
		'value'=>$model->traveldate,
	    'htmlOptions'=>array('style'=>'width:265px;'),
	));   ?> 
	<?php echo $form->error($model,'traveldate'); ?>
	    </div>
</td></tr>
<tr><td colspan=2>	
		
	<div class="row">
		<?php echo $form->labelEx($model,'purpose'); ?>
		<?php echo $form->textArea($model,'purpose',array('rows'=>3,style=>'width:640px')); ?>
		<?php echo $form->error($model,'purpose'); ?>
	</div>
	
</td></tr></table>
<?php 
	$w=Chtml::ListData(TravelItems::model()->findAll(strtolower($_REQUEST['m'])."='Yes'"),'id','item');
	$ss="";
	foreach ($w as $k=>$v) 
		$ss .="<option value=".$k.">".$v."</option>";
	
	$w2=Yii::app()->db->createCommand("SELECT * from v_currency where budget=".user()->budget['id'])->queryAll();
	$cu="";
	foreach ($w2 as $cur) {
		$cu .="<option value=".$cur[id].">".$cur[sign]." ".$cur[symbol]."</option>";
		echo "<div id=c".$cur[id]." style='display:none;'>".$cur[rate]."</div>";
	}
//	echo $ss;
Yii::app()->clientScript->registerScript('textFieldAdder','$("#additional-link").bind("click",function(){
    var id="TravelItems";
	 var size=$("#additional-inputs > tr").size()+1;
	 var rown= size%2==0 ? "even" : "odd";
	 var d=document.getElementById("dk").innerHTML;
	//alert(size);
	 if(parseInt(d) <= size)
	 	document.getElementById("dk").innerHTML=size;
	 $("#additional-inputs").append("<tr class="+rown+"><td><select name=TravelDetails[item][]>'.$ss.'</select></td><td><input type=\"number\" onKeyUp=onk() id="+id+size+" name=TravelDetails[amount][]></td><td><select onChange=onk() id=cur"+id+size+" name=TravelDetails[cur][]>'.$cu.'</select></td></td><td  id=ugx"+id+size+"></td></tr>");
    })');
	// echo "<pre>".$ss."</pre>";
?>    
<div class="grid-view">
<?php echo CHtml::link('Add '.$_REQUEST['m'].' Detail','#',array('id'=>'additional-link')); ?>
<table class="items"><tr><th>Detail</th><th>Price</th><th>Currency</th><th>Amount (UGX)</th></tr><tbody id="additional-inputs">
	
<?php
if($model->id) {
	$dets=VTravel::model()->findAll('training='.$model->id);
	$tt=$i=0;
	foreach ($dets as $det) {
		$ss=""; $i++;
		$cls = $i%2==0 ? "even" : "odd";
		foreach ($w as $k=>$v) {
			$sel = $k==$det['itemid'] ? "selected=selected" :"";
			$ss .="<option value=".$k." $sel>".$v."</option>";
		}
		
		$w2=Yii::app()->db->createCommand("SELECT * from v_currency where budget=".user()->budget['id'])->queryAll();
		$cu="";
		foreach ($w2 as $cur) {
			$sel = $cur[id]==$det['currencyid'] ? "selected=selected" :"";
			$cu .="<option value=".$cur[id]." $sel>".$cur[sign]." ".$cur[symbol]."</option>";
		}		
		$linetotal=$det['amount']*$det['exchangerate'];
		$tt+=$linetotal;
		echo '<tr class="'.$cls.'"><td><select name="TravelDetails[item][]">'.$ss.'</select></td><td><input type="number" id="TravelItems'.$i.'" onKeyUp="onk()" name="TravelDetails[amount][]" value="'.$det['amount'].'"></td><td><select onChange=onk() id=curTravelItems'.$i.' name=TravelDetails[cur][]>'.$cu.'</select></td><td style="text-align:right" id="ugxTravelItems'.$i.'">'.number_format($linetotal).'</td> </tr>';	
	}
}	
?>

</tbody><tr><th>Totals</th><th id=tusd></th><th></th><th id=tugx style="text-align:right"><?php echo number_format($tt);?></th></tr></table><div id="dk" style='display:none'><?php echo $i > 0? $i : "0"; ?></div>
<script>
function onk() {
	var ii=0;
	var st=0;
	var iii=0;
	var s=parseInt(document.getElementById('dk').innerHTML);
	for(i=1;i<=s;i++) {
		ii += parseInt(document.getElementById("TravelItems"+i).value);
		iii =  parseInt(document.getElementById("TravelItems"+i).value)*document.getElementById("c"+document.getElementById("curTravelItems"+i).value).innerHTML;
		st +=iii;
		document.getElementById('ugxTravelItems'+i).innerHTML=accounting.formatNumber(parseInt(iii));
	}	
	document.getElementById('tusd').innerHTML=accounting.formatNumber(parseInt(ii));
	document.getElementById('tugx').innerHTML=accounting.formatNumber(parseInt(st));
}
</script>

</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>