<?php

Yii::import('application.extensions.*');

class AttachmentController extends Controller
{
	public function actionIndex()
	{
		$this->redirect(array('list'));
	}
	
	public function actionNew()
	{
		// Probably need the project id for the attachment
		$this->render('new');
	}
	
	/**
	 * Create attachment handler
	 * 
	 * 08/03/13	RC	Redirect back to project id instead of study id
	 */
	public function actionCreate()
	{
		$fileCount = $_POST['fileCount'];
		
		for ($i=0; $i< $fileCount; $i++) {
			// Create a new attachment
			$attachment = new Attachment;
			
			// filename
			$attachment->studyId = $_POST['studyId'];
			$attachment->projectId = $_POST['projectId'];

			if (!empty($_POST['experimentId']))
			{
				$attachment->experimentId = $_POST['experimentId'];
			}
						
			$attachment->name = $_POST["fileName$i"];
			$attachment->iconLink = $_POST["iconUrl$i"];
			$attachment->urlLink = $_POST["urlLink$i"];
			
			$attachment->created = new CDbExpression('UTC_TIMESTAMP()');
			$attachment->modified = new CDbExpression('UTC_TIMESTAMP()');
			
			// Determine the file extension using the last dot
			$items = explode(".", $attachment->name);
			if (count($items) > 0) {
				$attachment->ext = $items[count($items) - 1];
			} else {
				$attachment->ext = 'Unknown';
			}
			
			// User Id
			$attachment->userId = Yii::app()->user->id;
			
			// Save the attachment to the database
			if (!$attachment->save()) {
				Yii::log("Error saving attachment", 'error', 'AttachmentController.create.attachmentSave');
				Yii::log(json_encode($attachment->getErrors()), 'error', 'AttachmentController.create.attachmentSave');
				//$this->render('preview', array('attachment' => $attachment));
				//return;
			}
		}

		if (isset($attachment->experimentId))
		{
			$this->redirect(array('experiment/index', 'id' => $attachment->experimentId));
		}
		else
		{
			$this->redirect(array('project/index', 'id' => $attachment->projectId));	
		}
		
		return;
	}
	
	/**
	 * Delete handler
	 * 
	 * 08/03/13	RC	Redirect back to project id instead of study id
	 * 08/17/13 RC	id validation
	 */
	 public function actionDelete(){
	 	
		if (isset($_POST['id'])) {
			$attachmentId = $_POST['id'];
			
			Yii::log("Deleting attachment" + $attachmentId, 'info', 'AttachmentController.delete.attachmentDelete');
			
			$attachment = Attachment::model()->findByPk($attachmentId);
			
			$projectId = $attachment->projectId;
			
			if (!$attachment->delete()) {
				Yii::log("Error deleting attachment", 'error', 'AttachmentController.delete.attachmentDelete');
				Yii::log(json_encode($attachment->getErrors()), 'error', 'AttachmentController.delete.attachmentDelete');
				$this->render('preview', array('attachment' => $attachment));
				return;
			}
			
			$this->redirect(array('project/index', 'id' => $projectId));
		} else {
			$msg = 'Missing input parameter(s)';
			Yii::log("Error deleting attachment", 'error', 'AttachmentController.delete.attachmentDelete');
			Yii::log(json_encode($msg), 'error', 'AttachmentController.delete.attachmentDelete');
			
			$this->render('error', array('msg' => $msg));
		}
	} 
	 
	public function actionList()
	{
		$projectId = $_GET['id'];
		
		$project = Project2::model()->findByPk($projectId);
		$study = $project->study;
		
		$this->render('list', array('study' =>$study, 'project' => $project));
	}

	public function actionDownload($id)
	{
		if (!Yii::app()->user->isGuest && !empty($id))
		{
			$attachment = Attachment::model()->findByPk($id);

			if ($attachment)
			{
				$member = Member::model()->findByAttributes(array('userId' => Yii::app()->user->id, 'studyId' => $attachment->studyId));

				if ($member)
				{
					$this->redirect($attachment->urlLink);
					return;
				}
				else
				{
					Yii::log("Someone trying to download a file they down own - " . Yii::app()->user->id . ' - ' . $attachment->id, 'error', 'AttachmentController.downlaod');
				}

			}
			else
			{
				Yii::log("Someone trying to download a file that doesn't exist - " . Yii::app()->user->id . ' - ' . $id, 'error', 'AttachmentController.downlaod');
			}
			
		}

		$this->redirect("/");

	}

	public function actionAjaxCreate()
	{
		if (!Yii::app()->user->isGuest && isset($_POST['attachments']) && is_array($_POST['attachments']))
		{

			$respArray = array();

			foreach ($_POST['attachments'] as $a)
			{
				$attachment = new Attachment;
			
				$attachment->studyId = $a['studyId'];
				$attachment->projectId = $a['projectId'];
				$attachment->experimentId = $a['experimentId'];
							
				$attachment->name = $a['filename'];
				$attachment->ext = $a['mimetype'];
				$attachment->urlLink = $a['url'];
				
				// User Id
				$attachment->userId = Yii::app()->user->id;
				
				// Save the attachment to the database
				if (!$attachment->save()) 
				{
					Yii::log("Error saving attachment", 'error', 'AttachmentController.actionAjaxCrateAttachment');
					Yii::log(json_encode($attachment->getErrors()), 'error', 'AttachmentController.actionAjaxCrateAttachment');
				}
				else
				{
					// copy file to Box.com

				}
			}

			$resp = json_decode(json_encode($respArray), false);

			$this->_sendResponse(200, json_encode($resp));
		}
	}

	public function actionAjaxRemoveAttachment()
	{
		if (!Yii::app()->user->isGuest && isset($_POST['id']))
		{

			$respArray = array();

			$attachment = Attachment::model()->findByPk($_POST['id']);

			if ($attachment)
			{

				$study = $attachment->study;

				if ($study)
				{

					if ($study->isAdmin() && $attachment->delete())
					{
						$respArray['status'] = 'OK';
					}
				}
			}

			$resp = json_decode(json_encode($respArray), false);

			$this->_sendResponse(200, json_encode($resp));

		}
	}

	public function actionUploadToBox()
	{


		
		/*
		$project = new Project;
		$project->title = "Super Fancy Project";
		$project->userId = Yii::app()->user->id;
		$project->save();
		*/

		/*
		$file = new File;
		$file->fpUrl = 'https://www.filepicker.io/api/file/IdfgCY0gRYuot9y2GXbn';
		$file->name = 'abc2.png';
		$file->projectId = 1;
		$file->userId = 1;

		$file->save();
		*/
		

		$box = new Box_API(Yii::app()->params['boxclientid'], Yii::app()->params['boxclientsecret'], 'n/a');



		if(!$box->load_token('protected/config/')){
			echo "A";
			if(isset($_GET['code'])){
				echo "B";
				$token = $box->get_token($_GET['code'], true);
				if($box->write_token($token, 'file')){
					$box->load_token();
				}
			} else {
				echo "C";
				$box->get_code();
			}
		}

		echo "!!!!!!";

		//$resp = $box->create_folder('test199', Yii::app()->params['boxfolderid']);

		//print_r($resp);

		echo "+++" . $resp['id'] . "+++";

		//$temp = file_get_contents('https://www.filepicker.io/api/file/IdfgCY0gRYuot9y2GXbn');
		//file_put_contents('protected/data/files/', $temp);

		//copy('https://www.filepicker.io/api/file/IdfgCY0gRYuot9y2GXbn', 'protected/data/files/a.png');

		//print_r($box->put_file('protected/data/files/a.png', Yii::app()->params['boxfolderid']));

		//unlink('protected/data/files/a.png');
		echo "!!!!!!";

		print_r($box->get_user());
		echo "DONE";

		
		$this->render('error');
	}

}