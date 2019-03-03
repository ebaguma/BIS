<?php
/* @var $this ReallocationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Reallocations',
);

$this->menu=array(
	array('label'=>'Create Reallocation', 'url'=>array('create')),
	array('label'=>'Manage Reallocation', 'url'=>array('admin')),
);
?>

<h1>Reallocations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
