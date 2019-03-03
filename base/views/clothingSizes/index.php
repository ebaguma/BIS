<?php
/* @var $this ClothingSizesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Clothing Sizes',
);

$this->menu=array(
	array('label'=>'Create ClothingSizes', 'url'=>array('create')),
	array('label'=>'Manage ClothingSizes', 'url'=>array('admin')),
);
?>

<h1>Clothing Sizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
