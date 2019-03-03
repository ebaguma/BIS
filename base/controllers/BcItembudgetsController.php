<?php

class BcItembudgetsController extends Controller
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
		$a=$b=['admin'];
		if(is_sat() or is_pbfo()) $a[]=user()->details['username'];
		if(is_proc_officer() or is_manager_finance() or is_sys_admin() or is_sat() or is_pbfo()) $b[]=user()->details['username'];
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('accountcodes'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin'),
				'users'=>$b,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','view'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionCreate()
	{
		$model=new BcItembudgets;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['BcItembudgets']))
		{
			$model->attributes=$_POST['BcItembudgets'];
			if($model->save()) {
				$msg="The item has been added to the budget. Please use the reallocation form to put money on it.";
			//	$this->render('create',array('message'=>$msg,'model'=>$model));
//				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array('message'=>$msg,'model'=>$model));
	}
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BcItembudgets']))
		{
			$model->attributes=$_POST['BcItembudgets'];
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
		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BcItembudgets');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAccountcodes()
	{
		$sql="select * from v_bc_itembudgets where budget='".budget()."' ";
		if($_REQUEST['costcentre']) {
			if($_REQUEST['section']) $sql.= " and section=".$_REQUEST['section'];
		  $sql.= " and accountcode  like '".$_REQUEST['costcentre']."%'";
		}

		if($_REQUEST['accountcode']) {
			$sql="select * from v_bc_itembudgets where budget='".budget()."' ";
			if($_REQUEST['section'])
				$sql.= " and section=".$_REQUEST['section'];
			if($_REQUEST['item'])
				$sql.= " and item=".$_REQUEST['item'];
			else
				  $sql.= " and accountid ='".$_REQUEST['accountcode']."'";
			$sql.=" order by dateadded asc";

		}
		//echo $sql;
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();

		if($_REQUEST['print']==1) {
			$html2pdf = Yii::app()->ePdf->mPDF();
			$html2pdf->WriteHTML($this->renderPartial('accountcodes', array('model' => $rawData), true));
			// $html2pdf->Output('my_doc.pdf', 'D');
			$html2pdf->Output();
		} else
			$this->render('accountcodes', array('model' => $rawData));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$sql="select * from v_budgets_requests where budget='".budget()."' and status='COMMITED' ";
		if($_REQUEST['section'])
			$sql.= " and section=".$_REQUEST['section'];
		if($_REQUEST['bcmethod'])
			$sql.= " and reason='".$_REQUEST['bcmethod']."'";
		else
			$sql.= " and reason in (3,6) ";
		if($_REQUEST['periodfrom'])
			$sql.= " and dateadded >'".$_REQUEST['periodfrom']."'";
		if($_REQUEST['periodto'])
			$sql.= " and dateadded <'".$_REQUEST['periodto']."'";
	//	echo $sql;
		$rawData = Yii::app()->db->createCommand($sql);
		$count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar();
		$model = new CSqlDataProvider($rawData, array( //or $model=new CArrayDataProvider($rawData, array(... //using with querAll...
		                    'keyField' => 'id',
		                    'totalItemCount' => $count,

		                    'sort' => array(
		                        'attributes' => array(
		                            'id','updated_at'
		                        ),
		                        'defaultOrder' => array(
		                            'id' => CSort::SORT_DESC, //default sort value
							'updated_at' => CSort::SORT_DESC, //default sort value
		                        ),
		                    ),
		                    'pagination' => array(
		                        'pageSize' => 200,
		                    ),
		                ));

		       $this->render('admin', array('model' => $model));
	}
	public function loadModel($id)
	{
		$model=BcItembudgets::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BcItembudgets $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bc-itembudgets-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
