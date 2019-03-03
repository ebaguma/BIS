<style>
.vvs td {
	font-weigiht:bold;
	font-size:14px;
}
.even {
	background-color:rgb(225,241,244);
}
.odd {
	background-color:rgb(248,248,248);
}

.vvs tr {
	line-height:10px;
	height:10px;
	padding:0px;
	margin:0px;
}
.t td {
	font-size:14px;
}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staffi-costs-form',
	'enableAjaxValidation'=>false,
)); echo $form->errorSummary($model);
if(budget_locked()) { $this->renderPartial('/site/locked_warning'); }
?>

<!--	<div class="row" style="display:block">
	<?php echo $form->labelEx($model,'Vehicle'); ?>
	<?php echo $form->dropDownList($model,'vehicle',
		Chtml::ListData(Vehicles::model()->findAll('1 order by regno'),'id','regno'),array('style'=>'width:265px')); ?>
	</div>
		-->
	<TABLE style='width:900px'><tr>
		<td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Vehicle Costs</legend>
			<table class=t>

				<tr>
					<!--<th>Section</th>-->
					<th>Reg No.</th>
					<!--<th>Type</th>-->

					<th>Mileage (KM)</th>

					<th>Tyres</th>
					<th>Batteries</th>

					<th>Fuel (Ltrs)</th>
					<th>Rate</th>
					<th>Total</th>


					<th>Servicing (Times)</th>
					<th>Interval (KM)</th>
					<th>Rate</th>
					<th>Total</th>

					<th>Repairs</th>
				<!--	<th>Washing</th>
					<th>Oils</th>
					<th>Insurance</th>-->
					<th>Total</th>
				</tr>
				<?php
				$depts=Yii::app()->db->createCommand("select * from dept order by dept")->queryAll();
				foreach ($depts as $dep) {

					echo "<tr><td colspan=15 style='border:0px solid'><b>$dep[dept]</b></td></tr>";
				$codes=Yii::app()->db->createCommand("select * from v_transport where section in (select id from sections where department='$dep[id]') and budget=".user()->budget['id']." order by regno limit 1000")->queryAll();
				foreach($codes as $c) { $cl++;
					$cls= $cl%2==0 ? "even" : "odd";
					$drate.="<div id=fc_".$c[id].">".$c[fuelconsumption]."</div>";
					$drate.="<div id=si_".$c[id].">".$c[serviceinterval]."</div>";
					$serviceinterval=$c[serviceinterval] > 0 ? $c[serviceinterval] : 9999999999999999999;
				?>
				<tr class="<?php echo $cls; ?>">
					<!--<td><?php echo $c['section']?></td>-->
					<td><?php echo $c['regno']?></td>
					<!--<td><?php echo $c['vehicletype']?></td>-->
					<td><?php echo CHtml::numberField("rev_$c[id][mileage]",$c[mileage],array('style'=>'width:60px;height:22px;','onKeyUp'=>'update(this.id)')); ?></td>
					<td><?php echo CHtml::numberField("rev_$c[id][tyres]",$c[num_tyres],array('style'=>'width:40px;height:22px;')); ?></td>
					<td><?php echo CHtml::numberField("rev_$c[id][battery]",$c[num_battery],array('style'=>'width:40px;height:22px;')); ?></td>

					<td id="rev_<?php echo $c[id]?>_fuel"><?php echo number_format($c[mileage]/$c[fuelconsumption])?></td>
					<td id="rev_<?php echo $c[id]?>_frate"><?php echo $c[fuelprice]; ?></td>
					<td id="rev_<?php echo $c[id]?>_ftotal"><?php echo number_format($c[mileage]*$c[fuelprice]/$c[fuelconsumption])?></td>

					<td id="rev_<?php echo $c[id]?>_svc"><?php echo number_format($c[mileage]/$serviceinterval)?></td>
					<td id="rev_<?php echo $c[id]?>_int"><?php echo $c[serviceinterval]; ?></td>
					<td id="rev_<?php echo $c[id]?>_srate"><?php echo $c[serviceprice]; ?></td>
					<td id="rev_<?php echo $c[id]?>_stotal"><?php echo number_format($c[mileage]*$c[serviceprice]/$serviceinterval)?></td>

					<td id="rev_<?php echo $c[id]?>_repairs"></td>
					<!--<td id="rev_<?php echo $c[id]?>_washing">600000</td>
					<td id="rev_<?php echo $c[id]?>_oils"></td>-->
					<!--<td id="rev_<?php echo $c[id]?>_insurance"></td>-->
					<td id="rev_<?php echo $c[id]?>_total"></td>
				</tr>
				<?php }
			} ?>

			</table>
	</fieldset>
</td></tr></table>
<div style='display:none'><?php echo $drate;?></div>
	<input type='submit' value='Submit' />
<?php $this->endWidget(); ?>
</div><!-- form -->

<script>
function update(ah) {
	var ahh=document.getElementById(ah).value;
	var res=ah.split('_');
	var fc=document.getElementById('fc_'+res[1]).innerHTML;
	var si=document.getElementById('si_'+res[1]).innerHTML;
	var fuel=parseInt(ahh/fc);
<?php
	$repairitem=Items::model()->findByAttributes(array('name'=>'VehicleRepairPercentage','accountcode'=>'119'));
	$repairprice=ItemsPrices::model()->findByAttributes(array('item'=>$repairitem->id,'budget'=>budget()))->price;

	?>
	var rp=<?= $repairprice ? $repairprice : 10 ?>;
	document.getElementById('rev_'+res[1]+'_fuel').innerHTML=fuel;
	document.getElementById('rev_'+res[1]+'_ftotal').innerHTML=accounting.formatNumber(fuel*document.getElementById('rev_'+res[1]+'_frate').innerHTML);

	var svc=parseInt(ahh/si);
	document.getElementById('rev_'+res[1]+'_svc').innerHTML=svc;
	document.getElementById('rev_'+res[1]+'_stotal').innerHTML=accounting.formatNumber(svc*document.getElementById('rev_'+res[1]+'_srate').innerHTML);

	document.getElementById('rev_'+res[1]+'_repairs').innerHTML=accounting.formatNumber(rp*accounting.unformat(document.getElementById('rev_'+res[1]+'_ftotal').innerHTML));

	document.getElementById('rev_'+res[1]+'_total').innerHTML=accounting.formatNumber(parseInt(accounting.unformat(document.getElementById('rev_'+res[1]+'_ftotal').innerHTML))+parseInt(accounting.unformat(document.getElementById('rev_'+res[1]+'_stotal').innerHTML))+parseInt(accounting.unformat(document.getElementById('rev_'+res[1]+'_repairs').innerHTML))) ;

}
</script>
