<?php
/* @var $this BcBudgetapprovalsController */
/* @var $data BcBudgetapprovals */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request')); ?>:</b>
	<?php echo CHtml::encode($data->request); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approver')); ?>:</b>
	<?php echo CHtml::encode($data->approver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('decision')); ?>:</b>
	<?php echo CHtml::encode($data->decision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approverdate')); ?>:</b>
	<?php echo CHtml::encode($data->approverdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
	<?php echo CHtml::encode($data->comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approvallevel')); ?>:</b>
	<?php echo CHtml::encode($data->approvallevel); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nextapprover')); ?>:</b>
	<?php echo CHtml::encode($data->nextapprover); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nextapprover_role')); ?>:</b>
	<?php echo CHtml::encode($data->nextapprover_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nextapprover_level')); ?>:</b>
	<?php echo CHtml::encode($data->nextapprover_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nextapprover_done')); ?>:</b>
	<?php echo CHtml::encode($data->nextapprover_done); ?>
	<br />

	*/ ?>

</div>