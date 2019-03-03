<?php
/* @var $this TemplateController */
/* @var $model Template */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'template-form',
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
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entity'); ?>
		<?php echo $form->textField($model,'entity'); ?>
		<?php echo $form->error($model,'entity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner'); ?>
		<?php // echo $form->textField($model,'owner'); ?>
        <?php
       // $list = CHtml::listData(template::model()->findAll(array('dept' => 'id')), 'id', 'id');
        //echo $form->dropDownList($model, 'id', $list); ?>
           <?php
    $list = CHtml::listData(users::model()->findAll(array('order' => 'id')), 'id', 'names'); //table_col_name1 is value of option, table_col_name2 is label of option
    // echo $form->dropDownList($model, 'product_type_id', $list);
    echo CHtml::dropDownList('owner', $model, $list);
    ?>
		<?php echo $form->error($model,'owner'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rights'); ?>
		<?php echo $form->textField($model,'rights'); ?>
		<?php echo $form->error($model,'rights'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->