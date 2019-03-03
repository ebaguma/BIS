<?php
$this->breadcrumbs=array(
	'Travels',
	'Manage',
);

$this->menu=array(
//array('label'=>'Create Travel', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#travel-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>My Travel Budget</h1>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'travel-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
		array(
			name=>'employee',
			value=>'$data->employee0->employee',
		),
		'course',
		'purpose',
		'centre',
	//	'mission',
		/*
		'budget',
		*/
	   array(
	     'class'=>'CButtonColumn',
	     'template'=>'{view}{update}{delete}',
	     'buttons'=>array(
	       'update'=>array(
	           'url'=>'$this->grid->controller->createUrl("travel/update", array("id"=>$data->id,"m"=>$_REQUEST[m]))',
				  	'visible'=>'($data->id===null)?false:true;'
	           ),
	 	    'view'=>array(
	 	           'url'=>'$this->grid->controller->createUrl("travel/view", array("id"=>$data->id,"m"=>$_REQUEST[m]))',
					  'visible'=>'($data->id===null)?false:true;'
	 	       ),
				  
	     ),
	   ),
	),
)); 
?>
</div>