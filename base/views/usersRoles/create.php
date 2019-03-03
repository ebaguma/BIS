<?php
/* @var $this UsersRolesController */
/* @var $model UsersRoles */

$this->breadcrumbs=array(
	'Users Roles'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List UsersRoles', 'url'=>array('admin')),
	array('label'=>'Manage UsersRoles', 'url'=>array('admin')),
);
?>

<h1>Create UsersRoles</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>