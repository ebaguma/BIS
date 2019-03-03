<?php
/* @var $this UsersRolesController */
/* @var $model UsersRoles */

$this->breadcrumbs=array(
	'Users Roles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UsersRoles', 'url'=>array('index')),
	array('label'=>'Create UsersRoles', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-roles-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users Roles</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-roles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'user',
			'value'=>'$data->user0->username',
		),
		array(
			'name'=>'role',
			'value'=>'$data->role0->rolename',
				
		),
		'active',
		'fromdate',
		'expirydate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
