<?php
$this->breadcrumbs=array('Items'=>array('list'),'Update');
$this->menu=array(
	array('label'=>'List Items', 'url'=>array('admin')),
	array('label'=>'Create One Item', 'url'=>array('create')),
	array('label'=>'Items & Prices', 'url'=>array('itemsPrices/admin')),
);
?>
		 <div id='ajax_loader' style="position: fixed; left: 30%; top: 40%; display: none;">
		     <img src=images/loading.gif></img>
		 </div>
		 <script type="text/javascript">
		     jQuery(function ($){
		         $(document).ajaxStop(function(){
		             $("#ajax_loader").hide();
		          });
		          $(document).ajaxStart(function(){
		              $("#ajax_loader").show();
		          });    
		     });    
		 </script>

<h1>Update Items & Prices</h1>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array('id'=>'items-form', 'enableAjaxValidation'=>false )); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Cost Centre'); 
		    $rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
			 $role_list=array();
			 foreach($rl as $r) $role_list[$r[accountcode]]=$r[accountcode]." - ".$r[item];
			echo Chtml::dropDownList('costcentre', array(), $role_list,
				array(
					'style'=>'width:270px',
					'empty' => ' - Select a Cost Centre - ',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('Items/item'), 
						'update'=>'#Items_accountcode',
					),	
			)); 
?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Account Code'); 
			echo $form->dropDownList($model,'accountcode', array(),array(
				'style'=>'width:270px',
				'prompt'=>'- select -',
				'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('items/details'), 
					'update'=>'#StaffCosts_items',
				),
				
			)); 
			?>
	</div>
<div class="grid-view row" id="StaffCosts_items"></div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>