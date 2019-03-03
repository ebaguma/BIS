<?php
/* @var $this DeptController */
/* @var $model Dept */

$this->breadcrumbs=array(
	'Depts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Dept', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#dept-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Depts</h1>



<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dept-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
		'dept',
		//'accountcode0.item',
		'shortname',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
