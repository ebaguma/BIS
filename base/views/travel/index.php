<?php
/* @var $this TravelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Travels',
);

$this->menu=array(
	array('label'=>'Create Travel', 'url'=>array('create')),
	array('label'=>'Manage Travel', 'url'=>array('admin')),
);
?>

<h1>Travels</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
