<?php
/* @var $this CostcentresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Costcentres',
);

$this->menu=array(
	array('label'=>'Create Costcentres', 'url'=>array('create')),
	array('label'=>'Manage Costcentres', 'url'=>array('admin')),
);
?>

<h1>Costcentres</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
