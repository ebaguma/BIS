<?php
/* @var $this TelephonesController */
/* @var $model Telephones */

$this->breadcrumbs=array(
	'Telephones'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Telephones', 'url'=>array('index')),
	array('label'=>'Create Telephones', 'url'=>array('create')),
	array('label'=>'View Telephones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Telephones', 'url'=>array('admin')),
);
?>

<h1>Update Telephones <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>