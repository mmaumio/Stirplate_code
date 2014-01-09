<html>
<head>
</head>
<body>	<?php $activ = md5($records->id).md5(strtotime($records->created)); ?>
<p>Hi <?php echo ( $records->firstName.' '.$records->lastName); ?></p><br>
<p>Please click on the link given below to change your password.<br>
<a href="<?php echo (Yii::app()->params['siteUrl'].$this->createUrl('/site/changepass',array('k'=>$activ))); ?>">Click here</a></p><br>
<p>Or copy paste the below given url in your browser </p><br>
<p> <?php echo Yii::app()->params['siteUrl'].$this->createUrl('/site/changepass',array('k'=>$activ)); ?>
<p>Regards,<br>
Stirplate Team</p><br>
</body>
</html>
