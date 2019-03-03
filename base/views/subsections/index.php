<?php
/* @var $this SubsectionsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Subsections',
);

$this->menu=array(
	array('label'=>'Create Subsections', 'url'=>array('create')),
	array('label'=>'Manage Subsections', 'url'=>array('admin')),
);
?>

<h1>Subsections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
