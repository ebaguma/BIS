<?php
/* @var $this EmolumentratesController */
/* @var $model Emolumentrates */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'emolumentrates-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'employee'); ?>
		<?php echo $form->dropDownList($model,'employee',Chtml::ListData(Employees::model()->findAll(),'id','employee')); ?>
		<?php echo $form->error($model,'employee'); ?>
	</div>
	
<TABLE style='width:800px'><tr>
	<td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Allowances</legend>

	<div class="row">
		<?php echo $form->labelEx($model,'travel_in_ug_op'); ?>
		<?php echo $form->textField($model,'travel_in_ug_op'); ?>
		<?php echo $form->error($model,'travel_in_ug_op'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'travel_in_ug_cap'); ?>
		<?php echo $form->textField($model,'travel_in_ug_cap'); ?>
		<?php echo $form->error($model,'travel_in_ug_cap'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'weekend_lunch'); ?>
		<?php echo $form->textField($model,'weekend_lunch'); ?>
		<?php echo $form->error($model,'weekend_lunch'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weekend_transport'); ?>
		<?php echo $form->textField($model,'weekend_transport'); ?>
		<?php echo $form->error($model,'weekend_transport'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_of_station'); ?>
		<?php echo $form->textField($model,'out_of_station'); ?>
		<?php echo $form->error($model,'out_of_station'); ?>
	</div>
</fieldset>
</td><td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Travel Allowances</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'acting_allowance'); ?>
		<?php echo $form->textField($model,'acting_allowance'); ?>
		<?php echo $form->error($model,'acting_allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile_phone_allowance'); ?>
		<?php echo $form->textField($model,'mobile_phone_allowance'); ?>
		<?php echo $form->error($model,'mobile_phone_allowance'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'risk_allowance'); ?>
		<?php echo $form->textField($model,'risk_allowance'); ?>
		<?php echo $form->error($model,'risk_allowance'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'responsibility_allowance'); ?>
		<?php echo $form->textField($model,'responsibility_allowance'); ?>
		<?php echo $form->error($model,'responsibility_allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driving_allowance'); ?>
		<?php echo $form->textField($model,'driving_allowance'); ?>
		<?php echo $form->error($model,'driving_allowance'); ?>
	</div>
</fieldset></td></tr>
<tr><td style="vertical-align: text-top;"><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> myTravel Allowances</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'mileage'); ?>
		<?php echo $form->textField($model,'mileage'); ?>
		<?php echo $form->error($model,'mileage'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'soap'); ?>
		<?php echo $form->textField($model,'soap'); ?>
		<?php echo $form->error($model,'soap'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift'); ?>
		<?php echo $form->textField($model,'shift'); ?>
		<?php echo $form->error($model,'shift'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'milk'); ?>
		<?php echo $form->textField($model,'milk'); ?>
		<?php echo $form->error($model,'milk'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'leave_in_lieu'); ?>
		<?php echo $form->textField($model,'leave_in_lieu'); ?>
		<?php echo $form->error($model,'leave_in_lieu'); ?>
	</div>
</fieldset></td><td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Travel Allowances</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekdayhrs'); ?>
		<?php echo $form->textField($model,'overtime_weekdayhrs'); ?>
		<?php echo $form->error($model,'overtime_weekdayhrs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekdaydays'); ?>
		<?php echo $form->textField($model,'overtime_weekdaydays'); ?>
		<?php echo $form->error($model,'overtime_weekdaydays'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekend_hrs'); ?>
		<?php echo $form->textField($model,'overtime_weekend_hrs'); ?>
		<?php echo $form->error($model,'overtime_weekend_hrs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime_weekend_days'); ?>
		<?php echo $form->textField($model,'overtime_weekend_days'); ?>
		<?php echo $form->error($model,'overtime_weekend_days'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'shift_hours'); ?>
		<?php echo $form->textField($model,'shift_hours'); ?>
		<?php echo $form->error($model,'shift_hours'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift_days'); ?>
		<?php echo $form->textField($model,'shift_days'); ?>
		<?php echo $form->error($model,'shift_days'); ?>
	</div>
	-->
</fieldset></td></tr></table>
<!--
	<div class="row" id="leave_start" style="display:block">
    <?php echo $form->labelEx($model,'Leave Start'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'Emolumentrates[leave_start]',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'clip',
		'dateFormat'=>'yy-mm-dd',
		'yearRange'=>'2015:2016',
    ),
    'htmlOptions'=>array(
        'style'=>'height:13px;'
    ),
));   ?> 
    <?php echo $form->error($model,'leave_end'); ?>
	</div>

	<div class="row" id="leave_end" style="display:block">
    <?php echo $form->labelEx($model,'Leave End'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'Emolumentrates[leave_end]',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'clip',
		'dateFormat'=>'yy-mm-dd',
		'yearRange'=>'2015:2016',
    ),
    'htmlOptions'=>array(
        'style'=>'height:13px;'
    ),
));   ?> 
<?php echo $form->error($model,'leave_end'); ?>
    </div>
	-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->