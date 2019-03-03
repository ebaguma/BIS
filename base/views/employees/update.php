<?php
/* @var $this EmployeesController */
/* @var $model Employees */

$this->breadcrumbs=array(
	'Employees'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Employees', 'url'=>array('index')),
	array('label'=>'Create Employee', 'url'=>array('create')),
	array('label'=>'View Employee', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Employees', 'url'=>array('admin')),
);
?>

<h1>Update Employee: <?php echo $model->employee; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>