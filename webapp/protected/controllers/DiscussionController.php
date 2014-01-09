<?php

class DiscussionController extends Controller
{
	public function actionAjaxCreate()
	{

		$respArray = array();

		if (!empty($_POST['activity']) && !empty($_POST['activity']['projectId']))
		{

			$project = Project::model()->findByPk($_POST['activity']['projectId']);

			$activity = new Discussion;

			$activity->attributes=$_POST['activity'];

			$activity->userId = Yii::app()->user->id;

			if ($activity->save())
			{
				$respArray['status'] = 'OK';

				if (isset($activity->parentActivityId))
				{
					// it's a reply
					$replyDate = new DateTime(date('Y-m-d H:i:s'));
					$respArray['parentId'] = $activity->parentActivityId;
					$respArray['html'] = $this->renderPartial('_reply', array('project' =>$project, 'reply' => $activity, 'replyDate' => $replyDate), true);
				}	
				else
				{
					$activity->created = date('Y-m-d H:i:s');
					$respArray['html'] = $this->renderPartial('_comment', array('project' => $project, 'activity' => $activity), true);
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
			$activity = Discussion::model()->findByPk($_POST['activityId']);

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