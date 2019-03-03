<?php
/* @var $this AllowancesController */
/* @var $data Allowances */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allowancetype')); ?>:</b>
	<?php echo CHtml::encode($data->allowancetype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('units')); ?>:</b>
	<?php echo CHtml::encode($data->units); ?>
	<br />


</div>