<?php

class StaffCostsController extends Controller
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
		$a=array('adminn');
		if($_REQUEST['id']) {
			$m=StaffCosts::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			if(Yii::app()->user->id == $m->createdby) $a[]=Yii::app()->user->name;
		}
		$b=array('adminn');
		if(is_budget_officer()) $b[]=Yii::app()->user->name;
//		print_r($a);
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin','item'),
				'users'=>$b,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','update','view'),
				'users'=>$a,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) { $this->render('view',array('model'=>$this->loadModel($id))); }
	
	public function actionItem() {
	$redir=array(
		'102' => 'subsistence/create',
		'139' => 'subsistence/create',
		'147' => 'subsistence/create',
		'137' => 'subsistence/create',
		'144' => 'subsistence/create',
		'103' => 'travel/create&m=TrainingTravel',
	);
	if(array_key_exists($_REQUEST['StaffCosts']['accountcode'],$redir)) {
		echo "<script>document.location.href='index.php?r=".$redir[$_REQUEST['StaffCosts']['accountcode']]."';</script>";
		
	}
		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget['id'])->queryAll();
		for($i=0; $i<count($data);$i++) {
				
			$csz .="<option class=ew value=".$data[$i]['itemid'].">".$data[$i]['name']."s</option>";
			$jarray .="<div id='itemprice".$data[$i]['itemid']."'>".$data[$i]['price']."</div>";
			$jbudget .="<div id='tbudget".$data[$i]['itemid']."'>".number_format($tbudget)."</div>";
		}
		?>
        <script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script>
        <script type="text/javascript">
		function test(dd,v) { 
			
			document.getElementById("price"+dd).innerHTML=accounting.formatNumber(document.getElementById("itemprice"+v).innerHTML); 			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1; 
			document.getElementById("total"+dd).innerHTML=accounting.formatNumber(document.getElementById("qty"+dd).value * accounting.unformat(document.getElementById("price"+dd).innerHTML)); 
			var maxd=document.getElementById('dkeeper').innerHTML;
			var allt=0;
			for(i=1; i<=maxd;i++) {
				allt += parseFloat(accounting.unformat(document.getElementById("total"+i).innerHTML));
			}
			document.getElementById('alltotal').innerHTML=accounting.formatMoney(allt);		
		}
		
		jQuery(function($) {
			var d=document.getElementById('dkeeper').innerHTML;
			$("#additional-link").bind("click",function(){ //document.getElementById('price"+d+"').innerHTML=this.class
			d++;
			var rown = d%2==0 ? "even" : "odd";
			$("#additional-inputs").append("\n<tr class="+rown+" id=sel"+d+"><td>"+d+".</td><td><select onchange='test("+d+",this.value);' name=StaffCosts[item][]><?php echo $csz?></select></td><td id=price"+d+"></td><td><input id=qty"+d+" onBlur='test2("+d+")' size=4 type=number value=1 name=StaffCosts[quantity][]></td><td id=total"+d+"></td></tr>");
			document.getElementById('dkeeper').innerHTML=d;
    	});
		$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById('dkeeper').innerHTML=d;});
});

</script>

<div id=idbudget style='display:none;'><?php  echo $jbudget; ?></div>
<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a><table class=items><tr><th>No.</th><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr><tbody id="additional-inputs">
	
	<?php
	$d=0;	
	//echo "SELECT * from staff_costs where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget['id']." and dept='".user()->dept['id']."'";
	$dat=Yii::app()->db->createCommand("SELECT * from staff_costs where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget['id']." and dept='".user()->dept['id']."'")->queryAll();
	foreach($dat as $dt) {
		$cz1 = "<option value=$dt[item]>$dt[item]</option>";
		
		$cl=$d%2==0 ? "even" : "odd";
		$d++;
		?>

	<tr class=<?php echo $cl?> id=sel<?php echo $d;?>><td><?php echo $d;?></td><td><select onblur='test(<?php echo $d; ?>,this.value);' name=StaffCosts[item][]><?php echo $cz1?></select></td><td id=price<?php echo $d;?>></td><td><input id=qty<?php echo $d;?> onBlur='test2(<?php echo $d;?>)' size=4 type=number value=<?php echo $dt[quantity]?> name=StaffCosts[quantity][]></td><td id=total<?php echo $d;?>></td></tr>
	
	<?php } ?>
</tbody><tr><td></td><td></td><td></td><td>Grand Total</td><td id=alltotal style='font-weight:bold'>0</td></table>
	<div id=id3 style='display:none;'><?php  echo $jarray; ?><div id=dkeeper><?php echo $d?></div></div>
     <?php
	  
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function actionItem1()
	{
		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget->id)->queryAll();
		//echo "SELECT * from items_prices_view where  accountcode=".$_REQUEST['StaffCosts']['accountcode']." and budget=".Yii::app()->user->budget->id;
		for($i=0; $i<count($data);$i++) {
			$tot=Yii::app()->db->createCommand("SELECT * from staff_costs where accountcode='".$data[$i][accountcode]."' and item='".$data[$i][itemid]."' and budget='".Yii::app()->user->budget->id."' and dept='".Yii::app()->user->dept->id."'")->queryAll();
			//echo "SELECT * from staff_costs where accountcode='".$data[$i][accountcode]."' and item='".$data[$i][itemid]."' and budget='".Yii::app()->user->budget->id."' and dept='".Yii::app()->user->dept->id."'";
			$tbudget=0;
			//echo count($tot);
			for($myi=0;$myi<count($tot);$myi++) {
				$factor = $tot[$myi][units]== "Monthly" ? 12 : 1;
				$tbudget += $tot[$myi][quantity]*$factor*$data[$i][price];
				//echo "eeeee".$tot[$myi][quantity]; echo $factor;
			}
				
			$csz .="<option class=ew value=".$data[$i][itemid].">".$data[$i][name]."s</option>";
			$jarray .="<div id='itemprice".$data[$i][itemid]."'>".$data[$i][price]."</div>";
			$jbudget .="<div id='tbudget".$data[$i][itemid]."'>".$tbudget."</div>";
		}
		?>
        <script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script>
        <script type="text/javascript">
		function test(dd,v) { 
			
			document.getElementById("price"+dd).innerHTML=document.getElementById("itemprice"+v).innerHTML; 
			//document.getElementById("itotal"+dd).innerHTML=document.getElementById("tbudget"+v).innerHTML; 
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1; 
			document.getElementById("total"+dd).innerHTML=document.getElementById("qty"+dd).value * document.getElementById("price"+dd).innerHTML; 

			/*if(parseFloat(document.getElementById("total"+dd).innerHTML) > parseFloat(document.getElementById("itotal"+dd).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty"+dd).value=0;
			}*/

			var maxd=document.getElementById('dkeeper').innerHTML;
			var allt=0;
			for(i=1; i<=maxd;i++) {
				allt += parseFloat(document.getElementById("total"+i).innerHTML);
			}
			document.getElementById('alltotal').innerHTML=allt;		
		}
		function test2(dd) { 
			
			//document.getElementById("price"+dd).innerHTML=document.getElementById("itemprice"+v).innerHTML; 
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1; 
			document.getElementById("total"+dd).innerHTML=document.getElementById("qty"+dd).value * document.getElementById("price"+dd).innerHTML;
			
			/*if(parseFloat(document.getElementById("total"+dd).innerHTML) > parseFloat(document.getElementById("itotal"+dd).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty"+dd).value=0;
			}*/
			
			var maxd=document.getElementById('dkeeper').innerHTML;
			var allt=0;
			for(i=1; i<=maxd;i++) {
				allt += parseFloat(document.getElementById("total"+i).innerHTML);
			}
			document.getElementById('alltotal').innerHTML=allt;
		}
		
jQuery(function($) {
	var d=0;
	$("#additional-link").bind("click",function(){ //document.getElementById('price"+d+"').innerHTML=this.class
	d++;
    $("#additional-inputs").append("<tr id=sel"+d+"><td>"+d+".</td><td><select onchange='test("+d+",this.value);' name=StaffCosts[item][]><?php echo $csz?></select></td><td id=price"+d+"></td><td><input id=qty"+d+" onBlur='test2("+d+")' size=4 type=text value=1 name=StaffCosts[quantity][]></td><td id=total"+d+"></td></tr>");
	document.getElementById('dkeeper').innerHTML=d;
    });
	$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById('dkeeper').innerHTML=d;});
});

</script>
<div id=id3 style='display:none;'><?php  echo $jarray; ?><div id=dkeeper></div></div>
<div id=idbudget style='display:none;'><?php  echo number_format($jbudget); ?></div>
<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a><table class=items><tr class=even><th>No.</th><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr><tbody id="additional-inputs"></tbody><tr><td></td><td></td><td></td><td>Grand Total</td><td id=alltotal style='font-weight:bold'>0</td></table>
     <?php
	}		
	public function actionItems()
	{
		$csz="";
		$data=CHtml::ListData(Items::model()->findAll('accountcode='.$_REQUEST['StaffCosts']['accountcode']),'id','name');
		foreach ($data as $k=>$v)	$csz .="<option value=".$k.">".$v."</option>";
		?>
        <script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script>
        <script type="text/javascript">

jQuery(function($) {
$("#additional-link").bind("click",function(){
    $("#additional-inputs").append("<tr><td><select name=StaffCosts[item][]><?php echo $csz?></select></td><td><select name=StaffCosts[period][]><option value=Monthly>Monthly</option><option value=Annually>Annually</option></select></td><td><input size=4 type=text name=StaffCosts[quantity][]></td><td><?php echo number_format($cost)?></td><?php echo number_format($tcost)?></td></tr>");
    })
});

</script>
<a id="additional-link" href="#">Add Item</a><form action="?r=Staffcosts/create" method="post"><input type="hidden" value="<?php echo $_REQUEST['StaffCosts']['accountcode'];?>" name="StaffCosts[accountcode]" /><table><tr><th>Item</th><th>Period</th><th>Quantity</th><th>Unit Cost</th><th>Total</th></tr><tbody id="additional-inputs"></tbody></table>
<input type="submit" value="Create" />
</form>
     
  <?php
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Staffcosts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	//	echo "<pre>";print_r($_POST);
		if(isset($_POST['StaffCosts']['item']))
		{
			if(empty($_POST['StaffCosts']['dateneeded'])) $_POST['StaffCosts']['dateneeded']=date("Y-m-d");
			//$model->attributes=$_POST['StaffCosts'];
			//if($model->save())
				$v=$b=array();
				for($c=0;$c<count($_POST['StaffCosts']['item']);$c++) {
					$v[] = array(
						"accountcode"	=>	$_POST['StaffCosts']['accountcode'],
						"item"			=>	$_POST['StaffCosts']['item'][$c],
						//"unit"			=>	Yii::app()->user->dept['id'],
						"dept"			=>	Yii::app()->user->dept['id'],						
						"budget"			=>	Yii::app()->user->budget['id'],
						"createdby"		=>	Yii::app()->user->id,
						"dateneeded"	=> $_POST['StaffCosts']['dateneeded'],
						"quantity"		=>	$_POST['StaffCosts']['quantity'][$c],
						//"period"		=>	$_POST['StaffCosts']['period'][$c],
					);
//					print_r($v);exit;
					GeneralRepository::insertSeveral('staff_costs', $v);
					$scyy=Yii::app()->db->createCommand("SELECT last_insert_id() a from staff_costs")->queryAll();
					$amt=Yii::app()->db->createCommand("SELECT price a,name b from items_prices_view where itemid='".$_POST['StaffCosts']['item'][$c]."'")->queryAll();
					//print_r($scyy[0][a]);
					//exit;
					$b[] = array(
						"budget" 		=>	Yii::app()->user->budget['id'],
						"item"			=>	$_POST['StaffCosts']['item'][$c],
						"accountcode"	=>	$_POST['StaffCosts']['accountcode'],
						"dept"			=>	Yii::app()->user->details['dept'],
						"qty"				=>	$_POST['StaffCosts']['quantity'][$c],
						"amount"			=>	$amt[0][a],
						"createdby"		=>	Yii::app()->user->id,
						"dateneeded"	=> $_POST['StaffCosts']['dateneeded'],
						"tbl"				=>	"staff_costs",
						//"column"		=>  "leave_start",
						"tblid"			=>	$scyy[0][a],
						"descr"			=>	$amt[0][b],
						"units"			=>	10
					);
					
				}
				//echo "<pre>";print_r($v);exit;				
				
				GeneralRepository::insertSeveral('budget', $b);
				$redir='admin&ac='.$_REQUEST['ac'];
				$this->redirect(array($redir));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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
