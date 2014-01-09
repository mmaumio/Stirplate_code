<?php
/* @var $this TaskController */
/* @var $model Task */

$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List Task', 'url'=>array('index')),
//	array('label'=>'Manage Task', 'url'=>array('admin')),
//);
?>
<div><h1>Study: <?php echo CHtml::encode($study->title); ?></h1></div>
<?php if($project) { ?>
	<div><h2>Project: <?php echo CHtml::encode($project->name); ?></h2></div>
<?php  } ?>
<?php if($experiment) { ?>
	<div><h3>Experiment: <?php echo CHtml::encode($experiment->name); ?></h3></div>
<?php  } ?>

<h1>Create Task</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'study'=>$study,'project'=>$project,'experiment'=>$experiment,'relatedUserList'=>$relatedUserList)); ?>
