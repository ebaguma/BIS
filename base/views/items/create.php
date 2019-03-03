<?php
/* @var $this ItemsController */
/* @var $model Items */

$this->breadcrumbs=array(
	'Items'=>array('list'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Items', 'url'=>array('list')),
	array('label'=>'Import Items [Template]', 'url'=>'assets/items_template.xlsx'),
);
?>
<h1>Add Items</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>