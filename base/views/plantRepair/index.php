<?php
/* @var $this PlantRepairController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Plant Repairs',
);

$this->menu=array(
	array('label'=>'Create PlantRepair', 'url'=>array('create')),
	array('label'=>'Manage PlantRepair', 'url'=>array('admin')),
);
?>

<h1>Plant Repairs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
