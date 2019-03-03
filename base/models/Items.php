<?php

/**
 * This is the model class for table "items".
 *
 * The followings are the available columns in table 'items':
 * @property integer $id
 * @property integer $accountcode
 * @property integer $costcentre
 * @property string $name
 * @property string $descr
 *
 * The followings are the available model relations:
 * @property Costcentres $costcentre0
 * @property ItemsPrices[] $itemsPrices
 */
class Items extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,accountcode', 'required'),
			array('accountcode,uom', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('descr', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, accountcode, uom,costcentre, name, descr', 'safe', 'on'=>'search'),
		);
	}


	public function getprices()
	        {               
	                $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM items_prices_view')->queryScalar();
	                $sql='SELECT * FROM items_prices_view';
	                $dataProvider=new CSqlDataProvider($sql, array(
	                                'totalItemCount'=>$count,
	                                'sort'=>array(
	                                                'attributes'=>array(
	                                                                'id', 'accountcode',
	                                                ),
	                                ),
	                                'pagination'=>array(
	                                                'pageSize'=>100,
	                                ),
	                ));
                
	                return $dataProvider;
	        }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'acountcode0' => array(self::BELONGS_TO, 'Accountcodes', 'accountcode'),
			'uom0' => array(self::BELONGS_TO, 'Uom', 'uom'),
			'itemsPrices' => array(self::HAS_MANY, 'ItemsPrices', 'item'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'accountcode' => 'Accountcode',
			'name' => 'Name',
			'uom'	=>'uom',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('uom',$this->uom,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->with = array( 'acountcode0');
		$criteria->compare('acountcode0.item',$this->accountcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			    'pageSize'=>100,
			  ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Items the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
