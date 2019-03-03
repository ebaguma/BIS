<?php

/**
 * This is the model class for table "vehicles".
 *
 * The followings are the available columns in table 'vehicles':
 * @property integer $id
 * @property string $regno
 * @property integer $vehicletype
 * @property string $fueltype
 * @property string $battery
 * @property string $description
 * @property integer $dept
 * @property integer $section
 * @property integer $subsection
 * @property string $tyres
 *
 * The followings are the available model relations:
 * @property Sections $section0
 * @property Dept $dept0
 * @property Subsections $subsection0
 */
class Vehicles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicletype, dept, glcode,section, subsection,tyres,battery', 'numerical', 'integerOnly'=>true),
			array('regno ', 'length', 'max'=>100),
			array('regno, glcode,dept,section,vehicletype,fuelconsumption', 'required'),
			array('fueltype', 'length', 'max'=>6),
			array('description,fms', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, regno, fms,glcode,fuelconsumption,vehicletype, fueltype, tyres, description, dept, section, subsection, battery', 'safe', 'on'=>'search'),
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
			'section0' => array(self::BELONGS_TO, 'Sections', 'section'),
			'dept0' => array(self::BELONGS_TO, 'Dept', 'dept'),
			'vehicletype0' => array(self::BELONGS_TO, 'VehicleTypes', 'vehicletype'),	
			'tyres0' => array(self::BELONGS_TO, 'Items', 'tyres'),	
			'battery0' => array(self::BELONGS_TO, 'Items', 'battery'),	
			'subsection0' => array(self::BELONGS_TO, 'Subsections', 'subsection'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'regno' => 'Registration Number',
			'vehicletype' => 'Vehicle Type',
			'fueltype' => 'Fuel Type',
			'tyres' => 'Tyres',
			'description' => 'Description',
			'dept' => 'Department',
			'section' => 'Section',
			'subsection' => 'Sub-Section',
			'battery' => 'Battery',
			'fuelconsumption'=>'Fuel Consumption',
			'fms'=>'Fleet Management System',
			'glcode'=>'GL Code'
			
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
		if($_REQUEST['r']=='vehicles/admin') {
		$criteria->compare('id',$this->id);
		$criteria->compare('regno',$this->regno,true);
		$criteria->compare('fuelconsumption',$this->fuelconsumption,true);
		$criteria->compare('fueltype',$this->fueltype,true);
		$criteria->compare('tyres',$this->tyres,true);
		$criteria->compare('glcode',$this->glcode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('dept',$this->dept);
		$criteria->compare('subsection',$this->subsection);
		$criteria->compare('battery',$this->battery,true);
		$criteria->compare('fms',$this->fms,true);
		$criteria->with = array( 'vehicletype0','section0');
		$criteria->compare('vehicletype0.vehicletype',$this->vehicletype,true);
		$criteria->compare('section0.section',$this->section,true);
		
	}
	return new CActiveDataProvider($this, array('criteria'=>$criteria,'pagination'=>array('pageSize'=>50)));	
}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vehicles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
