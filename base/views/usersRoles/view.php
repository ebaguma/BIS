<?php
/* @var $this UsersRolesController */
/* @var $model UsersRoles */

$this->breadcrumbs=array(
	'Users Roles'=>array('index'),
	$model->id,
);
$this->menu=array(
	array('label'=>'Create UsersRoles', 'url'=>array('create')),
	array('label'=>'Update UsersRoles', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UsersRoles', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UsersRoles', 'url'=>array('admin')),
);
?>

<h1>View Users Roles  for:<strong><?php echo $model->user0->names; ?></strong></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
		'user0.username',
		'user0.names',
		'role0.rolename',
		'active',
		'fromdate',
		'expirydate',
	),
)); ?>
