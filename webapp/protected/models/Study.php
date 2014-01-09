<?php

/**
 * This is the model class for table "study".
 *
 * The followings are the available columns in table 'study':
 * @property integer $id
 * @property integer $ownerId
 * @property string $title
 * @property string $type
 * @property string $visibility
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property Project[] $projects
 * @property User $owner
 */
class Study extends CActiveRecord
{

		public static $VISIBILITY_VALUES = array(
		'Public'=>'Public',
		'Private'=>'Private',
		);
	
	public static $TYPE_VALUES = array(
		'Reagents'=>'Reagents or Methods Tests',
		'Preliminary'=>'Preliminary Study',
		'Full' => 'Full Study'
		);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'study';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ownerId', 'required'),
			array('ownerId', 'numerical', 'integerOnly'=>true),
			array('title, type, visibility', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ownerId, title, type, visibility, created, updated', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Member', 'studyId'),
			'users' => array(self::MANY_MANY, 'User', 'member(studyId, userId)'),
			'projects' => array(self::HAS_MANY, 'Project2', 'studyId'),
			'tasks' => array(self::HAS_MANY, 'Task', 'studyId'),
			'activeTasks' => array(self::HAS_MANY, 'Task', 'studyId', 'condition' => 'status!=\'complete\''),
			'owner' => array(self::BELONGS_TO, 'User', 'ownerId'),
			'activities' => array(self::HAS_MANY, 'Activity', 'studyId', 'order'=>'created DESC')
		);
	}
	
	/**
	 * Check to see if the study is public or private
	 * 
	 * 07/27/13	RKC	Initial version
	 */
	public function isPublic() {
		if (strtoupper($this->visibility) == 'PUBLIC') {
			return true;
		}
		
		return false;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ownerId' => 'Owner',
			'title' => 'Title',
			'type' => 'Type',
			'visibility' => 'Visibility',
			'created' => 'Created',
			'updated' => 'Updated',
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
		$criteria->compare('ownerId',$this->ownerId);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('visibility',$this->visibility,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Study the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {   
        if ($this->isNewRecord)
        {   
            $this->created = new CDbExpression('UTC_TIMESTAMP()');
        }   
    
        $this->updated = new CDbExpression('UTC_TIMESTAMP()');
    
        return parent::beforeSave();
    }

    public function isAdmin()
    {
    	if (Yii::app()->session['uid'])
    	{
    		$admin = Member::model()->findByAttributes(array('studyId' => $this->id, 'userId' => Yii::app()->session['uid'], 'role' => 'admin'));

    		if ($admin)
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    }

    public function isMemberOf()
    {
    	if (Yii::app()->session['uid'])
    	{
    		$member = Member::model()->findByAttributes(array('studyId' => $this->id, 'userId' => Yii::app()->session['uid']));

    		if ($member)
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    }
}
