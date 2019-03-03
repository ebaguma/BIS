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
    <b>Staff</b><br/>
	<?php 
	 $role_list = CHtml::listData(Staff::model()->findAll('dept='.Yii::app()->user->dept->id), 'id', 'names');
	echo CHtml::dropDownList('category','', $role_list); 
	?>
	</div>	
   <div class="row">
    <b>Constant Allowances:</b>
   <table>
	<?php 
	 $role_list = CHtml::listData(Allowances::model()->findAll('allowancetype !=\'custom\''), 'id', 'name');
	echo CHtml::checkBoxList('allowance','', $role_list,
	
	    array(
        'template'=>'<tr><td width=10>{input}</td><td>{label}</td></tr>',
        'separator'=>'',
       // 'labelOptions'=>array('style'=> 'padding-left:13px;width: 60px;float: left; '), )//'style'=>'float:left;',
        )
	); 
	?>
   </table>
	</div>
   <div class="row">
   <b>Variable Allowances:</b>
   <table>
	<?php 
	 $role_list = CHtml::listData(Allowances::model()->findAll('allowancetype =\'custom\''), 'id', 'name');
	echo CHtml::checkBoxList('vallowance','', $role_list,
	
	    array(
        'template'=>'<tr><td width=10>{input}</td><td width=130>{label}</td><td  width=40>Units:</td><td><input name=\'units[]\' size=4/></td></tr>',
        'separator'=>'',
       // 'labelOptions'=>array('style'=> 'padding-left:13px;width: 60px;float: left; '), )//'style'=>'float:left;',
        )
	); 
	?>
   </table>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->