<?php
/* @var $this PlantRepairController */
/* @var $model PlantRepair */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'plant-repair-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->hiddenField($model,'budget',array('value'=>Yii::app()->user->budget['id'])); ?>

	<?php echo $form->errorSummary($model); ?>
<table><tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'Activity Number'); ?>
		<?php echo $form->textField($model,'activity'); ?>
		<?php echo $form->error($model,'activity'); ?>
	</div>
</td><td>    
	<div class="row">
		<?php echo $form->labelEx($model,'Cost Item'); ?>
		<?php echo $form->dropDownList($model,'item',Chtml::ListData(PlantRepairItems::model()->findAll(),'id','item')); ?>
		<?php echo $form->error($model,'item'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'labour_source'); ?>
		<?php echo $form->dropDownList($model,'labour_source',array('Internal'=>'Internal','External'=>'External')); ?>
		<?php echo $form->error($model,'labour_source'); ?>
	</div>
</td></tr>
<tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'section'); ?>
		<?php echo $form->textField($model,'section'); ?>
		<?php echo $form->error($model,'section'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'subsection'); ?>
		<?php echo $form->textField($model,'subsection'); ?>
		<?php echo $form->error($model,'subsection'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'site'); ?>
		<?php echo $form->textField($model,'site'); ?>
		<?php echo $form->error($model,'site'); ?>
	</div>

</td></tr>
<tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'startdate'); ?>
		<?php echo $form->textField($model,'startdate'); ?>
		<?php echo $form->error($model,'startdate'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'enddate'); ?>
		<?php echo $form->textField($model,'enddate'); ?>
		<?php echo $form->error($model,'enddate'); ?>
	</div>
</td></tr>
<tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'casuals'); ?>
		<?php echo $form->textField($model,'casuals'); ?>
		<?php echo $form->error($model,'casuals'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'petrol'); ?>
		<?php echo $form->textField($model,'petrol'); ?>
		<?php echo $form->error($model,'petrol'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'diesel'); ?>
		<?php echo $form->textField($model,'diesel'); ?>
		<?php echo $form->error($model,'diesel'); ?>
	</div>
</td></tr></table>

	<div class="row">
		<?php echo $form->labelEx($model,'repair_items'); ?>
		<?php echo $form->textField($model,'repair_items',array('size'=>45,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'repair_items'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>3, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->