<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */
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
		<?php echo $form->label($model,'regno'); ?>
		<?php echo $form->textField($model,'regno',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vehicletype'); ?>
		<?php echo $form->textField($model,'vehicletype'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fueltype'); ?>
		<?php echo $form->textField($model,'fueltype',array('size'=>6,'maxlength'=>6)); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dept'); ?>
		<?php echo $form->textField($model,'dept'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'section'); ?>
		<?php echo $form->textField($model,'section'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subsection'); ?>
		<?php echo $form->textField($model,'subsection'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->