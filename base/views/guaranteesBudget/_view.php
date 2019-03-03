<?php
/* @var $this GuaranteesBudgetController */
/* @var $data GuaranteesBudget */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('guarantee')); ?>:</b>
	<?php echo CHtml::encode($data->guarantee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arrangement')); ?>:</b>
	<?php echo CHtml::encode($data->arrangement); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('establishment')); ?>:</b>
	<?php echo CHtml::encode($data->establishment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quarterly')); ?>:</b>
	<?php echo CHtml::encode($data->quarterly); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('annualrenewal')); ?>:</b>
	<?php echo CHtml::encode($data->annualrenewal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget')); ?>:</b>
	<?php echo CHtml::encode($data->budget); ?>
	<br />


</div>