<?php

/**
 * This is the model class for table "attachment".
 *
 * The followings are the available columns in table 'attachment':
 * @property integer $id
 * @property string $name
 * @property string $ext
 * @property string $urlLink
 * @property string $iconLink
 * @property string $thumbnailLink
 * @property integer $userId
 * @property string $created
 * @property string $modified
 * @property integer $studyId
 * @property integer $projectId
 * @property integer $experimentId
 *
 * The followings are the available model relations:
 * @property Study $study
 * @property User $user
 */
class AttachmentDB extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Attachment the static model class
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
		return 'attachment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, ext, urlLink, userId', 'required'),
			array('userId, studyId, projectId, experimentId', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('ext', 'length', 'max'=>32),
			array('urlLink, iconLink, thumbnailLink', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, ext, urlLink, iconLink, thumbnailLink, userId, created, modified, studyId, projectId', 'safe', 'on'=>'search'),
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
			'project' => array(self::BELONGS_TO, 'Project', 'projectId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'experiment' => array(self::BELONGS_TO, 'Experiment', 'experimentId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'ext' => 'Ext',
			'urlLink' => 'Url Link',
			'iconLink' => 'Icon Link',
			'thumbnailLink' => 'Thumbnail Link',
			'userId' => 'User',
			'created' => 'Created',
			'modified' => 'Modified',
			'studyId' => 'Study',
			'projectId' => 'Project',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('urlLink',$this->urlLink,true);
		$criteria->compare('iconLink',$this->iconLink,true);
		$criteria->compare('thumbnailLink',$this->thumbnailLink,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('studyId',$this->studyId);
		$criteria->compare('projectId',$this->projectId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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