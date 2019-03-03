<?php
/* @var $this ProcurementSpendingController */
/* @var $model ProcurementSpending */

$this->breadcrumbs=array(
	'Procurement Spendings'=>array('admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List ProcurementSpending', 'url'=>array('index')),
	array('label'=>'New Procurement Request', 'url'=>array('create')),
);
/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#procurement-spending-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
*/
?>

<h1>Manage Procurement Spendings</h1>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$s='Click to Approve';
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'procurement-spending-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'reference',
		'subject',
		array(
			'name'	=>'location',
			'value'	=>'$data->location0->name',
		),
		
		array(
			'name'	=>'date_required',
			'value'=>'date("d M Y",strtotime($data->date_required))',
		),		
		array(
			'name'	=>'accountcode',
			'value'	=>'$data->accountcode0->item',
		),
		array(
			'value'	=>'$data->approval1',
			'header'	=> 'HOD Approval'
		),
		array(
			'type'	=>'raw',
			'value'	=>'CHtml::link("Click to Approve",array("procurementSpending/view","id"=>$data->id))', 
			'header'	=> 'Finance Approval'
		),
		array(
			'value'	=>'$data->approval3',
			'header'	=> 'MGR Finance Approval'
		),

		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
