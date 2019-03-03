<?php
/* @var $this ReallocationController */
/* @var $data Reallocation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acfrom')); ?>:</b>
	<?php echo CHtml::encode($data->acfrom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acto')); ?>:</b>
	<?php echo CHtml::encode($data->acto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requestor')); ?>:</b>
	<?php echo CHtml::encode($data->requestor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approval1')); ?>:</b>
	<?php echo CHtml::encode($data->approval1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approval1_by')); ?>:</b>
	<?php echo CHtml::encode($data->approval1_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approval2')); ?>:</b>
	<?php echo CHtml::encode($data->approval2); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('approval2_by')); ?>:</b>
	<?php echo CHtml::encode($data->approval2_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approval3')); ?>:</b>
	<?php echo CHtml::encode($data->approval3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approval3_by')); ?>:</b>
	<?php echo CHtml::encode($data->approval3_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approval4')); ?>:</b>
	<?php echo CHtml::encode($data->approval4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approval4_by')); ?>:</b>
	<?php echo CHtml::encode($data->approval4_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disbursed')); ?>:</b>
	<?php echo CHtml::encode($data->disbursed); ?>
	<br />

	*/ ?>

</div>