<?php
/* @var $this GuaranteesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Guarantees',
);

$this->menu=array(
	array('label'=>'Create Guarantees', 'url'=>array('create')),
	array('label'=>'Manage Guarantees', 'url'=>array('admin')),
);
?>

<h1>Guarantees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
