<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
 * @property integer $id
 * @property integer $checkno
 * @property string $employee
 * @property integer $designation
 * @property integer $salary_scale
 * @property integer $spine
 * @property integer $department
 * @property integer $section
 * @property integer $unit
 * @property string $shift
 * @property string $standby
 * @property string $contract
 * @property string $recruitmentdate
 * @property integer $phone
 * @property integer $createdby
 *
 * The followings are the available model relations:
 * @property Designations $designation0
 * @property Scales $salaryScale
 * @property Spines $spine0
 * @property Sections $section0
 * @property Subsections $unit0
 * @property Dept $department0
 */
class Employees extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('checkno, designation, salary_scale, spine, department, section', 'required'),
			array('checkno, cc,risk,soap,phone', 'numerical', 'integerOnly'=>true),
			array('employee,enddate, recruitmentdate', 'length', 'max'=>100),
			array('createdby', 'default', 'value'=>Yii::app()->user->id,'setOnEmpty'=>true,'on'=>'update'),
			array('shift, standby, contract', 'length', 'max'=>3),
			array('budget','default','value'=>budget()),
			array('createdon','default', 'value'=>new CDbExpression('NOW()')),
			//array('checkno+enddate','ext.uniqueMultiColumnValidator'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, enddate, createdon,recruitmentdate, budget,cc,risk,soap,createdby,checkno, employee, designation, salary_scale, spine, department, section, unit, shift, standby, contract, phone', 'safe','on'=>'search'),
		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'designation0' => array(self::BELONGS_TO, 'Designations', 'designation'),
			'salaryScale' => array(self::BELONGS_TO, 'Scales', 'salary_scale'),
			'spine0' => array(self::BELONGS_TO, 'Spines', 'spine'),
			'section0' => array(self::BELONGS_TO, 'Sections', 'section'),
			'unit0' => array(self::BELONGS_TO, 'Subsections', 'unit'),
			'department0' => array(self::BELONGS_TO, 'Dept', 'department'),
			'createdby0' => array(self::BELONGS_TO, 'Users', 'createdby'),
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'createdby'		=>'createdby',
			'checkno' 			=> 'Check Number',
			'employee' 		=> 'Employee',
			'designation' 		=> 'Designation',
			'salary_scale' 	=> 'Salary Scale',
			'spine' 			=> 'Spine',
			'department' 		=> 'Department',
			'section' 			=> 'Section',
			'unit' 				=> 'Unit',
			'shift' 				=> 'Shift',
			'standby' 			=> 'Standby',
			'contract'			 => 'Contract',
			'recruitmentdate' => 'Recruitmentdate',
			'enddate' 			=> 'End Date',
			'phone' 			=> 'Phone',
			'soap'				=>'Soap Allowance',
			'cc'				=>'Contracts Commette',
			'risk'				=>'Risk Allowance'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		
		//$section = array_key_exists(HUMAN_RESOURCE,Yii::app()->user->roles) ? $this->section : Yii::app()->user->details->dept;
		
		$criteria=new CDbCriteria;
			//$criteria->compare('id',$this->id);
			$criteria->compare('checkno',$this->checkno);
			$criteria->compare('employee',$this->employee,true);
			//$criteria->compare('designation',$this->designation);
		//	$criteria->compare('salary_scale',$this->salary_scale);
			$criteria->compare('spine',$this->spine);
			//$criteria->compare('department',$this->department);
			//$criteria->compare('section',$this->section);
			$criteria->compare('unit',$this->unit);
			$criteria->compare('budget',budget());
			$criteria->compare('createdby',$this->createdby);
			$criteria->compare('shift',$this->shift,true);
			$criteria->compare('standby',$this->standby,true);
			$criteria->compare('contract',$this->contract,true);
			$criteria->compare('recruitmentdate',$this->recruitmentdate,true);
			//$criteria->compare('enddate',null,true);
			$criteria->compare('phone',$this->phone);
			$criteria->with = array( 'section0','department0','salaryScale','designation0');
			$criteria->compare( 'section0.section', $this->section, true );
			$criteria->compare( 'department0.dept', $this->department, true );
			$criteria->compare( 'salaryScale.name', $this->salary_scale, true );
			$criteria->compare( 'designation0.designation', $this->designation, true );
			//$criteria->addCondition('enddate is NULL');
			/*$criteria->with = array( 'department0');
			
			$criteria->with = array( 'salaryScale');
			$criteria->compare( 'salaryScale.name', $this->salary_scale, true );
/*			$criteria->with = array( 'section0');
			$criteria->compare( 'section0.section', $this->section, true );*/

			return new CActiveDataProvider($this, array('criteria'=>$criteria,'pagination'=>array('pageSize'=>50)));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Employees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
