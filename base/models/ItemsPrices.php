<?php

/**
 * This is the model class for table "items_prices".
 *
 * The followings are the available columns in table 'items_prices':
 * @property integer $id
 * @property integer $item
 * @property integer $budget
 * @property double $price
 *
 * The followings are the available model relations:
 * @property Budgets $budget0
 * @property Items $item0
 */
class ItemsPrices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'items_prices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item,currency', 'numerical', 'integerOnly'=>true),
			array('price,currency,insertby', 'numerical'),
			array('budget','default','value'=>budget(),'setOnEmpty'=>true,'on'=>'insert'),
			array('insertby','default','value'=>user()->id,'setOnEmpty'=>true,'on'=>'insert'),
			array('updateby','default','value'=>user()->id,'setOnEmpty'=>true,'on'=>'update'),
		   array('insertdate','default', 'value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
			 array('updatdate','default', 'value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'update'),
			array('id, item, budget, insertby,price,currency', 'safe', 'on'=>'search'),
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
			'item0' => array(self::BELONGS_TO, 'Items', 'item'),
			'currency0' => array(self::BELONGS_TO, 'Currencies', 'currency'),
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
			'budget' => 'Budget',
			'price' => 'Price',
			'currency' => 'Currency',
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
		$criteria->compare('price',$this->price);
		$criteria->compare('insertby',$this->insertby);
		$criteria->compare('currency',$this->currency);
		$criteria->with = array( 'item0','budget0');
		$criteria->compare('item0.name',$this->item,true);
		$criteria->compare('budget0.name',$this->budget);

		return new CActiveDataProvider($this, array('criteria'=>$criteria,'pagination'=>array('pageSize'=>100)));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemsPrices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
