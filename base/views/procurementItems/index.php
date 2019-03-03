<?php
/* @var $this ProcurementItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Procurement Items',
);

$this->menu=array(
	array('label'=>'Create ProcurementItems', 'url'=>array('create')),
	array('label'=>'Manage ProcurementItems', 'url'=>array('admin')),
);
?>

<h1>Procurement Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
