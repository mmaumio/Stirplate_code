<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List User', 'url'=>array('index')),
	//array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Edit Profile', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->firstName . " " . $model->lastName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
	//	'firstName',
	//	'lastName',
		'email',
		'gender',
		'link',
	//	'timezone',
	//	'locale',
	//	'type',
	//	'status',
	//	'profileImageUrl',
		'created',
	//	'modified',
		'position',
		'affiliation',
		'department',
		'fieldOfStudy',
		'labTitle',
		'labUrl',
		'researchInterests',
		'socialMediaFacebook',
		'socialMediaTwitter',
		'socialMediaLinkedIn',
	),
)); ?>
