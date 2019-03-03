<h1>Direct  Budget Capture</h1>
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
	    left: 0%;
	    top: 20%;
	    width: 90%;
	    height: auto;
	    opacity: 0.1;
		 z-index:-2;
}
#myform {
	padding:20px;
}
</style>

<div class=background>
	<img src='images/world.png' class='bg'/>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'procurement-spending-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<?php
/*
echo CHtml::ajaxLink('View Popup', 'procurementSpending/popup',
    array('update' => '#simple-div'),
    array('id' => 'simple-link-'.uniqid())
);
*/
?>
<!--<div id="simple-div">gwe</div>-->

	<div class="row">
		<?php echo Chtml::label('Reference',false); ?>
		<?php echo Chtml::textField('subject','',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	<div class="row">
		<?php echo Chtml::label('Narrative',false); ?>
		<?php echo Chtml::textField('justification','',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	<div class="row">
		<?=Chtml::label('Section',false); ?>
		<?php
    $rl = app()->db->CreateCommand("select * from v_sections order by dshortname,sshortname")->queryAll();
	 $role_list=array();
	 foreach($rl as $r) $role_list[$r['sectionid']]=$r['dshortname']." - ".$r['sshortname'];
		echo Chtml::dropDownList('section',array(),$role_list,array('onChange'=>"document.getElementById('ProcurementSpending_items').innerHTML='';document.getElementById('accountcode').value=''",'style'=>'width:270px','empty' => ' - Select a Cost Centre - ')); ?>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('Cost Category',false);
		    $rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
			 $role_list=array();
			 foreach($rl as $r) $role_list[$r[accountcode]]=$r[accountcode]." - ".$r[item];
			echo Chtml::dropDownList('costcentre', array(), $role_list,
				array(
					'style'=>'width:270px',
					'empty' => ' - Select a Cost Centre - ',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('Items/item'),
						'update'=>'#accountcode',
					),
			));
?>
	</div>
	<div class="row">
		<?php echo Chtml::label('Account Code',false);
			echo CHtml::dropDownList('accountcode', array(),array(),array(
				'style'=>'width:270px',
				'prompt'=>'- select -',
				'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('ProcurementSpending/itemCapture'),
					'update'=>'#ProcurementSpending_items',
				),
			));
			?>
	</div>

<div class="row grid-view" id="ProcurementSpending_items"></div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
