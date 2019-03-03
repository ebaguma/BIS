<?php
/* @var $this BcReallocationController */
/* @var $model BcReallocation */
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
		<?php echo $form->label($model,'fromitem'); ?>
		<?php echo $form->textField($model,'fromitem'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'toitem'); ?>
		<?php echo $form->textField($model,'toitem'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'budget'); ?>
		<?php echo $form->textField($model,'budget'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requestor'); ?>
		<?php echo $form->textField($model,'requestor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requestdate'); ?>
		<?php echo $form->textField($model,'requestdate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->