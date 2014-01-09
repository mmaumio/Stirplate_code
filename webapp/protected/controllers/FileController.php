<?php

Yii::import('application.extensions.*');
// require_once('facebook/facebook.php');

class FileController extends Controller
{


	public function actionAjaxcreate()
	{

//        $token_path = 'protected/config/';
//
//        $client_id = 'oqyuzb6qkeg9ziufh89u70r8rz54la9h'; 
//        $client_secret = 'HyEAPF1kMf3wVPyi3qXGxXBhZg90oHnS';
//        $redirect_uri = $this->createAbsoluteUrl('file/ajaxcreate');
//        
//	$box = new Box_API($client_id, $client_secret,$redirect_uri);
//        
//	if(!$box->load_token($token_path)){
//		if(isset($_GET['code'])){
//			$token = $box->get_token($_GET['code'], true);
//			if($box->write_token($token, 'file',$token_path)){
//				$box->load_token($token_path);
//			}
//		} else {
//			$box->get_code();
//		}
//	}	
        
        
//        var_dump($box->get_user());
//        echo '<br>';
        
//        $temp_file_content = file_get_contents('https://www.filepicker.io/api/file/rMSic7mKRBuB8lf0E4j9?dl=true',FALSE);
//        $temp_file_name = 'Penguins.jpg';
//        if(file_put_contents('protected/data/temp/'.$temp_file_name,$temp_file_content)){
//            //create a file
//            $box->put_file('protected/data/temp/'.$temp_file_name, '1421092800');            
//        }
        
//
//        var_dump($box->put_file('D:\yii_test_GAE.txt','0'));
//        print_r(getallheaders ());

//       echo '<hr>';
//        var_dump($box->get_folder_items('1421092800'));
//       echo '<hr>' ;
//	if (isset($box->error)){
//		echo $box->error . "\n";
//	}        
//        
//        die();
        
//        foreach ($attachments as $attachment)
//        {
//            $filename = $attachment['url'];
//            $this->putFileOnBox();        
//        }
        
        
         $uid = Yii::app()->session['uid'];
         $attachments = $_POST['attachments'] ;
         
		if ($uid)
		{
			// print_r($_POST['attachments']);

		
			$respArray = array();
			foreach ($attachments as $a)
			{
				$file = new File;
				
				// User Id
				$file->userId = Yii::app()->session['uid'];
				$file->projectId = $a['projectId'];			
				$file->name = $a['filename'];
				$file->mimetype = $a['mimetype'];
				$file->fpUrl = $a['url'];
				
				//print_r($file);
				
				//$attachment->save();
				// Save the attachment to the database
				//$file->save();
				$created = new CDbExpression('UTC_TIMESTAMP()');
				$conn = Yii::app()->db;
				//$sql="insert into `file` values(`$file->userId`,`$file->projectId`,`$file->name`,`$file->mimetype`,`$file->fpUrl`)";
				//$command=$conn->createCommand($sql);
				$sql = "insert into file (userId, projectId,name,mimetype,fpUrl,created) values (:userId, :projectId,:name,:mimetype,:fpUrl,UTC_TIMESTAMP())";
				$parameters = array(":userId"=>$file->userId, ':projectId' => $file->projectId, ':name' => $file->name, ':mimetype' => $file->mimetype, ':fpUrl' => $file->fpUrl);
				//var_dump($parameters);
                                
                                Yii::app()->db->createCommand($sql)->execute($parameters);
                                //var_dump(Yii::app()->db->createCommand($sql));
                                
			/*	if ($file->save())
				{
					echo "success";
			//	$this->redirect('/dashboard');
				}
				else 
				{
					Yii::log("Error saving attachment", 'error', 'FileController.actionAjaxcreate');
					Yii::log(json_encode($file->getErrors()), 'error', 'FileController.actionAjaxcreate');
				}	*/

			}

	//	$file = json_decode(json_encode($file), false);

	//	$this->_sendResponse(200, json_encode($file));
		}
	}
        
        
/*	public function actionDelete_Comment(){
		if (!empty($_GET['id'])){
			$uid=Yii::app()->session['uid'];
			$file=File::model()->find(array(
		    'condition'=>'userId=:userId AND id=:id',
		    'params'=>array(':userId'=>$uid, ':id' => $_GET['id']),
			));
			// $activity= Activity::model()->findByPk($_GET['id']); 
			if ($file) {
				$file->delete();
			}
			$this->redirect('/file/ajaxcreate'.$file->projectId);
			
		}
	}
	*/
	public function actionDownload($file)
	{
                $file_id = $file;
                unset($file);
                
		if (Yii::app()->session['uid'] && !empty($file_id))
		{
			$file = File::model()->findByPk($file_id);

                        $project = Project::model()->findByPk($file->projectId);

			if ($project->isMemberOf())
			{
			                $policy = base64_encode(json_encode(array('expiry'=>strtotime("+5 minutes"), 'call'=>array('read'))));
							$signature = hash_hmac('sha256', $policy, Yii::app()->params['filepicker']['app_secret']);
                            $this->redirect($file->fpUrl.'?dl=true&signature='.$signature.'&policy='.$policy);			}
                }else{
                    throw new CHttpException(': Access Control','You are not authorised to download this file.');
                }
	}
        

}