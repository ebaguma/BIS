<?php
/* @var $this BudgetCapsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Budget Caps',
);

$this->menu=array(
	array('label'=>'Create BudgetCaps', 'url'=>array('create')),
	array('label'=>'Manage BudgetCaps', 'url'=>array('admin')),
);
?>

<h1>Budget Caps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
