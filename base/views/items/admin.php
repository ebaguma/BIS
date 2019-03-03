<?php
/* @var $this ItemsController */
/* @var $model Items */

$this->breadcrumbs=array(
	'Items'=>array('list'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Items', 'url'=>array('list')),
	array('label'=>'Create Items', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#items-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Items</h1>

<?php  $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'items-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'value' =>'$data->acountcode0->accountcode',
			'type'=>'raw',
			'header'=>'Account ID'
		),
		array(
			'name'=>'accountcode',
			'value' =>'$data->acountcode0->item',
			'type'=>'raw',
			'header'=>'Account Code'
		),
		//'costcentre',
		'name',
		'descr',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
