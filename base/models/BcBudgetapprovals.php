<?php

class BcBudgetapprovals extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bc_budgetapprovals';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('approver_id, decision,approver_level', 'required'),
			array('request,request,reallocation, approver_id,  approver_level, nextapprover_id, nextapprover_level, nextapprover_done', 'numerical', 'integerOnly'=>true),
			array('approverdate, nextapprover_role,approver_role, comments', 'safe'),
			array('approverdate','default', 'value'=>new CDbExpression('NOW()')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request, reallocation,approver_role,approver_id, decision, approverdate, comments, approver_level, nextapprover_id, nextapprover_role, nextapprover_level, nextapprover_done', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'request0' => array(self::BELONGS_TO, 'BcBudgetrequests', 'request'),
			'approverId0' => array(self::BELONGS_TO, 'Users', 'approver_id'),
			'nextapproverRole' => array(self::BELONGS_TO, 'Roles', 'nextapprover_role'),
			'nextapproverId0' => array(self::BELONGS_TO, 'Users', 'nextapprover_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request' => 'Request',
			'approver_id' => 'Approver',
			'decision' => 'Decision',
			'approverdate' => 'Approverdate',
			'comments' => 'Comments',
			'approver_level' => 'approver_level',
			'approver_role' => 'Approver Role',
			'nextapprover_id' => 'Nextapprover',
			'nextapprover_role' => 'Nextapprover Role',
			'nextapprover_level' => 'Nextapprover Level',
			'nextapprover_done' => 'Nextapprover Done',
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
		$criteria->compare('request',$this->request);
		$criteria->compare('approver_id',$this->approver_id);
		$criteria->compare('decision',$this->decision);
		$criteria->compare('approverdate',$this->approverdate,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('approver_role',$this->approver_role);
		$criteria->compare('approver_level',$this->approver_level);
		$criteria->compare('nextapprover_id',$this->nextapprover_id);
		$criteria->compare('nextapprover_role',$this->nextapprover_role);
		$criteria->compare('nextapprover_level',$this->nextapprover_level);
		$criteria->compare('nextapprover_done',$this->nextapprover_done);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BcBudgetapprovals the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
