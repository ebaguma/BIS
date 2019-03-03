<?php
/* @var $this EmployeesController */
/* @var $model Employees */

$this->breadcrumbs=array(
	'Employees'=>array('admin'),
	$model->id,
);

?>

<h1>View Employees: <?php echo $model->employee; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'checkno',
		'employee',
		'designation0.designation',
		'salaryScale.name',
		'spine0.spine',
		'department0.dept',
		'section0.section',
		'unit0.unit',
		//'shift',
		//'standby',
		//'contract',
	),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'checkno',
		'employee',
		'designation0.designation',
		'salaryScale.name',
		'spine0.spine',
		'department0.dept',
		'section0.section',
		'unit0.unit',
		//'shift',
		//'standby',
		//'contract',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>