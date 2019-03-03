<?php
/* @var $this AccountcodesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accountcodes',
);

$this->menu=array(
	array('label'=>'Create Accountcodes', 'url'=>array('create')),
	array('label'=>'Manage Accountcodes', 'url'=>array('admin')),
);
?>

<h1>Accountcodes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
