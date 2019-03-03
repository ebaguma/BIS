<?php
/* @var $this ItemsPricesController */
/* @var $model ItemsPrices */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'items-prices-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'Cost Centre'); 
		    $rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
			 $role_list=array();
			 foreach($rl as $r) $role_list[$r[accountcode]]=$r[accountcode]." - ".$r[item];
			echo Chtml::dropDownList('costcentre', array(), $role_list,			
				array(
					'style'=>'width:230px',
					'empty' => ' - Select a Cost Centre - ',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('Items/item'), 
						'update'=>'#accountcode',
					),
					
			)); 
			?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Account Code'); 
			echo Chtml::dropDownList('accountcode', array(), array(),
				array(
					'style'=>'width:230px',
					'empty' => ' - Select an Account Code - ',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('Items/accountcode'), 
						'update'=>'#ItemsPrices_item',
					),
					
			)); 
			?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'item'); 
		    $role_list = CHtml::listData(Items::model()->findAll(), 'id', 'name');
			echo $form->dropDownList($model,'item', array(),array('style'=>'width:230px',)); 

		 echo $form->error($model,'item'); ?>
	</div>
		<div class="row">
		<table style='width:230px'><tr>
			<td>
				<?php echo $form->labelEx($model,'Currency'); ?>
				<?php echo $form->dropDownList($model,'currency',array('1'=>'UGX','3'=>'$ USD','2'=>'£ GBP','4'=>'€ EUR'),array()); ?>
			</td>
			<td>
				<?php echo $form->labelEx($model,'price'); ?>
				<?php echo $form->NumberField($model,'price'); ?>
				<?php echo $form->error($model,'price'); ?>
			</td>
		</tr></table>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->