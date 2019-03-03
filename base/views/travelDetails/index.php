<?php
/* @var $this TravelDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Travel Details',
);

$this->menu=array(
	array('label'=>'Create TravelDetails', 'url'=>array('create')),
	array('label'=>'Manage TravelDetails', 'url'=>array('admin')),
);
?>

<h1>Travel Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
