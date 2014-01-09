<?php
/* @var $this LoginController */

$this->breadcrumbs=array(
	'Login',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>

<?php print_r($user) ?>

<?php print_r($userDetails) ?>

<p>User id:<?php echo Yii::app()->user->id ?></p>
<p>Name:<?php echo Yii::app()->user->name ?></p>

<p>isGuest:<?php echo Yii::app()->user->isGuest ?></p>