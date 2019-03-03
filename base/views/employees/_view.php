<?php
/* @var $this EmployeesController */
/* @var $data Employees */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checkno')); ?>:</b>
	<?php echo CHtml::encode($data->checkno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee')); ?>:</b>
	<?php echo CHtml::encode($data->employee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('designation')); ?>:</b>
	<?php echo CHtml::encode($data->designation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salary_scale')); ?>:</b>
	<?php echo CHtml::encode($data->salary_scale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spine')); ?>:</b>
	<?php echo CHtml::encode($data->spine); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('section')); ?>:</b>
	<?php echo CHtml::encode($data->section); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit')); ?>:</b>
	<?php echo CHtml::encode($data->unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift')); ?>:</b>
	<?php echo CHtml::encode($data->shift); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('standby')); ?>:</b>
	<?php echo CHtml::encode($data->standby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contract')); ?>:</b>
	<?php echo CHtml::encode($data->contract); ?>
	<br />

	*/ ?>

</div>