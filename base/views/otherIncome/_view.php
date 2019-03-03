<?php
/* @var $this OtherIncomeController */
/* @var $data OtherIncome */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget')); ?>:</b>
	<?php echo CHtml::encode($data->budget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accountcode')); ?>:</b>
	<?php echo CHtml::encode($data->accountcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount1')); ?>:</b>
	<?php echo CHtml::encode($data->amount1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount2')); ?>:</b>
	<?php echo CHtml::encode($data->amount2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount3')); ?>:</b>
	<?php echo CHtml::encode($data->amount3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount4')); ?>:</b>
	<?php echo CHtml::encode($data->amount4); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('createdby')); ?>:</b>
	<?php echo CHtml::encode($data->createdby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createdon')); ?>:</b>
	<?php echo CHtml::encode($data->createdon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatedby')); ?>:</b>
	<?php echo CHtml::encode($data->updatedby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatedon')); ?>:</b>
	<?php echo CHtml::encode($data->updatedon); ?>
	<br />

	*/ ?>

</div>