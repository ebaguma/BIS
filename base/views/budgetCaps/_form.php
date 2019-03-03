<?php $form=$this->beginWidget('CActiveForm',array('method'=>'GET')); ?>
	<?php echo Chtml::dropDownList('ac',$_REQUEST['ac'],Chtml::ListData(Accountcodes::model()->findAll("accountcode regexp '^[1|4].$' order by accountcode"),'accountcode','item')); ?>
	<?php echo CHtml::submitButton('Select'); ?>
<?php $this->endWidget(); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'budget-caps-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
$ht = "<h1>Departmental Budget Caps: ".user()->budget['name']."</h1>";
$ht .= "<div id='foo'  class='grid-view'><table style='border: 1px solid;max-width:1400px' class=items>";
$depts=app()->db->CreateCommand("SELECT * from dept order by ordering asc")->queryAll();
$ht.="<tr><th>Account Code</th>";
$depts_num=count($depts);
foreach($depts as $dep) 
	$ht.="<th style='width:100pax'>".$dep[shortname]."</th>";
$ht.="</tr>";

$e=BudgetCaps::model()->findAll('budget='.budget());
foreach ($e as $as)
	$cap[$as[dept]][$as[accountcode]]=$as[cap];


	$ct=0;
	$ac=!empty($_REQUEST['ac']) ? $_REQUEST['ac'] : 10;
	$ccentres = Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$ac.".' order by accountcode")->queryAll();
	$mydep=array();
	foreach ($ccentres as $cc) {
		$cl= $ctr%2==0 ? 'even' : 'odd'; $ctr++;
		if(preg_match('/^[0-9]{2}$/',$cc[accountcode])) {
			$ht .="<tr class=$cl><td colspan=".($depts_num+1)."><h3>".$cc[accountcode]." - ".$cc[item]."</td></tr>";
		} else {
		
			$ht .="<tr class=$cl><td>".$cc[accountcode]." - ".$cc[item]."</td>";
			//$cstotal=0;
			//$dctr=0;
			foreach($depts as $dpt) {
				//$dt=0;
				/*$bdgt	= Yii::app()->db->createCommand("select amount a, qty from v_budget where realdept =".$dpt['id']." and budget =".user()->budget[id]." and accountcode in (select id from accountcodes where accountcode like '".$cc[accountcode]."%') ")->queryAll();
				foreach($bdgt as $rw) {
					$qty=1;
					$dt+=$rw['a'];	
					$ct+=$dt;		
				}*/
				$ht.= "<td style='text-align:right'><input style='width:80px' name=cap[".$dpt['id']."][".$cc[accountcode]."] type=number value=".($cap[$dpt['id']][$cc[accountcode]])." /></td>";
			
				//$cstotal+=$dt;
				//$mydep[$dctr] +=$dt;$dctr++;
			}
		
			$ht.= "</tr>";
			$mtotal+=$cstotal;
		}
	}
	$ht .="</tr>";
	echo $ht;
?>
</tbody></table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->