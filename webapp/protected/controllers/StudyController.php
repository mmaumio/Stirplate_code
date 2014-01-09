<?php

class StudyController extends Controller
{
	public function beforeAction($action)
	{

		parent::beforeAction($action);

		$adminEmails = array('kgonzales@omnisci.org', 
			'kgonzales@gmail.com',
			'kgonzalesit@yahoo.com');

		$actionId = $action->id;
		
		if ($actionId == 'index')
		{
			if (!Yii::app()->user->isGuest)
			{
				$user = User::model()->findByPk(Yii::app()->user->id);

				if (in_array($user->email, $adminEmails)) return true;

				$member = Member::model()->findByAttributes(array('userId' => Yii::app()->user->id, 'studyId' => $_GET['id']));
				
				if ($member)
				{
					return true;
				}
				
				// Current user could be an admin which should have permission to look at the study itself
				// ToDo: Should the admin has access to modify?
				$allMembers = Member::model()->findAllByAttributes(array('studyId' => $_GET['id']));
				
				if (!empty($allMembers)) {
					// Lookup all the group members
					foreach ($allMembers as $studyMember) {
						$groupMembers = UserGroupMember::model()->findGroupMembers($studyMember->userId);
						if (!empty($groupMembers)) {
							foreach ($groupMembers as $groupMember) {
								if ($groupMember->userId === Yii::app()->user->id && $groupMember->isAdmin()) {
									return true;
								}	
							}
						}
					}
				}
				
				$this->redirect(array('study/invalid', 'retUrl' => '/study/index/' . $_GET['id']));
			}
			else
			{
				$this->redirect(array('study/invalid', 'retUrl' => '/study/index/' . $_GET['id']));
			}
		}
		else
		{
			return true;
		}
	}

	public function actionIndex()
	{
		$studyId = $_GET['id'];
		
		if (!empty($studyId))
		{
			// Load the study
			$study = Study::model()->findByPk($studyId);

			if ($study != null)
			{

				$tasks = $study->activeTasks; //Task::model()->findAllByAttributes(array('studyId' => $study->id));

				$groups = UserGroupMember::model()->findAllByAttributes(array('userId' => Yii::app()->session['uid']));
				$users = array();
				$collaborators = array();

				if ($study->users)
				{
					foreach ($study->users as $u)
					{
						$collaborators[$u->id] = true;
					}
				}

				if ($groups)
				{
					foreach ($groups as $group)
					{
						$usersOfGroup = UserGroupMember::model()->findAllByAttributes(array('groupId' => $group->groupId));

						foreach ($usersOfGroup as $u)
						{
							$user = User::model()->findByPk($u->userId);

							if ($user && $user->id != Yii::app()->session['uid'] && empty($users[$user->id]) && empty($collaborators[$user->id]))
							{
								$users[] = $user;
							}
						}
					}
				}

				$this->render('index', array('study' => $study, 'tasks' => $tasks, 'users' => $users));
				return;
			}
			else
			{
				Yii::log('No study found for id:' . $studyId, 'error', 'StudyController.index');
			}

		}

		//TODO: this should take you an error page saying study not found
		$this->redirect('/');
	}

	public function actionNew()
	{
		if (Yii::app()->user->isGuest) 
		{
			$this->redirect(array('auth/login'));
		}
		else
		{
			$study = new Study;
			$project = new Project2;
			$experiment = new Experiment;

			$this->render('new', array('study' => $study, 'project' => $project, 'experiment' => $experiment));
		}
	}
	
	/**
	 * Delete the study
	 * 
	 * RC	07/31/13	Initial Version
	 */
	public function actionDelete() 
	{
		$studyId = $_POST['id'];
		
		if (!empty($studyId))
		{
			// Load the study
			$study = Study::model()->findByPk($studyId);
					
			if (!$study->delete()) {
				// there was a problem saving the study
				Yii::log("Error deleting the study", 'error', 'StudyController.delete.studyDelete');
				Yii::log(json_encode($study->getErrors()), 'error', 'StudyController.delete.studyDelete');
			}
		}
		
		$this->redirect(array('study/list'));
	}
	
	/**
	 * Edit the study
	 * 
	 * Right now, it's only allowing it to update the title. We should be able
	 * to handle updating all the properties of the study from here
	 * 
	 * RC	07/31/13	Editing title only
	 */
	public function actionEdit() 
	{
		$studyId = $_POST['studyId'];
		$title = $_POST['title'];
		
		if (!empty($studyId) && !empty($title))
		{
			// Load the study
			$study = Study::model()->findByPk($studyId);
			
			// Update the database if the title is different
			if ($study->title !== $title) {
				$prevTitle = $study->title;
				
				$study->title = $title;
				if (!$study->save()) {
					// there was a problem saving the study
					Yii::log("Error updating the study", 'error', 'StudyController.update.studyEdit');
					Yii::log(json_encode($study->getErrors()), 'error', 'StudyController.update.studyEdit');
				} else {
					// create activity
					$activity = new Activity;
					$activity->studyId = $study->id;
					$activity->userId = Yii::app()->user->id;
					$activity->content = Yii::app()->user->name . ' renamed title from "' . $prevTitle . '" to "' . $study->title . '"';
					$activity->type = 'event';
					
					if(!$activity->save())
					{
						Yii::log("Error saving activity", 'error', 'StudyController.create.activitySave');
						Yii::log(json_encode($activity->getErrors()), 'error', 'StudyController.create.activitySave');
					}
				}
			}
		}
		
		$this->redirect(array('study/index', 'id' => $studyId));
	}
	
	public function actionCreate()
	{
		if (!empty($_POST['Study']))
		{
			$study = new Study;
			//$study->title = $_POST['title'];
			//$study->type = $_POST['type'];
			//$study->visibility = $_POST['visibility'];
			$study->attributes = $_POST['Study'];
			$study->ownerId = Yii::app()->user->id;
			$study->visibility = 'Private';

			if ($study->save()) 
			{
				//project saved, now add member record for user
				$member = new Member;
				$member->userId = Yii::app()->user->id;
				$member->studyId = $study->id;
				$member->role = 'admin';

				if (!$member->save()) 
				{
					Yii::log("Error saving member", 'error', 'StudyController.create.memberSave');
					Yii::log(json_encode($member->getErrors()), 'error', 'StudyController.create.memberSave');
				}

				// create project (optional)
				if(isset($_POST['Project']) && !empty($_POST['Project']['name']))
				{
					$project = new Project2;
					//$project->name = $_POST['projectName'];
					//$project->abstract="-";
					//$project->type = 'QPCR';
					$project->attributes = $_POST['Project'];
					//$project->technique = 'qPCR';
					if (empty($project->technique)) $project->technique = 'N/A';
					$project->studyId = $study->id;
					$project->ownerId = Yii::app()->user->id;

					if (!$project->save()) 
					{
						Yii::log("Error saving project", 'error', 'StudyController.create.projectSave');
						Yii::log(json_encode($project->getErrors()), 'error', 'StudyController.create.projectSave');
					}
					else
					{
						if (isset($_POST['Experiment']) && !empty($_POST['Experiment']['name']))
						{
							$experiment = new Experiment;
							$experiment->attributes = $_POST['Experiment'];
							if (empty($experiment->type)) $experiment->type = 'Other';
							$experiment->projectId = $project->id;

							if (!$experiment->save())
							{
								Yii::log("Error saving experiment", 'error', 'StudyController.create.experimentSave');
								Yii::log(json_encode($experiment->getErrors()), 'error', 'StudyController.create.experimentSave');
							}
						}
					}
				}

				// create activity
				$activity = new Activity;
				$activity->studyId = $study->id;
				$activity->userId = Yii::app()->user->id;
				$activity->content = Yii::app()->user->name . ' created study "' . $study->title . '"';
				$activity->type = 'event';

				if(!$activity->save())
				{
					Yii::log("Error saving activity", 'error', 'StudyController.create.activitySave');
					Yii::log(json_encode($activity->getErrors()), 'error', 'StudyController.create.activitySave');
				}

				$event = new SystemEvent;
                $event->userId = Yii::app()->user->id;
                $event->type = 'create_study';
                $event->description = $study->title;

                if (!$event->save())
                {
                    YII::log(json_encode($event->getErrors()), 'error', 'StudyController.actionCreate');
                }

				if (isset($experiment))
				{
					$this->redirect(array('experiment/index', 'id' => $experiment->id));
				}
				else if (isset($project))
				{
					$this->redirect(array('project/index', 'id' => $project->id));
				}
				else
				{
					$this->redirect(array('study/index', 'id' => $study->id));	
				}

			}
			else
			{
				// there was a problem saving the study
				Yii::log("Error saving study", 'error', 'StudyController.create.studySave');
				Yii::log(json_encode($study->getErrors()), 'error', 'StudyController.create.studySave');
				$this->render('new');
			}
		}
		else
		{
			// re-render create page with validation errors
			$this->render('new');
		}
	}

	/**
	 * Get a list of studies by the user
	 * 
	 * 08/05/13	RC	Loads the list by user Id (either passed in or current user)
	 */
	public function actionList()
	{
		$studies = array();
		
		// Get the user id
		if (!empty($_GET['id'])) {
			$userId = $_GET['id'];
		} else {
			$userId = Yii::app()->user->id;
		}
			
		if (!empty($userId)) {
			$members = Member::model()->findAllStudies($userId);
				
			foreach ($members as $member) { 
				$studies[] = $member->study;
			}
		}
		
		$this->render('list', array('studies' => $studies));
	}
	
	public function actionInvalid() 
	{
		if (Yii::app()->user->isGuest)
		{
			$this->redirect('/login' . (!empty($_GET['retUrl']) ? '?retUrl=' . $_GET['retUrl'] : ''));
		}
		else
		{
			$this->render('notFound');
		}
	}
}