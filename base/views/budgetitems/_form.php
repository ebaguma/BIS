<?php
/* @var $this BudgetitemsController */
/* @var $model Budgetitems */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'budgetitems-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php /*
	 $role_list = CHtml::listData(Categories::model()->findAll(), 'id', 'name');
	echo CHtml::dropDownList('category','', $role_list,
	array(
	'ajax' => array(
	'type'=>'POST', //request type
	'url'=>CController::createUrl('budgetitems/CostCentres'), //url to call.
	//Style: CController::createUrl('currentController/methodToCall')
	'update'=>'#Budgetitems_costcentre', //selector to update
	//'data'=>'js:javascript statement' 
	//leave out the data key to pass all form values through
	))); */
	?>
	</div>	
   <div class="row">
	<?php echo $form->labelEx($model,'costcentre'); ?>
   <?php 
//empty since it will be filled by the other dropdown array('category'=>$_REQUEST['cat'])
	$data=CHtml::listData(Costcentres::model()->findAll('category='.$_GET['cat']),'id','name');
	echo CHtml::dropDownList('Budgetitems[costcentre]','', $data,
	array(
	'ajax' => array(
	'type'=>'POST', //request type
	'url'=>CController::createUrl('budgetitems/items'), //url to call.
	//Style: CController::createUrl('currentController/methodToCall')
	'update'=>'#Budgetitems_item', //selector to update
	//'data'=>'js:javascript statement' 
	//leave out the data key to pass all form values through
	)));	?>
	<div class="row">
		<?php echo $form->labelEx($model,'item'); 
			echo CHtml::dropDownList('Budgetitems[item]','', array());

		 echo $form->error($model,'item'); ?>
	</div>
    
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->NumberField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'dept'); 
		    $role_list = CHtml::listData(Dept::model()->findAll('id=(select dept from users where id= '.Yii::app()->user->id.')'), 'id', 'dept');
			echo $form->dropDownList($model,'dept', $role_list); 
		 echo $form->error($model,'dept'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'budget'); 
		    $role_list = CHtml::listData(Budgets::model()->findAll(), 'id', 'name');
			echo $form->dropDownList($model,'budget', $role_list); 

		 echo $form->error($model,'budget'); ?>
	</div>
-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->