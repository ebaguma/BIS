<?php
/* @var $this UsersRolesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users Roles',
);

$this->menu=array(
	array('label'=>'Create UsersRoles', 'url'=>array('create')),
	array('label'=>'Manage UsersRoles', 'url'=>array('admin')),
);
?>

<h1>Users Roles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
