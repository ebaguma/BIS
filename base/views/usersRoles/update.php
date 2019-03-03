<?php
/* @var $this UsersRolesController */
/* @var $model UsersRoles */

$this->breadcrumbs=array(
	'Users Roles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List UsersRoles', 'url'=>array('index')),
	array('label'=>'Create UsersRoles', 'url'=>array('create')),
	array('label'=>'View UsersRoles', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UsersRoles', 'url'=>array('admin')),
);
?>

<h1>Update User Roles for <strong><?php echo $model->user0->username; ?></strong></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>