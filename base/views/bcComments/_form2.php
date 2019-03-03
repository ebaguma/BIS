<?php
/* @var $this BcCommentsController */
/* @var $m BcComments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form2=$this->beginWidget('CActiveForm', array(
	'id'=>'bc-comments-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php // echo $form2->errorSummary($m); ?>

	<div class="row">
		<?php echo $form2->labelEx($m,'request'); ?>
		<?php echo $form->textField($m,'request'); ?>
		<?php echo $form->error($m,'request'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($m,'initiator'); ?>
		<?php echo $form->textField($m,'initiator'); ?>
		<?php echo $form->error($m,'initiator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($m,'owner'); ?>
		<?php echo $form->textField($m,'owner'); ?>
		<?php echo $form->error($m,'owner'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($m,'comments'); ?>
		<?php echo $form->textArea($m,'comments',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($m,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($m,'requestdate'); ?>
		<?php echo $form->textField($m,'requestdate'); ?>
		<?php echo $form->error($m,'requestdate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($m->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->