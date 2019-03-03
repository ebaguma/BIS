<?php
/* @var $this BcCommentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bc Comments',
);

$this->menu=array(
	array('label'=>'Create BcComments', 'url'=>array('create')),
	array('label'=>'Manage BcComments', 'url'=>array('admin')),
);
?>

<h1>Bc Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
