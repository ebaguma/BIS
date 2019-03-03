<?php

/**
 * This is the model class for table "costcentres".
 *
 * The followings are the available columns in table 'costcentres':
 * @property integer $id
 * @property integer $accountcode
 * @property integer $category
 * @property string $name
 * @property string $descr
 *
 * The followings are the available model relations:
 * @property Costcentres $category0
 * @property Costcentres[] $costcentres
 * @property Items[] $items
 */
class Costcentres extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'costcentres';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountcode, category', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('descr', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, accountcode, category, name, descr', 'safe', 'on'=>'search'),
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
			'category0' => array(self::BELONGS_TO, 'Costcentres', 'category'),
			'costcentres' => array(self::HAS_MANY, 'Costcentres', 'category'),
			'items' => array(self::HAS_MANY, 'Items', 'costcentre'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'accountcode' => 'Account Code',
			'category' => 'Category',
			'name' => 'Name',
			'descr' => 'Descr',
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
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('category',$this->category);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('descr',$this->descr,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Costcentres the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
