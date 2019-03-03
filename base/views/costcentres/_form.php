<?php
/* @var $this CostcentresController */
/* @var $model Costcentres */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'costcentres-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'accountcode'); ?>
		<?php echo $form->textField($model,'accountcode'); ?>
		<?php echo $form->error($model,'accountcode'); ?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'category'); 
		    $role_list = CHtml::listData(categories::model()->findAll(), 'id', 'name');
			echo $form->dropDownList($model,'category', $role_list); 
			echo $form->error($model,'category'); 
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descr'); ?>
		<?php echo $form->textField($model,'descr',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descr'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->