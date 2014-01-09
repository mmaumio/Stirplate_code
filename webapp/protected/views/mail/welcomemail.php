<html>
<head>
</head>
<body>	<?php $activ = base64_encode($records->created); ?>
<p>Hi <?php echo ( $records->firstName.' '.$records->lastName); ?></p><br>
<p>Please click on the link given below to verify your email.<br>
<a href="<?php echo (Yii::app()->params['siteUrl'].$this->createUrl('/site/verifyemail',array('key'=>$activ,'string'=>$string))); ?>">Click here</a></p><br>
<p>Or copy paste the below given url in your browser </p><br>
<p> <?php echo Yii::app()->params['siteUrl'].$this->createUrl('/site/verifyemail',array('key'=>$activ,'string'=>$string)); ?>
<p>Regards,<br>
Stirplate Team</p><br>
</body>
</html>
