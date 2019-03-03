<?php
/* @var $this BcItembudgetsController */
/* @var $model BcItembudgets */

$this->breadcrumbs=array(
	'Bc Itembudgets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BcItembudgets', 'url'=>array('index')),
	array('label'=>'Manage BcItembudgets', 'url'=>array('admin')),
);
?>

<h1>Add a new Item to the Current Budget</h1>
<?php if($message) { ?>
<div class="flash notice">
  <span class="close"><a href="#">X</a></span>
<?=$message?>
</div>
<?php } ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>