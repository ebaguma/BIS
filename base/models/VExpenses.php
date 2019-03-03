<?php

/**
 * This is the model class for table "v_expenses".
 *
 * The followings are the available columns in table 'v_expenses':
 * @property string $itemname
 * @property string $budgetname
 * @property double $price
 * @property string $accountname
 * @property string $accountid
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
 */
class VExpenses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_expenses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountcode, budget, dept, createdby, dateneeded', 'required'),
			array('id, accountcode, item, quantity, budget, dept, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('itemname, budgetname, accountname', 'length', 'max'=>100),
			array('accountid', 'length', 'max'=>11),
			array('period', 'length', 'max'=>8),
			array('createdon, updatedon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('itemname, budgetname, price, accountname, accountid, id, accountcode, item, period, quantity, budget, dept, createdon, createdby, updatedon, updatedby, dateneeded', 'safe', 'on'=>'search'),
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
			'itemname' => 'Itemname',
			'budgetname' => 'Budgetname',
			'price' => 'Price',
			'accountname' => 'Accountname',
			'accountid' => 'Accountid',
			'id' => 'ID',
			'accountcode' => 'Accountcode',
			'item' => 'Item',
			'period' => 'Period',
			'quantity' => 'Quantity',
			'budget' => 'Budget',
			'dept' => 'Dept',
			'createdon' => 'Createdon',
			'createdby' => 'Createdby',
			'updatedon' => 'Updatedon',
			'updatedby' => 'Updatedby',
			'dateneeded' => 'Dateneeded',
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

		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('budgetname',$this->budgetname,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('accountname',$this->accountname,true);
		$criteria->compare('accountid',$this->accountid,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('item',$this->item);
		$criteria->compare('period',$this->period,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('dept',$this->dept);
		$criteria->compare('createdon',$this->createdon,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('updatedon',$this->updatedon,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('dateneeded',$this->dateneeded,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VExpenses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
