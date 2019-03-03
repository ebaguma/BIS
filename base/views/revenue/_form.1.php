<?php
/* @var $this RevenueController */
/* @var $model Revenue */
/* @var $form CActiveForm */
?>
<style>
.vvs td {
	font-weigiht:bold;
	font-size:14px;
}
.even {
	background-color:rgb(230,230,230);
}
.vvs tr {
	line-height:10px;
		height:10px;
		padding:0px;
		margin:0px;
}

</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'revenue-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>	
	<TABLE >
		<?php 
				$grps = array(
					'30'	=> 'Energy Sales',
					//'31'	=>	'Cost of Sales',
					//'32'	=>	'Other Income'
				);
				foreach($grps as $rkey=>$rvalue) {
				?>
					<tr><td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> <?php echo $rvalue?></legend><table class=vvs>
				<thead><tr><th>Client</th><th>No. of Units</th></tr></thead>
				<?php								
				$codes=Yii::app()->db->createCommand("select * from v_revenue where accountcode regexp '^".$rkey."[0-9]{4}$' and budget='".user()->budget['id']."' order by item")->queryAll();
				foreach($codes as $code) { $cl++;
					$cls= $cl%2==0 ? "even" : "odd";
				?>
				<tr class="<?php echo $cls; ?>">
					<td><?php echo $code[accountcode]."  ".$code[item]; ?></td>
					<td><?php echo CHtml::numberField("rev[$code[id]]",$code[amount]); ?></td>
				</tr>
				<?php } ?>	
					</table></fieldset></td></tr>
	<?php } ?>
	<tr>
		<td>	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
</td></tr></table>

<?php $this->endWidget(); ?>

</div><!-- form -->