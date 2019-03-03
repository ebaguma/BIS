<?php

class TransportBudgetController extends Controller
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
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
		$model=new TransportBudget;
		if(isset($_POST))
		{
		//	echo "<pre>";print_r($_POST); exit;
			foreach($_POST as $s=>$vl) {
				list($desc,$vid,)=explode("_",$s,2);
				$b=TransportBudget::model()->findByAttributes(array('budget'=>user()->budget['id'],'vehicle'=>$vid));
				$b->attributes=array('budget'=>user()->budget['id'],'mileage'=>$vl[mileage],'vehicle'=>$vid,'tyres'=>$vl[tyres],'battery'=>$vl[battery]);
				$b->save();
				$ve=app()->db->createCommand("SELECT * from v_transport where id='".$vid."' and budget='".budget()."'")->queryAll();
				$c=$ve[0];
				//echo $c[mileage];
				//FMS
				$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'tblcolumn'=>'fms','tblid'=>$vid,'tbl'=>'transport'));
				$fms=Items::model()->findByAttributes(array('name'=>'Fleet Management System','accountcode'=>'132'));

				if($fms==null) {
					$this->renderText('Price for Fleet Management System not found. Please go to the Item Registration page and enter it.');
					exit;
				}

				if($bt==null) $bt=new Budget;
				if($c[fms]==1) {
					$bt->attributes=array('budget'=>budget(),'tblcolumn'=>'fms','tblid'=>$vid,'tbl'=>'transport','qty'=>1,'dept'=>user()->dept[id],'item'=>$fms->id,'createdby'=>user()->id,'dateneeded'=>date('Y-m-d'),'createdon'=>date('Y-m-d'));
					$bt->save();
					//dump($bt->attributes,false);
				}  else
					if(!$bt->isNewRecord) $bt->delete();

				//OTV
				$bt=Budget::model()->findByAttributes(array('budget'=>user()->budget['id'],'tblcolumn'=>'otv','tblid'=>$vid,'tbl'=>'transport'));
				$otv=Items::model()->findByAttributes(array('name'=>'OTV','accountcode'=>'127'));
				if($bt==null) $bt=new Budget;
				if($c[type]=='Lorry' || $c[type]=='Pickup') {
					$bt->attributes=array('budget'=>user()->budget['id'],'tblcolumn'=>'otv','tblid'=>$vid,'tbl'=>'transport','qty'=>1,'dept'=>user()->dept[id],'item'=>$otv->id,'createdby'=>user()->id,'dateneeded'=>date('Y-m-d'),'createdon'=>date('Y-m-d'));
					$bt->save();
				} else
					if(!$bt->isNewRecord) $bt->delete();

				//Fuel
				if($c[fuelconsumption] >0) {
					/*
					$st="budget=".budget().",tblcolumn='fueeel',tblid='".$vid."',tbl='transport',qty=".round($vl[mileage]/$c[fuelconsumption]).",descr='".$c['regno']."',dept=".user()->dept[id].",item=".$c[fuel].",createdby=".user()->id.",dateneeded='".date('Y-m-d')."',createdon='".date('Y-m-d')."'";

					$bb=app()->db->createCommand("SELECT * from budget where budget='".budget()."' and tblcolumn='fueeel' and tblid='".$vid."' and tbl='transport'")->queryAll();
					$qry=count($bb) > 0 ? "UPDATE": "INSERT INTO ";
					$qry2=count($bb) > 0 ? " where budget='".budget()."' and tblcolumn='fueeel' and tblid='".$vid."' and tbl='transport'": "";
					$sql=$qry." budget set ".$st.$qry2;
					if (count($bb)>0) dump($bb,false);
					echo $sql."; ".count($bb)."<br>";
					$qq=app()->db->createCommand($sql)->execute();
					echo $qq;
					*/

					$bt1=Budget::model()->findByAttributes(array('budget'=>budget(),'tblcolumn'=>'mafuta','tblid'=>$vid,'tbl'=>'transport'));
					if($bt1==null) $bt1=new Budget;
					$bt1->attributes=array('tblcolumn'=>'mafuta','tblid'=>$vid,'tbl'=>'transport','qty'=>round($vl[mileage]/$c[fuelconsumption]),'descr'=>$c['regno'],'dept'=>user()->dept[id],'item'=>$c[fuel],'createdby'=>user()->id,'dateneeded'=>date('Y-m-d'),'createdon'=>date('Y-m-d'),'period'=>1);
					$bt1->save() ;
				}
				//Servicing
				if($c[serviceinterval] >0) {
					$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'tblcolumn'=>'service','tblid'=>$vid,'tbl'=>'transport'));
					if($bt==null) $bt=new Budget;
					$bt->attributes=array('budget'=>user()->budget['id'],'tblcolumn'=>'service','tblid'=>$vid,'tbl'=>'transport','qty'=>round($vl[mileage]/$c[serviceinterval]),'dept'=>user()->dept[id],'item'=>$c[serviceitem],'createdby'=>user()->id,'dateneeded'=>date('Y-m-d'),'createdon'=>date('Y-m-d'));
					$bt->save();
				}

				//Repairs
				$repairitem=Items::model()->findByAttributes(array('name'=>'VehicleRepairPercentage','accountcode'=>'119'));
				$repairprice=ItemsPrices::model()->findByAttributes(array('item'=>$repairitem->id,'budget'=>budget()))->price;

				if($c[fuelconsumption] >0 && $repairprice > 0) {
					$bt=Budget::model()->findByAttributes(array('budget'=>user()->budget['id'],'tblcolumn'=>'repairs','tblid'=>$vid,'tbl'=>'transport'));
					if($bt==null) $bt=new Budget;

					//die($repairprice->price);

					$r=$vl[mileage]*$repairprice*$c[fuelprice]/$c[fuelconsumption];
					$ri=Items::model()->findByAttributes(array('name'=>'Repairs for '.$c['regno'],'accountcode'=>119));
					if($ri==null) {
						$ri=new Items;
						$ri->attributes=array('name'=>'Repairs for '.$c['regno'],'accountcode'=>119);
						$ri->save();
					}
					$rip=ItemsPrices::model()->findByAttributes(array('budget'=>user()->budget['id'],'item'=>$ri->id,));
					if($rip==null) $rip=new ItemsPrices;
					$rip->attributes=array('item'=>$ri->id,'currency'=>1,'price'=>$r,'insertby'=>user()->id);
					$rip->save();
					$bt->attributes=array('budget'=>user()->budget['id'],'tblcolumn'=>'repairs','tblid'=>$vid,'tbl'=>'transport','qty'=>1,'dept'=>user()->dept[id],'item'=>$ri->id,'createdby'=>user()->id,'dateneeded'=>date('Y-m-d'),'createdon'=>date('Y-m-d'));
					$bt->save();
				}
				//Tyres
				$bt=Budget::model()->findByAttributes(array('budget'=>user()->budget['id'],'tblcolumn'=>'tyres','tblid'=>$vid,'tbl'=>'transport'));
				if($bt==null) $bt=new Budget;
				if($vl[tyres] > 0) {
					$bt->attributes=array('budget'=>user()->budget['id'],'tblcolumn'=>'tyres','tblid'=>$vid,'tbl'=>'transport','qty'=>round($vl[tyres]),'dept'=>user()->dept[id],'item'=>$c[tyres],'createdby'=>user()->id,'dateneeded'=>date('Y-m-d'),'createdon'=>date('Y-m-d'));
				$bt->save();
				} else
					if(!$bt->isNewRecord) $bt->delete();
				//Battery
				$bt=Budget::model()->findByAttributes(array('budget'=>user()->budget['id'],'tblcolumn'=>'battery','tblid'=>$vid,'tbl'=>'transport'));
				if($bt==null) $bt=new Budget;
				if($vl[battery] > 0) {
					$bt->attributes=array('budget'=>user()->budget['id'],'tblcolumn'=>'battery','tblid'=>$vid,'tbl'=>'transport','qty'=>round($vl[battery]),'dept'=>user()->dept[id],'item'=>$c[battery],'createdby'=>user()->id,'dateneeded'=>date('Y-m-d'),'createdon'=>date('Y-m-d'));
				$bt->save();
				} else
					if(!$bt->isNewRecord) $bt->delete();
			}
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

		if(isset($_POST['TransportBudget']))
		{
			$model->attributes=$_POST['TransportBudget'];
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
		$dataProvider=new CActiveDataProvider('TransportBudget');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TransportBudget('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TransportBudget']))
			$model->attributes=$_GET['TransportBudget'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TransportBudget the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TransportBudget::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TransportBudget $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transport-budget-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
