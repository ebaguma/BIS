<?php
/* @var $this DeptController */
/* @var $model Dept */

$this->breadcrumbs=array(
	'Depts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Dept', 'url'=>array('index')),
	array('label'=>'Create Dept', 'url'=>array('create')),
	array('label'=>'View Dept', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Dept', 'url'=>array('admin')),
);
?>

<h1>Update Dept <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>