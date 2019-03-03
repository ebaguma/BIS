<?php
/* @var $this OtherIncomeController */
/* @var $model OtherIncome */

$this->breadcrumbs=array(
	'Other Incomes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OtherIncome', 'url'=>array('index')),
	array('label'=>'Create OtherIncome', 'url'=>array('create')),
	array('label'=>'Update OtherIncome', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OtherIncome', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OtherIncome', 'url'=>array('admin')),
);
?>

<h1>View OtherIncome #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'budget',
		'accountcode',
		'amount1',
		'amount2',
		'amount3',
		'amount4',
		'createdby',
		'createdon',
		'updatedby',
		'updatedon',
	),
)); ?>
