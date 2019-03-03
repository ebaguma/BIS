<?php

/**
 * This is the model class for table "travel".
 *
 * The followings are the available columns in table 'travel':
 * @property integer $id
 * @property integer $employee
 * @property string $course
 * @property string $purpose
 * @property string $centre
 * @property string $mission
 * @property integer $budget
 *
 * The followings are the available model relations:
 * @property Employees $employee0
 * @property Budgets $budget0
 * @property TravelDetails[] $travelDetails
 */
class Travel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'travel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mission,traveldate,employee', 'required'),
			array('employee, budget', 'numerical', 'integerOnly'=>true),
			array('course, centre,traveldate', 'length', 'max'=>100),
			array('mission', 'length', 'max'=>130),
			array('purpose', 'safe'),
			array('createdby','default','value'=>Yii::app()->user->details['id']),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, employee, course, purpose, centre, mission, traveldate,budget', 'safe', 'on'=>'search'),
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
			'employee0' => array(self::BELONGS_TO, 'Employees', 'employee'),
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
			'travelDetails' => array(self::HAS_MANY, 'TravelDetails', 'training'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'employee' => 'Employee',
			'course' => 'Course',
			'purpose' => 'Purpose',
			'centre' => 'Centre',
			'mission' => 'Mission',
			'budget' => 'Budget',
			'traveldate' => 'Travel Date (Approximate)',
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
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('employee',$this->employee);
		$criteria->compare('course',$this->course,true);
		$criteria->compare('purpose',$this->purpose,true);
		$criteria->compare('centre',$this->centre,true);
		$criteria->compare('mission',$_REQUEST['m']);
		$criteria->compare('budget',user()->budget['id']);
		$criteria->compare('createdby',sectionmates());

		return new CActiveDataProvider($this, array('criteria'=>$criteria,'pagination'=>array('pageSize'=>50)));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Travel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
