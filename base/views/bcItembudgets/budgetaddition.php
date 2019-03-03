<div id="sections-grid" class="grid-view"><table class="items">
</thead><tr><th>AC Code</th><th>Item</th><th>Original Budget</th><th> Budget Check Figure</th><th> Option</th></tr></thead><tbody>
<?php

$secs=app()->db->createCommand("select id,section from sections where department is not null limit 10000")->queryAll();
foreach ($secs as $s) {
	$c++;
	//print_r($s[section]);

	echo "<tr><th colspan=5>$c.". ".$s[section]</th></tr>";
	$w=app()->db->createCommand("Select distinct item,name from budget a join items b on (a.item=b.id and b.accountcode not in (172,114,108,113,103,76,77,74,93,83,72,79,81,78,73,96,167,119,120)) where budget=4 and dept=".$s[id])->queryAll();
	//echo "Select distinct item,name from budget a join items b on a.item=b.name where budget=4 and dept=".$s[0];
	//exit;
	foreach($w as $ss) {
		//print_r($ss);
		//echo "select sum(amount) am,accountcode a from v_budget where item='".$ss[item]."' and budget=4 and dept=".$s[id];
		//exit;
		$w2=app()->db->createCommand("select sum(amount) am,accountid a from v_budget where item='".$ss[item]."' and budget=4 and dept=".$s[id])->queryAll();
		$budgt=app()->db->createCommand("select sum(amount) a from bc_itembudgets where item='".$ss[item]."' and budget=4 and section=".$s[id]." and reason=1")->queryAll();
//print_r($w2);
		//echo $budgt[0][am];
		//echo "select amount a from bc_itembudgets where item='".$ss[item]."' and budget=4 and section=".$s[id]." and reason=1";
		//exit;
		if($w2[0][am] <> $budgt[0][a]) {
			$cc++;
			$d=$cc%2==0 ? "odd" : "even";
			echo "<tr class=".$d."><td>".$w2[0][a]."</td><td>".$ss[name]."</td><td>".number_format($w2[0][am])."</td><td>".number_format($budgt[0][a])."</td><td><a href='index.php?r=settings/budgetaddition&item=$ss[item]&dept=$s[id]'>Add to Budget</a></td></tr>";
		}
		//echo "select sum(amount) a from v_budget where item='".$ss[0]."' and budget=3 and section=".$s[0];
		//echo "$ss[0] $w2[0] <br/>";

		//if($w2[0] > 0) mysql_query("INSERT INTO bc_itembudgets (item,amount,section,budget,reason,dateadded,addedby,updated_by) values('".$ss[0]."','".$w2[0]."','".$s[0]."','4','1',now(),'1','1')") or die(mysql_error().$w2[0]);
	}
//echo "...done<br>";
}
//echo "Ehuuuuu";
?></tbody>
</table></div>
