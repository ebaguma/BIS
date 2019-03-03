<?php

/**
 * This is the model class for table "items_prices_view".
 *
 * The followings are the available columns in table 'items_prices_view':
 * @property integer $readonly
 * @property double $priceugx
 * @property string $currency
 * @property double $exrate
 * @property integer $itemid
 * @property integer $accountcode
 * @property string $accountid
 * @property string $accountitem
 * @property string $name
 * @property string $descr
 * @property integer $budget
 * @property string $budgetname
 * @property double $price
 */
class ItemsPricesView extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'items_prices_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountcode, name, budget, price', 'required'),
			array('readonly, itemid, accountcode, budget', 'numerical', 'integerOnly'=>true),
			array('priceugx, exrate, price', 'numerical'),
			array('currency', 'length', 'max'=>3),
			array('accountid', 'length', 'max'=>11),
			array('accountitem, name, budgetname', 'length', 'max'=>100),
			array('descr', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('readonly, priceugx, currency, exrate, itemid, accountcode, accountid, accountitem, name, descr, budget, budgetname, price', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'readonly' => 'Readonly',
			'priceugx' => 'Priceugx',
			'currency' => 'Currency',
			'exrate' => 'Exrate',
			'itemid' => 'Itemid',
			'accountcode' => 'Accountcode',
			'accountid' => 'Accountid',
			'accountitem' => 'Accountitem',
			'name' => 'Name',
			'descr' => 'Descr',
			'budget' => 'Budget',
			'budgetname' => 'Budgetname',
			'price' => 'Price',
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

		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('priceugx',$this->priceugx);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('exrate',$this->exrate);
		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('accountid',$this->accountid,true);
		$criteria->compare('accountitem',$this->accountitem,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('budgetname',$this->budgetname,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemsPricesView the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
