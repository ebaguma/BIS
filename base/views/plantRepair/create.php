<?php
/* @var $this PlantRepairController */
/* @var $model PlantRepair */

$this->breadcrumbs=array(
	'Plant Repairs'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PlantRepair', 'url'=>array('index')),
	array('label'=>'Manage PlantRepair', 'url'=>array('admin')),
);
?>

<h1>Create PlantRepair</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>