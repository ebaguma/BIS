<?php
/* @var $this ClothingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Clothings',
);

$this->menu=array(
	array('label'=>'Create Clothing', 'url'=>array('create')),
	array('label'=>'Manage Clothing', 'url'=>array('admin')),
);
?>

<h1>Clothings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
