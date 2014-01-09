<?php

Yii::import('application.extensions.*');


/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property integer $userId
 * @property string $title
 * @property string $boxFolderId
 * @property string $status
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Activity[] $activities
 * @property File[] $files
 * @property User $user
 * @property Tag[] $tags
 * @property User[] $users
 * @property Task[] $tasks
 */
class Project extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, title', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('title, boxFolderId, status', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, title, boxFolderId, status, created, modified', 'safe', 'on'=>'search'),
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
			'activities' => array(self::HAS_MANY, 'Activity', 'projectId'),
			'comments' => array(self::HAS_MANY, 'Activity', 'projectId', 'condition' => 'type="comment"'),
			'files' => array(self::HAS_MANY, 'File', 'projectId'),
			'discussions' => array(self::HAS_MANY, 'Discussion', 'projectId', 'order'=>'created DESC'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'invitedUser' => array(self::BELONGS_TO, 'User', 'invited_user'),
			'tags' => array(self::MANY_MANY, 'Tag', 'project_tag(projectId, tagId)'),
			'users' => array(self::MANY_MANY, 'User', 'project_user(projectId, userId)'),
			'tasks' => array(self::HAS_MANY, 'Task', 'projectId'),
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
			'title' => 'Title',
			'boxFolderId' => 'Box Folder',
			'status' => 'Status',
			'created' => 'Created',
			'modified' => 'Modified',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('boxFolderId',$this->boxFolderId,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Project the static model class
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

    public function afterSave()
    {
    	if ($this->isNewRecord)
        {   
            // create project user record
            $projectUser = new ProjectUser;
            $projectUser->projectId = $this->id;
            $projectUser->userId = Yii::app()->session['uid'];
            $projectUser->role = 'admin';

            if (!$projectUser->save())
            {
            	Yii::log(json_encode($projectUser->getErrors()), 'error', 'Project.afterSave');
            }
        }   

      /* 
        if (empty($this->boxFolderId))
        {   
            $box = new Box_API(Yii::app()->params['boxclientid'], Yii::app()->params['boxclientsecret'], 'n/a');

			if(!$box->load_token('protected/config/')){
				$box->get_code();
			}

            $resp = $box->create_folder($this->title, Yii::app()->params['boxfolderid']);

            if (isset($resp['id']))
            {
            	$this->setIsNewRecord(false);
            	$this->boxFolderId = $resp['id'];
            	$this->update();
            }
        }
          
    */
        return parent::afterSave();
    }

    public function isMemberOf()
    {
    	if (!Yii::app()->user->isGuest)
    	{
    		$member = ProjectUser::model()->findByAttributes(array('projectId' => $this->id, 'userId' => Yii::app()->user->id));

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
