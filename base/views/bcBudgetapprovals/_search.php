<?php
/* @var $this BcBudgetapprovalsController */
/* @var $model BcBudgetapprovals */
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
		<?php echo $form->label($model,'request'); ?>
		<?php echo $form->textField($model,'request'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approver_id'); ?>
		<?php echo $form->textField($model,'approver_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'decision'); ?>
		<?php echo $form->textField($model,'decision'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approverdate'); ?>
		<?php echo $form->textField($model,'approverdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comments'); ?>
		<?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approvallevel'); ?>
		<?php echo $form->textField($model,'approvallevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nextapprover_id'); ?>
		<?php echo $form->textField($model,'nextapprover_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nextapprover_role'); ?>
		<?php echo $form->textField($model,'nextapprover_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nextapprover_level'); ?>
		<?php echo $form->textField($model,'nextapprover_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nextapprover_done'); ?>
		<?php echo $form->textField($model,'nextapprover_done'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->