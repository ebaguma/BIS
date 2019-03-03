#!/usr/bin/php
<?php
//echo "<pre>";
$csv = array_map('str_getcsv', file("training2018.csv"));
$dbh = new PDO("mysql:host=localhost;dbname=bis", "root", "Uetcl7625");

foreach($csv as $l) {
	$dbh->exec("INSERT INTO items (accountcode,name,uom,readonly) values (103,'".$l[0]."',4,1)") or die(print_r($dbh->errorInfo()).$l[0]);
//	echo "DELETE from bc_itembudgets where section=$l[2] and budget=5 and item in (select id from items where accountcode=103) and amount <1";
	$dbh->exec("DELETE from bc_itembudgets where section=$l[2] and budget=5 and item in (select id from items where accountcode=103) and amount >1");// or die("ded".print_r($dbh->errorInfo()).$l[0]);
	$a=$dbh->query("SELECT id from items where accountcode=103 and name='".$l[0]."'")->fetch();
	//echo $a[0]."-".$l[0]."\n";
	$dbh->exec("INSERT INTO bc_itembudgets (item,amount,section,budget,reason,dateadded,addedby,updated_by,updated_at) values('".$a[0]."','".$l[1]."','".$l[2]."','5','1',now(),'1','1',now())")  or die(print_r("a".$dbh->errorInfo()).$l[0]);
	echo "done with $l[0]\n";
}
?>
