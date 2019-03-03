<?php
/* @var $this RevenueController */
/* @var $model Revenue */

$this->breadcrumbs=array(
	'Revenues'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Revenue', 'url'=>array('index')),
	array('label'=>'Create Revenue', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#revenue-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Revenues</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'revenue-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
// /		'id',
		'budget0.name',
		'accountcode0.accountcode',
		'accountcode0.item',
		'amount1',
		'amount2',
		'amount3',
		'amount4',
		//'createdby',
		//'createdon',
		/*
		'updatedby',
		'updatedon',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
