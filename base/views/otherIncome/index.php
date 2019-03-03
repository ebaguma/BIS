<?php
/* @var $this OtherIncomeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Other Incomes',
);

$this->menu=array(
	array('label'=>'Create OtherIncome', 'url'=>array('create')),
	array('label'=>'Manage OtherIncome', 'url'=>array('admin')),
);
?>

<h1>Other Incomes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
