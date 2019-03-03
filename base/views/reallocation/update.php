<?php
/* @var $this ReallocationController */
/* @var $model Reallocation */

$this->breadcrumbs=array(
	'Reallocations'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Reallocation', 'url'=>array('index')),
	array('label'=>'Create Reallocation', 'url'=>array('create')),
	array('label'=>'View Reallocation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Reallocation', 'url'=>array('admin')),
);
?>

<h1>Update Reallocation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>