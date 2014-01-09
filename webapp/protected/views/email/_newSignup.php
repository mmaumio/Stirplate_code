<?php $activ = base64_encode($records->created); ?>
Hi <?php echo ( $records->firstName.' '.$records->lastName); ?>
Please click on the link given below to verify your email.
<?php echo (Yii::app()->params['siteUrl'].Yii::app()->createAbsoluteUrl('/site/verifyemail',array('key'=>$records->keystring,'string'=>$string))); ?>

Regards,
Stirplate Team