<?php
/* @var $this EmployeesController */
/* @var $model Employees */

$this->breadcrumbs=array(
	'Employees'=>array(''),
	'Create',
);
$this->menu=array(
//	array('label'=>'Create Employees', 'url'=>array('create')),
	array('label'=>'View Employees', 'url'=>array('admin')),
);

?>

<h1>Add an Employee</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>