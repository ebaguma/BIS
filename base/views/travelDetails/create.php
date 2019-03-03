<?php
/* @var $this TravelDetailsController */
/* @var $model TravelDetails */

$this->breadcrumbs=array(
	'Travel Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TravelDetails', 'url'=>array('index')),
	array('label'=>'Manage TravelDetails', 'url'=>array('admin')),
);
?>

<h1>Create TravelDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>