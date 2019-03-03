<?php
/* @var $this EntityController */
/* @var $model Entity */

$this->breadcrumbs=array(
	'Entities'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Entity', 'url'=>array('index')),
	array('label'=>'Create Entity', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#entity-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Entities</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
/*
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'entity-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'descr',
		'parent',
		array('name'=>'dept','value'=>'$data->dept0->dept'),
		'rights',
		array(
			'class'=>'CButtonColumn',
		),
	),
));

*/ ?>


<?php
$fillable = new CActiveForm();

$this->widget('application.extensions.EFillableCGridView', array(
   'id'=>'my-grid',
   'dataProvider'=>$model->search(),
   // **** Here starts the addition ****
   'fillable' => array(
      'columns' => array(
         array(
            'name' => 'name',
            'value' => $fillable->textField($model,'name')
         ),
         array(
            'name' => 'descr',
            'value' => $fillable->textField($model,'descr')
         ),
         array(
            'name' => 'dept',
            'value' => $fillable->textField($model,'dept')
         ),
      ),
      'CButtonColumn' => array(
         'button' => '<a href="'.Yii::app()->createUrl('control/mcreateAjax').'"><img style="vertical-align: middle;" src="'. Yii::app()->baseUrl .'/assets/d72c9419/gridview/delete.png" alt="plus"></a>',
         'action' => Yii::app()->createUrl('control/mcreateAjax'),
      ),
      'position' => 'top',
      'fillIsFilter' => true,
   ),
   // **** Here ends the addition ****
   'columns'=>array(
      'id',
      'name',
      'descr',
      array(
         'name' => 'dept',
         'value' => '$data->dept0->dept',
      ),
      array(
         'class'=>'CButtonColumn',
      ),
   ),
));
?>