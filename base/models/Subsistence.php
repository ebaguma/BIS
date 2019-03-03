<?php

/**
 * This is the model class for table "subsistence".
 *
 * The followings are the available columns in table 'subsistence':
 * @property integer $id
 * @property integer $item
 * @property integer $section
 * @property integer $subsection
 * @property integer $site
 * @property integer $activity
 * @property integer $petrol
 * @property integer $diesel
 * @property integer $casuals
 * @property string $startdate
 * @property string $enddate
 * @property string $description
 * @property integer $budget
 *
 * The followings are the available model relations:
 * @property Budgets $budget0
 * @property SubsitenceItems $item0
 * @property SubsitenceSections $section0
 * @property SubsitenceSections $subsection0
 * @property Sites $site0
 * @property SubsistenceDetails[] $subsistenceDetails
 * @property SubsistenceStaff[] $subsistenceStaff
 */
class Subsistence extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subsistence';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('item, section, subsection, site, activity, petrol, diesel, casuals, budget', 'numerical', 'integerOnly'=>true),
			array('startdate, enddate, description', 'safe'),
			array('item, site,startdate,enddate', 'required'),
			array('section', 'default', 'value'=>user()->dept['id']),
			array('createdby', 'default', 'value'=>user()->id),
			array('id, item, createdby, section, subsection, site, activity, petrol, diesel, casuals, startdate, enddate, description, budget', 'safe', 'on'=>'search'),
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
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
			'item0' => array(self::BELONGS_TO, 'SubsistenceItems', 'item'),
			'section0' => array(self::BELONGS_TO, 'SubsistenceSections', 'section'),
			'subsection0' => array(self::BELONGS_TO, 'SubsistenceSections', 'subsection'),
			'site0' => array(self::BELONGS_TO, 'Sites', 'site'),
			'subsistenceDetails' => array(self::HAS_MANY, 'SubsistenceDetails', 'activity'),
			'subsistenceStaff' => array(self::HAS_MANY, 'SubsistenceStaff', 'activity'),
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
			'petrol' => 'Petrol',
			'diesel' => 'Diesel',
			'casuals' => 'Casuals',
			'startdate' => 'Startdate',
			'enddate' => 'Enddate',
			'description' => 'Description',
			'budget' => 'Budget',
			'createdby' => 'Created By',
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
		$criteria->compare('section',user()->dept['id']);
		$criteria->compare('subsection',$this->subsection);
		$criteria->compare('site',$this->site);
		$criteria->compare('activity',$this->activity);
		$criteria->compare('petrol',$this->petrol);
		$criteria->compare('diesel',$this->diesel);
		$criteria->compare('casuals',$this->casuals);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('budget',user()->budget['id']);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subsistence the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
