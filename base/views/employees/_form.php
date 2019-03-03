<style>
.emptable tr {
	margin:0px;
	padding:-20px;
	height:10px;
}
.emptable tr td {
	font-size:13px;
}

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
	    width: 90%;
	    height: auto;
	    opacity: 0.05;
		 z-index:-2;
		 -khtml-opacity:0.05; 
		 -moz-opacity:0.05; 
		  -ms-filter:”alpha(opacity=5)”;
		   filter:alpha(opacity=5);
		   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=5);
}
#myform {
	padding:20px;
}
</style>

<div class=background>
	<img src='images/uetcl_structure.png' class='bg'/>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('hasphones', '
   $("#hasphone").change(function() {
      var content = $("#hasphone option:selected").text();
	  if(content=="Yes") $("#phone").show(); else $("#phone").hide();
   });
');

Yii::app()->clientScript->registerScript('myphones', '
   $("#myphone").ready(function() {	 $("#phone").hide();  });
');
?>
<div class="form" id="myphone">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employees-form',
	'enableAjaxValidation'=>false,
)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
	<table class='emptable'>
<tr style='height:10px'><td>
	<div class="row">
		<?php echo $form->labelEx($model,'Check No'); ?>
		<?php echo $form->textField($model,'checkno',array('style'=>'width:250px')); ?>
		<?php echo $form->error($model,'checkno'); ?>
	</div>
</td><td>
		<?php if($_REQUEST['emp'] !='extra') {  ?>
	
	<div class="row">
		<?php  echo $form->labelEx($model,'Employee Name');

		//$list = Chtml::ListData(Employees::model()->findAll(),'id','employee');
		//$list[''] = "New Employee";
		echo $form->textField($model,'employee',array('style'=>'width:248px'));
		echo $form->error($model,'employee');
	 ?>
	</div>
    <?php } else { ?>
	<div class="row" id="redate" style="display:block">
    <?php echo $form->labelEx($model,'Recruitment Date'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'Employees[recruitmentdate]',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'clip',
		'dateFormat'=>'yy-mm-dd',
		'yearRange'=>'2014:2015',
    ),
    'htmlOptions'=>array(
        'style'=>'width:248px'
    ),
));   ?> 
    </div>
	<?php } ?>
</td></tr>
   <tr><td> 
	<div class="row">
		<?php echo $form->labelEx($model,'designation'); ?>
		<?php echo $form->dropDownList($model,'designation',Chtml::ListData(Designations::model()->findAll(),'id','designation'),array('style'=>'height:25px;width:250px')); ?>
		<?php echo $form->error($model,'designation'); ?>
	</div>
</td><td><div class="row">
		<?php echo $form->labelEx($model,'salary_scale'); ?>
		<?php echo $form->dropDownList($model,'salary_scale',Chtml::ListData(Scales::model()->findAll(),'id','name'),array('style'=>'line-heigh2t:15px;width:250px')); ?>
		<?php echo $form->error($model,'salary_scale'); ?>
	</div></td>

	<td><div class="row">
		<?php echo $form->labelEx($model,'spine'); ?>
		<?php echo $form->dropDownList($model,'spine',Chtml::ListData(Spines::model()->findAll(),'id','spine'),array('style'=>'width:250px')); ?>
		<?php echo $form->error($model,'spine'); ?>
	</div></td><td>&nbsp;</td></tr>

	
    <tr><td width="50"><div class="row">
		<?php echo $form->labelEx($model,'department'); ?>
		<?php echo $form->dropDownList($model,'department',Chtml::ListData(Dept::model()->findAll(),'id','dept'),array(
		'style'=>'width:250px;line-heighte:40px',
	'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('employees/items'), 
	'update'=>'#Employees_section',
	)));	?>
		<?php echo $form->error($model,'department'); ?>
	</div></td>
	
	<td width="50"><div class="row">
		<?php echo $form->labelEx($model,'section'); ?>
		<?php echo $form->dropDownList($model,'section',Chtml::ListData(Sections::model()->findAll("department='".$model->department."'"),'id','section'),array(
		'style'=>'width:250px',
	'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('employees/units'), 
	'update'=>'#Employees_unit',
	
	)));	?>

		<?php echo $form->error($model,'section'); ?>
	</div></td>

	<td width="50"><div class="row">
		<?php echo $form->labelEx($model,'unit'); ?>
		<?php echo $form->dropDownList($model,'unit',Chtml::ListData(Subsections::model()->findAll("section='".$model->section."'"),'id','section'),array('style'=>'width:250px',)); ?>
		<?php echo $form->error($model,'unit'); ?>
	</div></td></tr>
<tr><td colspan=3>
	<div class="row"><?php echo $form->labelEx($model,'Contract Type'); ?></div>
	<table style='border:0px solid;width:200px'><tr>	
		<td><div class="row"><?php echo $form->radioButton($model,'contract',array('value'=>1,'uncheckValue'=>0)); ?>&nbsp;Contract</div></td>
		<td><div class="row"><?php echo $form->radioButton($model,'contract',array('value'=>0,'uncheckValue'=>1)); ?>&nbsp;Temporary</div></td>
	</tr></table>
</td></tr>
<tr><td colspan=3>
	<div class="row"><?php echo $form->labelEx($model,'Allowances'); ?></div>
	<table style='border:0px solid;width:71%'><tr>
	<td><div class="row"><?php echo $form->checkBox($model,'standby',array('value'=>1,'uncheckValue'=>0)); ?>&nbsp;Standby Allowance</div></td>
	<td><div class="row"><?php echo $form->checkBox($model,'shift',array('value'=>1,'uncheckValue'=>0)); ?>&nbsp;Shift Allowance</div></td>	
	<td><div class="row"><?php echo $form->checkBox($model,'soap',array('value'=>1,'uncheckValue'=>0)); ?>&nbsp;Soap Allowance</div></td>
	<td><div class="row"><?php echo $form->checkBox($model,'risk',array('value'=>1,'uncheckValue'=>0)); ?>&nbsp;Risk Allowance</div></td>
</td></tr></table>
</td></tr>
<tr><td colspan=3>
	<div class="row"><?php echo $form->labelEx($model,'Other Allowances'); ?></div>
	<table style='border:0px solid;width:500px'>
		<tr><td>Contracts Commitee</td><td><?php echo $form->numberField($model,'cc',array('style'=>'width:250px')); ?></td></tr>
		<tr><td>Phone Allowance</td><td><?php echo $form->numberField($model,'phone',array('style'=>'width:250px')); ?></td></tr>
	</table>
</td></tr>

</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'checkno',
		'employee',
		array(
			'value'=>'$data->designation0->designation',
			'name'=>'designation'
		),
		array(
			'value'=>'$data->salaryScale->name',
			'name'=>'salary_scale'
		),
		array(
			'value'=>'$data->spine0->spine',
			'name'=>'spine'
		),
		array(
			'value'=>'$data->section0->section',
			'name'=>'section'
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
<?php $this->widget('ext.ScrollTop');  ?>