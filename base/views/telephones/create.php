<?php
/* @var $this TelephonesController */
/* @var $model Telephones */

$this->breadcrumbs=array(
	'Telephones'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Telephones', 'url'=>array('index')),
	array('label'=>'Manage Telephones', 'url'=>array('admin')),
);
?>

<h1>Register a  Telephone Line</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>