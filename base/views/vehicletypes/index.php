<?php
/* @var $this VehicletypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicletypes',
);

$this->menu=array(
	array('label'=>'Create Vehicletypes', 'url'=>array('create')),
	array('label'=>'Manage Vehicletypes', 'url'=>array('admin')),
);
?>

<h1>Vehicletypes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
