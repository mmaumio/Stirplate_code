<?php

/**
 * This is the model class for table "activity".
 *
 * The followings are the available columns in table 'activity':
 * @property integer $id
 * @property integer $userId
 * @property integer $projectId
 * @property integer $fileId
 * @property integer $taskId
 * @property integer $parentActivityId
 * @property string $content
 * @property string $type
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Project $project
 * @property File $file
 * @property Task $task
 * @property Activity $parentActivity
 * @property Activity[] $activities
 */
class Activity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, projectId', 'required'),
			array('userId, projectId, fileId, taskId, parentActivityId', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, projectId, fileId, taskId, parentActivityId, content, type, created, modified', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'inviter_user' => array(self::BELONGS_TO, 'User', 'relatedObjectId'),
			'project' => array(self::BELONGS_TO, 'Project', 'projectId'),
			'file' => array(self::BELONGS_TO, 'File', 'fileId'),
			'task' => array(self::BELONGS_TO, 'Task', 'taskId'),
			'parentActivity' => array(self::BELONGS_TO, 'Activity', 'parentActivityId'),
			'activities' => array(self::HAS_MANY, 'Activity', 'parentActivityId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'User',
			'studyId' => 'Study',
			'fileId' => 'File',
			'taskId' => 'Task',
			'parentActivityId' => 'Parent Activity',
			'content' => 'Content',
			'type' => 'Type',
			'created' => 'Created',
			'modified' => 'Modified',
			'projectId' => 'Project',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('studyId',$this->studyId);
		$criteria->compare('fileId',$this->fileId);
		$criteria->compare('taskId',$this->taskId);
		$criteria->compare('parentActivityId',$this->parentActivityId);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('projectId',$this->projectId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Activity the static model class
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
    
        $this->modified = new CDbExpression('UTC_TIMESTAMP()');
    
        return parent::beforeSave();
    }
}
