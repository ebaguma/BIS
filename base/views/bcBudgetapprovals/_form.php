<?php
/* @var $this BcBudgetapprovalsController */
/* @var $model BcBudgetapprovals */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bc-budgetapprovals-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'request'); ?>
		<?php echo $form->textField($model,'request'); ?>
		<?php echo $form->error($model,'request'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approver'); ?>
		<?php echo $form->textField($model,'approver'); ?>
		<?php echo $form->error($model,'approver'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'decision'); ?>
		<?php echo $form->textField($model,'decision'); ?>
		<?php echo $form->error($model,'decision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approverdate'); ?>
		<?php echo $form->textField($model,'approverdate'); ?>
		<?php echo $form->error($model,'approverdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comments'); ?>
		<?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approvallevel'); ?>
		<?php echo $form->textField($model,'approvallevel'); ?>
		<?php echo $form->error($model,'approvallevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nextapprover'); ?>
		<?php echo $form->textField($model,'nextapprover'); ?>
		<?php echo $form->error($model,'nextapprover'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nextapprover_role'); ?>
		<?php echo $form->textField($model,'nextapprover_role'); ?>
		<?php echo $form->error($model,'nextapprover_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nextapprover_level'); ?>
		<?php echo $form->textField($model,'nextapprover_level'); ?>
		<?php echo $form->error($model,'nextapprover_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nextapprover_done'); ?>
		<?php echo $form->textField($model,'nextapprover_done'); ?>
		<?php echo $form->error($model,'nextapprover_done'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->