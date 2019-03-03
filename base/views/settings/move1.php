<?php

$this->menu=array(
	array('label'=>'List Settings', 'url'=>array('salaryindex')),
	array('label'=>'Manage Settings', 'url'=>array('admin')),
);
?>

<h1>Combine Items in Budget</h1>
<br/><br/>
<h3>This page combines all items in an account code to  a single item per section. E.g Stationery, Bolts & Nuts etc</h3>
<?php if($moved==1)
	echo "<h2> Success!! The items have been merged successfully!</h2>";
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings-form',
	'enableAjaxValidation'=>false,
)); ?>

<table>
<tr><td>Account Code</td><td>
<select name='acccode'>
	<option></option>
	<?php
	$c=app()->db->createCommand("SELECT * FROM accountcodes WHERE accountcode REGEXP '^4[0-9]{5}$'")->queryAll();
	foreach($c as $cc) {
		echo "<option value='".$cc['id']."'>".$cc['accountcode']." - ".$cc['item']."</option>";
	}
	?>
</select>
</td></tr>
</table>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
