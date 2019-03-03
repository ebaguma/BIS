<?php
/* @var $this OtherIncomeController */
/* @var $model OtherIncome */
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
		<?php echo $form->label($model,'budget'); ?>
		<?php echo $form->textField($model,'budget'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accountcode'); ?>
		<?php echo $form->textField($model,'accountcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount1'); ?>
		<?php echo $form->textField($model,'amount1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount2'); ?>
		<?php echo $form->textField($model,'amount2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount3'); ?>
		<?php echo $form->textField($model,'amount3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount4'); ?>
		<?php echo $form->textField($model,'amount4'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createdby'); ?>
		<?php echo $form->textField($model,'createdby'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createdon'); ?>
		<?php echo $form->textField($model,'createdon'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updatedby'); ?>
		<?php echo $form->textField($model,'updatedby'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updatedon'); ?>
		<?php echo $form->textField($model,'updatedon'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->