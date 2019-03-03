<?php
/* @var $this RevenueController */
/* @var $model Revenue */

$this->breadcrumbs=array(
	'Revenues'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Revenue', 'url'=>array('create')),
	array('label'=>'Manage Revenue', 'url'=>array('admin')),
);
?>

<h1>Update Revenue </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>