<?php
/* @var $this TravelItemsController */
/* @var $model TravelItems */

$this->breadcrumbs=array(
	'Travel Items'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TravelItems', 'url'=>array('index')),
	array('label'=>'Manage TravelItems', 'url'=>array('admin')),
);
?>

<h1>Create TravelItems</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>