<?php
/* @var $this ScalesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Scales',
);

$this->menu=array(
	array('label'=>'Create Scales', 'url'=>array('create')),
	array('label'=>'Manage Scales', 'url'=>array('admin')),
);
?>

<h1>Scales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
