<?php
/* @var $this VehiclesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicles',
);

$this->menu=array(
	array('label'=>'Create Vehicles', 'url'=>array('create')),
	array('label'=>'Manage Vehicles', 'url'=>array('admin')),
);
?>

<h1>Vehicles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
