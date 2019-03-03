<?php

/**
 * This is the model class for table "dept".
 *
 * The followings are the available columns in table 'dept':
 * @property integer $id
 * @property string $dept
 * @property integer $accountcode
 * @property string $shortname
 *
 * The followings are the available model relations:
 * @property Budgetitems[] $budgetitems
 * @property AccountcodesOld $accountcode0
 * @property Employees[] $employees
 * @property Sections[] $sections
 * @property Staff[] $staff
 * @property Vehicles[] $vehicles
 */
class Dept extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dept';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dept,shortname', 'required'),
			array('accountcode', 'numerical', 'integerOnly'=>true),
			array('dept, shortname', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dept, accountcode, shortname', 'safe', 'on'=>'search'),
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
			'budgetitems' => array(self::HAS_MANY, 'Budgetitems', 'dept'),
			'accountcode0' => array(self::BELONGS_TO, 'Accountcodes', 'accountcode'),
			'employees' => array(self::HAS_MANY, 'Employees', 'department'),
			'sections' => array(self::HAS_MANY, 'Sections', 'department'),
			'staff' => array(self::HAS_MANY, 'Staff', 'dept'),
			'vehicles' => array(self::HAS_MANY, 'Vehicles', 'dept'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dept' => 'Dept',
			'accountcode' => 'Accountcode',
			'shortname' => 'Shortname',
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
		$criteria->compare('dept',$this->dept,true);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('shortname',$this->shortname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dept the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
