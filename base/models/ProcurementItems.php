<?php

/**
 * This is the model class for table "procurement_items".
 *
 * The followings are the available columns in table 'procurement_items':
 * @property integer $id
 * @property integer $spending
 * @property integer $item
 * @property integer $quantity
 * @property string $description
 * @property double $actual_spent
 * @property string $delivery_date
 *
 * The followings are the available model relations:
 * @property ProcurementSpending $spending0
 * @property Items $item0
 */
class ProcurementItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'procurement_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('spending, item, quantity', 'numerical', 'integerOnly'=>true),
			array('actual_spent', 'numerical'),
			array('description, delivery_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, spending, item, quantity, description, actual_spent, delivery_date', 'safe', 'on'=>'search'),
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
			'spending0' => array(self::BELONGS_TO, 'ProcurementSpending', 'spending'),
			'item0' => array(self::BELONGS_TO, 'Items', 'item'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'spending' => 'Spending',
			'item' => 'Item',
			'quantity' => 'Quantity',
			'description' => 'Description',
			'actual_spent' => 'Actual Spent',
			'delivery_date' => 'Delivery Date',
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
		$criteria->compare('spending',$this->spending);
		$criteria->compare('item',$this->item);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('actual_spent',$this->actual_spent);
		$criteria->compare('delivery_date',$this->delivery_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProcurementItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
