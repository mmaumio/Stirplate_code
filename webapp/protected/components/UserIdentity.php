<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
        
        /**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
                $record = User::model()->findByAttributes(array('email' => $this->username));
                if($record===null)
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
                elseif($record->password!== User::hashPassword($this->password))
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                elseif($record->status=='block')
                      {
                        Yii::app()->user->setFlash('error','Your email not verified');
                        $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
                       // $this->errorMessage='Email not verified yet';
                       }
                else{
                    
                    $this->_id=$record->id;
                    $this->setState('name', $record->firstName);
                    $this->setState('image', $record->profileImageUrl);
                    $this->setState('email',  $record->email);
                    Yii::app()->session['uid'] = $record->id;
                    if($record->status=="notlogged"){ //Check if user is logging for 1st time.
                        $uid=Yii::app()->session['uid'];
                        
                        /**
                         * Following Fuctions are defined below getId().
                         */
                        $projectId = $this->createProject($uid); // This will create 1 demo Project
                        $this->createCollaborator($uid, $projectId); //This will create a Collaborator
                        $this->createDiscussion($uid, $projectId); // This will create 1 demo Discussion
                        $this->createTask($uid, $projectId); //This will create 4 demo Task
                        $this->uploadFiles($uid, $projectId); //This will add two temporary files
                        
                        /**
                         * Change status from notlogged to active.
                         */
                        $record->status="active";
                        $record->save(false);
                        
                    }
                    $this->errorCode=self::ERROR_NONE;
                }
		return !$this->errorCode;
	}

	public function getId()
        {
            return $this->_id;
        }
        
        /**
         * For 1st Time LoggedIn User
         */
        public function createProject($uid){
            if ($uid)
                {
                    $project = new Project;
                    $project->userId = $uid;
                    $project->title = "Demonstration Project, Click here to get started";
                    $project->status = 'active';
                    $project->save();
                }
                return $project->id;
        }
        public function createCollaborator($uid, $projectId){
            $projectUser = new ProjectUser;
		if ($uid)
                {
                    $projectUser->projectId = $projectId;
                    $projectUser->userId = Omniscience::Keithid();
                    $projectUser->role = 'collaborator';
                    $projectUser->save();

                }
	}
        public function createDiscussion($uid, $projectId){
            $activity = new Activity;
		if ($uid)
                {	
			$activity->userId = Omniscience::Keithid();
                        $activity->content = "This is the discussion area, make a comment here and all of your collaborators will be notified. Type something in here and I'll respond to you";
			$activity->type = "comment";
                        $activity->projectId = $projectId;
                        $activity->save(false);
                }
	}
        public function createTask($uid, $projectId){
            $t[0] = "Make a comment in the discussion area";
            $t[1] = "Upload a file below";
            $t[2] = "Change the title of this project by hovering over the title with the mouse";
            $t[3] = "Add a collaborator to the project";
                if ($uid)
                {
                    foreach($t as $val){
                        $task = new Task;
                        $task->assigneeId = $uid;
                        $task->ownerId = $uid;
			$task->status = empty($task->status) ? 'Pending' : $task->status;
                        $task->subject = $val;
                        $task->description = $val;
                        $task->projectId = $projectId;
			if ($task->save(false))
			{
                            $activity = new Activity;
                            $activity->userId = $uid;
                            $activity->relatedObjectId = $task->id;
                            $activity->relatedObjectType = 'task';
                            $activity->type = 'task';
                            $activity->projectId = $projectId;
                            $activity->content = $task->subject;
                            $activity->save(false);
                                
                        }
                    }
                }
	}
        
        //file upload
        public function uploadFiles($uid, $projectId){
            if ($uid)
                {
                    $files = array();
                    $files['example_file1.pdf'] = isset(File::model()->findByAttributes(array('name'=>'example_file1.pdf'))->fpUrl)?File::model()->findByAttributes(array('name'=>'example_file1.pdf'))->fpUrl:'https://www.filepicker.io/api/file/tfdszEsOTjOCH3fUrMYg';
                    $files['example_file2.jpg'] = isset(File::model()->findByAttributes(array('name'=>'example_file2.jpg'))->fpUrl)?File::model()->findByAttributes(array('name'=>'example_file2.jpg'))->fpUrl:'https://www.filepicker.io/api/file/EY9sPv8ySKaaVaOjvMAq';
                    foreach($files as $k=>$v){
                        $model = new File();
                        $model->userId = $uid;
                        $model->projectId = $projectId;
                        $model->name = $k;
                        $model->mimetype = ($k == 'example_file1.pdf')?'application/pdf':'image/jpeg';
                        $model->fpUrl = $v;
                        $model->save();
                    }
                }
            
        }
}