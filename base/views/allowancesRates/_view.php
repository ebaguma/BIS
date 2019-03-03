<?php
/* @var $this AllowancesRatesController */
/* @var $data AllowancesRates */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allowance')); ?>:</b>
	<?php echo CHtml::encode($data->allowance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('scale')); ?>:</b>
	<?php echo CHtml::encode($data->scale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate')); ?>:</b>
	<?php echo CHtml::encode($data->rate); ?>
	<br />


</div>