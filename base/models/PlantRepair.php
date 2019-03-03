<?php

/**
 * This is the model class for table "plant_repair".
 *
 * The followings are the available columns in table 'plant_repair':
 * @property integer $id
 * @property integer $item
 * @property integer $section
 * @property integer $subsection
 * @property integer $site
 * @property integer $activity
 * @property string $labour_source
 * @property string $repair_items
 * @property string $startdate
 * @property string $enddate
 * @property integer $casuals
 * @property integer $petrol
 * @property integer $diesel
 * @property string $description
 * @property integer $budget
 *
 * The followings are the available model relations:
 * @property PlantRepairSites $site0
 * @property PlantRepairItems $item0
 * @property PlantRepairSections $section0
 * @property PlantRepairSections $subsection0
 * @property Budgets $budget0
 * @property PlantRepairDetails[] $plantRepairDetails
 * @property PlantRepairStaff[] $plantRepairStaff
 */
class PlantRepair extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plant_repair';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('startdate, enddate', 'required'),
			array('item, section, subsection, site, activity, casuals, petrol, diesel, budget', 'numerical', 'integerOnly'=>true),
			array('labour_source', 'length', 'max'=>8),
			array('repair_items', 'length', 'max'=>100),
			array('startdate, enddate, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item, section, subsection, site, activity, labour_source, repair_items, startdate, enddate, casuals, petrol, diesel, description, budget', 'safe', 'on'=>'search'),
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
			'site0' => array(self::BELONGS_TO, 'PlantRepairSites', 'site'),
			'item0' => array(self::BELONGS_TO, 'PlantRepairItems', 'item'),
			'section0' => array(self::BELONGS_TO, 'PlantRepairSections', 'section'),
			'subsection0' => array(self::BELONGS_TO, 'PlantRepairSections', 'subsection'),
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
			'plantRepairDetails' => array(self::HAS_MANY, 'PlantRepairDetails', 'activity'),
			'plantRepairStaff' => array(self::HAS_MANY, 'PlantRepairStaff', 'activity'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item' => 'Item',
			'section' => 'Section',
			'subsection' => 'Subsection',
			'site' => 'Site',
			'activity' => 'Activity',
			'labour_source' => 'Labour Source',
			'repair_items' => 'Repair Items',
			'startdate' => 'Startdate',
			'enddate' => 'Enddate',
			'casuals' => 'Casuals',
			'petrol' => 'Petrol',
			'diesel' => 'Diesel',
			'description' => 'Description',
			'budget' => 'Budget',
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
		$criteria->compare('item',$this->item);
		$criteria->compare('section',$this->section);
		$criteria->compare('subsection',$this->subsection);
		$criteria->compare('site',$this->site);
		$criteria->compare('activity',$this->activity);
		$criteria->compare('labour_source',$this->labour_source,true);
		$criteria->compare('repair_items',$this->repair_items,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('casuals',$this->casuals);
		$criteria->compare('petrol',$this->petrol);
		$criteria->compare('diesel',$this->diesel);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('budget',$this->budget);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantRepair the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
