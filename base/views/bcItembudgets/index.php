<?php
/* @var $this BcItembudgetsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bc Itembudgets',
);

$this->menu=array(
	array('label'=>'Create BcItembudgets', 'url'=>array('create')),
	array('label'=>'Manage BcItembudgets', 'url'=>array('admin')),
);
?>

<h1>Bc Itembudgets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
