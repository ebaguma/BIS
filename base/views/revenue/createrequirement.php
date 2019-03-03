<?php
/* @var $this RevenueController */
/* @var $model Revenue */

$this->breadcrumbs=array(
	'Revenues'=>array('index'),
	'Create',
);

//$this->menu=array(
	//array('label'=>'List Revenue', 'url'=>array('index')),
//	array('label'=>'Manage Revenue', 'url'=>array('admin')),
//);
?>

<h1>Revenue Requirement</h1>

<?php $this->renderPartial('purchases', array('model'=>$model)); ?>