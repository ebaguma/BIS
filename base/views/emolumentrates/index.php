<?php
/* @var $this EmolumentratesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Emolumentrates',
);

$this->menu=array(
	array('label'=>'Create Emolumentrates', 'url'=>array('create')),
	array('label'=>'Manage Emolumentrates', 'url'=>array('admin')),
);
?>

<h1>Emolumentrates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
