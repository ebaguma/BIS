<?php
/* @var $this BcReallocationController */
/* @var $data BcReallocation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromitem')); ?>:</b>
	<?php echo CHtml::encode($data->fromitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('toitem')); ?>:</b>
	<?php echo CHtml::encode($data->toitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget')); ?>:</b>
	<?php echo CHtml::encode($data->budget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requestor')); ?>:</b>
	<?php echo CHtml::encode($data->requestor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requestdate')); ?>:</b>
	<?php echo CHtml::encode($data->requestdate); ?>
	<br />


</div>