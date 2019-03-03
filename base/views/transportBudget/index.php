<?php
/* @var $this TransportBudgetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transport Budgets',
);

$this->menu=array(
	array('label'=>'Create TransportBudget', 'url'=>array('create')),
	array('label'=>'Manage TransportBudget', 'url'=>array('admin')),
);
?>

<h1>Transport Budgets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
