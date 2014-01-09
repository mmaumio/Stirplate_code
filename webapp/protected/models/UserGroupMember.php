<?php

/**
 * This is the model class for table "user_group_member".
 *
 * The followings are the available columns in table 'user_group_member':
 * @property integer $groupId
 * @property integer $userId
 * @property string $role
 * @property string $created
 * @property string $modified
 */
class UserGroupMember extends CActiveRecord
{
	const USER_ADMIN = 'admin';
	const USER_NORMAL = 'user';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserGroupMember the static model class
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
		return 'user_group_member';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('groupId, userId', 'required'),
			array('groupId, userId', 'numerical', 'integerOnly'=>true),
			array('role', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('groupId, userId, role, created, modified', 'safe', 'on'=>'search'),
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
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'groupId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'groupId' => 'Group',
			'userId' => 'User',
			'role' => 'Role',
			'created' => 'Created',
			'modified' => 'Modified',
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

		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Check to see if the user is an admin
	 * 
	 * 08/04/13	RC	Initial version
	 * 08/19/13 RC	Change to compare with a constant
	 */
	public function isAdmin() {
		if (strtolower($this->role) === self::USER_ADMIN) {
			return true;
		}
		
		return false;
	}
	
	private static function _newUser($groupId, $userId, $role) {
		$groupMember = new UserGroupMember;
		$groupMember->groupId = $groupId;
		$groupMember->userId = $userId;
		$groupMember->role = $role;
		$groupMember->modified = new CDbExpression('UTC_TIMESTAMP()');
		$groupMember->created = new CDbExpression('UTC_TIMESTAMP()');
		return $groupMember;	
	}
	
	public static function newMember($groupId, $userId) {
		return UserGroupMember::model()->_newUser($groupId, $userId, self::USER_NORMAL);
	}
	
	public static function newAdmin($groupId, $userId) {
		return UserGroupMember::model()->_newUser($groupId, $userId, self::USER_ADMIN);
	}
	
	/**
	 * Find all the group members
	 * 
	 * If user is admin, return all members in the group
	 * otherwise, return null
	 * 
	 * 08/04/13	RC	Returns group members
	 */
	public function findGroupMembers($userId) {
				
		// Use the user Id to find the group the user belongs to
		// Does not support user belongs in multiple groups!!
		if (!empty($userId)) {
			$userGroupMember = parent::findByAttributes(array('userId'=>$userId));
			
			if (!empty($userGroupMember) && $userGroupMember->isAdmin()) {
				return $userGroupMember->userGroup->members;
			} else {
				//Yii::log($userId . ' is not an admin', 'info', 'findGroupMembers.UserGroupMember');
				if (!empty($userGroupMember)) {
					//Yii::log($userId . ' belongs to group ' . $userGroupMember->userGroup->id, 'info', 'findGroupMembers.UserGroupMember');	
				} else {
					//Yii::log($userId . ' does not belong to any group ', 'info', 'findGroupMembers.UserGroupMember');
				}

			}
		} else {
			Yii::log("Undefined user id:" . $userId, 'info', 'findGroupMembers.UserGroupMember');
		}
		
		return null;
	}
	
	/**
	 * Find all the groups
	 * 
	 * 08/04/13	RC	Returns groups
	 */
	public function findGroupsByUserId($userId) {
				
		// Use the user Id to find the group the user belongs to
		// Does not support user belongs in multiple groups!!
		if (!empty($userId)) {
			$userGroupMembers = parent::findAllByAttributes(array('userId'=>$userId));
						
			if (!empty($userGroupMembers)) {
				$groups = array();
						
				foreach($userGroupMembers as $member){
					if ($member->isAdmin()) {
						$groups[] = $member->userGroup;
					}
				}
				return $groups;
			} else {
				Yii::log($userId . ' is not an admin', 'info', 'findGroupMembers.UserGroupMember');
			}
		} else {
			Yii::log("Undefined user id:" . $userId, 'info', 'findGroupMembers.UserGroupMember');
		}
		
		return null;
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