<?php

$this->breadcrumbs=array(
	'Designations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create Designation', 'url'=>array('create')),
	array('label'=>'Update Designation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Designation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this designation?')),
	array('label'=>'Manage Designations', 'url'=>array('admin')),
);
?>

<h1>View Designations #<?php echo $model->designation; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
		'designation',
	),
)); ?>
