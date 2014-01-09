<?php

class ActivityController extends Controller
{
	public function actionCreate()
	{
		// echo "1";
		if (!empty($_POST['activity']))
		{
			// echo "2";
			$activity = new Activity;
			
			$activity->attributes=$_POST['activity'];

			$activity->userId = Yii::app()->session['uid'];
			// echo "3";
			// print_r($activity);
			if ($activity->save())
			{
				$obj = array();
				$obj['study'] = Project::model()->findByPk($_POST['activity']['projectId']);
				$obj['activity'] = $activity;
				$obj['author'] = User::model()->findByPk($activity->userId);
				$criteria = new CDbCriteria();
				$criteria->condition = "projectId =:projectId";
				$criteria->params = array(':projectId' => $_POST['activity']['projectId']);
				if (strpos($_POST['activity']['content'],'@') !== false) {
					$pattern = '/@([a-zA-Z]+)/';
					preg_match_all ($pattern, $_POST['activity']['content'], $matches);
					foreach ($matches[1] as $firstName) {
						$user = User::model()->findByAttributes(array('firstName' => $firstName));
						if ($user) {
							Notification::sendEmail('newActivity', $user, $obj);
							$activity->content =  str_replace("@$firstName", "<a href='#'>@$firstName</a>", $_POST['activity']['content']);
							$activity->save();
							// echo str_replace($firstName, '<a href="#">'.$firstName.'</a>', $_POST['activity']['content']);
						}
					}
				}else{
					$users  = ProjectUser::model()->findAll($criteria);
					$my_users  = array();
					foreach ($users as $user) {
						array_push($my_users, User::model()->findByPk($user->userId));
					}
					Notification::sendEmailBluk('newActivity', $my_users, $obj);
					
				}
				$this->redirect(array('project/index', 'id' => $activity->projectId));
			}
			else
			{
				Yii::log("Error saving activity", 'error', 'ActivityController.create');
				Yii::log(json_encode($activity->getErrors()), 'error', 'ActivityController.create');

				$this->redirect(array('study/index', 'id' => $activity->studyId));
			}
		}
		else
		{
			Yii::log("Error saving activity", 'error', 'ActivityController.create');

		}
	}

	public function actionAjaxCreate()
	{

		$respArray = array();

		if (!empty($_POST['activity']))
		{

			$study = Study::model()->findByPk($_POST['activity']['studyId']);

			if ($study)
			{
				$activity = new Activity;

				$activity->attributes=$_POST['activity'];

				$activity->userId = Yii::app()->user->id;

				if (!empty($_POST['activity']['relatedObjectType']) && !empty($_POST['activity']['relatedObjectId']))
				{
					if ($_POST['activity']['relatedObjectType'] === 'project')
					{
						$project = Project2::model()->findByPk($_POST['activity']['relatedObjectId']);
					}
					else if ($_POST['activity']['relatedObjectType'] === 'experiment')
					{
						$experiment = Experiment::model()->findByPk($_POST['activity']['relatedObjectId']);
					}
				}

				if ($activity->save())
				{
					$respArray['status'] = 'OK';
					if (isset($activity->parentActivityId))
					{
						// it's a reply
						$replyDate = new DateTime(date('Y-m-d H:i:s'));
						$respArray['parentId'] = $activity->parentActivityId;
						$respArray['html'] = $this->renderPartial('_reply', array('study' => $activity->study, 'project' => isset($project) ? $project : null, 'experiment' => isset($experiment) ? $experiment : null, 'reply' => $activity, 'replyDate' => $replyDate), true);
					}	
					else
					{
						$activity->created = date('Y-m-d H:i:s');
						$respArray['html'] = $this->renderPartial('_comment', array('study' => $activity->study, 'project' => isset($project) ? $project : null, 'experiment' => isset($experiment) ? $experiment : null, 'activity' => $activity), true);
					}

					$members = Member::model()->findAllByAttributes(array('studyId' => $study->id));

					if ($members)
					{
						$author = User::model()->findByPk(Yii::app()->user->id);

						foreach ($members as $member)
						{
							if ($member->userId != Yii::app()->user->id)
							{
								$user = User::model()->findByPk($member->userId);

								if ($user)
								{
									$obj = array();
									$obj['study'] = $study;
									$obj['activity'] = $activity;
									$obj['author'] = $author;
									Notification::sendEmail('newActivity', $user, $obj);
								}
							}
						}
					}
				}
				else
				{
					Yii::log("Error saving activity", 'error', 'ActivityController.create');
					Yii::log(json_encode($activity->getErrors()), 'error', 'ActivityController.create');

					$respArray['status'] = 'ERROR - unable to save activity';
				}
			}
		}
		else
		{
			Yii::log("Error saving activity", 'error', 'ActivityController.create');

			$respArray['status'] = 'ERROR - no activity provided';

		}

		$resp = json_decode(json_encode($respArray), false);

		$this->_sendResponse(200, json_encode($resp));

	}

	public function actionAjaxDelete()
	{

		$respArray = array();

		if (!empty($_POST['activityId']))
		{
			$activity = Activity::model()->findByPk($_POST['activityId']);

			if ($activity && $activity->userId === Yii::app()->user->id)
			{
				if ($activity->delete())
				{
					$respArray['status'] = 'OK';	
				}
				else
				{
					Yii::log("Error deleting activity", 'error', 'ActivityController.delete');
					Yii::log(json_encode($activity->getErrors()), 'error', 'ActivityController.delete');

					$respArray['status'] = 'ERROR - unable to delete activity';
				}
			}
		}
		else
		{
			Yii::log("Error deleting activity", 'error', 'ActivityController.delete');

			$respArray['status'] = 'ERROR - no activity provided';

		}

		$resp = json_decode(json_encode($respArray), false);

		$this->_sendResponse(200, json_encode($resp));

	}

}