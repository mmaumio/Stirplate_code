<?php

Yii::import('application.extensions.*');
require_once('PHPExcel.php');
require_once('PHPExcel/IOFactory.php');

class DataController extends Controller
{
	 public function actionDelete(){
		
		$projectId = $_GET['projectId'];
		$project = Project::model()->findByPk($projectId);
		
		$experimentId = $_GET['experimentId'];
		$experiment = Experiment::model()->findByPk($experimentId);
		
		$dataSetId = $_GET['dataSetId'];
		$dataSet = DataSet::model()->findByPk($dataSetId);
		
		$dataSet->delete();
		
		$this->render('deleted',array('project'=>$project,'experiment'=>$experiment, 'dataSet' => $dataSet) );
	}
	 
	public function actionUpload()
	{

		if (!empty($_FILES) && !empty($_POST['dataSet'])) {

			//$projectId = $_POST['projectId'];
			//$project = Project::model()->findByPk($projectId);
			$experiment = Experiment::model()->findByPk($_POST['dataSet']['experimentId']);

			foreach ($_FILES as $f) {
				//Yii::log('file=' . serialize($f), 'info', 'SiteController');

				$tempFile = $_FILES['file']['tmp_name'];

				//Yii::log("contents - " . $tempFile, 'info', 'SiteController');

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objPHPExcel = PHPExcel_IOFactory::load($tempFile);

				$data = array();
				$titles = array();
				$numColumns = 0;
				$titleRow = true;
				$processedFirstWorksheet = false;

				$dataset = new DataSet;
				$dataset->attributes = $_POST['dataSet'];
				$dataset->tableName = 'n/a';
				$dataset->name = $_FILES['file']['name'];
				$dataset->ownerId = Yii::app()->user->id;

				if (!$dataset->save())
				{
					Yii::log('Error saving dataset', 'error', 'DataController.upload.save');
					Yii::log(json_encode($dataset->getErrors()), 'error', 'DataController.upload.save');
				}

				$cleanExperimentName = preg_replace("/[^A-Za-z0-9]/", '', $experiment->name);
				$tableName = '_dataset_' . $cleanExperimentName . '_' . $_POST['dataSet']['type'] . '_' . $experiment->id . '_' . $dataset->id;

				// update dataset object with newly generated tablename which includes dataset->id
				DataSet::model()->updateByPk($dataset->id, array('tableName' => $tableName));

				//echo date('H:i:s') , " Iterate worksheets" , EOL;
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
					//Yii::log('Worksheet - ' . $worksheet->getTitle(), 'error');

					foreach ($worksheet->getRowIterator() as $row) {
						//Yii::log('	Row number - ' . $row->getRowIndex(), 'error');
						$rowNumber = $row->getRowIndex();
						$data[$rowNumber] = array();

						$cellIterator = $row->getCellIterator();
						$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
		
						$cellIndex = 1;

						foreach ($cellIterator as $cell) {
							if (!is_null($cell)) {
								$cellNumber = $cell->getCoordinate();

								if ($rowNumber === 1 && $titleRow)
								{
									$titles[$cellNumber] = $cell->getCalculatedValue();

									$columnMapping = new ColumnMapping;
									$columnMapping->dataSetId = $dataset->id;
									$columnMapping->type = 'test';
									$columnMapping->columnIndex = $cellIndex++;
									$columnMapping->originalLabel = $cell->getCalculatedValue();
									$columnMapping->save();
								}

								//Yii::log('		Cell - ' . $cell->getCoordinate() . ' - ' . $cell->getCalculatedValue(), 'error');
								$data[$rowNumber][$cellIndex] = $cell->getCalculatedValue();

								$cellIndex++;
							}
						}
					}

					$processedFirstWorksheet = true;
					break;
				}

				$numColumns = count($titles);

				// create table

				$columns = array();

				for ($i = 1; $i <= $numColumns; $i++) 
				{
					$columns['column' . $i] = 'string';
				}

				$dbCommand = Yii::app()->db->createCommand()->createTable($tableName, $columns);

				// insert records into table

				$row = 1;
				$transaction=Yii::app()->db->beginTransaction();
				foreach ($data as $k => $v)
				{
					if ($k === 1 && $titleRow) 
					{
						// skip first row if used for titles
					}
					else
					{

						$values = array();

						foreach ($v as $ind => $value)
						{
							$values['column' . $ind] = $value;
						}

						Yii::app()->db->createCommand()->insert($tableName, $values);
					}
				}
				$transaction->commit();

				//successful import, return experimentId
				//$this->_sendResponse(201, 'Created', json_encode(array('experimentId' => $experiment->id), JSON_FORCE_OBJECT));
			}
		}
		else
		{
			$projectId = $_GET['projectId'];
			$project = Project::model()->findByPk($projectId);
			
			Yii::app()->clientScript->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/dropzone/2.0.8/css/dropzone.min.css');
			Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/dropzone/2.0.8/dropzone.min.js');

			$this->render('upload', array('project'=>$project));   
		}	 
	}

    public function actionResults()
	{

		Yii::app()->clientScript->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/nvd3/0.9/nv.d3.css');
		Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/d3/3.2.2/d3.min.js');
		Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/nvd3/0.9/nv.d3.min.js');

		$projectId = $_GET['projectId'];
		$project = Project::model()->findByPk($projectId);
		$this->render('results', array('project' => $project));
	}

	public function actionView()
	{
		if (!empty($_GET['id']))
		{
			$data = DataSet::model()->with('columnMappings')->findByPK($_GET['id']);

			$experiment = $data->experiment;

			$project = $experiment->project;

			$study = $project->study;

			if ($study->isMemberOf()) 
			{
				$tableName = $data->tableName;

				$rows = Yii::app()->db->createCommand()
    					->select()
    					->from($tableName)
    					->queryAll();

    			$this->renderPartial('_view', array('data' => $data, 'rows' => $rows));
			}
			else
			{
				// user is not allowed to view this data
			}
		}
		else
		{
			// no data provided
		}
	}
}
