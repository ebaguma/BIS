<?php

class SubsistenceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','subsection','sites'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSites1(){
		$ht=$st="";
		if( $_REQUEST[Subsistence][item]) {
			if($_REQUEST[Subsistence][item]==147) // Transmission Lines
				$data=CHtml::listData(Sites::model()->findAll("code='E'"),'id','site');
			else if($_REQUEST[Subsistence][item]==137) // Pole Plant
				$data=CHtml::listData(Sites::model()->findAll("code='P'"),'id','site');
			else if($_REQUEST[Subsistence][item]==144) // Communication Equipment
				$data=CHtml::listData(Sites::model()->findAll("code='C' or code='O"),'id','site');
			else if($_REQUEST[Subsistence][item]==157) // Optic Fibre
				$data=CHtml::listData(Sites::model()->findAll(),'id','site');
			else // Substation
				$data=CHtml::listData(Sites::model()->findAll("code='O'"),'id','site');
			foreach($data as $value=>$name)
				$st.= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

			$csz=""; $jarray="";$jbudget="";
			$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where  accountcode=".$_REQUEST[Subsistence][item]." and budget=".Yii::app()->user->budget['id'])->queryAll();
			//echo "SELECT * from items_prices_view where  accountcode='147' and budget='3';
			for($i=0; $i<count($data);$i++) {

				$csz .="<option class=ew value=".$data[$i]['itemid'].">".$data[$i]['name']."s</option>";
				$jarray .="<div id='itemprice".$data[$i]['itemid']."'>".$data[$i]['price']."</div>";
				$jbudget .="<div id='tbudget".$data[$i]['itemid']."'>".number_format($tbudget)."</div>";
			}
			$jarray .="<div id='itemprice0'></div>";

	       $ht .=' <script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script>
	        <script type="text/javascript">
			function test(dd,v) {
				document.getElementById("price"+dd).innerHTML=accounting.formatNumber(document.getElementById("itemprice"+v).innerHTML);
				if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1;
				document.getElementById("total"+dd).innerHTML=accounting.formatNumber(document.getElementById("qty"+dd).value * accounting.unformat(document.getElementById("price"+dd).innerHTML));
				var maxd=document.getElementById(\'dkeeper\').innerHTML;
				var allt=0;
				for(i=1; i<=maxd;i++) {
					allt += parseFloat(accounting.unformat(document.getElementById("total"+i).innerHTML));
				}
				document.getElementById(\'alltotal\').innerHTML=accounting.formatMoney(allt);
			}
			function test2(dd) {

				//document.getElementById("price"+dd).innerHTML=document.getElementById("itemprice"+v).innerHTML;
				if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1;
				document.getElementById("total"+dd).innerHTML=accounting.formatNumber(document.getElementById("qty"+dd).value * accounting.unformat(document.getElementById("price"+dd).innerHTML));

				var maxd=document.getElementById(\'dkeeper\').innerHTML;
				var allt=0;
				for(i=1; i<=maxd;i++) {
					allt += parseFloat(accounting.unformat(document.getElementById("total"+i).innerHTML));
				}
				document.getElementById(\'alltotal\').innerHTML=accounting.formatMoney(allt);
			}

			jQuery(function($) {
				var d=document.getElementById(\'dkeeper\').innerHTML;
				$("#additional-link").bind("click",function(){ //document.getElementById(\'price"+d+"\').innerHTML=this.class
				d++;
				var rown = d%2==0 ? "even" : "odd";
				$("#additional-inputs").append("\n<tr class="+rown+" id=sel"+d+"><td>"+d+".</td><td><select onchange=\'test("+d+",this.value);\' name=StaffCosts[item][]><option value=0> - select -</option>'.$csz.'</select></td><td id=price"+d+"></td><td>UGX</td><td><select><option value=12>Annually</option><option value=1>Monthly</option></select></td><td><input id=qty"+d+" onBlur=\'test2("+d+")\'  style=\'width:60px\' type=number value=1 name=StaffCosts[quantity][]></td><td style=\'text-align:right\' id=total"+d+"></td></tr>");
				document.getElementById(\'dkeeper\').innerHTML=d;
	    	});
			$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById(\'dkeeper\').innerHTML=d;});
	});
	</script>
	<div id=idbudget style=\'display:none;\'>'.$jbudget.'</div>
	<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a><table class=items style=\'width:900px\'><tr><th>No.</th><th>Item</th><th>Price</th><th>Currency</th><th>Period</th><th>Quantity</th><th>Total</th></tr><tbody id="additional-inputs"></tbody><tr><td colspan=6>Grand Total</td><td id=alltotal style=\'text-align:right;font-weight:bold\'>UGX '.number_format($bigtot).'</td></table>
		<div id=id3 style=\'display:none;\'>'.$jarray.'<div id=dkeeper>'.$d.'</div></div>';

			echo CJSON::encode(
				array(
					 'sites'	=>$st,
					 'om'		=>$ht,
				)
			);
		}
	}

	public function actionSites() {
		$st=$ht="";
		if($_REQUEST[Subsistence][item]==147) // Transmission Lines
			$data=CHtml::listData(Sites::model()->findAll("code='E'"),'id','site');
		else if($_REQUEST[Subsistence][item]==137) // Pole Plant
			$data=CHtml::listData(Sites::model()->findAll("code='P'"),'id','site');
		else if($_REQUEST[Subsistence][item]==144) // Communication Equipment
			$data=CHtml::listData(Sites::model()->findAll("code='C'"),'id','site');
		else
			$data=CHtml::listData(Sites::model()->findAll("code='O'"),'id','site');
		foreach($data as $value=>$name)
			$st.= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where  accountcode=".$_REQUEST[Subsistence][item]." and budget='".Yii::app()->user->budget['id']."' and readonly='0'")->queryAll();
		for($i=0; $i<count($data);$i++) {
			$csz .="<option class=ew value=".$data[$i]['itemid'].">".strip($data[$i]['name'])."</option>";
			$jarray .="<div id='itemprice".$data[$i]['itemid']."'>".$data[$i]['price']."</div>";
			$jarrayc .="<div id='itemcur".$data[$i]['itemid']."'>".$data[$i]['currency']."</div>";
			$jarrayr .="<div id='itemrate".$data[$i]['itemid']."'>".$data[$i]['exrate']."</div>";
			$jbudget .="<div id='tbudget".$data[$i]['itemid']."'>".number_format($tbudget)."</div>";
		}
		$jarray .="<div id='itemprice0'></div><div id='itemcur0'>UGX</div><div id='itemrate0'>1</div>";

       $ht='<script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script>
        <script type="text/javascript">
		function test(dd,v) {
			document.getElementById("price"+dd).innerHTML=accounting.formatNumber(document.getElementById("itemprice"+v).innerHTML);
			document.getElementById("cur"+dd).innerHTML=document.getElementById("itemcur"+v).innerHTML;
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1;
			document.getElementById("total"+dd).innerHTML=accounting.formatNumber(document.getElementById("qty"+dd).value * accounting.unformat(document.getElementById("price"+dd).innerHTML)*document.getElementById("itemrate"+v).innerHTML);
			var maxd=document.getElementById(\'dkeeper\').innerHTML;
			var allt=0;
			for(i=1; i<=maxd;i++) {
				allt += parseFloat(accounting.unformat(document.getElementById("total"+i).innerHTML));
			}
			document.getElementById(\'alltotal\').innerHTML=accounting.formatMoney(allt);
		}
		function test2(dd) {
			//document.getElementById("price"+dd).innerHTML=document.getElementById("itemprice"+v).innerHTML;
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1;
//			alert();
			document.getElementById("total"+dd).innerHTML=accounting.formatNumber(document.getElementById("qty"+dd).value * accounting.unformat(document.getElementById("price"+dd).innerHTML)*document.getElementById("itemrate"+document.getElementById("it"+dd).value).innerHTML);
			var maxd=document.getElementById(\'dkeeper\').innerHTML;
			var allt=0;
			for(i=1; i<=maxd;i++) {
				allt += parseFloat(accounting.unformat(document.getElementById("total"+i).innerHTML));
			}
			document.getElementById(\'alltotal\').innerHTML=accounting.formatMoney(allt);
		}
		jQuery(function($) {
			var d=document.getElementById(\'dkeeper\').innerHTML;
			$("#additional-link").bind("click",function(){ //document.getElementById(\'price"+d+"\').innerHTML=this.class
			d++;
			var rown = d%2==0 ? "even" : "odd";
			$("#additional-inputs").append("\n<tr class="+rown+" id=sel"+d+"><td>"+d+".</td><td><select id=\'it"+d+"\' onchange=\'test("+d+",this.value);\' name=item[]><option value=0> - select -</option>'.$csz.'</select></td><td style=\'text-align:right\' id=price"+d+"></td><td id=cur"+d+"></td><td><input id=qty"+d+" onKeyUp=\'test2("+d+");\' onChange=\'test2("+d+")\'  style=\'width:60px\' type=number value=1 name=quantity[]></td><td style=\'text-align:right\' id=total"+d+"></td></tr>");
			document.getElementById(\'dkeeper\').innerHTML=d;
    	});
		$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById(\'dkeeper\').innerHTML=d;});
});
</script>

<div id=idbudget style=\'display:none;\'>'.$jbudget.'</div>
<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a><table class=items style=\'widthi:900px\'><tr><th>No.</th><th>Item</th><th>Price</th><th>Currency</th><th>Quantity</th><th>Total</th></tr><tbody id="additional-inputs">';


	$d=$bigtot=0;
	$dat=Yii::app()->db->createCommand("SELECT * from v_staff_costs where  accountcode=147 and budget=".Yii::app()->user->budget['id']." and dept='".user()->dept['id']."' and createdby='".Yii::app()->user->id."'")->queryAll();
	//$dat=Yii::app()->db->createCommand("SELECT * from v_staff_costs where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget['id']."'")->queryAll();
	$rtr="";
	foreach($dat as $dt) {
		$cz1 = "<option value=$dt[item]>$dt[itemname]</option>";
		$jarrayr.= "<div style='display:none'  id='itemrate".$dt['item']."'>".$dt['exrate']."</div>";

		$cl=$d%2==0 ? "even" : "odd";
		$d++;
		$www=$dt[price]*$dt[quantity]*$dt['exrate']*($dt[period]=='Annually' ? 1 : 12);
		$bigtot+=$www;

	$ht .="<tr class=".$cl." id=sel".$d."><td>".$d."</td><td><select id='it".$d."' onblur='test(".$d.",this.value);' name=StaffCosts[item][]>".$cz1."</select></td><td style='text-align:right' id=price".$d.">".number_format($dt[price])."</td><td id=cur".$d.">".$dt[currency]."</td><td><input id=qty".$d." onKeyUp='test2(".$d.")' onChange='test2(".$d.")' type=number style='width:60px' value=".$dt[quantity]." name=StaffCosts[quantity][] /></td><td style='text-align:right' id=total".$d.">".number_format($www)."</td></tr>";

	 }
	$ht.="</tbody><tr><td colspan=5>Grand Total</td><td id=alltotal style='text-align:right;font-weight:bold'>UGX ".number_format($bigtot)."</td></table>
	<div id=id3 style='display:none;'>".$jarray.$jarrayc.$jarrayr."<div id=dkeeper>".$d."</div></div>";
	echo CJSON::encode(
		array(
			 'sites'	=>$st,
			 'om'		=>$ht,
		)
	);

	}

	public function actionSubsection()
	{
		$data=CHtml::listData(SubsistenceSections::model()->findAll('parent='.$_REQUEST[Subsistence][section]),'id','section');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Subsistence;
		if(isset($_POST['Subsistence']))
		{
			//echo "<pre>";print_r($_POST);exit;
			$_POST['Subsistence']['activity'] = mt_rand(10000,99999);
			$this->saveModel();
		}
		$this->render('create',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Subsistence']))
		{
			app()->db->CreateCommand("DELETE from subsistence_staff where activity=".$id)->execute();
			app()->db->CreateCommand("DELETE from subsistence_details where activity=".$id)->execute();
			app()->db->CreateCommand("DELETE from budget where tbl='subsistence'and tblid=".$id)->execute();
			$this->saveModel($id);
		}
		$this->render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		app()->db->CreateCommand("DELETE from subsistence_staff where activity=".$id)->execute();
		app()->db->CreateCommand("DELETE from subsistence_details where activity=".$id)->execute();
		app()->db->CreateCommand("DELETE from budget where tbl='subsistence'and tblid=".$id)->execute();
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Subsistence');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Subsistence('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Subsistence']))
			$model->attributes=$_GET['Subsistence'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Subsistence the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Subsistence::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Subsistence $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subsistence-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function saveModel($id=0) {

		if($id > 0)
			$model=$this->loadModel($id);
			else
			$model=new Subsistence;
		$date1=  strtotime($_POST['Subsistence']['startdate']);
		$date2= 	strtotime($_POST['Subsistence']['enddate']);
		$days=($date2-$date1)/86400;

		if(budget_locked()) { $this->render('/site/locked'); exit; }

		if($days <1) {
			$this->renderText('Start Date can not be after End date!');
			exit;
		}
		$model->attributes=$_POST['Subsistence'];
		if($model->save()) {
			$v=$k=$bdt=array();

			// Casuals
			$dc=Items::model()->findByAttributes(array('name'=>'Casuals','accountcode'=>$_POST['Subsistence']['item']));
			if($dc==null) {
				$dc=new Items;
				$dc->attributes=array('name'=>'Casuals','accountcode'=>$_POST['Subsistence']['item']);
				$dc->save();
				$md2=new ItemsPrices;
				$md2->attributes=array('item'=>$dc->id,'currency'=>1,'price'=>1,'budget'=>user()->budget['id']);
				$md2->save();
			}
			$md=Budget::model()->findByAttributes(array('tbl'=>'subsistence','tblid'=>$model->id,'tblcolumn'=>'casuals'));
			if($md==null) $md=new Budget;
			if(intval($_POST['Subsistence']['casuals']) > 0) {
				$md->attributes = array (
					"budget"			=> Yii::app()->user->budget['id'],
					"dept"				=> Yii::app()->user->dept['id'],
					"item"				=>	$dc->id,
					"descr"				=> $model->activity." - Casuals",
					"qty"				=> $_POST['Subsistence']['casuals'],
					"tbl"				=> "subsistence",
					"period"			=> $days,
					"tblcolumn"			=> "casuals",
					"tblid"				=> $model->id,
					"dateneeded"		=> $_POST['Subsistence']['startdate'],
					"createdby"			=> Yii::app()->user->id,
					"createdon"	=>	date("Y-m-d H:m:s"),
				);
				$md->save();
			} else
				if(!$md->IsNewRecord) $dc->delete();

			$bdt=$alr=array();
			for($i=0;$i<count($_POST['employee']);$i++) {
				if(!in_array($_POST['employee'][$i],$alr)) {
					$alr[]=$_POST['employee'][$i];

					$v[] = array(
						"employee" 	=>	$_POST['employee'][$i],
						"activity"		=>	$model->id
					);
					$d=app()->db->CreateCommand("select scalename from v_employees_scales where id='".$_POST['employee'][$i]."' limit 1")->queryAll();
					//echo "select scalename from v_employees_scales where id='".$_POST['employee'][$i]."' limit 1";
					//echo "select id from items where name='Subsistence - ".$d[0]['scalename']." ' and accountcode='".$_POST['Subsistence']['item']."'";
					$item=app()->db->CreateCommand("select id from items where name='Subsistence - ".$d[0]['scalename']." ' and accountcode='".$_POST['Subsistence']['item']."'")->queryAll();
					$itemid=$item[0][id];
					if(!$item[0][id]) {
						$dc=new Items;
						$dc->attributes=array('name'=>'Subsistence - '.$d[0]['scalename'],'accountcode'=>$_POST['Subsistence']['item']);
						$dc->save();
						$md2=new ItemsPrices;
						$md2->attributes=array('item'=>$dc->id,'currency'=>1,'price'=>1,'budget'=>user()->budget['id']);
						$md2->save();
						$itemid=$dc->id;
					}

					$bdt[] = array (
					"budget"			=> Yii::app()->user->budget['id'],
					"dept"				=> Yii::app()->user->dept['id'],
					"item"				=>	$itemid,
					"descr"				=> $model->activity." - Subsistence Allowance for ".$_POST['employee'][$i],
					"qty"				=> $days,
					"tbl"				=> "subsistence",
					'tblcolumn'			=> "staff",
					"tblid"				=> $model->id,
					"dateneeded"		=> $_POST['Subsistence']['startdate'],
					"createdby"			=> Yii::app()->user->id,
					"createdon"	=>date("Y-m-d H:m:s"),
					);
				}
			}
			$alr=array();
			for($i=0;$i<count($_POST['item']);$i++) {
				if(!in_array($_POST['item'][$i],$alr) && $_POST['item'][$i] > 0) {
					$alr[]=$_POST['item'][$i];
					$k[] = array(
						"item" 		=>	$_POST['item'][$i],
						"quantity" 	=>	$_POST['quantity'][$i],
						"activity"	=>	$model->id
					);
					$bdt[] = array (
					"budget"		=> Yii::app()->user->budget['id'],
					"dept"			=> Yii::app()->user->dept['id'],
					"item"			=>	$_POST['item'][$i],
					"descr"			=> $model->activity,
					"qty"			=> $_POST['quantity'][$i],
					"tbl"			=> "subsistence",
					"tblcolumn"		=> "details",
					"tblid"			=> $model->id,
					"dateneeded"	=> $_POST['Subsistence']['startdate'],
					"createdby"		=> Yii::app()->user->id,
					"createdon"	=>date("Y-m-d H:m:s"),
					);
				}
			}
			//echo "<pre>";print_r($v); exit;
			if (count($bdt) > 0) 	GeneralRepository::insertSeveral('budget', $bdt);
			if(count($v) > 0) 	GeneralRepository::insertSeveral('subsistence_staff', $v);
			if (count($k) > 0) 	GeneralRepository::insertSeveral('subsistence_details', $k);
			$this->redirect(array('view','id'=>$model->id));
		}	else die("Failed to save model!");

	}
}
