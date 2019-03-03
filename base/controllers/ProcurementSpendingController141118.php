<?php

class ProcurementSpendingController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','item','view','reallocation','itemto','itemfrom','reallocationapproval'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array('model'=>$this->loadModel($id)));
	}
	public function actionReallocation() {	
		$model=new ProcurementSpending;
		/*$this->render('reallocation',array(
			'model'=>$model,
		));*/
		//$this->renderPartial('reallocation', array('model'=>$model));
		$this->render('reallocation',array('model'=>new ProcurementSpending));
	}
	public function actionReallocationapproval() {	
		$model=new ProcurementSpending;
		/*$this->render('reallocation',array(
			'model'=>$model,
		));*/
		//$this->renderPartial('reallocation', array('model'=>$model));
		$this->render('reallocation_approval',array('model'=>new ProcurementSpending));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ProcurementSpending;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProcurementSpending']))
		{
			$model->attributes=$_POST['ProcurementSpending'];
			//echo "<pre>";print_r($_POST);exit;
			//if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionItem()
	{
		
		//echo "<pre>";
		//print_r($)
		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where accountcode=".$_REQUEST['ProcurementSpending']['accountcode']." and budget=".Yii::app()->user->budget->id)->queryAll();
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
			document.getElementById("itotal"+dd).innerHTML=document.getElementById("tbudget"+v).innerHTML; 
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1; 
			document.getElementById("total"+dd).innerHTML=document.getElementById("qty"+dd).value * document.getElementById("price"+dd).innerHTML; 

			if(parseFloat(document.getElementById("total"+dd).innerHTML) > parseFloat(document.getElementById("itotal"+dd).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty"+dd).value=0;
			}

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
			
			if(parseFloat(document.getElementById("total"+dd).innerHTML) > parseFloat(document.getElementById("itotal"+dd).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty"+dd).value=0;
			}
			
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
    $("#additional-inputs").append("<tr id=sel"+d+"><td>"+d+".</td><td><select onchange='test("+d+",this.value);' name=ProcurementItems[item][]><?php echo $csz?></select></td><td id=price"+d+"></td><td><input id=qty"+d+" onBlur='test2("+d+")' size=4 type=text value=1 name=ProcurementItems[quantity][]></td><td id=total"+d+"></td><td id=itotal"+d+"></td></tr>");
	document.getElementById('dkeeper').innerHTML=d;
    });
	$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById('dkeeper').innerHTML=d;});
});

</script>
<div id=id3 style='display:none;'><?php  echo $jarray; ?><div id=dkeeper></div></div>
<div id=idbudget style='display:none;'><?php  echo $jbudget; ?></div>
<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a><table><tr><th>No.</th><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th><th>Total Budget</th></tr><tbody id="additional-inputs"></tbody><tr><td></td><td></td><td></td><td>Grand Total</td><td id=alltotal style='font-weight:bold'>0</td><td></td></table>
     
        <?php

	}

	public function actionItemfrom()
	{
		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where accountcode=".$_REQUEST['ProcurementSpending']['accountcode']." and budget=".Yii::app()->user->budget->id)->queryAll();
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
			document.getElementById("itotal"+dd).innerHTML=document.getElementById("tbudget"+v).innerHTML; 
			if(isNaN(document.getElementById("qty"+dd).value)) document.getElementById("qty"+dd).value=1; 
			document.getElementById("total"+dd).innerHTML=document.getElementById("qty"+dd).value * document.getElementById("price"+dd).innerHTML; 

			if(parseFloat(document.getElementById("total"+dd).innerHTML) > parseFloat(document.getElementById("itotal"+dd).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty"+dd).value=0;
			}

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
			
			if(parseFloat(document.getElementById("total"+dd).innerHTML) > parseFloat(document.getElementById("itotal"+dd).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty"+dd).value=0;
			}
			
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
    $("#additional-inputs").append("<tr id=sel"+d+"><td>"+d+".</td><td><select onchange='test("+d+",this.value);' name=ProcurementItems[item][]><?php echo $csz?></select></td><td style='background-color:#eeeeee' id=price"+d+">90</td><td style='background-color:#eeeeee' id=toteweal"+d+">9902</td><td style='background-color:#eeeeee' id=toteeweal"+d+">99ww02</td><td><input id=qty"+d+" onBlur='test2("+d+")' size=4 type=text value=1 name=ProcurementItems[quantity][]></td><td style='background-color:#deeeee' id=witotal"+d+">0</td><td style='background-color:#deeeee' id=wital"+d+">0</td><td style='background-color:#deeeee' id=otal"+d+">0</td></tr>");
	document.getElementById('dkeeper').innerHTML=d;
    });
	$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById('dkeeper').innerHTML=d;});
});

</script>
<div id=id3 style='display:none;'><?php  echo $jarray; ?><div id=dkeeper></div></div>
<div id=idbudget style='display:none;'><?php  echo $jbudget; ?></div>
<a id="additional-link" href="#">Add Item (De-Allocate)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a><table><tr>
	<th>No.</th>
	<th>Item</th>
	<th>Price</th>
	<th>Current Budget</th>
	<th>Current Quantity</th>
	<th>Quantity Subtract</th>
	<th>New Quantity</th>
	<th>New Budget</th>
	<th>Budget Difference</th>
</tr><tbody id="additional-inputs"></tbody><tr><td colspan=4></td><td></td><td></td><td  colspan=4>Total De-Allocated</td><td id=alltotal style='font-weight:bold'>0</td><td></td></table>
     
        <?php

	}
	public function actionItemto()
	{
		$csz=""; $jarray="";$jbudget="";
		$data=Yii::app()->db->createCommand("SELECT * from items_prices_view where accountcode=".$_REQUEST['ProcurementSpending']['accountcode']." and budget=".Yii::app()->user->budget->id)->queryAll();
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
			$jarray .="<div id='itemprice2".$data[$i][itemid]."'>".$data[$i][price]."</div>";
			$jbudget .="<div id='tbudget2".$data[$i][itemid]."'>".$tbudget."</div>";
		}
		?>
        <script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script>
        <script type="text/javascript">
		function test2(dd2,v2) { 
			
			document.getElementById("price2"+dd2).innerHTML=document.getElementById("itemprice2"+v2).innerHTML; 
			document.getElementById("itotal2"+dd2).innerHTML=document.getElementById("tbudget2"+v2).innerHTML; 
			if(isNaN(document.getElementById("qty2"+dd2).value)) document.getElementById("qty2"+dd2).value=1; 
			document.getElementById("total2"+dd2).innerHTML=document.getElementById("qty2"+dd2).value * document.getElementById("price2"+dd2).innerHTML; 

			if(parseFloat(document.getElementById("total2"+dd2).innerHTML) > parseFloat(document.getElementById("itotal2"+dd2).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty2"+dd2).value=0;
			}

			var maxd2=document.getElementById('dkeeper2').innerHTML;
			var allt2=0;
			for(i2=1; i2<=maxd2;i++) {
				allt2 += parseFloat(document.getElementById("total2"+i2).innerHTML);
			}
			document.getElementById('alltotal2').innerHTML=allt2;		
		}
		function test22(dd2) { 
			
			//document.getElementById("price2"+dd2).innerHTML=document.getElementById("itemprice2"+v2).innerHTML; 
			if(isNaN(document.getElementById("qty2"+dd2).value)) document.getElementById("qty2"+dd2).value=1; 
			document.getElementById("total2"+dd2).innerHTML=document.getElementById("qty2"+dd2).value * document.getElementById("price2"+dd2).innerHTML;
			
			if(parseFloat(document.getElementById("total2"+dd2).innerHTML) > parseFloat(document.getElementById("itotal2"+dd2).innerHTML)){
					alert('You can not spend more than the maximum');
					document.getElementById("qty2"+dd2).value=0;
			}
			
			var maxd2=document.getElementById('dkeeper2').innerHTML;
			var allt2=0;
			for(i2=1; i2<=maxd2;i2++) {
				allt2 += parseFloat(document.getElementById("total2"+i2).innerHTML);
			}
			document.getElementById('alltotal2').innerHTML=allt2;
		}
		
jQuery(function($) {
	var d2=0;
	$("#additional-link2").bind("click",function(){ //document.getElementById('price2"+d2+"').innerHTML=this.class
	d2++;
    $("#additional-inputs2").append("<tr id=sel2"+d2+"><td>"+d2+".</td><td><select onchange='test2("+d2+",this.value);' name=ProcurementItems2[item][]><?php echo $csz?></select></td><td id=price2"+d2+"></td><td><input id=qty2"+d2+" onBlur='test22("+d2+")' size=4 type=text value=1 name=ProcurementItems2[quantity][]></td><td id=total2"+d2+"></td><td id=itotal2"+d2+"112></td><td>2</td><td>0</td><td>ddfif</td></tr>");
	document.getElementById('dkeeper2').innerHTML=d2;
    });
	$("#additional-linkr2").bind("click",function(){ $("#sel2" + d2).remove();	d2--;document.getElementById('dkeeper2').innerHTML=d2;});
});

</script>
<div id=id3 style='display:none;'><?php  echo $jarray; ?><div id=dkeeper2></div></div>
<div id=idbudget2 style='display:none;'><?php  echo $jbudget; ?></div>
<a id="additional-link2" href="#">Add Item (Allocate)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr2" href="#" style="color:red">Remove Last Item</a><table><tr>
	<th>No.</th>
	<th>Item</th>
	<th>Price</th>
	<th>Current Budget</th>
	<th>Current Quantity</th>
	<th>Quantity Add</th>
	<th>New Quantity</th>
	<th>New Budget</th>
	<th>Budget Difference</th>
</tr><tbody id="additional-inputs2"></tbody><tr><td colspan=4></td><td></td><td></td><td  colspan=4>Total De-Allocated</td><td id=arew style='font-weight:bold'>0</td><td></td></table>
     
        <?php

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

		if(isset($_POST['ProcurementSpending']))
		{
			$model->attributes=$_POST['ProcurementSpending'];
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
		$dataProvider=new CActiveDataProvider('ProcurementSpending');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ProcurementSpending('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProcurementSpending']))
			$model->attributes=$_GET['ProcurementSpending'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProcurementSpending the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProcurementSpending::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProcurementSpending $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='procurement-spending-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
