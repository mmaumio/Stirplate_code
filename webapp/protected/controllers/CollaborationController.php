<?php
Yii::import('application.extensions.*');
require_once("Guid.php");
require_once('facebook/facebook.php');

class CollaborationController extends Controller
{
	public function actionAdd()
	{
		
		if (!empty($_POST['invitedEmailOrName']) && !empty($_POST['studyId']) && !empty($_POST['role']))
		{
			$invitedEmailOrName = $_POST['invitedEmailOrName'];
			$studyId = $_POST['studyId'];
			$role = $_POST['role'];
			$study = Study::model()->findByPk($studyId);
			
			$collaborator = User::model()->findByAttributes(array('email'=>$invitedEmailOrName));
			
			if(!$collaborator)
			{
				$invitedEmailOrNameNoSpaces = str_replace(' ', '', $invitedEmailOrName);
				$query = addcslashes($invitedEmailOrNameNoSpaces, '%_'); // escape LIKE's special characters
				$criteria = new CDbCriteria( array(
					'condition' => "concat(firstName,lastName) LIKE :match",
					'params'    => array(':match' => "%$query%")
					));
				$users = User::model()->findAll( $criteria );
				
				//TODO: Assuming no duplicate names for now. Need to handle duplicate names.
				if(count($users) == 1)
					{
						$collaborator = $users[0];
					}
			}
			if(!$collaborator)
			{
				$newUser=new User;
				$newUser->firstName = $invitedEmailOrName;
				$newUser->lastName = $invitedEmailOrName;
				$newUser->email = $invitedEmailOrName;
				$newUser->created = new CDbExpression('UTC_TIMESTAMP()');
				$newUser->modified = new CDbExpression('UTC_TIMESTAMP()');
				$newUser->status = "pending";

				if(!$newUser->save())
				{
					Yii::log("Error saving user", 'error', 'CollaborationController.add');
					Yii::log(json_encode($newUser->getErrors()), 'error', 'CollaborationController.add');
				}
				$collaborator = $newUser;
			}
			$existingMembership = Member::model()->findByAttributes(array('userId'=>$collaborator->id,'studyId'=>$studyId));
			if(!$existingMembership)
			{
				$member = new Member;
				$member->userId = $collaborator->id;
				$member->studyId = $studyId;
				$member->role = $role;
				if ($member->save())
				{
					$invitation = new Invitation;

					$invitation->invitingUserId = Yii::app()->user->id;
					$invitation->invitedUserId =  $collaborator->id;
					$invitation->studyId = $studyId;
					$invitation->invitedEmail = $collaborator->email;
					$invitation->created = new CDbExpression('UTC_TIMESTAMP()');
					$invitation->guid = guid ( );
					$invitation->status = "Sent";

					if ($invitation->save())
					{
						$message = new YiiMailMessage("[OmniSci.org] Invitation to collaborate on study");
						$message->view = 'invitation/email';
						 
						//userModel is passed to the view
						$message->setBody(array('guid'=>$invitation->guid, 'study'=>$study), 'text/html');
						
						$message->addTo($invitation->invitedEmail);
						$message->from = "omniscienceinvite@gmail.com";//Yii::app()->params['adminEmail'];
						$result = Yii::app()->mail->send($message);

						if($result>0)
						{ 
						}
					}
				}
			}
			$this->redirect(array('study/index', 'id' => $_POST['studyId']));
		}
		Yii::log("Error adding collaborator", 'error', 'CollaborationController.add');
	}

	public function actionAccept()
	{
		if (!empty($_GET['guid']))
		{
			$invitation = Invitation::model()->findByAttributes(array('guid' => $_GET['guid']));
			if(!$invitation)
			{
				$this->render('/collaboration/invalidInvitation');
				return;
			}

			$user = User::model()->findByPk($invitation->invitedUserId);
			if($user->status=="pending")
			{
				$this->render('/collaboration/accept',array('guid'=>$_GET['guid'],'email'=>$invitation->invitedEmail));
			}
			else
			{
				$identity = new UserIdentity($user->id, $user->firstName, $user->profileImageUrl);

				if ($identity->authenticate())
				{
					$duration = 3600 * 24 * 30; // 30 day
					Yii::app()->user->login($identity,$duration);
					$this->redirect(array('study/index', 'id' => $invitation->studyId));
				}
			}
		}
		else
		{
			//TODO: log error
		}
	}

	public function actionRegister()
	{
		if (!empty($_POST['guid']))
		{
			$invitation = Invitation::model()->findByAttributes(array('guid' => $_POST['guid']));
			if(!$invitation)
			{
				$this->render('/collaboration/invalidInvitation');
				return;
			}

			$user = User::model()->findByPk($invitation->invitedUserId);
			
			if($_GET['type']=="facebook")
			{
				Yii::app()->user->setReturnUrl( Yii::app()->request->requestUri);
				$this->redirect(array('auth/facebook', 'guid' => $_POST['guid']));
				return;
			}
			else if($_GET['type']=="omnisci")
			{
				$user->password =  User::hashPassword($_POST['password']);
				$user->status = "active";
				$user->save();

				$identity = new UserIdentity($user->id, $user->firstName, $user->profileImageUrl);

				if ($identity->authenticate())
				{			
					$duration = 3600 * 24 * 30; // 30 day
					Yii::app()->user->login($identity,$duration);
				}
			}
			$invitation->status = "Accepted";
			$invitation->save();
			$this->redirect(array('study/index', 'id' => $invitation->studyId));
			
		}
	}

	public function actionAutoComplete()
	{
		if (Yii::app()->user->isGuest)
		{
			$this->renderJSON("");
			return;
		}

		$query="";
		if (!empty($_GET['query'])) $query=$_GET['query'];

		$query = addcslashes($query, '%_'); // escape LIKE's special characters
		$criteria = new CDbCriteria( array(
			'condition' => "concat(concat(firstName, ' ' ),lastName) LIKE :match",
			'params'    => array(':match' => "%$query%")
			));
 
		$users = User::model()->findAll( $criteria );

		$names = array();
		foreach($users as $user){
			$names[] = $user->firstName . " " . $user->lastName;
		}

		$options = array('options'=>$names);
		
		$this->renderJSON( $options);
	}

	public function actionAddUser()
	{
		if (!Yii::app()->user->isGuest)
		{
			if (isset($_POST['users']) && isset($_POST['studyId']))
			{

				$study = Study::model()->findByPk($_POST['studyId']);

				foreach ($_POST['users'] as $user)
				{
					if (!empty($user['id']) && !empty($user['role']))
					{
						$existingUser = User::model()->findByPk($user['id']);

						if ($existingUser)
						{
							$member = new Member;
							$member->studyId = $study->id;
							$member->userId = $user['id'];
							$member->role = $user['role'];

							if (!$member->save())
							{
								Yii::log(json_encode($member->getErrors()), 'error', 'CollaborationController.actionAddUser');
							}
							else
							{
								Notification::sendEmail('userAdded', $existingUser, $study);
							}
						}
					}
				}

				$this->redirect(array('study/index', 'id' => $study->id));
				return;
			}

		}

		$this->redirect('/');

	}

	public function actionAjaxRemoveUser()
	{

		if (isset($_POST['id']) && isset($_POST['studyId']))
		{
			//Yii::log(json_encode($_POST['user']), 'error');

			$member = Member::model()->findByAttributes(array('userId' => $_POST['id'], 'studyId' => $_POST['studyId']));

			Yii::log(json_encode($member), 'error');

			$resp = array();

			if ($member && $member->delete())
			{
				$respArray['status'] = 'OK';
			}

			$resp = json_decode(json_encode($respArray), false);

			$this->_sendResponse(200, json_encode($resp));

		}
	}
}
