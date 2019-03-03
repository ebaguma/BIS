<?php
/* @var $this AllowancesController */
/* @var $model Allowances */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'allowances-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'allowancetype'); ?>
		<?php echo $form->dropDownList($model,'allowancetype',array(',monthly'=>'Monthly','daily'=>'Daily','annual'=>'Annually','custom'=>'Custom')); ?>
		<?php echo $form->error($model,'allowancetype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'units'); ?>
		<?php echo $form->dropDownList($model,'units',CHtml::listData(Units::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'units'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->