<?php
/* @var $this TravelItemsController */
/* @var $data TravelItems */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item')); ?>:</b>
	<?php echo CHtml::encode($data->item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descr')); ?>:</b>
	<?php echo CHtml::encode($data->descr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foreigntravel')); ?>:</b>
	<?php echo CHtml::encode($data->foreigntravel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('training')); ?>:</b>
	<?php echo CHtml::encode($data->training); ?>
	<br />


</div>