<?php

/**
 * This is the model class for table "data_set".
 *
 * The followings are the available columns in table 'data_set':
 * @property integer $id
 * @property integer $experimentId
 * @property string $tableName
 * @property string $type
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property ColumnMapping[] $columnMappings
 * @property Experiment $experiment
 */
class DataSet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'data_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('experimentId, tableName, type', 'required'),
			array('experimentId', 'numerical', 'integerOnly'=>true),
			array('tableName', 'length', 'max'=>128),
			array('type', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, experimentId, tableName, type, created, modified', 'safe', 'on'=>'search'),
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
			'columnMappings' => array(self::HAS_MANY, 'ColumnMapping', 'dataSetId'),
			'experiment' => array(self::BELONGS_TO, 'Experiment', 'experimentId'),
			'owner' => array(self::BELONGS_TO, 'User', 'ownerId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'experimentId' => 'Experiment',
			'tableName' => 'Table Name',
			'type' => 'Type',
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
		$criteria->compare('experimentId',$this->experimentId);
		$criteria->compare('tableName',$this->tableName,true);
		$criteria->compare('type',$this->type,true);
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
	 * @return DataSet the static model class
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
    
    public function beforeDelete(){
        Yii::app()->db->createCommand()->dropTable($this->tableName);
        return TRUE;
        }
    
}
