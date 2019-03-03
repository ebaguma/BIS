<?php
/* @var $this ClothingItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Clothing Items',
);

$this->menu=array(
	array('label'=>'Create ClothingItems', 'url'=>array('create')),
	array('label'=>'Manage ClothingItems', 'url'=>array('admin')),
);
?>

<h1>Clothing Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
