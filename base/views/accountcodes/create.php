<?php
/* @var $this AccountcodesController */
/* @var $model Accountcodes */

$this->breadcrumbs=array(
	'Accountcodes'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Accountcodes', 'url'=>array('index')),
	array('label'=>'Manage Accountcodes', 'url'=>array('admin')),
);
?>

<h1>Create Accountcodes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>