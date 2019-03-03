<?php
/* @var $this BcBudgetapprovalsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bc Budgetapprovals',
);

$this->menu=array(
	array('label'=>'Create BcBudgetapprovals', 'url'=>array('create')),
	array('label'=>'Manage BcBudgetapprovals', 'url'=>array('admin')),
);
?>

<h1>Bc Budgetapprovals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
