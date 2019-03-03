<?php
/* @var $this DeptController */
/* @var $model Dept */

$this->breadcrumbs=array(
	'Depts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create Dept', 'url'=>array('create')),
	array('label'=>'Update Dept', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Dept', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Dept', 'url'=>array('admin')),
);
?>

<h1>View Dept #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
		'dept',
	//	'accountcode',
		'shortname',
	),
)); ?>
