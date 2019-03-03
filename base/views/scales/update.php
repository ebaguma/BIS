<?php
/* @var $this ScalesController */
/* @var $model Scales */

$this->breadcrumbs=array(
	'Scales'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Scales', 'url'=>array('index')),
	array('label'=>'Create Scales', 'url'=>array('create')),
	array('label'=>'View Scales', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Scales', 'url'=>array('admin')),
);
?>

<h1>Update Scales <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>