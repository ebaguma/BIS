<?php
	$codes=app()->db->createCommand("select * from v_revenue_purchases where capacity_price > 0 and contract_capacity >0 and budget='".user()->budget['id']."'")->queryAll();
	$cst=0;
	$capacity_payments=$fixed_payments=$fixed_local=$capacity_local=0;
	foreach($codes as $c) $capacity_payments+=$c[capacity_price]*$c[contract_capacity]*24*365;

	//Communication Levy: 2% of Fiber Revenue
	$codes=app()->db->createCommand("select * from items_prices_view where budget='".user()->budget['id']."' and accountid='320008'")->queryAll();
	foreach($codes as $c) $fiberIncome+= $c[priceugx];
	$commlevy=0.02*$fiberIncome;
	$itemid=Items::model()->findByAttributes(array('name'=>'Communication Levy','accountcode'=>202))->id;
	$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$commlevy);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'communicationlevy',"tblid"=>1,"descr"=>'Communication levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();
	
	// Generation Levy: 0.3% of Export Revenue
	$codes=app()->db->createCommand("select * from v_revenue_sales where local=0 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $exportRevenue+= $c[unitp]*($c[amount1]+$c[amount2]+$c[amount3]+$c[amount4]);
	$genlevy=0.003*$exportRevenue;
	$itemid=Items::model()->findByAttributes(array('name'=>'Generation Levy','accountcode'=>193))->id;
	$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$genlevy);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'generationlevy',"tblid"=>1,"descr"=>'generation levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();

	// Rural Electrification Levy: 5% of Internally generated power costs
	$codes=app()->db->createCommand("select * from v_revenue_purchases where local=1 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $internalRevenue +=  $c[unitp]*($c[amount1]+$c[amount2]+$c[amount3]+$c[amount4]);
	$relevy=0.05*$internalRevenue;
	$itemid=Items::model()->findByAttributes(array('name'=>'Rural Elecrification Levy','accountcode'=>66))->id;
	$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$relevy);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'ruralelectrificationlevy',"tblid"=>1,"descr"=>'rural electrification levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();

	//VAT on Imported Power2: 18% of Imported Power
	$codes=app()->db->createCommand("select * from v_revenue_purchases where local=0 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $importedPower +=  $c[unitp]*($c[amount1]+$c[amount2]+$c[amount3]+$c[amount4]);
	$vat=0.18*$importedPower;
	$itemid=Items::model()->findByAttributes(array('name'=>'VAT on Imported Power','accountcode'=>66))->id;
	/*$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$vat);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'ruralelectrificationlevy',"tblid"=>1,"descr"=>'rural electrification levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();*/
	
	//Other Income
	$codes=app()->db->createCommand("select * from items_prices_view where budget='".user()->budget['id']."' and accountid !='320008' and accountid regexp '^32[0-9]{4}$'")->queryAll();
	foreach($codes as $c) $otherIncome+= $c[priceugx];
	$codes=app()->db->createCommand("select * from v_revenue_sales where accountcode !='300002'  and accountcode !='300003' and local=1 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $energysales += $c[amount1]+$c[amount2]+$c[amount3]+$c[amount4];
	$peaks=app()->db->createCommand("select * from v_revenue_sales where accountcode ='300002'  and local=1 and budget='".user()->budget['id']."'")->queryAll();
	$peaksales=$peaks[0][amount1]+$peaks[0][amount2]+$peaks[0][amount3]+$peaks[0][amount4];
	$peaks=app()->db->createCommand("select * from v_revenue_sales where accountcode ='300003'  and local=1 and budget='".user()->budget['id']."'")->queryAll();
	$offpeaksales=$peaks[0][amount1]+$peaks[0][amount2]+$peaks[0][amount3]+$peaks[0][amount4];
	
?>
<div class="grid-view">

<?php 
	$cb=Yii::app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and (accountid regexp '^4[0-9]{5}$' or accountid regexp '^10[0-9]{4}$')")->queryAll(); 
	$ob=$cb[0][a];
	$cb=Yii::app()->db->createCommand("select * from v_revenue_purchases where budget='".user()->budget['id']."' and (accountcode regexp '^31[0-9]{4}$')")->queryAll(); 
	foreach($cb as $c) $ep += $c[unitp]*($c[amount1]+$c[amount2]+$c[amount3]+$c[amount4]);
	//$ep=$cb[0][a];
	$ar=array(
		'<b>Revenue<b>'			=>'',
		'GOU Subsidies'				=>$capacity_payments,
		'Fiber Lease'					=>$fiberIncome,
		'Other Income'				=>$otherIncome,
		'export Revenue'				=>$exportRevenue,
		'<b>Total Revenue</b>'		=>($exportRevenue + $otherIncome + $fiberIncome +  $capacity_payments),
		'<b>&nbsp;<b>'				=>'&nbsp;',
		'<b>Expenses</b>'			=>'',
		'O&M Budget'					=>$ob,
		'Energy Purchases'			=>$ep,
		'Capacity Charges'			=>$capacity_payments,
		'Generation Levy'				=>$genlevy,
		'Communication Levy'		=>$commlevy,
		'Rural Electrification Levy'	=>$relevy,
		'VAT on Imported Power'	=>$vat,
		'<b>Total Costs<b>'			=>($vat + $relevy + $commlevy + $genlevy + $capacity_payments + $ep + $ob),
		'<b>&nbsp;&nbsp;<b>'		=>'&nbsp;',
		'Revenue Requirement'		=>($vat + $relevy + $commlevy + $genlevy + $capacity_payments + $ep + $ob) -($exportRevenue + $otherIncome + $fiberIncome +  $capacity_payments),
		'Energy Sales - Shoulder (kWh)'			=>$energysales,
		'Energy Sales - Peak (kWh)'				=>$peaksales,
		'Energy Sales - Off Peak (kWh)'			=>$offpeaksales,
		'Generated Tarrif'			=>@((($vat + $relevy + $commlevy + $genlevy + $capacity_payments + $ep + $ob) -($exportRevenue + $otherIncome + $fiberIncome +  $capacity_payments))/($energysales+$peaksales+$offpeaksales))
		
	);
	$tarrif=$ar['Generated Tarrif'];
	?>	
	<form method=post>
<fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Tarrif Generation</legend><table class="items vvs">
				<thead><tr><th>Item</th><th>Amount</th></tr></thead>
				<?php 
				$cl=1;
				foreach ($ar as $k=>$v) {
					$cls= $cl%2==0 ? "even" : "odd"; $cl++;
					echo "<tr class=$cls><td>$k</td><td style='text-align:right'>".(round($v) > 0 ? number_format($v) : $v)."</td></tr>";
				}?>
				<tr class=$cls><td>Difference</td><td style='text-align:right' id=difff><?php echo number_format($ar['Revenue Requirement']-($tarrif*($peaksales + $energysales + $offpeaksales)))  ?></td></tr>
				<tr class="<?php echo $cls; $cls++?>">
					<td></td>
					<td colspan=2 style='text-align:center'><table width=100%><tr><td width=30%>Off Peak</td><td width=30%>Shoulder</td><td width=30%> Peak</td></tr></table></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<td></td>
					<td  style='text-align:center'><table width=100%><tr>
						<td width=30%  id=offp><?php echo $tarrif;?></td>
						<td width=30%  id=shld><?php echo $tarrif;?></td>
						<td width=30% id=peak><?php echo $tarrif;?></td></tr></table>
					</td>
					<input type='hidden' name='toffp' id='tioffp' value='<?php echo $tarrif; ?>'>
					<input type='hidden' name='tpeak' id='tipeak' value='<?php echo $tarrif; ?>'>
					<input type='hidden' name='tshld' id='tishld' value='<?php echo $tarrif; ?>'>
					<input type='hidden' name='r' value='revenue/revenuerequirement'>
				</tr>				

				<tr class="<?php echo $cls; $cls++?>">
					
					<td  style='text-align:center' colspan=2><input  style='width:850px' name='offpeaktarrif' id='offpeaktarriff' oninput="outputUpdate2(value)"  type=range width=100% min=<?php echo round($tarrif*0.8); ?> value=<?php echo round($tarrif); ?> step="0.0000000001"  max=<?php echo round($tarrif); ?> ></td></tr>
					<tr class="<?php echo $cls; $cls++?>">
					<td colspan=2><input style='width:850px' name='peaktarrif' id='peaktarriff' oninput="outputUpdate2(value)"  type=range width=100% min=<?php echo round($tarrif); ?> value=<?php echo round($tarrif); ?> step="0.000000001"  max=<?php echo round($tarrif*1.2); ?> ></td>
					
				</tr>				
				<tr>
					<td colspan=2 style='text-align:right'><input type='submit' value='Save' /></td>
				</tr>
					</table></fieldset></form></div>
					<script>
					function outputUpdate2(vol) {
						var opv=document.querySelector('#offpeaktarriff').value;
						var ppv=document.querySelector('#peaktarriff').value;
						var fixt=<?php echo $ar['Revenue Requirement']-($tarrif*$energysales);?>;
						var pps=<?php echo $peaksales;?>;
						//alert('hi');
						
						
						var ops=<?php echo $offpeaksales;?>.
						document.querySelector('#tipeak').value=document.querySelector('#peak').innerHTML = ppv;
						document.querySelector('#tioffp').value=document.querySelector('#offp').innerHTML =  opv;
						document.querySelector('#difff').innerHTML=accounting.formatNumber(fixt-((opv*ops)+(ppv*pps)));
						
					}
					</script>
					