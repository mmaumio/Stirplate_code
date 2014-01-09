<?php

Yii::import('application.extensions.*');

class ExperimentController extends Controller
{

	public function beforeAction($action)
	{
		parent::beforeAction($action);

		$adminEmails = array( 
			's7@hotmail.com', 
			'kgonzales@omnisci.org', 
			'kgonzales@gmail.com',
			'kgonzalesit@yahoo.com');

		$actionId = $action->id;
		
		if ($actionId == 'index')
		{
			if (!Yii::app()->user->isGuest)
			{
				$user = User::model()->findByPk(Yii::app()->user->id);

				if (in_array($user->email, $adminEmails)) return true;

				$experiment = Experiment::model()->findByPk($_GET['id']);

				$project = $experiment->project;

				$member = Member::model()->findByAttributes(array('userId' => Yii::app()->user->id, 'studyId' => $project->studyId));
				
				if ($member)
				{
					return true;
				}
				
				// Current user could be an admin which should have permission to look at the study itself
				// ToDo: Should the admin has access to modify?
				$allMembers = Member::model()->findAllByAttributes(array('studyId' => $project->studyId));
				
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
				
				$this->redirect(array('study/invalid', 'retUrl' => '/experiment/index/' . $_GET['id']));

			}
			else
			{
				$this->redirect(array('study/invalid', 'retUrl' => '/experiment/index/' . $_GET['id']));
			}

		}
		else
		{
			return true;
		}
	}

	public function actionIndex()
	{

		if (!empty($_GET['id']))
		{
			$experiment = Experiment::model()->findByPk($_GET['id']);
			
			if (isset($experiment))
			{
				$project = $experiment->project;
				$study = $project->study;

				Yii::app()->clientScript->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/dropzone/2.0.8/css/dropzone.min.css');
				Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/dropzone/2.0.8/dropzone.min.js');

				$this->render('index', array('study' => $study, 'project' => $project, 'experiment' => $experiment));
			}
		}
	}

	/**
	 * 08/03/13	RC	Use experiment Id instead of project id to look
	 * 				up the experiment.
	 */
	public function actionDelete(){
		//$experimentId = $_GET['projectId'];
		//$experiment = Project::model()->findByPk($experimentId);
		
		$experimentId = $_GET['id'];
		$experiment = Experiment::model()->findByPk($experimentId);

		$project = $experiment->project;
		$study = $project->study;

		if ($study->isMemberOf())
		{
			if (!$experiment->delete())
			{
				Yii::log("Error deleteing experiment id #" . $experiment->id, 'error', 'ExperimentController.actionDelete');
			}
			else
			{
				$this->redirect(array('project/index', 'id' => $project->id));
			}
		}
		
		//$this->render('deleted', array('project'=>$experiment) );
	}
	
	 public function actionPreview()
	{
		$experimentId = $_GET['projectId'];
		$experiment = Project2::model()->with('experiments', 'experiments.dataSets', 'experiments.dataSets.columnMappings')->findByPk($experimentId);
		
		$experimentId = $_GET['experimentId'];
		
		$experimentDataSets = array();

		$experiment = NULL;
		foreach ($experiment->experiments as $_experiment)
		{
			if($_experiment->id==$experimentId) $experiment = &$_experiment;
		}
		
		foreach ($experiment->dataSets as $dataSet) {
			$sql = 'select * from ' . $dataSet->tableName;
	
			$dbCommand = Yii::app()->db->createCommand($sql);
	
			$sqlResults = $dbCommand->queryAll();
	
			$returnValue = array();
			$returnValue['dataSet'] = $dataSet;
			$returnValue['dataSetRows'] = $sqlResults;
	
			$experimentDataSets[] = $returnValue;
		}

		Yii::app()->clientScript->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/jquery-footable/0.1.0/css/footable.css');
		Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/jquery-footable/0.1.0/js/footable.min.js');

		$qpcr = array();

		//$qpcr = new QPCR($id);

		//$qpcr->processData();

		$this->render('preview', array('project' => $experiment, 'experiment'=>$experiment, 'experimentDataSets' => $experimentDataSets, 'qpcr' => $qpcr));		
	}

	public function actionCreate()
	{
		if (!empty($_POST['Experiment']))
		{
			$experiment = new Experiment;

			$experiment->attributes=$_POST['Experiment'];
			//$experiment->projectId = $_POST['projectId'];

			if ($experiment->save()) 
			{
				$project = Project2::model()->findByPk($experiment->projectId);

				// create activity
				$activity = new Activity;
				$activity->studyId = $project->studyId;
				$activity->relatedObjectId = $experiment->projectId;
				$activity->relatedObjectType = 'project';
				$activity->userId = Yii::app()->user->id;
				$activity->content = Yii::app()->user->name . ' created experiment "' . $experiment->name . '"';
				$activity->type = 'event';

				if(!$activity->save())
				{
					Yii::log("Error saving activity", 'error', 'ExperimentController.create.activitySave');
					Yii::log(json_encode($activity->getErrors()), 'error', 'ExperimentController.create.activitySave');
				}
				else
				{
					$event = new SystemEvent;
	                $event->userId = Yii::app()->user->id;
	                $event->type = 'create_experiment';
	                $event->description = $experiment->name;

	                if (!$event->save())
	                {
	                    YII::log(json_encode($event->getErrors()), 'error', 'ExperimentController.actionCreate');
	                }

					$this->redirect(array('experiment/index', 'id' => $experiment->id));
				}
			}
			else
			{
				// there was a problem saving the project
				Yii::log(json_encode($experiment->getErrors()), 'error', 'ProjectController.create.projectSave');
				$this->redirect(array('site/index'));
			}
		}
		else
		{
			// re-render create page with validation errors
			$this->render('new');
		}
	}

	/**
	 * Edit the experiment
	 * 
	 * Right now, it's only allowing it to update the name. We should be able
	 * to handle updating all the properties of the experiment
	 * 
	 * RC	08/17/13	Editing name only
	 */
	public function actionEdit() 
	{
		if (isset($_POST['experimentId']) && isset($_POST['experimentName'])) {
			$experimentId = $_POST['experimentId'];
			$name = $_POST['experimentName'];
			
			if (!empty($experimentId) && !empty($name))
			{
				// Load the project
				$experiment = Experiment::model()->findByPk($experimentId);
				
				// Update the database if the title is different
				if ($experiment->name !== $name) {
					$prevExperiment = clone $experiment;
					
					$experiment->name = $name;
					if (!$experiment->save()) {
						// there was a problem saving the study
						Yii::log("Error updating the experiment", 'error', 'ExperimentController.update.experimentEdit');
						Yii::log(json_encode($experiment->getErrors()), 'error', 'ExperimentController.update.experimentEdit');
					} else {
						// create activity
						$project = Project2::model()->findByPk($experiment->projectId);
		
						// create activity
						$activity = new Activity;
						$activity->studyId = $project->studyId;
						$activity->relatedObjectId = $experiment->projectId;
						$activity->relatedObjectType = 'project';
						$activity->userId = Yii::app()->user->id;
						$activity->content = Yii::app()->user->name . ' renamed experiment name from "' . $prevExperiment->name . '" to "' . $experiment->name . '"';
						$activity->type = 'event';
						
						if(!$activity->save())
						{
							Yii::log("Error saving activity", 'error', 'ProjectController.create.activitySave');
							Yii::log(json_encode($activity->getErrors()), 'error', 'ProjectController.create.activitySave');
						}
					}
				}
			}
		}
		
		$this->redirect(array('experiment/index', 'id' => $experimentId));
	}

	public function actionResults()
	{

		if (!empty($_GET['id']))
		{

			$experiment = Experiment::model()->findByPk($_GET['id']);

			if ($experiment)
			{

				$project = $experiment->project;

				$study = $project->study;

				$qpcr = new QPCR($_GET['id']);
				$qpcr->processData();

				Yii::app()->clientScript->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/nvd3/0.9/nv.d3.css');
				Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/d3/3.2.2/d3.min.js');
				Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/nvd3/0.9/nv.d3.min.js');

				$this->render('results', array('study' => $study, 'project' => $project, 'experiment' => $experiment, 'qpcr' => $qpcr));
			}
		}
	}
	
}
