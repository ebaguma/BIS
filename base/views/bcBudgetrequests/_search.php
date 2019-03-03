<?php
/* @var $this BcBudgetrequestsController */
/* @var $model BcBudgetrequests */
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
		<?php echo $form->label($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requestdate'); ?>
		<?php echo $form->textField($model,'requestdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requireddate'); ?>
		<?php echo $form->textField($model,'requireddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requestor'); ?>
		<?php echo $form->textField($model,'requestor'); ?>
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