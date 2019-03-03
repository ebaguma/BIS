<?php
/* @var $this UsersRolesController */
/* @var $data UsersRoles */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user')); ?>:</b>
	<?php echo CHtml::encode($data->user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role')); ?>:</b>
	<?php echo CHtml::encode($data->role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromdate')); ?>:</b>
	<?php echo CHtml::encode($data->fromdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expirydate')); ?>:</b>
	<?php echo CHtml::encode($data->expirydate); ?>
	<br />


</div>