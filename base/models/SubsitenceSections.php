<?php

/**
 * This is the model class for table "subsitence_sections".
 *
 * The followings are the available columns in table 'subsitence_sections':
 * @property integer $id
 * @property string $section
 * @property integer $parent
 *
 * The followings are the available model relations:
 * @property Subsistence[] $subsistences
 * @property Subsistence[] $subsistences1
 * @property SubsitenceSections $parent0
 * @property SubsitenceSections[] $subsitenceSections
 */
class SubsitenceSections extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subsitence_sections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent', 'numerical', 'integerOnly'=>true),
			array('section', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, section, parent', 'safe', 'on'=>'search'),
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
			'subsistences' => array(self::HAS_MANY, 'Subsistence', 'section'),
			'subsistences1' => array(self::HAS_MANY, 'Subsistence', 'subsection'),
			'parent0' => array(self::BELONGS_TO, 'SubsitenceSections', 'parent'),
			'subsitenceSections' => array(self::HAS_MANY, 'SubsitenceSections', 'parent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'section' => 'Section',
			'parent' => 'Parent',
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
		$criteria->compare('section',$this->section,true);
		$criteria->compare('parent',$this->parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubsitenceSections the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
