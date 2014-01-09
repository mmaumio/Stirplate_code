<?php

class TaskController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		//$this->render('view',array(
		//	'model'=>$this->loadModel($id),
		//));
		//$this->render('_view',array(
		//	'data'=>$this->loadModel($id),
		//));

		$task = Task::model()->findByPk($_GET['id']);

		$this->renderPartial('_view', array('task' => $task));
	}

	public function actionAjaxCreate()
	{
		//TODO: check to make sure user is logged in

		if (isset($_POST['task']))
		{
			Yii::log(json_encode($_POST['task']), 'error');

			//TODO: check to make sure user is a member of study before letting them create a task

			$task = new Task;

			$task->attributes = $_POST['task'];
			$task->ownerId = Yii::app()->user->id;
			$task->status = empty($task->status) ? 'Pending' : $task->status;

			$respArray = array();

			if ($task->save())
			{

				// add to activity feed
				$activity = new Activity;
				$activity->userId = Yii::app()->user->id;
				$activity->studyId = $task->studyId;
				$activity->relatedObjectId = $task->id;
				$activity->relatedObjectType = 'task';
				$activity->type = 'task';
				$activity->content = $task->createdByUser->getName() . ' added a new task: "' . $task->subject . '"';

				$activity->save();

				$respArray['status'] = 'OK';
				$respArray['id'] = $task->id;
				$respArray['task'] = array();
				$respArray['task']['subject'] = $task->subject;
				$respArray['task']['description'] = $task->description;
				$respArray['task']['assigneeImgUrl'] = $task->assignedToUser->getUserImage();
			}
			else
			{
				$respArray['status'] = 'ERROR';
			}

			$resp = json_decode(json_encode($respArray), false);

			$this->_sendResponse(200, json_encode($resp));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$study = isset($_GET['studyId'])? Study::model()->findByPk($_GET['studyId']):null;
		$project = isset($_GET['projectId'])? Project2::model()->findByPk($_GET['projectId']):null;
		$experiment = isset($_GET['experimentId'])?Experiment::model()->findByPk($_GET['experimentId']):null;

		$model=new Task;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task']))
		{
			$model->attributes=$_POST['Task'];
			$model->created = date("Y-m-d H:i:s");
			if($model->save())
			{
				if($study)
				{
				Yii::app()->db->createCommand()->insert('task_relation', array(
					'taskId' => $model->id,
					'itemType' => 'study',
					'itemId' => $study->id));
				}
				if($project)
				{
				Yii::app()->db->createCommand()->insert('task_relation', array(
					'taskId' => $model->id,
					'itemType' => 'project',
					'itemId' => $project->id));
				}
				if($experiment)
				{
				Yii::app()->db->createCommand()->insert('task_relation', array(
					'taskId' => $model->id,
					'itemType' => 'experiment',
					'itemId' => $experiment->id));
				}


				$this->redirect(array('view','id'=>$model->id));
			}
		}

		
		$relatedUserList = $this->getRelatedUsers($study);

		$this->render('create',array(
			'model'=>$model,
			'study'=>$study,
			'project' =>$project,
			'experiment' =>$experiment,
			'relatedUserList' => $relatedUserList
		));
	}

	public function actionAjaxComplete()
	{

		$respArray = array();

		if (!empty($_GET['id']))
		{
			$task = Task::model()->findByPk($_GET['id']);

			if ($task && $task->assigneeId === Yii::app()->user->Id)
			{
				$task->status = 'complete';

				if ($task->save())
				{

					// add to activity feed
					$activity = new Activity;
					$activity->userId = Yii::app()->user->id;
					$activity->studyId = $task->studyId;
					$activity->relatedObjectId = $task->id;
					$activity->relatedObjectType = 'task';
					$activity->type = 'task';
					$activity->content = $task->createdByUser->getName() . ' completed task: "' . $task->subject . '"';

					$activity->save();

					$respArray['status'] = 'OK';
					$respArray['id'] = $task->id;
				}
				else
				{
					$respArray['status'] = 'ERROR - task could not be updated';
				}

			}
			else
			{
				$respArray['status'] = 'ERROR - no task found or not owner';
			}
		}
		else
		{
			$respArray['status'] = 'ERROR - no id specified';
		}

		$resp = json_decode(json_encode($respArray), false);

		$this->_sendResponse(200, json_encode($resp));
	}

	private function getRelatedUsers($study)
	{
		$relatedUsers = $study->users;

		$relatedUserList = CHtml::listData($relatedUsers ,'id',function($user) {
			return CHtml::encode($user->firstName . ' ' . $user->lastName);
		});
		return $relatedUserList;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$projectId = Yii::app()->db->createCommand(array(
		'select'=>'itemId',
		'from'=>'task_relation',
		'where'=>'taskId=:taskId',
		'params'=>array(':taskId'=>$id)))->queryScalar();
		
		
		$project = Project2::model()->findByPk($projectId);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task']))
		{
			$model->attributes=$_POST['Task'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$relatedUserList = $this->getRelatedUsers($project);

		$this->render('update',array(
			'model'=>$model,
			'project' =>$project,
			'relatedUserList' => $relatedUserList
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Task');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Task the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Task::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
