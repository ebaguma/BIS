<style>
.ttt{
	font-size:14px;
}
.vvs {
	width:900px;
}
.vvs td {
	font-weigiht:bold;
	font-size:14px;
}
.even td {
	/*background-color:rgb(220,220,220);*/
	background-color:#d7e5f5;
	text-align:right;
}
.odd td,th {
	background-color:#f1f1f1;
	text-align:right;
	font-size:13px;
}

.vvs tr {
	line-height:10px;
		height:10px;
		padding:0px;
		margin:0px;
}
.danger {
	font-weight:bold;
	color:red;
}

</style>

<!--<div class="form"  ng-app="app" ng-controller="MainCtrl as ctrl">
<div class="form-group" ng-class="{ 'has-error': form.numberNoOptions.$invalid }">-->
<div><div>
<form id="otherIcome-form" method="post" onSubmiti='return vali();'>
<fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Energy Purchases</legend><table class=vvs>
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th colspan=4 style='text-align:center;letter-spacing:4px;font-size:16px'>Units per Quarter (kWh)</th>
					</tr>
					<tr>
						<th>Plant</th>
						<th>Q1</th>
						<th>Q2</th>
						<th>Q3</th>
						<th>Q4</th>
					</tr>
			</thead>
			
				<?php		
				$ht="var ids=[";
				$codes=Yii::app()->db->createCommand("select * from v_revenue_purchases where accountcode regexp '^31[0-9]{4}$' and budget='".user()->budget['id']."' order by accountcode limit 111")->queryAll();
				foreach($codes as $code) { $cl++;
					$cls= $cl%2==0 ? "even" : "odd";
					$t1 +=$code[amount1];
					$t2 +=$code[amount2];
					$t3 +=$code[amount3];
					$t4 +=$code[amount4];
					$ht.="'".$code[accountcode]."',";
									?>
				<tr class="<?php echo $cls; ?>">
					<td style='text-align:left'><?php echo $code[accountcode]."  ".$code[item]; ?></td>
					<td id="uu1<?php echo $cl; ?>" ><?php echo CHtml::numberField("rev[1$code[id]]",$code[amount1],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u1'.$code[accountcode], 'style'=>'width:100px')); ?>
					<?php /*?><input type="text" fcsa-number="{  }" value=<?php echo $code[amount1];?> ng-model="ctrl.model.numberNoOptions" naiime="numberNoOption22s" name=rev[2<?php echo $code[id];?>] class="form-control" /><?php */?>
					</td>
					<td id="uu2<?php echo $code[accountcode];?>"><?php echo CHtml::numberField("rev[2$code[id]]",$code[amount2],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u2'.$code[accountcode],'style'=>'width:100px')); ?></td>
					<td id="uu3<?php echo $code[accountcode];?>"><?php echo CHtml::numberField("rev[3$code[id]]",$code[amount3],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u3'.$code[accountcode],'style'=>'width:100px')); ?></td>
					<td id="uu4<?php echo $code[accountcode];?>"><?php echo CHtml::numberField("rev[4$code[id]]",$code[amount4],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u4'.$code[accountcode],'style'=>'width:100px')); ?></td>
				</tr>
				
				<?php } 
				$ht=substr($ht,0,strlen($ht)-1)."];";
				$sales=Yii::app()->db->createCommand("select sum(amount1) amt1,sum(amount2) amt2,sum(amount3) amt3,sum(amount4) amt4 from v_revenue where accountcode regexp '^30[0-9]{4}$' and budget='".user()->budget['id']."' order by item")->queryAll();
				
				$losses=app()->db->createCommand("select name,price from items_prices_view where accountid='470008' and budget='".user()->budget['id']."'")->queryAll();
				foreach($losses as $ls) {
					if($ls['name']=="Q1") {
						$ls1=$ls['price']/100;
						$eb1=($sales[0][amt1]*100)/(100-$ls['price']);
					}
					if($ls['name']=="Q2") { 
						$ls2=$ls['price']/100;
						$eb2=($sales[0][amt2]*100)/(100-$ls['price']);
					}
					if($ls['name']=="Q3") { 
						$ls3=$ls['price']/100;
						$eb3=($sales[0][amt3]*100)/(100-$ls['price']);
					}
					if($ls['name']=="Q4") {
						 $l4=$ls['price']/100;				
						$eb4=($sales[0][amt4]*100)/(100-$ls['price']);
					}
				}
				$s1=$sales[0][amt1]*1.035;
				$d1=$t1 - $eb1; $c1= round($d1) == 0 ? "" : "danger";
				$s2=$sales[0][amt2]*1.035;
				$d2=$t2 - $eb2; $c2= round($d2) == 0 ? "" : "danger";
				$s3=$sales[0][amt3]*1.035;
				$d3=$t3 - $eb3; $c3= round($d3) == 0 ? "" : "danger";
				$s4=$sales[0][amt4]*1.035;
				$d4=$t4 - $eb4; $c4= round($d4) == 0 ? "" : "danger";
				
				
				?>
				<div style='display:none' id=clkeeper><?php echo $cl;?></div>	
				<tr><td colspan=5>&nbsp;</td></tr>
				<tr class="even"  class='righttext'>
					<td style='text-align:left'>Total Energy Purchases</td>
					<td id=l1><?php echo number_format($t1); ?> </td>
					<td id=l2><?php echo number_format($t2); ?></td>
					<td id=l3><?php echo number_format($t3); ?></td>
					<td id=l4><?php echo number_format($t4); ?></td>
				</tr>
				
				<tr class="odd"  class='righttext'>
					<td style='text-align:left'>Transmission Losses (<?php echo $ls['price']?>%)</td>
					<td id=l1><?php echo number_format($eb1-$sales[0][amt1]); ?> </td>
					<td id=l2><?php echo number_format($eb2-$sales[0][amt2]); ?></td>
					<td id=l3><?php echo number_format($eb3-$sales[0][amt3]); ?></td>
					<td id=l4><?php echo number_format($eb4-$sales[0][amt4]); ?></td>
				</tr>
				<tr class="even"  class='righttext'>
					<td style='text-align:left'>Total Energy Sales (KWh)</td>
					<td id=lp1><?php echo number_format($sales[0][amt1]); ?></td>
					<td id=lp2><?php echo number_format($sales[0][amt2]); ?></td>
					<td id=lp3><?php echo number_format($sales[0][amt3]); ?></td>
					<td id=lp4><?php echo number_format($sales[0][amt4]); ?></td>
				</tr>				
				<tr class="odd"  class='righttext'>
					<td style='text-align:left'>Total to Buy (KWh)</td>
					<td id=p1><?php echo number_format($eb1); ?></td>
					<td id=p2><?php echo number_format($eb2); ?></td>
					<td id=p3><?php echo number_format($eb3); ?></td>
					<td id=p4><?php echo number_format($eb4); ?></td>
				</tr>				

				<tr class="even" class='righttext'>
					<td style='text-align:left'>Difference</td>
					<td id=d1 class=<?php echo $c1; ?>><?php echo number_format($d1); ?></td>
					<td id=d2 class=<?php echo $c2; ?>><?php echo number_format($d2); ?></td>
					<td id=d3 class=<?php echo $c3; ?>><?php echo number_format($d3); ?></td>
					<td id=d4 class=<?php echo $c4; ?>><?php echo number_format($d4); ?></td>
				</tr>				
	<tr>
		<td colspan=5 style='text-align:right'>	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>
</td></tr>				
					</table></fieldset>
	<fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Cost Of Sales</legend><table class=vvs>
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th colspan=5 style='text-align:center;letter-spacing:4px;font-size:16px'>Amounts per Quarter (UGX)</th>
					</tr>
					<tr>
						<th style='text-align:left'>Plant</th>
						<th style='text-align:right'>Q1</th>
						<th style='text-align:right'>Q2</th>
						<th style='text-align:right'>Q3</th>
						<th style='text-align:right'>Q4</th>
						<th style='text-align:right'>Totals</th>
					</tr>
			</thead>
				<?php			
				$cl=$t1=$t2=$t3=$t4=0;
				$codes=Yii::app()->db->createCommand("select * from v_revenue_purchases where accountcode regexp '^31[0-9]{4}$' and budget='".user()->budget['id']."' order by accountcode")->queryAll();
				foreach($codes as $code) { $cl++;
					$cls= $cl%2==0 ? "even" : "odd";
					$ht1.= "<div id=v".$code[accountcode]." style='display:none'>".$code[unitp]."</div>";
					$t1+=$code[unitp]*$code[amount1];
					$t2+=$code[unitp]*$code[amount2];
					$t3+=$code[unitp]*$code[amount3];
					$t4+=$code[unitp]*$code[amount4];
					
					if($code[local]==0) {
						
						$vat1+=$code[unitp]*$code[amount1]*0.18;
						$vat2+=$code[unitp]*$code[amount2]*0.18;
						$vat3+=$code[unitp]*$code[amount3]*0.18;
						$vat4+=$code[unitp]*$code[amount4]*0.18;
					}
					
				?>
				<tr class="<?php echo $cls; ?>">
					<td style='text-align:left'><?php echo $code[accountcode]."  ".$code[item]; ?></td>
					<td id="a1<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount1])?></td>
					<td id="a2<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount2])?></td>
					<td id="a3<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount3])?></td>
					<td id="a4<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount4])?></td>
					<td id="a5"><?php echo number_format($code[unitp]*($code[amount4]+$code[amount3]+$code[amount2]+$code[amount1]))?></td>
				</tr>
				<?php } ?>
				
				<tr class="<?php echo $cls; ?>" style='font-weight:bold'>
					<th style='text-align:left'>Total (Energy Purchases)</th>
					<th id="t1"><?php echo number_format($t1)?></td>
					<th id="t2"><?php echo number_format($t2)?></th>
					<th id="t3"><?php echo number_format($t3)?></th>
					<th id="t4"><?php echo number_format($t4)?></th>
					<th id="t5"><?php echo number_format($t4+$t3+$t2+$t1)?></th>
				</tr>
				<tr class="<?php echo $cls; ?>" style='font-weight:bold'>
					<th style='text-align:left'>VAT on Imported Power</th>
					<th id="t1"><?php echo number_format($vat1)?></td>
					<th id="t2"><?php echo number_format($vat2)?></th>
					<th id="t3"><?php echo number_format($vat3)?></th>
					<th id="t4"><?php echo number_format($vat4)?></th>
					<th id="t5"><?php echo number_format($vat4+$vat3+$vat2+$vat1)?></th>
				</tr>

				<tr><td colspan=5><b>Capacity Charges</th></tr>
				<!--
					</table>
				</fieldset>
	<fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Capacity Charges</legend><table class=vvs>
				<thead>
					<tr>
						<th style='text-align:left'>Plant</th>
						<th style='text-align:right'>Capacity (MWh)</th>
						<th style='text-align:right'>Contract Capacity</th>
						<th style='text-align:right'>Capacity Price</th>
						<th style='text-align:right'>Q1</th>
						<th style='text-align:right'>Q2</th>
						<th style='text-align:right'>Q3</th>
						<th style='text-align:right'>Q4</th>
						<th style='text-align:right'>Totals</th>
					</tr>
			</thead>-->
		<?php
		$codes=Yii::app()->db->createCommand("select * from v_revenue_purchases where accountcode regexp '^31[0-9]{4}$' and budget='".user()->budget['id']."' and thermal=1 order by accountcode")->queryAll();
		
		$date1=  	strtotime(date("Y")."-1-1");
		$date2= 	strtotime(date("Y")."-3-31");
		$q1=1+($date2-$date1)/86400;
		$date1=  	strtotime(date("Y")."-4-1");
		$date2= 	strtotime(date("Y")."-6-30");
		$q2=1+($date2-$date1)/86400;
		$date1=  	strtotime(date("Y")."-7-1");
		$date2= 	strtotime(date("Y")."-9-30");
		$q3=1+($date2-$date1)/86400;
		$date1=  	strtotime(date("Y")."-10-1");
		$date2= 	strtotime(date("Y")."-12-31");
		$q4=1+($date2-$date1)/86400;
		
		foreach($codes as $code) { $cl++;
			$cls= $cl%2==0 ? "even" : "odd";
			$c1+=24*$code[contract_capacity]*$code[capacity_price]*$q1;
			$c2+=24*$code[contract_capacity]*$code[capacity_price]*$q2;
			$c3+=24*$code[contract_capacity]*$code[capacity_price]*$q3;
			$c4+=24*$code[contract_capacity]*$code[capacity_price]*$q4;
			$c5+=24*$code[contract_capacity]*$code[capacity_price]*($q4+$q3+$q2+$q1);
			?>
			<tr class="<?php echo $cls; ?>">
				<td style='text-align:left'><?php echo $code[accountcode]."  ".$code[item]; ?></td>
				<!--<td><?php echo number_format($code[contract_capacity])?></td>
				<td><?php echo number_format($code[contract_capacity]*24)?></td>
				<td><?php echo number_format($code[capacity_price])?></td>-->
				<td><?php echo number_format(24*$code[contract_capacity]*$code[capacity_price]*$q1)?></td>
				<td><?php echo number_format(24*$code[contract_capacity]*$code[capacity_price]*$q2)?></td>
				<td><?php echo number_format(24*$code[contract_capacity]*$code[capacity_price]*$q3)?></td>
				<td><?php echo number_format(24*$code[contract_capacity]*$code[capacity_price]*$q4)?></td>
				<td><?php echo number_format(24*$code[contract_capacity]*$code[capacity_price]*($q4+$q3+$q2+$q1))?></td>
			</tr>
			
	<?php
		}
		?>
		<tr class="<?php echo $cls; ?>" style='font-weight:bold'>
			<th style='text-align:left'>Total (Capacity Charges)</th>
			<th id="t1w"><?php echo  @number_format($c1)?></td>
			<th id="t2w"><?php echo @number_format($c2)?></th>
			<th id="t3w"><?php echo @number_format($c3)?></th>
			<th id="t4w"><?php echo @number_format($c4)?></th>
			<th id="t5w"><?php echo @number_format($c4+$c3+$c2+$c1)?></th>
		</tr>
		<tr><td colspan=5><b>&nbsp;</th></tr>
		<tr class=" <?php echo $cls; ?>" style='fo'>
			<th  class="ttt"  style='text-align:left'>Total (Cost of Sales)</th>
			<th class="ttt" id="t1q" ><?php echo number_format(($c1+$t1+$vat1))?></td>
			<th class="ttt"  id="t2q"><?php echo number_format(($c2+$t2+$vat2))?></th>
			<th class="ttt"  id="t3q"><?php echo number_format(($c3+$t3+$vat3))?></th>
			<th class="ttt"  id="t4q"><?php echo number_format(($c4+$t4+$vat4))?></th>
			<th class="ttt"  id="t5q"><?php echo number_format($c4+$c3+$c2+$c1+$t1+$t2+$t3+$t4+$vat1+$vat2+$vat3+$vat4)?></th>
		</tr>
		
		</table></fieldset>
</form></div>

</div><!-- form -->
<?php echo $ht1; ?>
<script>
function vali() {
	if(document.getElementById('d1').innerHTML != document.getElementById('d2').innerHTML != document.getElementById('d3').innerHTML != document.getElementById('d4').innerHTML != 0) {
		alert('Please adjust the cost of sales to match the energy purchaes.');
		return false;
	}
	return true;
}
function e() {
	<?php echo $ht;?>
	var s=	document.getElementById('clkeeper').innerHTML;
	var v1=v2=v3=v4=0;
	var t1=t2=t3=t4=0;
	var i=0;
	//alert(ids.length);
	for(var i=0;i<ids.length;i++) {
	
		document.getElementById('a1'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u1'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
		t1+=document.getElementById('u1'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML; 
		document.getElementById('a2'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u2'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
		document.getElementById('a3'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u3'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
		document.getElementById('a4'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u4'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
	
		v1 += parseInt(document.getElementById('u1'+ids[i]).value);
		v2 += parseInt(document.getElementById('u2'+ids[i]).value);
		v3 += parseInt(document.getElementById('u3'+ids[i]).value);
		v4 += parseInt(document.getElementById('u4'+ids[i]).value);
	}
	var vv1=accounting.unformat(document.getElementById('p1').innerHTML)-v1;
	var vv2=accounting.unformat(document.getElementById('p2').innerHTML)-v2;
	var vv3=accounting.unformat(document.getElementById('p3').innerHTML)-v3;
	var vv4=accounting.unformat(document.getElementById('p4').innerHTML)-v4;
	document.getElementById('d1').innerHTML=accounting.formatNumber(vv1);
	document.getElementById('d1').className=vv1 != 0 ? "danger" : "";
	document.getElementById('d2').innerHTML=accounting.formatNumber(vv2);
	document.getElementById('d2').className=vv2 != 0 ? "danger" : "";
	document.getElementById('d3').innerHTML=accounting.formatNumber(vv3);
	document.getElementById('d3').className=vv3 != 0 ? "danger" : "";
	document.getElementById('d4').innerHTML=accounting.formatNumber(vv4);
	document.getElementById('d4').className=vv4 != 0 ? "danger" : "";
	document.getElementById('t1').innerHTML=accounting.formatNumber(t1);
}
</script>

