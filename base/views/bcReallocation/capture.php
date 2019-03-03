<h1>Direct Budget  Re-Allocation</h1>

<?php if($message) { ?>
<div class="flash notice">
  <span class="close"><a href="#">X</a></span>
<?=$message?>
</div>
<?php } ?>

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
	    width: 50%;
	    height: auto;
	    opacity: 0.1;
		 z-index:-2;
}
#myform {
	padding:20px;
}
</style>
<script>
function reac() {
	if(parseInt(document.getElementById('falloc').value) <0 ||
		parseInt(document.getElementById('falloc').value) >parseInt(accounting.unformat(document.getElementById('forig').innerHTML))
	)  {
		document.getElementById('falloc').value=0; 
		document.getElementById('talloc').innerHTML=0;
		document.getElementById('frunn').innerHTML=document.getElementById('forig').innerHTML;
		document.getElementById('trunn').innerHTML=document.getElementById('torig').innerHTML;
		return;
	}
	document.getElementById('talloc').innerHTML=accounting.format(document.getElementById('falloc').value);
	document.getElementById('frunn').innerHTML=accounting.format(accounting.unformat(document.getElementById('forig').innerHTML)-document.getElementById('falloc').value);
	document.getElementById('trunn').innerHTML=accounting.format(parseInt(accounting.unformat(document.getElementById('torig').innerHTML)) + parseInt(document.getElementById('falloc').value));
}
</script>
<div class=background>
	<img src='images/manyarrows.png' class='bg'/>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bc-reallocation-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table><tr><td>
	<div class="row">
		<?=$form->labelEx($model,'fromsection');  ?>
		<?php 
    $rl = app()->db->CreateCommand("select * from v_sections order by dshortname,sshortname")->queryAll();
	 $role_list=array();
	 foreach($rl as $r) $role_list[$r['sectionid']]=$r['dshortname']." - ".$r['sshortname'];
		echo $form->dropDownList($model,'fromsection',$role_list,array('onChange'=>"document.getElementById('ProcurementSpending_items').innerHTML='';document.getElementById('accountcode').value=''",'style'=>'width:270px','empty' => ' - Select a Cost Centre - ')); ?>
	</div>

		<div class="row">
			<?php echo $form->labelEx($model,'From Cost Category'); 
			    $rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
				 $role_list=array();
				 foreach($rl as $r) $role_list[$r[accountcode]]=$r[accountcode]." - ".$r[item];
				echo Chtml::dropDownList('costcentre', array(), $role_list,
					array(
						'empty' => ' - Select a Cost Centre - ',
						'style'=>'width:270px',
						'ajax' => array(
							'type'=>'POST',
							'url'=>CController::createUrl('Items/item'), 
							'update'=>'#accountcode',
						
						),
					)
			); 
	?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'From Account Code'); 
				echo Chtml::dropDownList('accountcode', array(),array(),array(
						'style'=>'width:270px',
						'empty' => ' - Select an Account Code - ',
						'ajax' => array(
							'type'=>'POST',
							'success'=>"function(data){
								//$('#BcReallocation_toitem').html(data.sites);
								$('#BcReallocation_fromitem').html(data.sites);
							}" , 
							'dataType' => 'json',
							'url'=>CController::createUrl('BcReallocation/items'), 
						),
				)); 
	 		  ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'fromitem'); 
				echo $form->dropDownList($model,'fromitem', array(),array(	'style'=>'width:270px',
	'empty' => ' - Select an Item - ',
				'ajax' => array(
						'type'=>'POST',
						'success'=>"function(data){
							$('#forig').html(data.sites);
							$('#frunn').html(data.sites);
						}" , 
						'dataType' => 'json',
						'url'=>CController::createUrl('BcReallocation/itemf'), 
					),)); 
	 		  ?>
		</div>
	
</td>
<td><img src='images/arrow.png' style='width:200px'/></td>
	<td>
		<div class="row">
			<?=$form->labelEx($model,'tosection'); ?>
			<?php 
	    $rl = app()->db->CreateCommand("select * from v_sections order by dshortname,sshortname")->queryAll();
		 $role_list=array();
		 foreach($rl as $r) $role_list[$r['sectionid']]=$r['dshortname']." - ".$r['sshortname'];
			echo $form->dropDownList($model,'tosection',$role_list,array('onChange'=>"document.getElementById('ProcurementSpending_items').innerHTML='';document.getElementById('accountcode').value=''",'style'=>'width:270px','empty' => ' - Select a Cost Centre - ')); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'To Cost Category'); 
			    $rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
				 $role_list=array();
				 foreach($rl as $r) $role_list[$r[accountcode]]=$r[accountcode]." - ".$r[item];
				echo Chtml::dropDownList('costcentre2', array(), $role_list,
					array(
						'empty' => ' - Select a Cost Category - ',
						'style'=>'width:270px',
						'ajax' => array(
							'type'=>'POST',
							'url'=>CController::createUrl('Items/item'), 
							'update'=>'#accountcode2',
						
						),
					)
			); 
	?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'To Account Code'); 
				echo Chtml::dropDownList('accountcode2', array(),array(),array(
						'style'=>'width:270px',
						'empty' => ' - Select an Account Code - ',
						'ajax' => array(
							'type'=>'POST',
							'success'=>"function(data){
								$('#BcReallocation_toitem').html(data.sites);
							//	$('#BcReallocation_fromitem').html(data.sites);
							}" , 
							'dataType' => 'json',
							'url'=>CController::createUrl('BcReallocation/itemst'), 
						),
				)); 
	 		  ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'toitem'); 
				echo $form->dropDownList($model,'toitem', array(),array(	
					'style'=>'width:270px',
					'empty' => ' - Select an Item - ',
					'ajax' => array(
						'type'=>'POST',
						'success'=>"function(data){
							$('#torig').html(data.sites);
							$('#talloc').html(0);
							$('#trunn').html(data.sites);
						}" , 
						'dataType' => 'json',
						'url'=>CController::createUrl('BcReallocation/itemo'), 
					),
				)); 
	 		  ?>
		</div>
	
</td></tr>
<tr><td>
	<div class="row grid-view"><table class='items'>
		<tr>
			<th>Original Budget</th>
			<th>Reallocation Amount</th>
			<th>Running Balance</th>
		</tr>
		<tr>
			<td id=forig></td>
			<td><input id=falloc name='BcReallocation[amount]' onKeyUp='reac();'/></td>
			<td id=frunn></td>
		</tr>
	</table></div>
</td><td>&nbsp;</td>
<td><div class="row grid-view">
	<table class='items'>
		<tr>
			<th>Original Budget</th>
			<th>Reallocation Amount</th>
			<th>Running Balance</th>
		</tr>
		<tr>
			<td id=torig></td>
			<td id=talloc></td>
			<td id=trunn></td>
		</tr>
	</table></div>
</td>
</tr></table>
		<?php echo $form->labelEx($model,'justification'); 
		echo $form->textArea($model,'justification',array('style'=>'width:270px')); 
		?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit Re-Allocation Request' : 'Save'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form --></div>
