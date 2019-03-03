<?php
/* @var $this SubsectionsController */
/* @var $model Subsections */

$this->breadcrumbs=array(
	'Subsections'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Subsections', 'url'=>array('index')),
	array('label'=>'Manage Subsections', 'url'=>array('admin')),
);
?>

<h1>Create Subsections</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>