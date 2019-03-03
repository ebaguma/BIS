<?php
/* @var $this EmployeesController */
/* @var $model Employees */

$this->breadcrumbs=array(
	'Employees'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Employees', 'url'=>array('index')),
	array('label'=>'Add an Employee', 'url'=>array('create')),
);
/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#employees-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
*/
?>

<h1>Manage Employees</h1>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php // $this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'checkno',
		'employee',
		array(
			'value'=>'$data->designation0->designation',
			'name'=>'designation'
		),
		array(
			'value'=>'$data->salaryScale->name',
			'name'=>'salary_scale'
		),
		array(
			'value'=>'$data->spine0->spine',
			'name'=>'spine'
		),
		array(
			'value'=>'$data->department0->dept',
			'name'=>'department'
		),
		array(
			'value'=>'$data->section0->section',
			'name'=>'section'
		),
		//'shift',
		//'standby',
		//'contract',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); $this->widget('ext.ScrollTop');  ?>