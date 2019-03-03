<?php
/* @var $this DeptController */
/* @var $model Dept */
/* @var $form CActiveForm */
?>
<?php Yii::app()->clientScript->registerScript('textFieldAdder','$("#additional-link").bind("click",function(){
    var id="optional_text";
    var size=$("#additional-inputs > li input").size();
    $("#additional-inputs").append("<li><input type=text id="+id+size+" name="+id+"["+size+"]></li>");
    })')?>

<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dept-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dept'); ?>
		<?php echo $form->textField($model,'dept',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'dept'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent'); ?>
		<?php echo $form->textField($model,'parent'); ?>
		<?php echo $form->error($model,'parent'); ?>
	</div>








<div class="row">

<?php echo CHtml::link('Add input','#',array('id'=>'additional-link')); ?>
<ul>
<div id="additional-inputs">
    <li><?php echo CHtml::textfield('optional_text[0]','');?></li>
</div>
</ul>
</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
   </div><!-- form -->
<?php $this->endWidget(); ?>
