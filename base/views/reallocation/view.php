<?php
/* @var $this ReallocationController */
/* @var $model Reallocation */

$this->breadcrumbs=array(
	'Reallocations'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List Reallocation', 'url'=>array('index')),
	//array('label'=>'Create Reallocation', 'url'=>array('create')),
	//array('label'=>'Update Reallocation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Reallocation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Reallocation', 'url'=>array('admin')),
);
?>

<h1>View Reallocation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'acfrom',
		'acto',
		'requestor',
		'approval1',
		'approval1_by',
		'approval2',
		'approval2_by',
		'approval3',
		'approval3_by',
		'approval4',
		'approval4_by',
		'disbursed',
	),
)); ?>
