<html>
<head>
</head>
<body>	
<?php echo Yii::app()->user->name;?> has invited you to contribute to a study: <?php echo $study->title ?>
</br>
<a href="http://os.setsocial.com/collaboration/accept?guid=<?php echo $guid;?>" >Accept Invitation</a>
</body>
</html>
