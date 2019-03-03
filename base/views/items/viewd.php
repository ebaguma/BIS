<?php
/* @var $this ItemsController */
/* @var $model Items */

$this->breadcrumbs=array(
	'Items'=>array('list'),
	'Create',
);

$this->menu=array(
	array('label'=>'Add a new Item', 'url'=>array('create')),
	array('label'=>'Import Items [Template]', 'url'=>'assets/items_template.xlsx'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#items-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>

<div class="wide form"><form method="post">
<div style="display:none"><input type="hidden" value="items/list" name="r" /></div>
	<div class="row">
		<label for="item_id">Account ID</label>		<input value="<?php echo $_POST[item][accountid]; ?>" name="item[accountid]" id="item_id" type="text" />	</div>
	<div class="row">
		<label for="item_employee">Account Code</label>		<input value="<?php echo $_POST[item][accountitem]; ?>" name="item[accountitem]" id="item_employee" type="text" />	</div>
	<div class="row">
		<label for="item_soap">Item</label>		<input value="<?php echo $_POST[item][name]; ?>" name="item[name]" id="item_soap" type="text" />	</div>
	<div class="row">
		<label for="item_leave_start">Price</label>		<input value="<?php echo $_POST[item][price]; ?>" name="item[price]" id="item_leave_start" type="text" />	</div>
	<div class="row">
		<label for="item_leave_end">Budget</label>		<input value="<?php echo $_POST[item][budget]; ?>" name="item[budget]" id="item_leave_end" type="text" />	</div>
	<div class="row buttons">
		<input type="submit" value="Search" />	</div>
</form></div>

<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'student-grid',
	'dataProvider'=>$model,
//	'filter'=>$model,
	'columns'=>array(

		array(
			'header'=>'Item Name',
			'name'=>'name',	
		),
		array(
			'header'=>'Account ID',
			'name'=>'accountid',	
		),
		array(
			'header'=>'Account Code',
			'name'=>'accountitem',	
		),

		array(
			'header'=>'Price',
			'name'=>'price',	
			'value'=>'number_format($data["price"],2)'
		),
		array(
			'header'=>'Currency',
			'name'=>'currency',	
		),

		/*array(
			'header'=>'Paid Amount',
			'name'=>'budget',	
			//'value'=>'$data["paid"]==""?0:$data["paid"]',	
		),
		array(
			'header'=>'Year',
			'name'=>'accountid',
			//'value'=>'Yii::app()->list->yeartext($data["admission_year_id"])'
		),*/
	//	array(
     // /       'class' => 'CButtonColumn',
           // 'template' => '{annual}',
           // 'buttons' => array(
            //'annual' => array('url' => 'Yii::app()->createAbsoluteUrl("student/student/create",array("id"=>$data["scyid"],"tab"=>1))','label'=>'<span class="btn btn-xs red">Balance</span>'),
          //  ),
     //   ),
	),
)); ?>