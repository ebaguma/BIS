<?php
/* @var $this DeptController */
/* @var $model Dept */

$this->breadcrumbs=array(
	'Depts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Dept', 'url'=>array('index')),
	array('label'=>'Manage Dept', 'url'=>array('admin')),
);
?>

<h1>Create Dept</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>