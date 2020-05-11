<?php

class ProcurementSpendingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update', 'item', 'view', 'reallocation', 'itemto', 'itemfrom', 'reallocationapproval'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete', 'deletes', 'popup', 'ItemCapture'),
				'users' => array('@'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionPopup()
	{

		$this->renderPartial('viewpopup', array('data' => 'Ur-data'), false, true);
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}
	public function actionReallocation()
	{
		$model = new ProcurementSpending;
		if ($_POST) {

			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
		}
		$this->render('reallocation', array('model' => new ProcurementSpending));
	}
	public function actionReallocationapproval()
	{
		$model = new ProcurementSpending;
		/*$this->render('reallocation',array(
			'model'=>$model,
		));*/
		//$this->renderPartial('reallocation', array('model'=>$model));
		$this->render('reallocation_approval', array('model' => new ProcurementSpending));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new BcBudgetrequests;;

		//echo "<pre>";print_r($_POST);exit;
		if (isset($_POST['ProcurementSpending'])) {
			$model->attributes = array('subject' => $_POST['ProcurementSpending']['subject'], 'requireddate' => $_POST['ProcurementSpending']['date_required']);
			//echo "<pre>";print_r($_POST);exit;
			if ($model->save()) {
				$images = CUploadedFile::getInstancesByName('appendix');
				if (isset($images) && count($images) > 0) {
					foreach ($images as $image => $pic) {

						/*** Edwin:22/04/2020 
						 * Replaced /appendix/p
						 ***/

						if (!$pic->saveAs(Yii::getPathOfAlias('webroot') . '/appendix/bc' . Yii::app()->user->budget['id'] . '/' . Yii::app()->user->id . '-' . $model->id . '-' . $pic->name)) {
							die("Could not save " . $pic->name . ". Please contact the administrator<br>");
						}
					}
				}
				foreach ($_POST['ProcurementItems']['item'] as $i => $v) {

					$values[] = array(
						"request"	=> $model->id,
						"item" 		=> $v,
						"quantity"	=> $_POST['ProcurementItems']['quantity'][$i],
						"quantity"	=> $_POST['ProcurementItems']['price'][$i]
					);
				}
				if (count($values)) GeneralRepository::insertSeveral('bc_budgetrequest_items', $values);
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array('model' => $model));
	}
	public function actionItemCapture()
	{

		//echo "<pre>";print_r($_REQUEST);exit;
		if (!$_REQUEST['section']) {
			echo "<script>alert('Please select a section/dept first');</script>";
			exit;
		}
		$csz = "";
		$jarray = "";
		$jbudget = "";
		$data = Yii::app()->db->createCommand("SELECT item,itemname,sum(amount) a FROM `v_bc_itembudgets` where section=" . $_REQUEST['section'] . " and accountid=" . $_REQUEST['accountcode'] . " and budget=" . Yii::app()->user->budget['id'] . " group by item order by itemname")->queryAll();
		//echo "SELECT item,itemname,sum(amount) a FROM `v_bc_itembudgets` where section=".$_REQUEST['section']." and accountid=".$_REQUEST['accountcode']." and budget=".Yii::app()->user->budget['id']." group by item order by itemname";
		for ($i = 0; $i < count($data); $i++) {
			$csz .= "<option class=ew value=" . $data[$i][item] . ">" . strip($data[$i][itemname]) . "</option>";
			$jbudget .= "<div id='tbudget" . $data[$i][item] . "'>" . $data[$i][a] . "</div>";
		}
?>
		<script type="text/javascript" src="/assets/dc899cdc/jquery.js"></script>
		<script type="text/javascript">
			function test(dd, v) {

				document.getElementById("afunds" + dd).innerHTML = accounting.formatNumber(document.getElementById("tbudget" + v).innerHTML);
				if (isNaN(document.getElementById("qty" + dd).value)) document.getElementById("qty" + dd).value = 1;
				if (document.getElementById("qty" + dd).value < 1) document.getElementById("qty" + dd).value = 1;
				if (isNaN(document.getElementById("price" + dd).value)) document.getElementById("price" + dd).value = 1;
				if (document.getElementById("price" + dd).value < 1) document.getElementById("price" + dd).value = 1;
				document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * document.getElementById("price" + dd).value);

				if (parseFloat(accounting.unformat(document.getElementById("total" + dd).innerHTML)) > parseFloat(accounting.unformat(document.getElementById("tbudget" + v).innerHTML))) {
					alert('You can not spend more than the maximum');
					document.getElementById("qty" + dd).value = 1;
					document.getElementById("price" + dd).value = 1;
				}

				var maxd = document.getElementById('dkeeper').innerHTML;
				var allt = 0;
				for (i = 1; i <= maxd; i++) {
					allt += parseFloat(accounting.unformat(document.getElementById("total" + i).innerHTML));
				}
				document.getElementById('alltotal').innerHTML = accounting.formatMoney(allt);
				document.getElementById("rbal" + dd).innerHTML = accounting.formatNumber(accounting.unformat(document.getElementById("afunds" + dd).innerHTML) - document.getElementById("total" + dd).innerHTML);
			}

			function test2(dd) {

				if (isNaN(document.getElementById("qty" + dd).value)) document.getElementById("qty" + dd).value = 1;
				if (isNaN(document.getElementById("price" + dd).value)) document.getElementById("price" + dd).value = 1;
				if (document.getElementById("qty" + dd).value < 1) document.getElementById("qty" + dd).value = 1;
				if (document.getElementById("price" + dd).value < 1) document.getElementById("price" + dd).value = 1;
				document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * document.getElementById("price" + dd).value);

				if (parseFloat(accounting.unformat(document.getElementById("total" + dd).innerHTML)) > parseFloat(accounting.unformat(document.getElementById("afunds" + dd).innerHTML))) {
					alert('You can not spend more than the maximum');
					document.getElementById("qty" + dd).value = 1;
					document.getElementById("price" + dd).value = 1;
					document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * document.getElementById("price" + dd).value);
				}

				var maxd = document.getElementById('dkeeper').innerHTML;
				var allt = 0;
				for (i = 1; i <= maxd; i++)
					allt += parseFloat(accounting.unformat(document.getElementById("total" + i).innerHTML));
				document.getElementById('alltotal').innerHTML = accounting.formatMoney(allt);
				document.getElementById("rbal" + dd).innerHTML = accounting.formatNumber(accounting.unformat(document.getElementById("afunds" + dd).innerHTML) - accounting.unformat(document.getElementById("total" + dd).innerHTML));
			}

			jQuery(function($) {
				var d = 0;
				$("#additional-link").bind("click", function() { //document.getElementById('price"+d+"').innerHTML=this.class
					d++;
					var rown = d % 2 == 0 ? "even" : "odd";
					$("#additional-inputs").append("<tr class=" + rown + " id=sel" + d + "><td>" + d + ".</td><td><select onchange='test(" + d + ",this.value);' name=ProcurementItems[item][]><option>- select - </option><?php echo $csz ?></select></td><td><input id=qty" + d + " onChange='test2(" + d + ")' size=4 type=number value=1 name=ProcurementItems[quantity][]></td><td><input id=price" + d + " onChange='test2(" + d + ")' size=8 type=number value=1 name=ProcurementItems[price][]></td><td id=total" + d + "></td><td id=afunds" + d + "></td><td id=rbal" + d + "></td></tr>");
					document.getElementById('dkeeper').innerHTML = d;
				});
				$("#additional-linkr").bind("click", function() {
					$("#sel" + d).remove();
					d--;
					document.getElementById('dkeeper').innerHTML = d;
				});
			});
		</script>
		<div id=id3 style='display:none;'><?php echo $jarray; ?><div id=dkeeper></div>
		</div>
		<div id=idbudget style='display:none;'><?php echo $jbudget; ?></div>
		<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a>
		<table class=items>
			<tr>
				<th>No.</th>
				<th>Item</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Total</th>
				<th>Available Funds</th>
				<th>Running Balance</th>
			</tr>
			<tbody id="additional-inputs"></tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td colspan=2>Grand Total</td>
				<td colspan=2 id=alltotal style='font-weight:bold'>0</td>
		</table>

	<?php
	}
	public function actionItem()
	{

		//echo "<pre>";print_r($_REQUEST);exit;
		$csz = "";
		$jarray = "";
		$jbudget = "";
		$data = Yii::app()->db->createCommand("SELECT item,itemname,sum(amount) a FROM `v_bc_itembudgets` where section=" . user()->dept['id'] . " and accountid=" . $_REQUEST['accountcode'] . " and accountid in (select accountcode from bc_workflows_accountcodes where budget=" . Yii::app()->user->budget['id'] . ") and budget=" . Yii::app()->user->budget['id'] . " group by item order by itemname")->queryAll();
		//		echo "SELECT item,itemname,sum(amount) a FROM `v_bc_itembudgets` where section=".user()->dept['id']." and accountid=".$_REQUEST['accountcode']." and accountid in (select accountcode from bc_workflows_accountcodes where budget=".Yii::app()->user->budget['id'].") and budget=".Yii::app()->user->budget['id']." group by item order by itemname";
		//echo "SELECT item,itemname,sum(amount) a FROM `v_bc_itembudgets` where section=".user()->dept['id']." and accountid=".$_REQUEST['accountcode']." and accountid in (select accountcode from bc_workflows_accountcodes where budget=".Yii::app()->user->budget['id'].") and budget=".Yii::app()->user->budget['id']." group by item order by itemname";
		for ($i = 0; $i < count($data); $i++) {
			$csz .= "<option class=ew value=" . $data[$i][item] . ">" . strip($data[$i][itemname]) . "</option>";
			$jbudget .= "<div id='tbudget" . $data[$i][item] . "'>" . $data[$i][a] . "</div>";
		}
	?>
		<script type="text/javascript" src="/assets/dc899cdc/jquery.js"></script>
		<script type="text/javascript">
			function test(dd, v) {

				document.getElementById("afunds" + dd).innerHTML = accounting.formatNumber(document.getElementById("tbudget" + v).innerHTML);
				if (isNaN(document.getElementById("qty" + dd).value)) document.getElementById("qty" + dd).value = 1;
				if (isNaN(document.getElementById("price" + dd).value)) document.getElementById("price" + dd).value = 1;
				if (document.getElementById("qty" + dd).value < 1) document.getElementById("qty" + dd).value = 1;
				if (document.getElementById("price" + dd).value < 1) document.getElementById("price" + dd).value = 1;

				document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * document.getElementById("price" + dd).value);

				if (parseFloat(accounting.unformat(document.getElementById("total" + dd).innerHTML)) > parseFloat(accounting.unformat(document.getElementById("tbudget" + v).innerHTML))) {
					alert('You can not spend more than the maximum');
					document.getElementById("qty" + dd).value = 1;
					document.getElementById("price" + dd).value = 1;
				}

				var maxd = document.getElementById('dkeeper').innerHTML;
				var allt = 0;
				for (i = 1; i <= maxd; i++) {
					allt += parseFloat(accounting.unformat(document.getElementById("total" + i).innerHTML));
				}
				document.getElementById('alltotal').innerHTML = accounting.formatMoney(allt);
				document.getElementById("rbal" + dd).innerHTML = accounting.formatNumber(accounting.unformat(document.getElementById("afunds" + dd).innerHTML) - document.getElementById("total" + dd).innerHTML);
			}

			function test2(dd) {

				if (isNaN(document.getElementById("qty" + dd).value)) document.getElementById("qty" + dd).value = 1;
				if (isNaN(document.getElementById("price" + dd).value)) document.getElementById("price" + dd).value = 1;

				if (document.getElementById("qty" + dd).value < 1) document.getElementById("qty" + dd).value = 1;
				if (document.getElementById("price" + dd).value < 1) document.getElementById("price" + dd).value = 1;

				document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * document.getElementById("price" + dd).value);

				if (parseFloat(accounting.unformat(document.getElementById("total" + dd).innerHTML)) > parseFloat(accounting.unformat(document.getElementById("afunds" + dd).innerHTML))) {
					alert('You can not spend more than the maximum');
					document.getElementById("qty" + dd).value = 1;
					document.getElementById("price" + dd).value = 1;
					document.getElementById("total" + dd).innerHTML = accounting.formatNumber(document.getElementById("qty" + dd).value * document.getElementById("price" + dd).value);
				}

				var maxd = document.getElementById('dkeeper').innerHTML;
				var allt = 0;
				for (i = 1; i <= maxd; i++)
					allt += parseFloat(accounting.unformat(document.getElementById("total" + i).innerHTML));
				document.getElementById('alltotal').innerHTML = accounting.formatMoney(allt);
				document.getElementById("rbal" + dd).innerHTML = accounting.formatNumber(accounting.unformat(document.getElementById("afunds" + dd).innerHTML) - accounting.unformat(document.getElementById("total" + dd).innerHTML));
			}

			jQuery(function($) {
				var d = 0;
				$("#additional-link").bind("click", function() { //document.getElementById('price"+d+"').innerHTML=this.class
					d++;
					var rown = d % 2 == 0 ? "even" : "odd";
					$("#additional-inputs").append("<tr class=" + rown + " id=sel" + d + "><td>" + d + ".</td><td><select onClick='test(" + d + ",this.value);' name=ProcurementItems[item][]><?php echo $csz ?></select></td><td><input id=qty" + d + " onChange='test2(" + d + ")' size=4 type=number value=1 name=ProcurementItems[quantity][]></td><td><input id=price" + d + " onClick='test2(" + d + ")' size=8 type=number value=1 name=ProcurementItems[price][]></td><td id=total" + d + "></td><td id=afunds" + d + "></td><td id=rbal" + d + "></td></tr>");
					document.getElementById('dkeeper').innerHTML = d;
				});
				$("#additional-linkr").bind("click", function() {
					$("#sel" + d).remove();
					d--;
					document.getElementById('dkeeper').innerHTML = d;
				});
			});
		</script>
		<div id=id3 style='display:none;'><?php echo $jarray; ?><div id=dkeeper></div>
		</div>
		<div id=idbudget style='display:none;'><?php echo $jbudget; ?></div>
		<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a>
		<table class=items>
			<tr>
				<th>No.</th>
				<th>Item</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Total</th>
				<th>Available Funds</th>
				<th>Running Balance</th>
			</tr>
			<tbody id="additional-inputs"></tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td colspan=2>Grand Total</td>
				<td colspan=2 id=alltotal style='font-weight:bold'>0</td>
		</table>
<?php
	}
	public function actionItemfrom()
	{
		$tbudget = 0;
		$data = Yii::app()->db->createCommand("SELECT * from items_prices_view where accountcode=" . $_REQUEST['ProcurementSpending']['accountcode'] . " and budget=" . Yii::app()->user->budget->id)->queryAll();
		for ($i = 0; $i < count($data); $i++) {
			$tot = Yii::app()->db->createCommand("SELECT * from staff_costs where accountcode='" . $data[$i][accountcode] . "' and item='" . $data[$i][itemid] . "' and budget='" . Yii::app()->user->budget->id . "' and dept='" . Yii::app()->user->dept->id . "'")->queryAll();
			for ($myi = 0; $myi < count($tot); $myi++) {
				$factor = $tot[$myi][units] == "Monthly" ? 12 : 1;
				$tbudget += $tot[$myi][quantity] * $factor * $data[$i][price];
			}
		}
		echo "
			<table  istyle='width:600px;border:1px solid'><tr>
					<td style='width:300px;border:1px solid'>" . $tbudget . "</td>
					<td style='width:300px;border:1px solid'>" . $tbudget . "</td>
					<td style='width:174px;border:1px solid'><input size=15 name='budgetsub' /></td>
					<td style='width:300px;border:1px solid' id='newbsub'></td></tr></table>
			";
	}
	public function actionItemto()
	{
		$tbudget = 0;
		$data = Yii::app()->db->createCommand("SELECT * from items_prices_view where accountcode=" . $_REQUEST['ProcurementSpending']['accountcode'] . " and budget=" . Yii::app()->user->budget->id)->queryAll();
		for ($i = 0; $i < count($data); $i++) {
			$tot = Yii::app()->db->createCommand("SELECT * from staff_costs where accountcode='" . $data[$i][accountcode] . "' and item='" . $data[$i][itemid] . "' and budget='" . Yii::app()->user->budget->id . "' and dept='" . Yii::app()->user->dept->id . "'")->queryAll();
			for ($myi = 0; $myi < count($tot); $myi++) {
				$factor = $tot[$myi][units] == "Monthly" ? 12 : 1;
				$tbudget += $tot[$myi][quantity] * $factor * $data[$i][price];
			}
		}
		echo "
			<table  istyle='width:600px;border:1px solid'><tr>
					<td style='width:300px;border:1px solid'>" . $tbudget . "</td>
					<td style='width:300px;border:1px solid'>" . $tbudget . "</td>
					<td style='width:174px;border:1px solid'><input size=15 name='budgetadd' /></td>
					<td style='width:300px;border:1px solid' id='newbadd'></td></tr></table>
			";
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['ProcurementSpending'])) {
			$model->attributes = $_POST['ProcurementSpending'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletes($id)
	{
		$m = $this->loadModel($id);
		//	echo ($m->id);
		if ($m->approval1 == null)
			$this->renderText('null');
		else
			$this->renderText($m->approval1);
		//	print_r($this->requestor);
		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//	if(!isset($_GET['ajax']))
		//		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionDelete($id)
	{
		$m = $this->loadModel($id);
		if ($m->approval1 == null && $m->approval2 == null && $m->approval3 == null && $m->approval4 == null && $m->approval5 == null) {
			$m->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ProcurementSpending');
		$this->render('index', array('dataProvider' => $dataProvider));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new ProcurementSpending('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['ProcurementSpending']))
			$model->attributes = $_GET['ProcurementSpending'];

		$this->render('admin', array(
			'model' => $model,
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
		$model = ProcurementSpending::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProcurementSpending $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'procurement-spending-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
