<?php

/**
 * This is the model class for table "bc_budgetrequests".
 *
 * The followings are the available columns in table 'bc_budgetrequests':
 * @property integer $id
 * @property string $subject
 * @property string $justification
 * @property string $requestdate
 * @property string $requireddate
 * @property integer $requestor
 * @property integer $budget
 *
 * The followings are the available model relations:
 * @property Users $requestor0
 * @property Budgets $budget0
 */
class BcBudgetrequests extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bc_budgetrequests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.

		return array(
			array('accountcode,ppform,requireddate,subject,justification', 'required'),
			array('requestor, section,accountcode,budget', 'numerical', 'integerOnly'=>true),
			array('subject,justification,ppform', 'length', 'max'=>255),
			array('budget','default','value'=>budget()),
			array('requestor','default','value'=>user()->id),
			array('section','default','value'=>user()->dept['id']),			
			array('requestdate','default', 'value'=>new CDbExpression('NOW()')),
			//array('dateadded','default', 'value'=>new CDbExpression('NOW()')),
			array('requireddate','default', 'value'=>new CDbExpression('NOW()')),
			array('updated_at','default', 'value'=>new CDbExpression('NOW()')),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, updated_at,ppform,accountcode,section,subject, justification, requestdate, requireddate, requestor, budget', 'safe', 'on'=>'search'),
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
			'requestor0' => array(self::BELONGS_TO, 'Users', 'requestor'),
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
			'accountcode0' => array(self::BELONGS_TO, 'Accountcodes', 'accountcode'),
			'section0' => array(self::BELONGS_TO, 'Sections', 'section'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ppform' => 'Procurement Form',
			'subject' => 'Subject',
			'justification' => 'Justification',
			'requestdate' => 'Request Date',
			'requireddate' => 'Date Required',
			'requestor' => 'Requestor',
			'budget' => 'Budget',
			'section' => 'Section',
			'updated_at' => 'Updated At',
			'accountcode' => 'Account Code'
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
	public function q() {
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM v_ba1 where decision is null and (approverid='.user()->id.' or section='.user()->dept[id].")")->queryScalar();
		$sql='SELECT * FROM v_ba1 where decision is null and (approverid='.user()->id.' or section='.user()->dept[id].")";
		$dataProvider=new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
		    'sort'=>array(
		        'attributes'=>array(
		             'requestid', 'requestdate', 'requireddate',
		        ),
		    ),
		    'pagination'=>array('pageSize'=>10),
		));
		return $dataProvider;
	}
	public function rejected_query() {
		$count=Yii::app()->db->createCommand("SELECT count(*) from bc_budgetrequests where budget=".budget()." and id in (select request FROM `bc_budgetapprovals` where decision='REJECT') order by id desc")->queryScalar();
		$sql="SELECT * from bc_budgetrequests where budget=".budget()." and id in (select request FROM `bc_budgetapprovals` where decision='REJECT') order by id desc";
		$dataProvider=new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
		    'sort'=>array(
		        'attributes'=>array('id'),
		    ),
		    'pagination'=>array('pageSize'=>100),
		));
		return $dataProvider;
	}
	
	public function rejected()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition ="id in (select request FROM `bc_budgetapprovals` where decision='REJECT')";
		$criteria->compare('budget',budget());
		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>array('pageSize'=>100)
		));
	}
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('justification',$this->justification,true);
		$criteria->compare('requestdate',$this->requestdate,true);
		$criteria->compare('requireddate',$this->requireddate,true);
		$criteria->compare('requestor',user()->id);
		$criteria->compare('budget',$this->budget);
		$criteria->order='id desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>array('pageSize'=>20)
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
