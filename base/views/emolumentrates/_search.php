<?php
/* @var $this EmolumentratesController */
/* @var $model Emolumentrates */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee'); ?>
		<?php echo $form->textField($model,'employee'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'travel_in_ug_op'); ?>
		<?php echo $form->textField($model,'travel_in_ug_op'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'travel_in_ug_cap'); ?>
		<?php echo $form->textField($model,'travel_in_ug_cap'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'weekend_lunch'); ?>
		<?php echo $form->textField($model,'weekend_lunch'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'weekend_transport'); ?>
		<?php echo $form->textField($model,'weekend_transport'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_of_station'); ?>
		<?php echo $form->textField($model,'out_of_station'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acting_allowance'); ?>
		<?php echo $form->textField($model,'acting_allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mobile_phone_allowance'); ?>
		<?php echo $form->textField($model,'mobile_phone_allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'risk_allowance'); ?>
		<?php echo $form->textField($model,'risk_allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'responsibility_allowance'); ?>
		<?php echo $form->textField($model,'responsibility_allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driving_allowance'); ?>
		<?php echo $form->textField($model,'driving_allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mileage'); ?>
		<?php echo $form->textField($model,'mileage'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'soap'); ?>
		<?php echo $form->textField($model,'soap'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shift'); ?>
		<?php echo $form->textField($model,'shift'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'milk'); ?>
		<?php echo $form->textField($model,'milk'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_in_lieu'); ?>
		<?php echo $form->textField($model,'leave_in_lieu'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'overtime_weekdayhrs'); ?>
		<?php echo $form->textField($model,'overtime_weekdayhrs'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'overtime_weekdaydays'); ?>
		<?php echo $form->textField($model,'overtime_weekdaydays'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'overtime_weekend_hrs'); ?>
		<?php echo $form->textField($model,'overtime_weekend_hrs'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'overtime_weekend_days'); ?>
		<?php echo $form->textField($model,'overtime_weekend_days'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shift_hours'); ?>
		<?php echo $form->textField($model,'shift_hours'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shift_days'); ?>
		<?php echo $form->textField($model,'shift_days'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_start'); ?>
		<?php echo $form->textField($model,'leave_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_end'); ?>
		<?php echo $form->textField($model,'leave_end'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->