<?php

class ServiceController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
		 public function actionBudget()
	 	{
      $sections = array (
'hr'=>254,
'ad'=>252,
'hu'=>255,
'mf'=>273,
'ds'=>112,
'es'=>253,
'pa'=>133,
'mi'=>275,
'cn'=>245,
'ti'=>258,
'tr'=>268,
'cs'=>274,
'pd'=>259,
'le'=>251,
'pp'=>250,
'sr'=>267,
'om'=>272,
'co'=>256,
'tl'=>257,
'pn'=>262,
'ma'=>261,
'au'=>265,
'md'=>266,
'de'=>131,
'po'=>277,
'pl'=>246,
'dv'=>247,
'ss'=>263,
'mp'=>118,
'eb'=>270,
'pm'=>250,
'pe'=>249,
'em'=>270,
'pi'=>260
);
	 		$sp=Yii::app()->db->createCommand("select id from budgets where current='Yes'")->queryAll();
	 		$budget=$sp[0]['id'];
      if($_GET['section'])
        $add=" AND section='".$sections[$_GET['section']]."'";
	 		$sp=Yii::app()->db->createCommand("select sum(amount) a from v_bc_itembudgets where budget=".$budget." ".$add." and  reason in (3,6) and status='COMMITED' and accountcode not regexp '^3'")->queryAll();

//echo "select sum(amount) a from v_bc_itembudgets where budget=".$budget." ".$add." and  reason in (3,6) and status='COMMITED' and accountcode not regexp '^3'";
	 		$bspent=(float)$sp[0][a]*-1;

      if($_GET['section'])
        $add=" AND dept='".$sections[$_GET['section']]."'";

	 		$tbudget= Yii::app()->db->createCommand('select sum(amount) a from v_budget where  budget='.$budget."  ".$add." and accountid not regexp '^3'")->queryAll();
	 		foreach($tbudget as $cds) {
	 			$btotal+=$cds[a];
	 		}
	 			echo json_encode(array('budget'=>$btotal,'spent'=>$bspent));//.'  '.$btotal;
	 	}
}
