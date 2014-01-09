<?php


class SiteController extends Controller
{
        
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		        $this->layout='//layouts/columnfull';
                $userModel=new User;
                $model=new LoginForm;
                if(isset(Yii::app()->request->cookies['authentic']) && isset(Yii::app()->request->cookies['identity']))
                  { 
                    $model->remember=1;
                    $model->email= base64_decode(Yii::app()->request->cookies['identity']);
                    $model->password=base64_decode(Yii::app()->request->cookies['authentic']);
                    if($model->validate() && $model->login())
                      {
                           $this->redirect('/dashboard');                                             
                      }
                  
                  }               
                $newsLetterModel = new NewsletterForm;
               if(isset($_POST['LoginForm']))
                {  
                       if(!empty($_POST['confirm-password']))
                       {
                           Yii::app()->user->setFlash('error','Stirplate not permitting you to perform this action');
                           $this->redirect(Yii::app()->createUrl('/'));
                       }
                       if(isset(Yii::app()->request->cookies['user_trails'])){
                            $val = Yii::app()->request->cookies['user_trails']->value;
                            Yii::app()->request->cookies['user_trails'] =new CHttpCookie('user_trails', (1 + $val));
                        }
                        else
                        {
                             Yii::app()->request->cookies['user_trails'] = new CHttpCookie('user_trails', 1);
                        }
                        
			                  $model->attributes=$_POST['LoginForm'];
                              $model->remember=$_POST['LoginForm']['remember'];
                               if($model->validate() && $model->login())
                               {
                                 if($model->remember)
                                  {
                                   $cookie = new CHttpCookie('identity',base64_encode($model->email));
                                   $cookie->expire = time()+3600*24*14;
                                   Yii::app()->request->cookies['identity'] = $cookie;
                                   $cookie = new CHttpCookie('authentic',base64_encode($model->password));
                                   $cookie->expire = time()+3600*24*14;
                                   Yii::app()->request->cookies['authentic'] = $cookie;
                                  }
                                  else 
                                  {
                                    if(isset(Yii::app()->request->cookies['authentic']))
                                    unset(Yii::app()->request->cookies['authentic']);
                                    if(isset(Yii::app()->request->cookies['identity']))
                                    unset(Yii::app()->request->cookies['identity']);
                                  }
                                   $this->redirect('/dashboard');
                                        
				            
                         }
                }
		$this->render('index',array('model'=>$model, 'newsLetterModel'=>$newsLetterModel,'userModel'=>$userModel));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $model=new LoginForm;
     	if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
     	if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}

        //require_once 'google/appengine/api/users/UserService.php';
        $googleLoginUrl = \google\appengine\api\users\UserService::createLoginURL('/site/googleLogin');
		// display the login form
		$this->render('login',array('model'=>$model, 'googleLoginUrl'=>$googleLoginUrl));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
	    if(isset(Yii::app()->request->cookies['authentic']))
                                   Yii::app()->request->cookies['authentic']->expire;
                                    if(isset(Yii::app()->request->cookies['identity']))
                                    Yii::app()->request->cookies['identity']->expire;
                                
		Yii::app()->user->logout();
      
		$this->redirect('site/index');
	}

    public function actionGoogleLogin()
    {
        $identity=new GUserIdentity('test','test');
        $identity->authenticate();
        if($identity->errorCode===GUserIdentity::ERROR_NONE) {
            Yii::app()->user->login($identity,$duration=0);
            $this->redirect('/');
        } else {
            $this->redirect('/site/login');
        }

    }
    /*
     * 
     * About Us Page
     *
    */
    public function actionAboutus()
	{
	
				$this->render('aboutus',array());
	
	}
     public function actionfaq()
	{
	
				$this->render('faq',array());
	
	}

    public function actionBlog()
	{
	
				$this->render('blog',array());
	
	}
    public function actionPrivacy()
	{
	
				$this->render('privacy',array());
	
	}
        
        /**
         * Forgot password 
         * Accepts an email and sends a change password link to the user
         */
       
    public function actionForgotPassword(){
            $model=new User;
            
            if(isset($_POST['User']))
            {
                    $records =  User::model()->findByAttributes(array('email'=>$_POST['User']['email']));
                    if($records){
                        // $message = new YiiMailMessage;
                        // $message->view = 'forgotpassmail';
                        // $message->setBody(array('records'=>$records), 'text/html');
                        // $message->subject = 'Request to change password';
                        // $message->addTo($records->email);
                        // $message->from = Yii::app()->params['adminEmail'];
                        // Yii::app()->mail->send($message);
                        $obj = array('token' => md5($records->id).md5(strtotime($records->created)));
                        Notification::sendEmail('passwordReset', $records, $obj);
                        Yii::app()->user->setFlash('success', "It's ok, it happens to the best of us. Check your email to reset your password");

                        $this->redirect('ForgotPassword');
                    }else{
                        Yii::app()->user->setFlash('error', "Invalid Email");
                    }
            }
            $this->render('forgotpass',array('model'=>$model));
        }
        
        /**
         * Change password 
         */
    public function actionChangepass()
	{       
                $model = new User;
                $records=  User::model()->findAll();
                if(isset($_POST) && isset($_POST['k'])){
                    foreach ($records as $value) {
                            if(md5($value->id).md5(strtotime($value->created)) == $_POST['k']){
                                $pass1 = trim($_POST['newpassword']);
                                $pass2 = trim($_POST['confirmpassword']);
                                if(isset($_POST['newpassword']) && isset($_POST['confirmpassword']) && !empty($pass1) && !empty($pass2)){
                                        $data=$value;
                                        if($pass1 != $pass2){
                                                    Yii::app()->user->setFlash('error', "Passwords don't match. Please try again.");
                                            }else{
                                                    $data->password=User::hashPassword($pass1);
                                                    if ($data->update()) {
                                                      Yii::app()->user->setFlash('success', "Password is changed. Please login with your new password.");
                                                    }else{
                                                      Yii::app()->user->setFlash('error', "Password not updated.");
                                                    }
                                            }
                                }else{
                                    Yii::app()->user->setFlash('error', "Please check entered values.");
                                }
                            }
                    }
                }
                if(isset($_GET['k'])){
                    $this->render('changepass',array('model'=>$model, 'k'=>$_GET['k']));
                }else{
                    $this->render('changepass',array('model'=>$model));
                }
	}


    /**
     * handles newsletter actions
     */
    public function actionNewsletter()
    {
        $this->layout = '//layouts/columnfull';
        $model        = new NewsletterForm;
        $userModel=new User;
        // collect user input data
        if (isset($_POST['NewsletterForm'])) {
            
            if(!empty($_POST['confirmemail']))
                       {
                           Yii::app()->user->setFlash('error','Stirplate not permitting you to perform this action');
                           $this->redirect(Yii::app()->createUrl('/'));
             }
             
                $model->attributes = $_POST['NewsletterForm'];
                if ($model->validate() && $model->process())
                {
                    
                      Yii::app()->user->setFlash('success', 'Good news is coming your way!');
                       $model->unsetAttributes();
                    
                }
             
           
        }
        $loginModel = new LoginForm;
        $this->render('index', array('model' => $loginModel, 'newsLetterModel' => $model, 'userModel'=>$userModel));
    }
    
    public function actionSignup()
    {
        $userModel=new User;
        if(isset($_POST['User']))
        {
           if(!empty($_POST['confirmemail']))
           {
             echo 'Access Denied'; exit;
           }
          
           $userModel->attributes=$_POST['User'];
           if(User::model()->exists('email=:email',array(":email"=>$userModel->email)))
           {
              echo 'exits'; exit;
           }
           if(!filter_var($userModel->email, FILTER_VALIDATE_EMAIL))
           {
             echo "invalid1";exit;
           }
             /* $array=explode("@",$userModel->email);
              $array2=expl ode(".",$array[1]);
              if($array2[1]!='edu')
              {
                echo 'invalid';exit;
              }*/
             
            $userModel->password=User::hashPassword($_POST['User']['password']);
                        $userModel->status='block';
                        $userModel->keystring=md5($userModel->email.time());
                  
            if($userModel->save(false))
            {
                Yii::app()->user->setFlash('success','Please check your email '.$userModel->email.'</i> for a verification link');
                $obj = array('records'=>$userModel,'string'=>base64_encode($_POST['User']['password']));
                Notification::sendEmail('newSignup', $userModel, $obj);
                echo 'success'; 
                
            }
        }
        exit;
    }
     public function actionVerifyemail()
     {
            $login=new LoginForm;
           if(isset($_GET['key']) && isset($_GET['string']))
           {
               $userData=User::model()->findByAttributes(array('keystring'=>$_GET['key']));
               if(!empty($userData))
               {
                   $userData->keystring=$_GET['key'];
                   $userData->status='notlogged';
                   if($userData->update(false))
                     {
                        $login->email=$userData->email;
                        $login->password=base64_decode($_GET['string']);
                        if($login->login())
                        {
                             Yii::app()->user->setFlash('success','<b>Welcome!</b> You are all set to use Stirplate, please fill in your first/last name and your preferred contact email address to get started');
            
                           	$this->redirect(array('user/profile'));
    	                }
                      exit;
                     }
               }
               else
               {
               echo  'invalid link'; exit;
               }
           }
           else{
              echo 'invalid link'; exit;
           }
    }
    
    public function actionResentemaillink()
    {
         
         
         $userModel=User::model()->findByAttributes(array('email'=>$_GET['email']));
          if($userModel)
          {
         Yii::app()->user->setFlash('success','Please check your email, an verification link sent on <i>'.$userModel->email.'</i>');
                $obj = array('records'=>$userModel,'string'=>$_GET['key']);
                Notification::sendEmail('newSignup', $userModel, $obj);
          Yii::app()->user->setFlash('success','Email verification sent successfully');
          }
          else
          {
            Yii::app()->user->setFlash('error','Fails to sent email verification link , Please check your email');
          
          } 
          $this->redirect(array('site/index'));                
    }
    
   
    
    
}
