<?php

/**
 * This is the model class for table "v_budget".
 *
 * The followings are the available columns in table 'v_budget':
 * @property integer $period
 * @property string $currency
 * @property double $exrate
 * @property double $price
 * @property double $amount
 * @property string $section
 * @property integer $realdept
 * @property string $realdptname
 * @property string $realdptshortname
 * @property integer $id
 * @property integer $accountcode
 * @property double $unit_mount
 * @property integer $budget
 * @property integer $dept
 * @property integer $item
 * @property string $descr
 * @property integer $qty
 * @property string $tbl
 * @property integer $tblid
 * @property string $tblcolumn
 * @property integer $units
 * @property integer $createdby
 * @property string $createdon
 * @property string $dateneeded
 * @property string $name
 */
class VBudget extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_budget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('section, realdptname, accountcode, unit_mount, qty, createdby, dateneeded, name', 'required'),
			array('period, realdept, id, accountcode, budget, dept, item, qty, tblid, units, createdby', 'numerical', 'integerOnly'=>true),
			array('exrate, price, amount, unit_mount', 'numerical'),
			array('currency', 'length', 'max'=>3),
			array('section, name', 'length', 'max'=>100),
			array('realdptname, realdptshortname', 'length', 'max'=>50),
			array('descr', 'length', 'max'=>255),
			array('tbl, tblcolumn', 'length', 'max'=>200),
			array('createdon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('period, currency, exrate, price, amount, section, realdept, realdptname, realdptshortname, id, accountcode, unit_mount, budget, dept, item, descr, qty, tbl, tblid, tblcolumn, units, createdby, createdon, dateneeded, name', 'safe', 'on'=>'search'),
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
			'period' => 'Period',
			'currency' => 'Currency',
			'exrate' => 'Exrate',
			'price' => 'Price',
			'amount' => 'Amount',
			'section' => 'Section',
			'realdept' => 'Realdept',
			'realdptname' => 'Realdptname',
			'realdptshortname' => 'Realdptshortname',
			'id' => 'ID',
			'accountcode' => 'Accountcode',
			'unit_mount' => 'Unit Mount',
			'budget' => 'Budget',
			'dept' => 'Dept',
			'item' => 'Item',
			'descr' => 'Descr',
			'qty' => 'Qty',
			'tbl' => 'Tbl',
			'tblid' => 'Tblid',
			'tblcolumn' => 'Tblcolumn',
			'units' => 'Units',
			'createdby' => 'Createdby',
			'createdon' => 'Createdon',
			'dateneeded' => 'Dateneeded',
			'name' => 'Name',
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

		$criteria->compare('period',$this->period);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('exrate',$this->exrate);
		$criteria->compare('price',$this->price);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('realdept',$this->realdept);
		$criteria->compare('realdptname',$this->realdptname,true);
		$criteria->compare('realdptshortname',$this->realdptshortname,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('unit_mount',$this->unit_mount);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('dept',$this->dept);
		$criteria->compare('item',$this->item);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('tbl',$this->tbl,true);
		$criteria->compare('tblid',$this->tblid);
		$criteria->compare('tblcolumn',$this->tblcolumn,true);
		$criteria->compare('units',$this->units);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createdon',$this->createdon,true);
		$criteria->compare('dateneeded',$this->dateneeded,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VBudget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
