<?php
/* @var $this AllowancesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Allowances',
);

$this->menu=array(
	array('label'=>'Create Allowances', 'url'=>array('create')),
	array('label'=>'Manage Allowances', 'url'=>array('admin')),
);
?>

<h1>Allowances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
