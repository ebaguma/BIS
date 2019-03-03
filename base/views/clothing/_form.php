<?php
/* @var $this ClothingController */
/* @var $model Clothing */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clothing-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'budget',array('value'=>Yii::app()->user->budget['id'])); ?>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'item'); ?>
		<?php echo $form->dropDownList($model,'item',Chtml::ListData(Employees::model()->findAll(),'id','name')); ?>
		<?php echo $form->error($model,'item'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size'); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'employee'); ?>
		<?php echo $form->dropDownList($model,'employee',Chtml::ListData(Employees::model()->findAll("department='".Yii::app()->user->dept->id."' or  section='".Yii::app()->user->dept->id."' or unit='".Yii::app()->user->dept->id."'"),'id','employee')); ?>
		<?php echo $form->error($model,'employee'); ?>
	</div>
<?php 
	$ci=Chtml::ListData(ClothingItems::model()->findAll(),'id','item');
	$cs=Chtml::ListData(ClothingSizes::model()->findAll(),'id','size');
	$csz=$ciz="";
	foreach ($ci as $k=>$v)	$ciz .="<option value=".$k.">".$v."</option>";
	foreach ($cs as $k=>$v)	$csz .="<option value=".$k.">".$v."</option>";
Yii::app()->clientScript->registerScript('textFieldAdder','$("#additional-link").bind("click",function(){
	 var size=$("#additional-inputs > tr").size();
	 var rown= size%2==0 ? "even" : "odd";
    $("#additional-inputs").append("<tr class="+rown+"><td><select name=Clothing[item][]>'.$ciz.'</select></td><td><select name=Clothing[size][]>'.$csz.'</select></td><td><input size=4 type=text name=Clothing[quantity][]></td></tr>");
    })')
?>    
<div class="grid-view row">
<?php echo CHtml::link('Add Clothing Details','#',array('id'=>'additional-link')); ?>
<table class="items"><tr><th>Item</th><th>Size</th><th>Quantity</th></tr><tbody id="additional-inputs"></tbody></table>
</div>
    
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'budget'); ?>
		<?php echo $form->textField($model,'budget'); ?>
		<?php echo $form->error($model,'budget'); ?>
	</div>
-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->