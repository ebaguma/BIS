<?php
/* @var $this ReallocationController */
/* @var $model Reallocation */
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
		<?php echo $form->label($model,'acfrom'); ?>
		<?php echo $form->textField($model,'acfrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acto'); ?>
		<?php echo $form->textField($model,'acto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requestor'); ?>
		<?php echo $form->textField($model,'requestor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval1'); ?>
		<?php echo $form->textField($model,'approval1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval1_by'); ?>
		<?php echo $form->textField($model,'approval1_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval2'); ?>
		<?php echo $form->textField($model,'approval2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval2_by'); ?>
		<?php echo $form->textField($model,'approval2_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval3'); ?>
		<?php echo $form->textField($model,'approval3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval3_by'); ?>
		<?php echo $form->textField($model,'approval3_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval4'); ?>
		<?php echo $form->textField($model,'approval4'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approval4_by'); ?>
		<?php echo $form->textField($model,'approval4_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'disbursed'); ?>
		<?php echo $form->textField($model,'disbursed'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->