<?php
/* @var $this RevenueController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Revenues',
);

$this->menu=array(
	array('label'=>'Create Revenue', 'url'=>array('create')),
	array('label'=>'Manage Revenue', 'url'=>array('admin')),
);
?>

<h1>Revenues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
