<?php
/* @var $this ItemsController */
/* @var $data Items */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accountcode')); ?>:</b>
	<?php echo CHtml::encode($data->accountcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costcentre')); ?>:</b>
	<?php echo CHtml::encode($data->costcentre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descr')); ?>:</b>
	<?php echo CHtml::encode($data->descr); ?>
	<br />


</div>