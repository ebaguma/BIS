<?php

/**
 * This is the model class for table "detail".
 *
 * The followings are the available columns in table 'detail':
 * @property integer $id
 * @property integer $entity
 * @property string $name
 * @property string $descr
 * @property string $datatype
 *
 * The followings are the available model relations:
 * @property Costables[] $costables
 * @property Entity $entity0
 * @property Details[] $details
 * @property Templates[] $templates
 */
class Detail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity', 'numerical', 'integerOnly'=>true),
			array('name, descr, datatype', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entity, name, descr, datatype', 'safe', 'on'=>'search'),
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
			'costables' => array(self::HAS_MANY, 'Costables', 'costable'),
			'entity0' => array(self::BELONGS_TO, 'Entity', 'entity'),
			'details' => array(self::HAS_MANY, 'Details', 'detail'),
			'templates' => array(self::HAS_MANY, 'Templates', 'detail'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entity' => 'Entity',
			'name' => 'Name',
			'descr' => 'Descr',
			'datatype' => 'Datatype',
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
		$criteria->compare('entity',$this->entity);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('datatype',$this->datatype,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Detail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
