<style>
.emptable tr {
	margin:0px;
	padding:-20px;
	height:10px;
}

.subtable {
 border: 1px #aaaaaa ridge;

}
.subtable tr {
	height:5px !important;
	padding-top: 10px !important;
}
div.background {
   border: 0px solid black;

}
div.background img.bg {
		position: absolute;
	    left: 10%;
	    top: 20%;
	    width: 40%;
	    height: auto;
	    opacity: 0.05;
		 z-index:-2;
}
#myform {
	padding:20px;
}
</style>

<div class=background>
	<img src='images/telephone.png' class='bg'/>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'telephones-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number'); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'purpose'); ?>
		<?php echo $form->dropDownList($model,'purpose',CHtml::listData(TelephonePurpose::model()->findAll(), 'id', 'purpose')); ?>

		<?php echo $form->error($model,'purpose'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner'); ?>
		<?php echo $form->dropDownList($model,'owner',CHtml::listData(Employees::model()->findAll(), 'id', 'employee')); ?>
		<?php echo $form->error($model,'owner'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'telephones-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'number',
		'purpose',
		'owner0.employee',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>