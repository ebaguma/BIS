<?php
/* @var $this UsersRolesController */
/* @var $model UsersRoles */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-roles-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->dropDownList($model,'user',Chtml::ListData(Users::model()->findAll('1 order by username'),'id','username')); ?>
		<?php echo $form->error($model,'user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role',Chtml::ListData(Roles::model()->findAll('1 order by rolename'),'id','rolename')); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model,'active',array('1'=>'Active','0'=>'Disabled')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fromdate'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'UsersRoles[fromdate]',
	    // additional javascript options for the date picker plugin
	    'options'=>array(
	        'showAnim'=>'clip',
			'dateFormat'=>'yy-mm-dd',
			'yearRange'=>'2015:2016',
	    ),
		'value'=>$model->fromdate,
	    'htmlOptions'=>array('style'=>'width:265px;'),
	));   ?> 
		<?php echo $form->error($model,'fromdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expirydate'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'UsersRoles[expirydate]',
	    // additional javascript options for the date picker plugin
	    'options'=>array(
	        'showAnim'=>'clip',
			'dateFormat'=>'yy-mm-dd',
			'yearRange'=>'2015:2016',
	    ),
		'value'=>$model->expirydate,
	    'htmlOptions'=>array('style'=>'width:265px;'),
	));   ?> 
		<?php echo $form->error($model,'expirydate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->