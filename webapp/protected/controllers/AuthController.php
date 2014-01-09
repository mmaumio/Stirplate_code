<?php

Yii::import('application.extensions.*');
// require_once('facebook/facebook.php');

class AuthController extends Controller
{

	public function actionLogin()
	{
		if(!empty($_POST['email']) && !empty($_POST['password']))
		{
			
		
			// echo "yuuu";
			//$conn = Yii::app()->db;
			// echo "3";
			// echo $conn->connectionString;
			//$sql="select * from `omniscience`.`user`";
			//$command=$conn->createCommand($sql);
			//$rowcount=$command->execute();
			// echo $rowcount;
			$user = User::model()->findByAttributes(array('email' => $_POST['email']));
			// echo "<br/>";
           
			// echo $user->id;
			if($user && $user->password == User::hashPassword($_POST['password']))
			{
				$identity = new UserIdentity($user->id, $user->firstName, $user->profileImageUrl, $user->email);
				//print_r($identity);
				if ($identity->authenticate())
				{			
					//ini_set('display_errors',true);
				//$duration = 3600 * 24 * 30; // 30 day
				Yii::app()->session['uid'] = $user->id;
				//Yii::app()->user->login($identity,$duration);

					if (!empty($_POST['retUrl']))
					{
						$this->redirect($_POST['retUrl']);
					}
					else
					{
					// echo "success";
					$this->redirect('/dashboard');
					}
				//	return;
			//echo "Success";
				}
				else{
				echo "failed";
				}
			}
			
			/*if($user && $_POST['password'] == 123))
			{
					

				$identity = new UserIdentity($user->id, $user->firstName, $user->profileImageUrl, $user->email);
				if ($identity->authenticate())
				{			
					$duration = 3600 * 24 * 30; // 30 day
					Yii::app()->user->login($identity,$duration);

					if (!empty($_POST['retUrl']))
					{
						$this->redirect($_POST['retUrl']);
					}
					else
					{
						$this->redirect('index.php?r=project/dashboard');
					}
					return;
				}
			} */
		$errorMsg = 'Sorry, that email and password combination was not valid';
		}
	}	
	

	/*public function actionFacebook()
	{

		$facebook = new Facebook(array(
			'appId'  => Yii::app()->params['fbAppId'],
			'secret' => Yii::app()->params['fbApiSecret'],
			'cookie' => true,
		));

		$fbId = $facebook->getUser();

		if ($fbId) 
		{
			// user detected, check if they've already registered
			$auth = AuthCredential::model()->with('user')->findByAttributes(array('externalId' => $fbId));

			if ($auth) 
			{
				//user exists, login
				$user = $auth->user;
				
				// $identity = UserIdentity::SetUser($user);
				$identity = new UserIdentity($user->id, $user->firstName, $user->profileImageUrl, $user->email);

				if ($identity->authenticate())
				{			
					$duration = 3600 * 24 * 30; // 30 day
					Yii::app()->user->login($identity,$duration);
				}
			}
			else
			{

				// new user - crate account
				$userDetails = $facebook->api('/me');

				$user = $invitedUser ? $invitedUser : new User;
				$user->firstName = !empty($userDetails['first_name']) ? $userDetails['first_name'] : '';
				$user->lastName = !empty($userDetails['last_name']) ? $userDetails['last_name'] : '';
				$user->email = $userDetails['email'];
				$user->link = $userDetails['link'];
				$user->gender = !empty($userDetails['gender']) ? $userDetails['gender'] : 'N/A';
				$user->timezone = !empty($userDetails['timezone']) ? $userDetails['timezone'] : 'N/A';
				$user->locale = !empty($userDetails['locale']) ? $userDetails['locale'] : 'N/A';
				$user->profileImageUrl = 'http://graph.facebook.com/' . $fbId . '/picture';
				$user->status = "active";

				if ($user->save())
				{
					// user saved successfully, now create auth credentials record
					$auth  = new AuthCredential;
					$auth->userId = $user->id;
					$auth->externalId = $fbId;
					$auth->name = isset($userDetails['username']) ? $userDetails['username'] : 'Personal Facebook Account';
					$auth->type = 'facebook';
					
					if (!$auth->save())
					{
						// problem saving auth credential
						$errors = $auth->getErrors();

						Yii::log(json_encode($errors), 'error', 'AuthController.actionFacebook');
					}
					else
					{
						// user saved - login 
						$identity = new UserIdentity($user->id, $user->firstName, $user->profileImageUrl, $user->email);

						if ($identity->authenticate())
						{			
							$duration = 3600 * 24 * 30; // 30 day
							Yii::app()->user->login($identity, $duration);
						}
					}
				}
				else
				{
					//problem saving user
					$errors = $user->getErrors();

					Yii::log(json_encode($errors), 'error', 'AuthController.actionFacebook');
				}

				
			}

			$this->redirect(Yii::app()->user->getReturnUrl());
			
		} 
		else 
		{
			// no user detected, redirect to login page
		  	$loginUrl = $facebook->getLoginUrl(array('scope' => 'email'));

		  	$this->redirect($loginUrl);
		}	
	}
	 */

	public function actionLogout()
	{
	   if(isset(Yii::app()->request->cookies['authentic']))
                                   unset(Yii::app()->request->cookies['authentic']);
                                    if(isset(Yii::app()->request->cookies['identity']))
                                    unset(Yii::app()->request->cookies['identity']);
                                
	
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createUrl('site/index'));
	}

}