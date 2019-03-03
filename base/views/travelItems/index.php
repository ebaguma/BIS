<?php
/* @var $this TravelItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Travel Items',
);

$this->menu=array(
	array('label'=>'Create TravelItems', 'url'=>array('create')),
	array('label'=>'Manage TravelItems', 'url'=>array('admin')),
);
?>

<h1>Travel Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
