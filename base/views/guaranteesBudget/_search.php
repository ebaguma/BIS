<?php
/* @var $this GuaranteesBudgetController */
/* @var $model GuaranteesBudget */
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
		<?php echo $form->label($model,'guarantee'); ?>
		<?php echo $form->textField($model,'guarantee'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'arrangement'); ?>
		<?php echo $form->textField($model,'arrangement'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'establishment'); ?>
		<?php echo $form->textField($model,'establishment'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quarterly'); ?>
		<?php echo $form->textField($model,'quarterly'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'annualrenewal'); ?>
		<?php echo $form->textField($model,'annualrenewal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'budget'); ?>
		<?php echo $form->textField($model,'budget'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->