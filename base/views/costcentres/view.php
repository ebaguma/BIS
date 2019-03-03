<?php
/* @var $this CostcentresController */
/* @var $model Costcentres */

$this->breadcrumbs=array(
	'Costcentres'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Costcentres', 'url'=>array('index')),
	array('label'=>'Create Costcentres', 'url'=>array('create')),
	array('label'=>'Update Costcentres', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Costcentres', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Costcentres', 'url'=>array('admin')),
);
?>

<h1>View Costcentres #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'accountcode',
		'category',
		'name',
		'descr',
	),
)); ?>
