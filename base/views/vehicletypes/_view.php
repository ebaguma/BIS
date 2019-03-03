<?php
/* @var $this VehicletypesController */
/* @var $data Vehicletypes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicletype')); ?>:</b>
	<?php echo CHtml::encode($data->vehicletype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descr')); ?>:</b>
	<?php echo CHtml::encode($data->descr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serviceinterval')); ?>:</b>
	<?php echo CHtml::encode($data->serviceinterval); ?>
	<br />


</div>