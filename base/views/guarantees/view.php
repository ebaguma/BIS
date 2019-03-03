<?php
/* @var $this GuaranteesController */
/* @var $model Guarantees */

$this->breadcrumbs=array(
	'Guarantees'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Guarantees', 'url'=>array('index')),
	array('label'=>'Create Guarantees', 'url'=>array('create')),
	array('label'=>'Update Guarantees', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Guarantees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Guarantees', 'url'=>array('admin')),
);
?>

<h1>View Guarantees #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'amount',
	),
)); ?>
