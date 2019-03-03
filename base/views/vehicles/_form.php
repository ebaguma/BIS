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
	    left: -10%;
	    top: 20%;
	    width: 100%;
	    height: auto;
	    opacity: 0.07;
		 z-index:-2;
		 -khtml-opacity:0.07; 
		 -moz-opacity:0.07; 
		  -ms-filter:”alpha(opacity=7)”;
		   filter:alpha(opacity=7);
		   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=7);
		 
}
#myform {
	padding:20px;
}
</style>

<div class=background>
	<img src='images/isuzu.png' class='bg'/>

<div class="form" id="myform">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicles-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'regno'); ?>
		<?php echo $form->textField($model,'regno',array('size'=>20,'maxlength'=>100,'style'=>'width:194px')); ?>
		<?php echo $form->error($model,'regno'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'vehicletype'); ?>
		<?php echo $form->dropDownList($model,'vehicletype',Chtml::ListData(Vehicletypes::model()->findAll(),'id','vehicletype'),array('style'=>'width:200px')); ?>
		<?php echo $form->error($model,'vehicletype'); ?>
	</div>
</td>
<td>	
	<div class="row">
		<?php echo $form->labelEx($model,'tyres'); ?>
		<?php echo $form->dropDownList($model,'tyres',Chtml::ListData(Items::model()->findAll("accountcode=120 and name regexp '^[0-9]{1}'"),'id','name'),array('style'=>'width:200px','prompt'=>'- select -')); ?>
		<?php echo $form->error($model,'tyres'); ?>
	</div>
<!--
	<div class="row">
		<?php // echo $form->labelEx($model,'hired'); ?>
		<?php // echo $form->dropDownList($model,'hired',array('No'=>'No','Yes'=>'Yes')); ?>
		<?php // echo $form->error($model,'hired'); ?>
	</div>-->
</td>
</tr><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'fueltype'); ?>
		<?php echo $form->dropDownList($model,'fueltype',array('Petrol'=>'Petrol','Diesel'=>'Diesel	'),array('style'=>'width:200px','prompt'=>'- select -')); ?>
		<?php echo $form->error($model,'fueltype'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'Consumption Rate (KM/L)'); ?>
		<?php echo $form->numberField($model,'fuelconsumption',array('size'=>20,'maxlength'=>100,'style'=>'width:194px')); ?>
		<?php echo $form->error($model,'fuelconsumption'); ?>
	</div>
	
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'battery'); ?>
		<?php echo $form->dropDownList($model,'battery',Chtml::ListData(Items::model()->findAll("accountcode=120 and name regexp '^N'"),'id','name'),array('style'=>'width:200px','prompt'=>'- select -')); ?>
		<?php echo $form->error($model,'battery'); ?>
	</div>
</td></tr>
    <tr><td width="10"><div class="row">
		<?php echo $form->labelEx($model,'dept'); ?>
		<?php echo $form->dropDownList($model,'dept',Chtml::ListData(Dept::model()->findAll(),'id','dept'),array(
		'style'=>'width:200px',
	'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('vehicles/items'), 
	'update'=>'#Vehicles_section',
	)));	?>
		<?php echo $form->error($model,'dept'); ?>
	</div></td>
	<td width="50"><div class="row">
		<?php echo $form->labelEx($model,'section'); ?>
		<?php echo $form->dropDownList($model,'section',Chtml::ListData(Sections::model()->findAll("department='".$model->dept."'"),'id','section'),array(
		'style'=>'width:200px',
	'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('vehicles/units'), 
	'update'=>'#Vehicles_subsection',
	)));	?>

		<?php echo $form->error($model,'section'); ?>
	</div></td>

	<td width="50"><div class="row">
		<?php echo $form->labelEx($model,'subsection'); ?>
		<?php echo $form->dropDownList($model,'subsection',Chtml::ListData(Subsections::model()->findAll("section='".$model->section."'"),'id','unit'),array('style'=>'width:200px')); ?>
		<?php echo $form->error($model,'subsection'); ?>
	</div></td></tr>
<tr>
	<td>
	<div class="row">
		<?php echo $form->labelEx($model,'glcode'); ?>
		<?php echo $form->numberField($model,'glcode',array('style'=>'width:196px')); ?>
		<?php echo $form->error($model,'glcode'); ?>
	</div>
</td>
	
	<td><div class="row"><?php echo $form->checkBox($model,'fms',array('value'=>1,'uncheckValue'=>0)); ?>&nbsp;<b>Fleet Management System</b></div></td>
	
	<td>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('style'=>'width:200px','rows'=>2)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
</td>
	</tr>
</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vehicles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
		'regno',
		'glcode',
		'vehicletype0.vehicletype',
		'description',		
		'dept0.dept',
		'section0.section',
		//'hired',
		/*
		'subsection',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

</div>