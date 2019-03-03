<?php
/* @var $this BudgetitemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Budgetitems',
);

$this->menu=array(
	array('label'=>'Create Budgetitems', 'url'=>array('create')),
	array('label'=>'Manage Budgetitems', 'url'=>array('admin')),
);
?>

<h1>Budgetitems</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
