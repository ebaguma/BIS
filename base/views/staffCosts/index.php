<?php
/* @var $this StaffCostsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Costs',
);

$this->menu=array(
	array('label'=>'Create StaffCosts', 'url'=>array('create')),
	array('label'=>'Manage StaffCosts', 'url'=>array('admin')),
);
?>

<h1>Staff Costs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
