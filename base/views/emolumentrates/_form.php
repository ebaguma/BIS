<script>
function va() {
	document.getElementById('out_of_station').innerHTML=accounting.formatNumber(document.getElementById('v_out_of_station').innerHTML*document.getElementById('Emolumentrates_out_of_station').value)
	document.getElementById('weekend_lunch').innerHTML=accounting.formatNumber(document.getElementById('v_weekend_lunch').innerHTML*document.getElementById('Emolumentrates_weekend_lunch').value)
	document.getElementById('weekend_transport').innerHTML=accounting.formatNumber(document.getElementById('v_weekend_transport').innerHTML*document.getElementById('Emolumentrates_weekend_transport').value)
	document.getElementById('responsibility_allowance').innerHTML=accounting.formatNumber(document.getElementById('v_responsibility_allowance').innerHTML*document.getElementById('Emolumentrates_responsibility_allowance').value)
	document.getElementById('acting_allowance').innerHTML=accounting.formatNumber(document.getElementById('v_acting_allowance').innerHTML*document.getElementById('Emolumentrates_acting_allowance').value)
	document.getElementById('travel_in_ug_op').innerHTML=accounting.formatNumber(document.getElementById('v_travel_in_ug_op').innerHTML*document.getElementById('Emolumentrates_travel_in_ug_op').value)
	document.getElementById('leave_in_lieu').innerHTML=accounting.formatNumber(document.getElementById('v_leave_in_lieu').innerHTML*document.getElementById('Emolumentrates_leave_in_lieu').value)

	document.getElementById('overtime_weekend_days').innerHTML=accounting.formatNumber(document.getElementById('v_overtime_weekend_days').innerHTML*(1.5*document.getElementById('Emolumentrates_overtime_weekdayhrs').value*document.getElementById('Emolumentrates_overtime_weekdaydays').value)+(2*document.getElementById('Emolumentrates_overtime_weekend_days').value*document.getElementById('Emolumentrates_overtime_weekend_hrs').value) )
	
	//document.getElementById('totall').innerHTML=accounting.formatNumber(accounting.unformat(document.getElementById('weekend_lunch').innerHTML)+accounting.unformat(document.getElementById('weekend_transport').innerHTML)+accounting.unformat(document.getElementById('out_of_station').innerHTML));
}
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'emolumentrates-form',
	'enableAjaxValidation'=>false,
));
if(budget_locked()) { $this->renderPartial('/site/locked_warning'); } 
 ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">		
		<?php echo $form->labelEx($model,'employee'); ?>
		<?php 
//		if($model->employee) $sa=" and id=".$model->employee;
		echo		 $form->dropDownList($model,'employee',Chtml::ListData(Employees::model()->findAll("budget=".budget()." and (department='".Yii::app()->user->dept->id."' or  section='".Yii::app()->user->dept->id."' or unit='".Yii::app()->user->dept->id."') ".$sa),'id','employee'),array('prompt'=>' - Select Employee - ','ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('emolumentrates/allowances'), 
	'update'=>'#allowances',
	))); ?>
		<?php echo $form->error($model,'employee'); ?>
	</div>
<div style='display:none' id='allowances'></div>	
<TABLE style='100%'><tr>
	<td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'>General Allowances</legend>
<table width=100%><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'acting_allowance'); ?>
		<?php echo $form->numberField($model,'acting_allowance',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'acting_allowance'); ?>
	</div>
</td><td style='text-align:right' id=acting_allowance>0</td></tr><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'responsibility_allowance'); ?>
		<?php echo $form->numberField($model,'responsibility_allowance',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'responsibility_allowance'); ?>
	</div>
</td><td style='text-align:right' id=responsibility_allowance>0</td></tr><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'leave_in_lieu'); ?>
		<?php echo $form->numberField($model,'leave_in_lieu',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'leave_in_lieu'); ?>
	</div>	
	</td><td style='text-align:right' id=leave_in_lieu>0</td></tr></table>
	<fieldset><legend>Amounts</legend>
		<!--
		<div class="row">
			<?php echo $form->labelEx($model,'driving_allowance'); ?>
			<?php echo $form->numberField($model,'driving_allowance',array('onkeyup'=>'va();')); ?>
			<?php echo $form->error($model,'driving_allowance'); ?>
		</div>
			-->
		<div class="row">
			<?php echo $form->labelEx($model,'mileage'); ?>
			<?php echo $form->numberField($model,'mileage',array('onkeyup'=>'va();')); ?>
			<?php echo $form->error($model,'mileage'); ?>
		</div>
	<!--<div class="row">
		<?php echo $form->labelEx($model,'mobile_phone_allowance'); ?>
		<?php echo $form->numberField($model,'mobile_phone_allowance',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'mobile_phone_allowance'); ?>
	</div>-->
	<div class="row">
		<?php echo $form->labelEx($model,'removal_allowance'); ?>
		<?php echo $form->numberField($model,'removal_allowance',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'removal_allowance'); ?>
	</div>
		<br><br><br><br><br><br><br>
		
	</fieldset>
	<table style='display:none'><tr><td>Total Allowances for the year: </td><td style='text-align:right; font-weight:bold' id=totall>0</td></tr></table>
</fieldset>
</td><td valign=top style='vertical-align:top'><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Operational Allowances</legend>
	<table width=100%><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'out_of_station'); ?>
		<?php echo $form->numberField($model,'out_of_station',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'out_of_station'); ?>
	</div>
</td><td style='text-align:right' id=out_of_station>0</td></tr><tr><td>

	<div class="row">
		<?php echo $form->labelEx($model,'travel_in_ug_op'); ?>
		<?php echo $form->numberField($model,'travel_in_ug_op',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'travel_in_ug_op'); ?>
	</div>
</td><td style='text-align:right' id=travel_in_ug_op>0</td></tr><tr><td>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekdayhrs'); ?>
		<?php echo $form->numberField($model,'overtime_weekdayhrs',array('max'=>100,'onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'overtime_weekdayhrs'); ?>
	</div>
</td><td style='text-align:right' id=overtime_weekdayhrs></td></tr><tr><td>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekdaydays'); ?>
		<?php echo $form->numberField($model,'overtime_weekdaydays',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'overtime_weekdaydays'); ?>
	</div>
</td><td style='text-align:right'></td></tr><tr><td>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekend_hrs'); ?>
		<?php echo $form->numberField($model,'overtime_weekend_hrs',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'overtime_weekend_hrs'); ?>
	</div>
</td><td style='text-align:right'></td></tr><tr><td>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekend_days'); ?>
		<?php echo $form->numberField($model,'overtime_weekend_days',array('max'=>100,'onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'overtime_weekend_days'); ?>
	</div>
</td><td style='text-align:right' id=overtime_weekend_days>0</td></tr><tr><td>
	
	<div class="row">
		<?php echo $form->labelEx($model,'weekend_lunch'); ?>
		<?php echo $form->numberField($model,'weekend_lunch',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'weekend_lunch'); ?>
	</div>
</td><td style='text-align:right' id=weekend_lunch>0</td></tr><tr><td>

	<div class="row">
		<?php echo $form->labelEx($model,'weekend_transport'); ?>
		<?php echo $form->numberField($model,'weekend_transport',array('onkeyup'=>'va();')); ?>
		<?php echo $form->error($model,'weekend_transport'); ?>
	</div>
</fieldset>
</td><td style='text-align:right' id=weekend_transport>0</td></tr></table>

</td></tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'emolumentrates-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'employee0.employee',
		'travel_in_ug_op',
		'travel_in_ug_cap',
		'weekend_lunch',
		'weekend_transport',
		'out_of_station',
		'acting_allowance',/*
		'mobile_phone_allowance',
		'risk_allowance',
		'responsibility_allowance',
		'driving_allowance',
		'mileage',
		'soap',
		'shift',
		'milk',
		'leave_in_lieu',
		'overtime_weekdayhrs',
		'overtime_weekdaydays',
		'overtime_weekend_hrs',
		'overtime_weekend_days',
		'shift_hours',
		'shift_days',
		'leave_start',
		'leave_end',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{view}{delete}',
			'buttons'=>array(
			'update' => 
				array(
				'url' =>'Yii::app()->createUrl("emolumentrates/updateemp", array("emp"=>$data->employee))',

				)
			)
		),
	),
)); ?>
