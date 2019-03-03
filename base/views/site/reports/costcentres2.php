<?php
$ht = "<h1>Corporate O&M Budget:".user()->budget['name']."</h1>";
$ht .= "<div id='foo'  class='grid-view'><table style='border: 1px solid;max-width:1400px' class=items>";
$ht.="<tr><th>Cost Centre</th>";
$ht.="<th>Total</th></tr>";
$codes=app()->db->createCommand("select sum(priceugx) a from items_prices_view where budget='".user()->budget['id']."' and accountid='320008'")->queryAll();
//foreach($codes as $c) $fiberIncome+= $c[priceugx];
$commlevy=0.02*$codes[0][a];
	$ct=0;
	$ccentres=array(
		'Staff Costs'			=>"accountid regexp '^40[0-9]{4}$'",
		'Other Staff Costs' 	=>"accountid regexp '^41[0-9]{4}$'",
		'Transport Costs'		=>"accountid regexp '^4[2-3][0-9]{4}$'",
		'Administraion Costs' =>"accountid regexp '^45[0-9]{4}$' and accountid not in ('450043','450031','450047')",
		'Repair and Maintenance' =>"accountid regexp '^44[0-9]{4}$'",
		'Insurance' 			=>"accountid ='470004'",
		'Bank Guarantees'	=>"accountid ='450043'",
		'License Fees'		=>"accountid in('450031','450047')",
		'Communication Levy'=>$commlevy,
		'Capital - Grid'		=>"accountid in ('100001','100002','100003','100004','100007','100012','100014','100999')",
		'Capital - Non Grid'	=>"accountid in ('100005','100006','100008','100009','100010','100011','100013')"
	);	
	$mydep=array();
	foreach ($ccentres as $cname=>$ccentre) {
		$cl= $ctr%2==0 ? 'even' : 'odd'; $ctr++;
		$ht .="<tr class=$cl><td>".$cname."</td>";
		if(is_float($ccentre) || is_int($ccentre))
			$vlu=$ccentre;
		else {
			$bdgt	= Yii::app()->db->createCommand("select sum(amount) a from v_budget where  budget =".user()->budget[id]." and ".$ccentre)->queryAll();
			$vlu=$bdgt[0]['a'];
		}
				$dt+=$vlu;	
		$ht.= "<td style='text-align:right'>".number_format($vlu)."</td></tr>";
	}
	$ht.= "<tr class=$r><th><strong>Totals</strong></th>";
	$ht .="<th style='text-align:right'><strong>".number_format($dt)."</strong></th></tr>";
	echo $ht;
?>
</tbody></table>