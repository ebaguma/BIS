<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'items-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<!--<div class="row">
		<?php echo $form->labelEx($model,'accountcode'); ?>
		<?php echo $form->textField($model,'accountcode'); ?>
		<?php echo $form->error($model,'accountcode'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'Cost Centre'); 
		    $rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
			 $role_list=array();
			 foreach($rl as $r) $role_list[$r[accountcode]]=$r[accountcode]." - ".$r[item];
			echo Chtml::dropDownList('costcentre', array(), $role_list,
				array(
					'empty' => ' - Select a Cost Centre - ',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('Items/item'), 
						'update'=>'#Items_accountcode',
					),
					
			)); 
		 echo $form->error($model,'costcentre'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Account Code'); 
			echo $form->dropDownList($model,'accountcode', array(),array('prompt'=>'- select -')); 
		 echo $form->error($model,'costcentre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Item Name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Description'); ?>
		<?php echo $form->textField($model,'descr',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descr'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Units of Measure'); ?>
		<?php echo $form->dropDownList($model,'descr',Chtml::ListData(Units::model()->findAll(),'id','label')); ?>
		<?php echo $form->error($model,'descr'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->