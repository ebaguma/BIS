<?php
/* @var $this BudgetsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Budgets',
);

$this->menu=array(
	array('label'=>'Create Budgets', 'url'=>array('create')),
	array('label'=>'Manage Budgets', 'url'=>array('admin')),
);
?>

<h1>Budgets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
