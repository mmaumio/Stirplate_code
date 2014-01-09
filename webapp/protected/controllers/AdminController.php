    <?php

class AdminController extends Controller
{

	public function beforeAction($action)
	{
		$adminEmails = array('kgonzales@omnisci.org' ,
			's@hotmail.com', 
			'kgonzales@omnisci.org', 
			'kgonzales@gmail.com',
			'kgonzalesit@yahoo.com');

		if (!Yii::app()->user->isGuest)
		{
			$currentUser = User::model()->findByPk(Yii::app()->user->id);

			if (in_array($currentUser->email, $adminEmails))
			{
				return true;
			}
		}

		$this->redirect('/');
	}

	public function actionIndex()
	{
		$user = new User;
		$group = new UserGroup;
		$groups = UserGroup::model()->findAll();

		$groupOptions = array();
		$groupOptions[''] = '---';

		foreach ($groups as $g)
		{
			$groupOptions[$g->id] = $g->name;
		}

		$this->render('index', array('user' => $user, 'group' => $group, 'groups' => $groupOptions));

		return;
	}

	public function actionUsers()
	{
		$users = User::model()->findAll();
		$groups = UserGroup::model()->findAll();
		$events = SystemEvent::model()->findAllByAttributes(array('type' => 'login'), new CDbCriteria(array('order' => 'id DESC')));
		
		$groupOptions = array();
		$groupOptions[''] = '---';

		foreach ($groups as $g)
		{
			$groupOptions[$g->id] = $g->name;
		}

		$lastLogins = array();

		foreach ($events as $e)
		{
			if (!isset($lastLogins[$e->userId]))
			{
				$lastLogins[$e->userId] = $e->created;
			}
		}

		$this->render('users', array('users' => $users, 'groups' => $groupOptions, 'lastLogins' => $lastLogins));
	}

	public function actionAddUser()
	{
		if (isset($_POST['User']))
		{
			$user = new User;
			$user->attributes = $_POST['User'];

			$user->password = User::hashPassword($_POST['User']['password']);

			if ($user->save())
			{
				if (isset($_POST['user_group']))
				{
					//Yii::log("user_group" . $_POST['user_group'], 'error');
					$group = UserGroup::model()->findByPk($_POST['user_group']);

					if ($group)
					{
						$member = new UserGroupMember;
						$member->groupId = $group->id;
						$member->userId = $user->id;
						$member->role = $_POST['user_group_role'];

						if (!$member->save())
						{
							Yii::log(json_encode($member->getErrors()), 'error', 'AdminController.actionaddUser');
						}
					}
				}
				$this->redirect(array('user/publicProfile', 'id' => $user->id));
			}
			else
			{
				$this->render('index', array('user' => $user));
			}
		}
	}

	public function actionAddGroup()
	{
		if (isset($_POST['UserGroup']))
		{
			$group = new UserGroup;
			$group->attributes = $_POST['UserGroup'];
			$group->ownerId = Yii::app()->user->id;

			if ($group->save())
			{
				$this->redirect(array('admin/index'));
			}
			else
			{
				$this->render('index', array('group' => $group));
			}
		}
	}

	public function actionAddUserToGroup()
	{
		if (!empty($_POST['group']) && !empty($_POST['userId']))
		{
			$existing = UserGroupMember::model()->findByAttributes(array('userId' => $_POST['userId'], 'groupId' => $_POST['group']));

			if (!$existing)
			{
				$member = new UserGroupMember;
				$member->userId = $_POST['userId'];
				$member->groupId = $_POST['group'];
				$member->role = $_POST['role'];

				if (!$member->save())
				{
					Yii::log(json_encode($member->getErrors()), 'error', 'AdminController.AddUserToGroup');
				}
			}
			else
			{
				Yii::log("User " . $_POST['userId'] . " is already a member of group " . $_POST['group'], 'error', 'AdminController.AddUserToGroup');
			}
		}

		$this->redirect('/admin/users');
	}

	public function actionDeleteUser()
	{
		if (!empty($_GET['id']))
		{
			$user = User::model()->findByPk($_GET['id']);

			if ($user)
			{
				if (!$user->delete())
				{
					Yii::log(json_encode($user->getErrors()), 'error', 'AdminController.actionDeleteUser');
				}
			}
		}

		$this->redirect(array('admin/users'));
	}

}