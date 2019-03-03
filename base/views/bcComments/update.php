<?php
/* @var $this BcCommentsController */
/* @var $model BcComments */

$this->breadcrumbs=array(
	'Bc Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BcComments', 'url'=>array('index')),
	array('label'=>'Create BcComments', 'url'=>array('create')),
	array('label'=>'View BcComments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BcComments', 'url'=>array('admin')),
);
?>

<h1>Update BcComments <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>