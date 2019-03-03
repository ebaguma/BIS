<?php

class GuaranteesBudgetController extends Controller
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
		$model=new GuaranteesBudget;
		if(isset($_POST['gb']))
		{
			foreach($_POST['gb'] as $k1=>$v1) {
				$g=GuaranteesBudget::model()->findByAttributes(array('budget'=>budget(),'guarantee'=>$k1));
				if($g==null) $g=new GuaranteesBudget;
				$g->attributes=array(
						'budget'			=>budget(),
						'guarantee'		=>$k1,
						'arrangement'	=>$v1[arrangement],
						'establishment'	=>$v1[establishment],
						'quarterly'			=>$v1[quarterly],
						'annualrenewal'	=>$v1[annualrenewal]
					);
				$g->save();
				
				$fs=array(
					'arrangement'=>1,
					'establishment'=>1,
					'quarterly'=>4,
					'annualrenewal'=>1
				);
				$it2=ItemsPricesView::model()->findByAttributes(array('itemid'=>$k1,'budget'=>budget()));
				if($it2) {
					foreach ($fs as $fee=>$prd) {
						$af=Items::model()->findByAttributes(array('accountcode'=>201,'name'=>$it2->name.' - '.ucfirst($fee).' Fees'));
						if($af==null) {
							$af=new Items;
							$af->attributes=array('accountcode'=>201,'name'=>$it2->name.' - '.ucfirst($fee).' Fees');
							$af->save();
						}
						$ap=ItemsPrices::model()->findByAttributes(array('item'=>$af->id,'budget'=>budget()));
						if($ap==null)
							$ap=new ItemsPrices;
						$ap->attributes=array('currency'=>$it2->currencyid,'item'=>$af->id,'budget'=>budget(),'price'=>$v1[$fee]*$it2->price/100,'insertdate'=>date('Y-m-d'),'insertby'=>user()->id);
						$ap->save();
						$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$af->id));
						if($bt==null) $bt=new Budget;
						$bt->attributes=array('budget'=>budget(),'item'=>$af->id,'dept'=>user()->dept[id],'qty'=>$prd,'tbl'=>'guarantees_budget','tblcolumn'=>$fee,'tblid'=>$g->id,'createdby'=>user()->id,'createdon'=>date("Y-m-d"),'dateneeded'=>date("Y-m-d"),'period'=>1);
						$bt->save();
						
						
						
					}
				}
			}
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

		if(isset($_POST['GuaranteesBudget']))
		{
			$model->attributes=$_POST['GuaranteesBudget'];
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
		$model=new GuaranteesBudget('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GuaranteesBudget']))
			$model->attributes=$_GET['GuaranteesBudget'];

		$this->render('admin_amounts',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new GuaranteesBudget('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GuaranteesBudget']))
			$model->attributes=$_GET['GuaranteesBudget'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return GuaranteesBudget the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=GuaranteesBudget::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param GuaranteesBudget $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='guarantees-budget-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
