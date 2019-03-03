<?php
/* @var $this VehiclesController */
/* @var $data Vehicles */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regno')); ?>:</b>
	<?php echo CHtml::encode($data->regno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicletype')); ?>:</b>
	<?php echo CHtml::encode($data->vehicletype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fueltype')); ?>:</b>
	<?php echo CHtml::encode($data->fueltype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('glcode')); ?>:</b>
	<?php echo CHtml::encode($data->glcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dept')); ?>:</b>
	<?php echo CHtml::encode($data->dept); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('section')); ?>:</b>
	<?php echo CHtml::encode($data->section); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsection')); ?>:</b>
	<?php echo CHtml::encode($data->subsection); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hired')); ?>:</b>
	<?php echo CHtml::encode($data->hired); ?>
	<br />

	*/ ?>

</div>