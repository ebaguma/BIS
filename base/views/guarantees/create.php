<?php
/* @var $this GuaranteesController */
/* @var $model Guarantees */

$this->breadcrumbs=array(
	'Guarantees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Guarantees', 'url'=>array('index')),
	array('label'=>'Manage Guarantees', 'url'=>array('admin')),
);
?>

<h1>Create Guarantees</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>