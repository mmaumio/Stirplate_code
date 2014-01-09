<?php

/**
 * This is the model class for table "invitation".
 *
 * The followings are the available columns in table 'invitation':
 * @property integer $id
 * @property integer $invitingUserId
 * @property string $invitedEmail
 * @property string $guid
 * @property integer $studyId
 * @property string $status
 * @property string $created
 * @property string $accepted
 *
 * The followings are the available model relations:
 * @property Study $study
 * @property User $invitingUser
 */
class Invitation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invitation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invitation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invitingUserId, invitedEmail, guid, studyId, status, created', 'required'),
			array('invitingUserId, studyId', 'numerical', 'integerOnly'=>true),
			array('invitedEmail, guid, status', 'length', 'max'=>255),
			array('accepted', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, invitingUserId, invitedEmail, guid, studyId, status, created, accepted', 'safe', 'on'=>'search'),
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
			'study' => array(self::BELONGS_TO, 'Study', 'studyId'),
			'invitingUser' => array(self::BELONGS_TO, 'User', 'invitingUserId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invitingUserId' => 'Inviting User',
			'invitedEmail' => 'Invited Email',
			'guid' => 'Guid',
			'studyId' => 'Study',
			'status' => 'Status',
			'created' => 'Created',
			'accepted' => 'Accepted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('invitingUserId',$this->invitingUserId);
		$criteria->compare('invitedEmail',$this->invitedEmail,true);
		$criteria->compare('guid',$this->guid,true);
		$criteria->compare('studyId',$this->studyId);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('accepted',$this->accepted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}