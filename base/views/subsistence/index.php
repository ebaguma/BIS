<?php
/* @var $this SubsistenceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Subsistences',
);

$this->menu=array(
	array('label'=>'Create Subsistence', 'url'=>array('create')),
	array('label'=>'Manage Subsistence', 'url'=>array('admin')),
);
?>

<h1>Subsistences</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
