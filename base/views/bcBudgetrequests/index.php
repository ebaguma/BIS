<?php
/* @var $this BcBudgetrequestsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bc Budgetrequests',
);

$this->menu=array(
	array('label'=>'Create BcBudgetrequests', 'url'=>array('create')),
	array('label'=>'Manage BcBudgetrequests', 'url'=>array('admin')),
);
?>

<h1>Bc Budgetrequests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
