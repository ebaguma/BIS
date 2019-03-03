<?php
/* @var $this BcReallocationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bc Reallocations',
);

$this->menu=array(
	array('label'=>'Create BcReallocation', 'url'=>array('create')),
	array('label'=>'Manage BcReallocation', 'url'=>array('admin')),
);
?>

<h1>Bc Reallocations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
