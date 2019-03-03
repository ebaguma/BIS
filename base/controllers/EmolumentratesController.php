<?php

class EmolumentratesController extends Controller
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
				'actions'=>array('create','update','view','updateemp','allowances'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','index','allsave'),
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
	public function actionAllowances() {
		$scal=app()->db->createCommand("SELECT * from v_employees_scales where id='".$_POST['Emolumentrates']['employee']."' ")->queryAll();
		$scale=$scal[0][scalename];
		$spined=$scal[0][spined];

		//Out of Station
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=97 and name='".$scale."')")->queryAll();
		$ht.="<div id=v_out_of_station>".$sc[0][price]."</div>";
		//Weekend Lunch
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=74 and name='".$scale."')")->queryAll();
		$ht.="<div id=v_weekend_lunch>".$sc[0][price]."</div>";
		//Weekend Transport
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=93 and name='".$scale."')")->queryAll();
		$ht.="<div id=v_weekend_transport>".$sc[0][price]."</div>";
		//Responsibility
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=82 and name='".$spined."')")->queryAll();
		$ht.="<div id=v_responsibility_allowance>".$sc[0][price]."</div>";
		//Acting
		//echo "SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=76 and name='".$spined."')";
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=76 and name='".$spined."')")->queryAll();
		$ht.="<div id=v_acting_allowance>".$sc[0][price]."</div>";
		//Subsistence
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=77 and name='".$scale."')")->queryAll();
		$ht.="<div id=v_travel_in_ug_op>".$sc[0][price]."</div>";
		//Pay in lieu of leave
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=87 and name='".$spined."')")->queryAll();
		$ht.="<div id=v_leave_in_lieu>".$sc[0][price]."</div>";
		//Overtime
		$sc=app()->db->createCommand("SELECT * from items_prices where budget=".user()->budget['id']." and item=(select id from items where accountcode=73 and name='".$spined."')")->queryAll();
		$ht.="<div id=v_overtime_weekend_days>".$sc[0][price]."</div>";

		echo $ht;
	}
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
		$model=new Emolumentrates;

		if(isset($_POST['Emolumentrates']))
		{
			if(budget_locked()) { $this->render('/site/locked'); exit; }
			if(!$_POST['Emolumentrates']['employee']) $this->renderText("Please select an employee");
			if(!$_POST['Emolumentrates']['leave_start']) $_POST['Emolumentrates']['leave_start']=null;
			if(!$_POST['Emolumentrates']['leave_end']) $_POST['Emolumentrates']['leave_end']=null;

			$record=$model->findByAttributes(array('budget'=>budget(),'employee'=>$_POST['Emolumentrates']['employee']));
			if($record) {
				$this->renderText("This employee was already budgeted for. Please <a href='index.php?r=emolumentrates/updateemp&emp=".$_POST['Emolumentrates']['employee']."'>click here</a> to update the employee instead");
			} else {
				$model->attributes=$_POST['Emolumentrates'];
				$w=Employees::model()->findByAttributes(array('id'=>$model->employee));
				//$this->renderText($w->employee);
				if($model->save()) {
					$this->budgetSave($model);
					$this->redirect(array('view','id'=>$model->id));
				}
			}

		} else {
			$this->render('create',array('model'=>$model));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateemp($emp)
	{
		$r=Emolumentrates::model()->findByAttributes(array('employee'=>$emp,'budget'=>Yii::app()->user->budget['id']));
//		dump($r);
		$model=$this->loadModel($r['id']);

		if(isset($_POST['Emolumentrates']))
		{
			if(budget_locked()) { $this->render('/site/locked'); exit; }
			if(!$_POST['Emolumentrates']['leave_start']) $_POST['Emolumentrates']['leave_start']=null;
			if(!$_POST['Emolumentrates']['leave_end']) $_POST['Emolumentrates']['leave_end']=null;

				$model->attributes=$_POST['Emolumentrates'];
//				die(dump($model));
				if($model->save()) {
					$this->budgetSave($model);
					$this->redirect(array('view','id'=>$model->id));
				} else {
					dump($model);
					dump($model->getErrors());
				}
				//}

		} else {
			$this->render('update',array('model'=>$model));
		}

	}
	private function budgetSave($model) {

		$fields = array(
						//'travel_in_ug_cap'		=>
						'removal_allowance'				=>86,
						'travel_in_ug_op'				=>77,
						'weekend_lunch'					=>74,
						'weekend_transport'				=>93,
						'out_of_station'					=>97,
						'acting_allowance'				=>76,
						'responsibility_allowance'		=>82,
						'overtime_weekdayhrs'			=>73,
						//'overtime_weekend_hrs'		=>73,
						'leave_in_lieu'					=>87,

					);
					foreach ($fields as $allowance=>$allowancecode) {
				//		die(dump());
						$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$allowance,'tblid'=>$model->employee,'budget'=>user()->budget['id']));
						if($md==null) $md= New Budget;
						if(intval($_POST['Emolumentrates'][$allowance])>0) {
							$itemm=app()->db->createCommand("select id from items where name=(select scalename from v_employees where id=$model->employee limit 1) and accountcode='".$allowancecode."'")->queryAll();
							if(!$itemm)
								$itemm=app()->db->createCommand("select id from items where name=(select spined from v_employees_scales where id=$model->employee limit 1) and accountcode='".$allowancecode."'")->queryAll();
							//if(!$itemm) die("no price!"); else {echo $allowancecode;print_r($itemm); echo"<br>---\n"; }
							if($allowance=='overtime_weekdayhrs' || $allowance=='overtime_weekend_hrs')
								$qt=round(1.5*$_POST['Emolumentrates'][$allowance]*$_POST['Emolumentrates']['overtime_weekdaydays']+2*$_POST['Emolumentrates']['overtime_weekend_days']*$_POST['Emolumentrates']['overtime_weekend_hrs']);
							else
								$qt=intval($_POST['Emolumentrates'][$allowance]);
	//							echo $qt;
							if($itemm) {

							} else if($allowance=='removal_allowance') {
								$empname=Employees::model()->findByPk($model->employee);
								//echo "passin  this..";
								if($empname) {
									$qt=1;
									$i_atts=array('accountcode'=>$allowancecode,'name'=>'Removal Allowance for '.$empname->employee);
									$item_ra=Items::model()->findByAttributes($i_atts);
									if(!$item_ra) {
										$item_ra=new Items;
										$item_ra->attributes=$i_atts;
										if(!$item_ra->save()) die(print_r($item_ra->getErrors()));
									}
									$item_ra=Items::model()->findByAttributes($i_atts);
									//$ip_atts=
									//echo "ho".print_r($item_ra->id);
									$ip_ra=ItemsPrices::model()->findByAttributes(array('item'=>$item_ra->id,'budget'=>budget()));
									if(!$ip_ra) {
										$ip_ra=new ItemsPrices;
										$ip_ra->attributes=array(
											'item'		=>	$item_ra->id,
										//	'budget'	=>	budget(),
											//'price'		=>$_POST['removal_allowance'],
											'currency'	=>	1,
											'price'		=>	$_POST['Emolumentrates'][$allowance],
											//'insertdate'	=>date("Y-m-d H:m:s"),
											//'insertby'		=>user()->id
										);

									} else {
										$ip_ra->attributes=array('price'	=>	$_POST['Emolumentrates'][$allowance],'updateby'=>user()->id);
									}
									if(!$ip_ra->save()) die(print_r($ip_ra->attributes).print_r($ip_ra->getErrors()));

								}
							}
							$item_budget= $itemm ? $itemm[0][id] : $item_ra->id;
							if($item_budget) {
								$md->attributes=array(
									"budget" 			=>	Yii::app()->user->budget['id'],
									"item"				=>	$item_budget,
									"dept"				=>	Yii::app()->user->details['dept'],
									"qty"					=>	$qt,
									"tbl"					=>	"employees",
									"tblcolumn"		=>	$allowance,
									"tblid"				=>	$model->employee,
									"descr"				=>	$model->employee,
									"createdon"		=>	date("Y-m-d"),
									"createdby"		=>	user()->id,
									"dateneeded"	=> date("Y-m-d")
								);
								if(!$md->save()) die($md->getErrors());
								//echo "saved.";
								//print_r($md->attributes);
							} //else die ("Not saving budget. Price not found");
						} else
							if(!$md->isNewRecord) $md->delete();
					}
	}
	public function actionAllsave() {
		$sql=app()->db->createCommand("select * from emolumentrates where budget=8 order by employee asc")->queryAll();
		foreach($sql as $i) {
			$model=$this->loadModel($i['id']);
			$this->budgetSaveManual($model);
		//	echo "<pre>";print_r($model->budget);
			echo "saved ".$i['employee']."<br/>";
		}
		echo "done..";
		//print_r($model);
		exit;

	}
	private function budgetSaveManual($model) {

		$fields = array(
						//'travel_in_ug_cap'		=>
						'travel_in_ug_op'					=>77,
						'weekend_lunch'						=>74,
						'weekend_transport'				=>93,
						'out_of_station'					=>97,
						'acting_allowance'				=>76,
						'responsibility_allowance'=>82,
						'overtime_weekdayhrs'			=>73,
						'leave_in_lieu'						=>87
					);
					foreach ($fields as $allowance=>$allowancecode) {
						//die(dump($model));
						$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$allowance,'tblid'=>$model->employee,'budget'=>$model->budget));
						if($md==null) $md= New Budget;
						if(intval($model->$allowance)>0) {
							$itemm=app()->db->createCommand("select id from items where name=(select scalename from v_employees where id=$model->employee limit 1) and accountcode='".$allowancecode."'")->queryAll();
							if(!$itemm)
								$itemm=app()->db->createCommand("select id from items where name=(select spined from v_employees_scales where id=$model->employee limit 1) and accountcode='".$allowancecode."'")->queryAll();
							//if(!$itemm) die("no price!"); else {echo $allowancecode;print_r($itemm); echo"<br>---\n"; }
							if($allowance=='overtime_weekdayhrs' || $allowance=='overtime_weekend_hrs')
								$qt=round(1.5 * $model->$allowance * $model->overtime_weekdaydays +  $model->$allowance * $model->overtime_weekdaydays + 2 * $model->overtime_weekend_days * $model->overtime_weekend_hrs);
							else
								$qt=intval($model->$allowance);
	//							echo $qt;
							$empl=Employees::model()->findByAttributes(array('id'=>$model->employee));
							if($itemm) {
								$md->attributes=array(
									"budget" 			=>	$model->budget,
									"item"				=>	$itemm[0][id],
									"dept"				=>	$empl->section,
									"qty"					=>	$qt,
									"tbl"					=>	"employees",
									"tblcolumn"		=>	$allowance,
									"tblid"				=>	$model->employee,
									"descr"				=>	$model->employee,
									"createdon"		=>	date("Y-m-d H:m:s"),
									"createdby"		=>	1,
									"dateneeded"	=> 	date("Y-m-d")
								);
								//print_r($md->attributes);
								if(!$md->save()) die($md->getErrors());
							//	echo "saved.";
							//	print_r($md->attributes);
							}// die ("Not saving budget. Price not found");
						} else
							if(!$md->isNewRecord) $md->delete();
					}

	}
	public function actionUpdate($id)
	{

		//$model=new Emolumentrates;

		//print_r($_POST['Emolumentrates']);
		if(isset($_POST['Emolumentrates']))
		{
			if(budget_locked()) { $this->render('/site/locked'); exit; }
			if(!$_POST['Emolumentrates']['leave_start']) $_POST['Emolumentrates']['leave_start']=null;
			if(!$_POST['Emolumentrates']['leave_end']) $_POST['Emolumentrates']['leave_end']=null;

			$record=$model->findByAttributes(array('budget'=>budget(),'employee'=>$_POST['Emolumentrates']['employee']));
			if($record) {
				$this->renderText("This employee was already budgeted for. Please <a href='index.php?r=emolumentrates/updateemp&emp=".$_POST['Emolumentrates']['employee']."'>click here</a> to update the employee instead");
			} else {
				$model->attributes=$_POST['Emolumentrates'];
				if($model->save()) {
					$this->redirect(array('view','id'=>$model->id));
				}
			}

		} else {
			$this->render('create',array('model'=>$model));
		}


	}
	public function actionUpdate1($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Emolumentrates']))
		{
			$model->attributes=$_POST['Emolumentrates'];
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
		if(budget_locked()) { $this->render('/site/locked'); exit; }
		$m=$this->loadModel($id);//->delete();

		app()->db->CreateCommand("Delete from budget where tbl='employees' and tblid=".$m->employee." and tblcolumn in ('travel_in_ug_op','weekend_lunch','weekend_transport','out_of_station','acting_allowance','responsibility_allowance','overtime_weekdayhrs','overtime_weekend_hrs','leave_in_lieu')")->execute();
		$m->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*
		$dataProvider=new CActiveDataProvider('Emolumentrates');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		$model=new Emolumentrates('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Emolumentrates']))
			$model->attributes=$_GET['Emolumentrates'];

		$this->render('admin',array(
			'model'=>$model,
		));

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Emolumentrates('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Emolumentrates']))
			$model->attributes=$_GET['Emolumentrates'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function loadModel($id)
	{
		$model=Emolumentrates::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Emolumentrates $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='emolumentrates-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
