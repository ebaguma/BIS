<?php

/**
 * This is the model class for table "transport_budget".
 *
 * The followings are the available columns in table 'transport_budget':
 * @property integer $id
 * @property integer $accountcode
 * @property integer $item
 * @property string $period
 * @property integer $quantity
 * @property integer $budget
 * @property integer $dept
 * @property string $createdon
 * @property integer $createdby
 * @property string $updatedon
 * @property integer $updatedby
 * @property string $dateneeded
 * @property integer $vehicle
 *
 * The followings are the available model relations:
 * @property Items $item0
 * @property Budgets $budget0
 * @property Accountcodes $accountcode0
 * @property Users $updatedby0
 * @property Users $createdby0
 */
class TransportBudget extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transport_budget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('budget, createdby', 'required'),
			array('budget, mileage,tyres,battery,createdby, updatedby, vehicle', 'numerical', 'integerOnly'=>true),
			array('createdon, updatedon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,budget, mileage,tyres,battery,createdon, createdby, updatedon, updatedby, vehicle', 'safe', 'on'=>'search'),
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
			'vehicle0' => array(self::BELONGS_TO, 'Vehicles', 'vehicle'),
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
			'updatedby0' => array(self::BELONGS_TO, 'Users', 'updatedby'),
			'createdby0' => array(self::BELONGS_TO, 'Users', 'createdby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'budget' => 'Budget',
			'createdon' => 'Createdon',
			'createdby' => 'Createdby',
			'updatedon' => 'Updatedon',
			'updatedby' => 'Updatedby',
			'dateneeded' => 'Dateneeded',
			'vehicle' => 'Vehicle',
			'mileage'=>'Mileage',
			'tyres'	=>'Tyres',
			'battery'=>'Battery'
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
		$criteria->compare('budget',$this->budget);
		$criteria->compare('mileage',$this->mileage);
		$criteria->compare('tyres',$this->tyres);
		$criteria->compare('battery',$this->battery);
		$criteria->compare('createdon',$this->createdon,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('updatedon',$this->updatedon,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('vehicle',$this->vehicle);

		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransportBudget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
