<?php
/* @var $this TelephonesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Telephones',
);

$this->menu=array(
	array('label'=>'Create Telephones', 'url'=>array('create')),
	array('label'=>'Manage Telephones', 'url'=>array('admin')),
);
?>

<h1>Telephones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
