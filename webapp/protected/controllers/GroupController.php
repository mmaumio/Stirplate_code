<?php

class GroupController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	 /*
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','accept'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','new','list','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	  * */
	
	public function actionNew()
	{
		if (Yii::app()->user->isGuest) 
		{
			$this->redirect(array('auth/login'));
		}
		else
		{
			$group = new UserGroup;
			$groupMember = new UserGroupMember;
			$this->render('new', array('group' => $group, 'groupMember' => $groupMember));
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (isset($_POST['UserGroup'])) {
						
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
	
			$model=new UserGroup;
			$model->attributes= $_POST['UserGroup'];
			$model->ownerId=Yii::app()->user->id;
			
			
			if($model->save()) {
				
				// Now see if we need to handle any members associated with this group
				$members = count($_POST['groupMembers']) ? $_POST['groupMembers'] : array();
				$admins = count($_POST['groupAdmin']) ? $_POST['groupAdmin'] : array();
				
				foreach ($members as $key => $member) {
					
					// Lookup the user by the name
					$user = User::model()->findUser($member);
					
					// Send invitation for pending user
					if ($user->isPending()) {
						// Send invitation
						$user->sendInvitationEmail($model, 'groupInvitation');
					}
					
					$isAdmin = 0;
					if (isset($admins[$key]) && ($admins[$key] === "admin")) {
						$isAdmin = 1;
					}
					// Associate the user with the group
					if ($user->id === Yii::app()->user->id || $isAdmin) {
						$groupMember = UserGroupMember::model()->newAdmin($model->id, $user->id);
					} else {
						$groupMember = UserGroupMember::model()->newMember($model->id, $user->id);
					}
					
					//$groupMember = new UserGroupMember;
					//$groupMember->groupId = $model->id;
					//$groupMember->userId = $user->id;
					//$groupMember->role = "USER";
					//$groupMember->modified = new CDbExpression('UTC_TIMESTAMP()');
					//$groupMember->created = new CDbExpression('UTC_TIMESTAMP()');
					
					if ($groupMember->save()) {
						
					} else {
						Yii::log("Error saving user group member", 'error', 'GroupController.create.groupSave');
						Yii::log(json_encode($groupMember->getErrors()), 'error', 'GroupController.create.groupSave');	
					}
				}
			  
				
				
				//$this->redirect(array('index','id'=>$model->id));
				
				$this->render('new', array('group' => $model));

				return;
			} else {
				Yii::log("Error saving user group", 'error', 'GroupController.create.groupSave');
				Yii::log(json_encode($model->getErrors()), 'error', 'GroupController.create.groupSave');
			}

		} else {
			$group = new UserGroup;
			$this->render('new', array('group' => $group));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			Yii::log(json_encode($_POST['User']), 'error');
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAccept()
	{
		if (!empty($_GET['guid']))
		{
			$user = User::model()->findPendingUserByGuid($_GET['guid']);
			if(!$user)
			{
				$this->render('/collaboration/invalidInvitation');
				return;
			}

			if($user->isPending())
			{
				$this->render('/collaboration/accept',array('guid'=>$_GET['guid'],'email'=>$user->email));
			}
			else
			{
				$identity = new UserIdentity($user->id, $user->firstName, $user->profileImageUrl);

				if ($identity->authenticate())
				{
					$duration = 3600 * 24 * 30; // 30 day
					Yii::app()->user->login($identity,$duration);
					$this->redirect('study/list');
				}
			}
		}
		else
		{
			//TODO: log error
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if (isset($_POST["id"])) {
			$id = $_POST['id'];
			
			$userGroup = UserGroup::model()->findByPk($id);
						
			if (!$userGroup->delete()) {
				Yii::log("Error deleting group", 'error', 'GroupController.delete.groupDelete');
				Yii::log(json_encode($userGroup->getErrors()), 'error', 'GroupController.delete.groupDelete');
			}
		}
		$this->redirect('list');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_GET['id']))
		{
			$groupId = $_GET['id'];
			
			// Load the group
			$group = UserGroup::model()->findByPk($groupId);
			
			if (isset($group))
			{
				$this->render('index', array('group' => $group));
				return;
			}
			else
			{
				Yii::log('No group found for id:' . $groupId, 'error', 'GroupController.index');
			}

		}

		//TODO: this should take you an error page saying study not found
		$this->redirect('/site');
	}

	/**
	 * Get a list of studies by the user
	 * 
	 * 08/05/13	RC	Loads the list by user Id (either passed in or current user)
	 */
	public function actionList()
	{
		$groups = array();
		
		// Get the user id
		if (!empty($_GET['id'])) {
			$userId = $_GET['id'];
		} else {
			$userId = Yii::app()->user->id;
		}
			
		if (!empty($userId)) {
			
			$groups = UserGroup::model()->findAllByAttributes(array('ownerId'=>$userId));
		}
		
		$this->render('list', array('groups' => $groups));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
