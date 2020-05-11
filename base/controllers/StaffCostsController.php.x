<?php

class StaffCostsController extends Controller
{
	public $layout='//layouts/column2';
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	public function accessRules()
	{
		$a=array('adminn');
		if($_REQUEST['id']) {
			$m=StaffCosts::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			if(Yii::app()->user->id == $m->createdby) $a[]=Yii::app()->user->name;
		}
		$b=array('adminn');
		if(is_budget_officer()) $b[]=Yii::app()->user->name;
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin','item','exportd'),
				'users'=>$b,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','view','exportd'),
				'users'=>$a,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionView($id) { $this->render('view',array('model'=>$this->loadModel($id))); }
	
	public function actionItem() {
	$redir=array(
		//'102' => 'transportBudget/create',
		'113' => 'travel/create&m=ForeignTravel',
		'139' => 'subsistence/create',
		'147' => 'subsistence/create',
		'137' => 'subsistence/create',
		'144' => 'subsistence/create',
		'103' => 'travel/create&m=TrainingTravel',
		'201' => 'guaranteesBudget/create',
	);
	if(array_key_exists($_REQUEST['StaffCosts']['accountcode'],$redir)) {
		echo "<script>document.location.href='index.php?r=".$redir[$_REQUEST['StaffCosts']['accountcode']]."';</script>";
		exit;
	}
		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget['id'])->queryAll();
		for($i=0; $i<count($data);$i++) {
				
			$csz .="<option class=ew value=".$data[$i]['itemid'].">".strip($data[$i]['name'])."</option>";
			$jarray .="<div id='itemprice".$data[$i]['itemid']."'>".$data[$i]['price']."</div>";
			$jarrayc .="<div id='itemcur".$data[$i]['itemid']."'>".$data[$i]['currency']."</div>";
			$jarrayr .="<div id='itemrate".$data[$i]['itemid']."'>".$data[$i]['exrate']."</div>";
			$jbudget .="<div id='tbudget".$data[$i]['itemid']."'>".number_format($tbudget)."</div>";
		}
		$jarray .="<div id='itemprice0'></div><div id='itemcur0'>UGX</div><div id='itemrate0'>1</div>";
		?>
	<script type="text/javascript" src="/assets/dc899cdc/jquery.js"></script>
	<script type="text/javascript">
		function test(dd, v) {
			var w = document.getElementById('period' + dd).value == "Monthly" ? 12 : 1;
			document.getElementById("price" + dd).innerHTML = accounting.formatNumber(document.getElementById("itemprice" + v).innerHTML);
			document.getElementById("cur" + dd).innerHTML = document.getElementById("itemcur" + v).innerHTML;
			if (isNaN(document.getElementById("qty" + dd).value)) document.getElementById("qty" + dd).value = 1;
			document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * accounting.unformat(document.getElementById("price" + dd).innerHTML) * document.getElementById("itemrate" + v).innerHTML * w);
			var maxd = document.getElementById('dkeeper').innerHTML;
			var allt = 0;
			for (i = 1; i <= maxd; i++) {
				allt += parseFloat(accounting.unformat(document.getElementById("total" + i).innerHTML));
			}
			document.getElementById('alltotal').innerHTML = accounting.formatMoney(allt);
		}

		function test2(dd) {
			var w = document.getElementById('period' + dd).value == "Monthly" ? 12 : 1;
			//document.getElementById("price"+dd).innerHTML=document.getElementById("itemprice"+v).innerHTML; 
			if (isNaN(document.getElementById("qty" + dd).value)) document.getElementById("qty" + dd).value = 1;
			//			alert();
			document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * accounting.unformat(document.getElementById("price" + dd).innerHTML) * document.getElementById("itemrate" + document.getElementById("it" + dd).value).innerHTML * w);
			var maxd = document.getElementById('dkeeper').innerHTML;
			var allt = 0;
			for (i = 1; i <= maxd; i++) {
				allt += parseFloat(accounting.unformat(document.getElementById("total" + i).innerHTML));
			}
			document.getElementById('alltotal').innerHTML = accounting.formatMoney(allt);
			checkDate(dd);
		}

		function checkDate(d) {
			var cDate = document.getElementById('dateneeded' + d).value;
			var NewDate = new Date(cDate); //dd-mm-YYYY
			var today = new Date();
			today.setHours(0,0,0,0);
				if (cDate == '') {
					alert('Please Capture Date Required (YYYY-MM-DD)');
					document.getElementById('additional-link').setAttribute("style", "display: none;");
					document.getElementById('submit').disabled = true;
				} else if (isDate(cDate) && (NewDate > today)) { 
					document.getElementById('additional-link').style.display = null;
					document.getElementById('submit').disabled = false; 
					}else{
						alert('\t Required Date is Invalid (YYYY-MM-DD) \t ');
					document.getElementById('additional-link').setAttribute("style", "display: none;");
					document.getElementById('submit').disabled = true;
					}
			}

			function formatDate(dDate) {
				var d = new Date(date),
					month = '' + (d.getMonth() + 1),
					day = '' + d.getDate(),
					year = d.getFullYear();

				if (month.length < 2) month = '0' + month;
				if (day.length < 2) day = '0' + day;

				return [year, month, day].join('-');
			}

		jQuery(function ($) {
			var d = document.getElementById('dkeeper').innerHTML;
			$("#additional-link").bind("click", function () { //document.getElementById('price"+d+"').innerHTML=this.class
				d++;
				var rown = d % 2 == 0 ? "even" : "odd";
				$("#additional-inputs").append("\n<tr class=" + rown + " id=sel" + d + "><td>" + d + ".</td><td><select id='it" + d + "' onchange='test(" + d + ",this.value);' name=StaffCosts[item][] style='width:200px' ><option value=0> - select -</option><?php echo $csz?></select></td><td><input id='dateneeded" + d + "' name=StaffCosts[dateneeded][] placeholder='YYYY-MM-DD' onBlur='checkDate(" + d + ")' /></td><td style='text-align:right' id=price" + d + "></td><td id=cur" + d + "></td><td><select onChange='test2(" + d + ")'  id='period" + d + "' name=StaffCosts[period][]><option value=Annually>Annually</option><option value=Monthly>Monthly</option></select></td><td><input id=qty" + d + " onKeyUp='test2(" + d + ");' onChange='test2(" + d + ")'  style='width:60px' type=number value=1 name=StaffCosts[quantity][]></td><td style='text-align:right' id=total" + d + "></td></tr>");
				document.getElementById('dkeeper').innerHTML = d;
				document.getElementById('submit').disabled = true;
			});

			$("#additional-linkr").bind("click", function () {
				$("#sel" + d).remove();
				d--;
				document.getElementById('dkeeper').innerHTML = d;
				document.getElementById('additional-link').style.display = null;
				document.getElementById('submit').disabled = false;
			});
		});

		function isDate(txtDate)
		{
			var currVal = txtDate;
			if(currVal == '')
				return false;

			var rxDatePattern = /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/; //Declare Regex
			var dtArray = currVal.match(rxDatePattern); // is format OK?

			if (dtArray == null) 
				return false;

			//Checks for mm/dd/yyyy format.
			dtMonth = dtArray[1];
			dtDay= dtArray[3];
			dtYear = dtArray[5];        

			if (dtMonth < 1 || dtMonth > 12) 
				return false;
			else if (dtDay < 1 || dtDay> 31) 
				return false;
			else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
				return false;
			else if (dtMonth == 2) 
			{
				var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
				if (dtDay> 29 || (dtDay ==29 && !isleap)) 
						return false;
			}
			return true;
		}

		
	</script>
	<div id=idbudget style='display:none;'>
		<?php  echo $jbudget; ?>
	</div> <a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a>. To remove any Item, set its quantity to <strong>0</strong>
	<table class=items style='widthi:900px'>
		<tr>
			<th>No.</th>
			<th style='text-align:left'>Item</th>
			<th style='text-align:left'>Date Required</th>
			<th style='text-align:right'>Price</th>
			<th style='text-align:left'>Currency</th>
			<th style='text-align:left'>Period</th>
			<th style='text-align:left'>Quantity</th>
			<th style='text-align:right'>Total</th>
		</tr>
		<tbody id="additional-inputs">
			<?php
	$d=$bigtot=0;	
	$dat=Yii::app()->db->createCommand("SELECT * from v_staff_costs where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget['id']." and dept='".user()->dept['id']."'")->queryAll();
//	echo "SELECT * from v_staff_costs where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget['id']." and dept='".user()->dept['id']."'";
	$rtr="";
	foreach($dat as $dt) {
		$cz1 = "<option value=$dt[item]>$dt[itemname]</option>";
		$jarrayr.= "<div style='display:none'  id='itemrate".$dt['item']."'>".$dt['exrate']."</div>";
		
		$cl=$d%2==0 ? "even" : "odd";
		$d++;
		$www=$dt[price]*$dt[quantity]*$dt['exrate']*($dt[period]=='Annually' ? 1 : 12);
		$bigtot+=$www;
		?>
				<tr class=<?php echo $cl?> id=sel
					<?php echo $d;?>>
						<td>
							<?php echo $d;?>
						</td>
						<td>
							<select id='it<?php echo $d; ?>' onblur='test(<?php echo $d; ?>,this.value);' name=StaffCosts[item][]>
								<?php echo $cz1?>
							</select>
						</td>
						<td>
							<input id='dateneeded<?php echo $d; ?>' value=<?php echo $dt[dateneeded] ?> name=StaffCosts[dateneeded][] onBlur='checkDate(<?php echo $d; ?>)' style='width:200px' />
						</td>
						<td style='text-align:right' id=price<?php echo $d;?>>
							<?php echo number_format($dt[price])?>
						</td>
						<td id=cur<?php echo $d;?>>
							<?php echo $dt[currency];?>
						</td>
						<td>
							<select onChange='test2(<?php echo $d;?>)' id='period<?php echo $d;?>' name=StaffCosts[period][]>
								<option value='Annually' <?php if($dt[period]=='Annually' ) echo "SELECTED=SELECTED"; ?>>Annually</option>
								<option value='Monthly' <?php if($dt[period]=='Monthly' ) echo "SELECTED=SELECTED"; ?>>Monthly</option>
							</select>
						</td>
						<td>
							<input id=qty<?php echo $d;?> onKeyUp='test2(
							<?php echo $d;?>)' onChange='test2(
								<?php echo $d;?>)' type=number style='width:60px' value=
									<?php echo $dt[quantity]?> name=StaffCosts[quantity][] /></td>
						<td style='text-align:right' id=total<?php echo $d;?>>
							<?php echo number_format($www)?>
						</td>
				</tr>
				<?php } ?>
		</tbody>
		<tr>
			<td colspan=5>Grand Total (UGX):</td>
			<td colspan=3 id=alltotal style='text-align:right; font-weight:bold; font-size:14px;'>
				<?php echo number_format($bigtot) ?>
			</td>
	</table>
	<div id=id3 style='display:none;'>
		<?php  echo $jarray.$jarrayc.$jarrayr; ?>
			<div id=dkeeper>
				<?php echo $d?>
			</div>
	</div>
	<?php	
	}
	public function actionExportd() {
		$mydata = Yii::app()->db->createCommand("select * from staff_costs where budget=6")->queryAll();
		foreach($mydata as $rec) {
//			/echo 
			$amt=Yii::app()->db->createCommand("SELECT price a,name b from items_prices_view where itemid='".$rec['item']."' and budget='6'")->queryAll();
				$newrec=array(
								"accountcode"	=>	$rec['accountcode'],
								"item"			=>	$rec['item'],
								"period"			=>	$rec['period'],
								"dept"			=>	$rec['dept'],						
								"budget"			=>	8,
								"createdby"		=>	$rec['createdby'],
								"dateneeded"	=> $rec['dateneeded'],
								"quantity"		=>	$rec['quantity'],
							);
			GeneralRepository::insertSeveral('staff_costs',  array($newrec));
$scyy=Yii::app()->db->createCommand("SELECT last_insert_id() a from staff_costs")->queryAll();
						$newbudget = array(
							"budget" 		=>	8,
							"item"			=>	$rec['item'],
							"dept"			=>	$rec['dept'],
							"qty"				=>	$rec['quantity'],
							"period"			=>	($rec['period']=='Monthly' ? 12 : 1),
							"createdby"		=>	$rec['createdby'],
							"dateneeded"	=> $rec['dateneeded'],
							"tbl"				=>	"staff_costs",
							"tblid"			=>	$scyy[0][a],
							"descr"			=>	$amt[0][b],
							//"units"			=>	10
						);
			GeneralRepository::insertSeveral('budget', array($newbudget));
			//echo "<pre>";
			//print_r($newrec);
			//print_r($newbudget);
		}
	}
	public function actionCreate()
	{
//		echo "<pre>";print_r($_POST['StaffCosts']); exit;	
		$model=new Staffcosts;
		
		if(isset($_POST['StaffCosts']['item']))
		{
			if(budget_locked()) { $this->render('/site/locked'); exit; } 
				
			if(empty($_POST['StaffCosts']['dateneeded'])) $_POST['StaffCosts']['dateneeded']=date("Y-m-d");
			StaffCosts::model()->deleteAll("accountcode='".$_POST['StaffCosts']['accountcode']."' and dept='".user()->dept['id']."' and budget='".Yii::app()->user->budget['id']."'");
				$b=$alr=array();
				for($c=0;$c<count($_POST['StaffCosts']['item']);$c++) {
					if(!in_array($_POST['StaffCosts']['item'][$c],$alr))  {
						$alr[]=$_POST['StaffCosts']['item'][$c];
					$qty=(int)$_POST['StaffCosts']['quantity'][$c];
					Budget::model()->deleteAll("item='".$_POST['StaffCosts']['item'][$c]."' and dept='".user()->dept['id']."' and budget='".Yii::app()->user->budget['id']."' and tbl='staff_costs'");
					if($qty > 0 && $_POST['StaffCosts']['item'][$c]) {
						Yii::app()->db->createCommand("delete from budget where item='".$_POST['StaffCosts']['item'][$c]."' and dept='".user()->dept['id']."' and budget='".Yii::app()->user->budget['id']."' and tbl='staff_costs'")->execute();
						GeneralRepository::insertSeveral('staff_costs',  array(array(
								"accountcode"	=>	$_POST['StaffCosts']['accountcode'],
								"item"			=>	$_POST['StaffCosts']['item'][$c],
								"period"			=>	$_POST['StaffCosts']['period'][$c],
								"dept"			=>	Yii::app()->user->dept['id'],						
								"budget"			=>	Yii::app()->user->budget['id'],
								"createdby"		=>	Yii::app()->user->id,
								"dateneeded"	=> $_POST['StaffCosts']['dateneeded'][$c],
								"quantity"		=>	$_POST['StaffCosts']['quantity'][$c],
							))
						);
						$scyy=Yii::app()->db->createCommand("SELECT last_insert_id() a from staff_costs")->queryAll();
						$amt=Yii::app()->db->createCommand("SELECT price a,name b from items_prices_view where itemid='".$_POST['StaffCosts']['item'][$c]."' and budget='".user()->budget['id']."'")->queryAll();
						$b[] = array(
							"budget" 		=>	Yii::app()->user->budget['id'],
							"item"			=>	$_POST['StaffCosts']['item'][$c],
							"dept"			=>	Yii::app()->user->details['dept'],
							"qty"				=>	$_POST['StaffCosts']['quantity'][$c],
							"period"			=>	($_POST['StaffCosts']['period'][$c]=='Monthly' ? 12 : 1),
							"createdby"		=>	Yii::app()->user->id,
							"dateneeded"	=> $_POST['StaffCosts']['dateneeded'][$c],
							"tbl"				=>	"staff_costs",
							"tblid"			=>	$scyy[0][a],
							"descr"			=>	$amt[0][b],
							//"units"			=>	10
						);
						
						$lg=new Log();
						$lg->action="Inserted ".$scyy[0][a]." in staff_costs with amount ".$_POST['StaffCosts']['quantity'][$c];
						$lg->addr=$_SERVER['REMOTE_ADDR'];
						$lg->host=$_SERVER['REMOTE_HOST'];
						$lg->browser=$_SERVER['HTTP_USER_AGENT'];
						$lg->created_by=Yii::app()->user->passwd;
						$lg->created_at=date("Y-m-d H:i:s");
						$lg->save();
					}
				} 
			}
			if(count($b) >0 ) GeneralRepository::insertSeveral('budget', $b);
			/***
			 if ($_POST['StaffCosts']['dateneeded'][$c] = ''){
				echo '<script type="text/javascript">alert("Date is Required");</script>';
			}else{ }
			***/

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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StaffCosts']))
		{
			$model->attributes=$_POST['StaffCosts'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('StaffCosts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StaffCosts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StaffCosts']))
			$model->attributes=$_GET['StaffCosts'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StaffCosts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StaffCosts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StaffCosts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staff-costs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}