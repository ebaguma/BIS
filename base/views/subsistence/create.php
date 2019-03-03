<?php
/* @var $this SubsistenceController */
/* @var $model Subsistence */

$this->breadcrumbs=array(
	'Subsistences'=>array(''),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Subsistence', 'url'=>array('index')),
	array('label'=>'Manage Subsistence', 'url'=>array('admin')),
);
/**/
?>

<h1>Create Subsistence</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>