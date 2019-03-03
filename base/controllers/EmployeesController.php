<?php

class EmployeesController extends Controller
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

	public function accessRules()
	{
		$heads=array('adminnn');
		if($_REQUEST['id']) {
			$m=Employees::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			if(
				(
					Yii::app()->user->details->dept == $m->department	||
					Yii::app()->user->details->dept == $m->section		||
					Yii::app()->user->details->dept == $m->unit
				) 	&&
				(
					array_key_exists(DEPT_HEAD,Yii::app()->user->roles)	||
					array_key_exists(BUDGET_OFFICER,Yii::app()->user->roles)
				)		
						
			) $heads[]=Yii::app()->user->name;
		}
		$hr=array('adminnn');
		if (is_hr()) {
			$hr[]=Yii::app()->user->name;
			$heads[]=Yii::app()->user->name;
		}
		return array(

			array('allow', // allow only HR to delete, update, create 
				'actions'=>array('create','update','delete'),
				'users'=>$hr,
			),
			array('allow', // allow HR and heads to view their employees
				'actions'=>array('view'),
				'users'=>$heads,
			),
			array('allow', // allow everyone (logged in) to view employees and to populate the sections and units drop downs
				'actions'=>array('admin','items','units','up'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionItems()
	{
		$data=CHtml::listData(Sections::model()->findAll('department='.$_POST[Employees][department]),'id','section');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
	}
	public function actionUnits()
	{
		$data=CHtml::listData(Subsections::model()->findAll('section='.$_POST[Employees][section]),'id','unit');
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
		$this->render('view',array('model'=>$this->loadModel($id)));
	}

	public function actionCreate()
	{
		$model=new Employees;
		if(isset($_POST['Employees']))
		{			
			if(!$_POST['Employees'][employee]) $_POST['Employees'][employee] = $_POST['Employees'][checkno]; 
			$model->attributes=$_POST['Employees'];
			if($model->save()) {
				$this->actionUpdate1($model->id);
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array('model'=>$model));
	}

	public function actionUp() {
		$row=app()->db->createCommand("select * from employees where budget=".budget())->queryAll();
//		dump($row);
		foreach($row as $r) {
//			dump($r[id]);
			echo "updating ".++$ctr." - ".$r[id]." : ".$r[employee]."<br/>";
			$this->actionUpdate1($r[id]);	
		}
		
	}
	
	public function actionUpdate1($id)
	{
		$model=$this->loadModel($id);
		//if(isset($_POST['Employees']))
	//	{
			$model->attributes=$_POST['Employees'];
			$model->createdby=user()->id;
			if($model->save())  {
				$allows=array(
					'salary'=>72,
				);
				$contkt=array(
					'medical'	=>105
				);

				if($model->contract==1) {
					foreach ($contkt as $kl=>$vl) $allows[$kl]=$vl;
				} else {
					foreach ($contkt as $kl=>$vl) {
						$md=Budget::model()->deleteAllByAttributes(array('tbl'=>'employees','tblcolumn'=>$kl,'tblid'=>$model->id,'budget'=>user()->budget['id']));
					}
				}
					
				$optionals=array(
					'soap'		=>92,
					'risk'		=>83
				);			
				foreach($optionals as $kl=>$vl) {	
					if($model->$kl==1)	$allows[$kl]=$vl;
					else {
						$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$kl,'tblid'=>$model->id,'budget'=>user()->budget['id']));
						if($md) $md->delete();
					}
				}
				$other=array(
					'phone'	=>96,
					'cc'		=>85
				);
				foreach($other as $kl=>$vl) {
					if(intval($model->$kl)>0) $allows[$kl]=$vl;
					 else {
						$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$kl,'tblid'=>$model->id,'budget'=>user()->budget['id']));
						if($md) $md->delete();											
					}		
				}
				$p1=array('leave','gratuity','medical');
				$const=array('phone','cc');
				//dump($allows);
				foreach($allows as $allowance=>$allowancecode) {
					$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$allowance,'tblid'=>$model->id,'budget'=>user()->budget['id']));					
					if($md==null) $md= New Budget;
					if(!in_array($allowance,$const)) {
						$itemm=app()->db->createCommand("select id from items where name=(select spined from v_employees_scales where id=$model->id limit 1) and accountcode='".$allowancecode."'")->queryAll();
						if(!$itemm)
							$itemm=app()->db->createCommand("select id from items where name=(select scalename from v_employees_scales where id=$model->id limit 1) and accountcode='".$allowancecode."'")->queryAll();
						$itemid=$itemm[0][id];
					} else {
						$md2=Items::model()->findByAttributes(array('name'=>$allowance.' for '.$model->employee,'accountcode'=>$allowancecode));
						if(!$md2) {
							$md2 = new Items;
							$md2->attributes=array('name'=>$allowance.' for '.$model->employee, 'accountcode'=>$allowancecode);
							$md2->save();
						}
						$md3=ItemsPrices::model()->findByAttributes(array('item'=>$md2->id,budget=>user()->budget['id']));
						if(!$md3) {
							$md3=new ItemsPrices;
							$md3->attributes=array('item'=>$md2->id,budget=>user()->budget['id'],'price'=>$model->$allowance,'currency'=>1);
							$md3->save();
						}
						if($md3->price !=$model->$allowance) {
							$md3->attributes=array('item'=>$md2->id,budget=>user()->budget['id'],'price'=>$model->$allowance,'currency'=>1);
							$md3->save();
						}	
					$itemid=$md2->id;	
					}
						
					if($itemm) {
						$pq=in_array($allowance,$p1) ? 1 : budget('period');
						//echo "$pq for $allowance<br><br><br>";
						$md->attributes=array(
							"period" 			=>	$pq,
							"budget" 			=>	Yii::app()->user->budget['id'],
							"item"				=>	$itemid,
							"dept"			=>	$model->section,
							"qty"				=>	1,
							"tbl"				=>	"employees",
							"tblcolumn"		=>	$allowance,
							"tblid"				=>	$model->id,
							"descr"			=>	$allowance." Allowance for ".$model->employee,
							"createdon"		=>	date("Y-m-d"),
							"createdby"		=>	user()->id,
							"dateneeded"		=> date("Y-m-d")
						);
						//print_r($md->attributes);
						$md->save();
					}
				}
			}
	//	}
		//$this->render('update',array('model'=>$model));
	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Employees']))
		{
			$model->attributes=$_POST['Employees'];
			$model->createdby=user()->id;
			if($model->save())  {
				$allows=array(
					'salary'=>72,
				);
				$contkt=array(
					'medical'	=>105
				);

				if($model->contract==1) {
					foreach ($contkt as $kl=>$vl) $allows[$kl]=$vl;
				} else {
					foreach ($contkt as $kl=>$vl) {
						$md=Budget::model()->deleteAllByAttributes(array('tbl'=>'employees','tblcolumn'=>$kl,'tblid'=>$model->id,'budget'=>user()->budget['id']));
					}
				}
					
				$optionals=array(
					'soap'		=>92,
					'risk'		=>83
				);			
				foreach($optionals as $kl=>$vl) {	
					if($model->$kl==1)	$allows[$kl]=$vl;
					else {
						$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$kl,'tblid'=>$model->id,'budget'=>user()->budget['id']));
						if($md) $md->delete();
					}
				}
				$other=array(
					'phone'	=>96,
					'cc'		=>85
				);
				foreach($other as $kl=>$vl) {
					if(intval($model->$kl)>0) $allows[$kl]=$vl;
					 else {
						$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$kl,'tblid'=>$model->id,'budget'=>user()->budget['id']));
						if($md) $md->delete();											
					}		
				}
				$p1=array('leave','gratuity','medical');
				$const=array('phone','cc');
				//dump($allows);
				foreach($allows as $allowance=>$allowancecode) {
					$md=Budget::model()->findByAttributes(array('tbl'=>'employees','tblcolumn'=>$allowance,'tblid'=>$model->id,'budget'=>user()->budget['id']));					
					if($md==null) $md= New Budget;
					if(!in_array($allowance,$const)) {
						$itemm=app()->db->createCommand("select id from items where name=(select spined from v_employees_scales where id=$model->id limit 1) and accountcode='".$allowancecode."'")->queryAll();
						if(!$itemm)
							$itemm=app()->db->createCommand("select id from items where name=(select scalename from v_employees_scales where id=$model->id limit 1) and accountcode='".$allowancecode."'")->queryAll();
						$itemid=$itemm[0][id];
					} else {
						$md2=Items::model()->findByAttributes(array('name'=>$allowance.' for '.$model->employee,'accountcode'=>$allowancecode));
						if(!$md2) {
							$md2 = new Items;
							$md2->attributes=array('name'=>$allowance.' for '.$model->employee, 'accountcode'=>$allowancecode);
							$md2->save();
						}
						$md3=ItemsPrices::model()->findByAttributes(array('item'=>$md2->id,budget=>user()->budget['id']));
						if(!$md3) {
							$md3=new ItemsPrices;
							$md3->attributes=array('item'=>$md2->id,budget=>user()->budget['id'],'price'=>$model->$allowance,'currency'=>1);
							$md3->save();
						}
						if($md3->price !=$model->$allowance) {
							$md3->attributes=array('item'=>$md2->id,budget=>user()->budget['id'],'price'=>$model->$allowance,'currency'=>1);
							$md3->save();
						}	
					$itemid=$md2->id;	
					}
						
					if($itemm) {
						$pq=in_array($allowance,$p1) ? 1 : budget('period');
						//echo "$pq for $allowance<br><br><br>";
						$md->attributes=array(
							"period" 			=>	$pq,
							"budget" 			=>	Yii::app()->user->budget['id'],
							"item"				=>	$itemid,
							"dept"			=>	$model->section,
							"qty"				=>	1,
							"tbl"				=>	"employees",
							"tblcolumn"		=>	$allowance,
							"tblid"				=>	$model->id,
							"descr"			=>	$allowance." Allowance for ".$model->employee,
							"createdon"		=>	date("Y-m-d"),
							"createdby"		=>	user()->id,
							"dateneeded"		=> date("Y-m-d")
						);
						//print_r($md->attributes);
						$md->save();
					}
				}
			}
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
		$m=$this->loadModel($id);;
		$m->attributes=array('enddate'=>date('Y-m-d'));
		//print_r($m->attributes);
		$m->save();
		Budget::model()->deleteAllByAttributes(array('tbl'=>'employees','budget'=>user()->budget['id'],'tblid'=>$id));
		Emolumentrates::model()->deleteAllByAttributes(array('budget'=>budget(),'employee'=>$id));
		//Travel::model()->deleteAllByAttributes(array('budget'=>budget(),'employee'=>$id));
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
    public function actionExcel(){
	
		$phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("K'iin Balam")
             ->setLastModifiedBy("K'iin Balam")
             ->setTitle("YiiExcel Test Document")
             ->setSubject("YiiExcel Test Document")
             ->setDescription("Test document for YiiExcel, generated using PHP classes.")
             ->setKeywords("office PHPExcel php YiiExcel UPNFM")
             ->setCategory("Test result file");        
        
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
        
        // Miscellaneous glyphs, UTF-8
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', '�����������������');
        
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('YiiExcel');
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        // Save a xls file
        $filename = 'YiiExcel';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
		
		spl_autoload_register(array('YiiBase','autoload'));
       // exit();
    }//fin del m�todo actionExcel

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Employees');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Employees('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employees']))
			$model->attributes=$_GET['Employees'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Employees the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Employees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Employees $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
