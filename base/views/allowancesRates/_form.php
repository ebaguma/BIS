<?php
/* @var $this AllowancesRatesController */
/* @var $model AllowancesRates */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'allowances-rates-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'allowance'); ?> 
		<?php echo $form->dropDownList($model,'allowance',CHtml::listData(Allowances::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'scale'); ?>
		<?php echo $form->dropDownList($model,'allowance',CHtml::listData(Scales::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'scale'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rate'); ?>
		<?php echo $form->textField($model,'rate'); ?>
		<?php echo $form->error($model,'rate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->