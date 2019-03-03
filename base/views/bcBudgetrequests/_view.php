<?php
/* @var $this BcBudgetrequestsController */
/* @var $data BcBudgetrequests */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requestdate')); ?>:</b>
	<?php echo CHtml::encode($data->requestdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requireddate')); ?>:</b>
	<?php echo CHtml::encode($data->requireddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requestor')); ?>:</b>
	<?php echo CHtml::encode($data->requestor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget')); ?>:</b>
	<?php echo CHtml::encode($data->budget); ?>
	<br />


</div>