<?php
/* @var $this ProcurementSpendingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Procurement Spendings',
);

$this->menu=array(
	array('label'=>'Create ProcurementSpending', 'url'=>array('create')),
	array('label'=>'Manage ProcurementSpending', 'url'=>array('admin')),
);
?>

<h1>Procurement Spendings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
