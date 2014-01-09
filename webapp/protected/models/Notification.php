<?php

class Notification
{

	private static $templates = array(
		'newSignup' => '_newSignup',
		'userAdded' => '_userAdded',
		'newActivity' => '_newActivity',
		'activityReply' => '_activityReply',
		'newTask' => '_newTask',
		'passwordReset' => '_passwordReset',
		'taskComplete' => '_taskComplete'
	);

	private static $subjects = array(
		'userAdded' => 'You were added to a study',
		'newActivity' => 'A new comment was posted',
		'activityReply' => '',
		'newTask' => '',
		'passwordReset' => 'Password reset',
		'taskComplete' => '',
		'newSignup' => 'Welcome to Stirplate'
	);

	public static function sendEmail($type, $toUser, $obj)
	{
		$subject = Notification::$subjects[$type];
		$template = Notification::$templates[$type];
		$toName = $toUser->getName();
		$toEmail = $toUser->email;

        $contactEmail = trim($toUser->contactEmail);
        if(!empty($contactEmail)) {
            $toEmail = $contactEmail;
        }

		if ($type === 'userAdded')
		{
			$data = array();
			$data['studyName'] = $obj->project->title;
			$data['user'] =  User::model()->findByPk($obj->invitedUser);
			$data['invited_user'] =  User::model()->findByPk($obj->userId);

			$data['studyUrl'] = Yii::app()->createAbsoluteUrl('study/index', array('id' => $obj->id));
			Notification::_sendEmail($toName, $toEmail, $subject, $template, $data);
		}
		else if ($type === 'newActivity')
		{
			$data = array();
			$data['studyUrl'] = Yii::app()->createAbsoluteUrl('study/index', array('id' => $obj['study']->id));
			$data['studyName'] = $obj['study']->title;
			$data['authorName'] = $obj['author']->getName();
			$data['comment'] = $obj['activity']->content;
			Notification::_sendEmail($toName, $toEmail, $subject, $template, $data);	
		}
		else if ($type === 'activityReply')
		{

		}
		else if ($type === 'newTask')
		{

		}
		else if ($type === 'taskComplete')
		{

		}
		else if ($type === 'passwordReset') 
		{
			$data = array();
			$data['token'] =  Yii::app()->createAbsoluteUrl('site/changepass', array('k' => $obj['token']));
			Notification::_sendEmail($toName, $toEmail, $subject, $template, $data);
		}
		else if ($type === 'newSignup') 
		{
			
			Notification::_sendEmail($toName, $toEmail, $subject, $template, $obj);
		}
	}

	private static function _sendEmail($toName, $toEmail, $subject, $template, $data)
	{
		
		if (!Yii::app()->params['emailNotifications']) return;
        $emailJson = array(
        	'key' => Yii::app()->params['mandrilKey'],
        	'message' => array(
        		'html' => Yii::app()->controller->renderPartial('//email/' . $template . 'Html', $data, true),
        		'text' => Yii::app()->controller->renderPartial('//email/' . $template, $data, true),
        		'subject' => $subject,
        		'from_email' => 'info@stirplate.io',
        		'from_name' => 'Stirplate.IO',
        		'to' => array(
        			array(
        				'email' => $toEmail,
        				'name' => $toName,
        				'type' => 'to'
        			)
        		)
        	)
        );

        
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/json',
		        'content' => json_encode($emailJson)
		    )
		);

		$context  = stream_context_create($opts);
    $result = file_get_contents('https://mandrillapp.com/api/1.0/messages/send.json', false, $context);    
		// // Setup cURL
		// $ch = curl_init('https://mandrillapp.com/api/1.0/messages/send.json');
		// curl_setopt_array($ch, array(
		//     CURLOPT_POST => TRUE,
		//     CURLOPT_RETURNTRANSFER => TRUE,
		//     CURLOPT_HTTPHEADER => array(
		//         'Content-Type: application/json'
		//     ),
		//     CURLOPT_POSTFIELDS => json_encode($emailJson)
		// ));

		// // Send the request
		// $response = curl_exec($ch);

		// // Check for errors
		// if($response === FALSE){
		//     die(curl_error($ch));
		// }

		// // Decode the response
		// $responseData = json_decode($response, TRUE);

		// if (!isset($responseData[0]['status']) || $responseData[0]['status'] !== 'sent')
		// {
		// 	YII::log(json_encode($responseData), 'error', 'Notification._sendEmail');
		// }
	}


public static function sendEmailBluk($type, $toUsers, $obj)
	{
		$subject = Notification::$subjects[$type];
		$template = Notification::$templates[$type];

		if ($type === 'userAdded')
		{
			$data = array();
			$data['studyName'] = $obj->project->title;
			$data['user'] =  User::model()->findByPk($obj->invitedUser);
			$data['invited_user'] =  User::model()->findByPk($obj->userId);

			$data['studyUrl'] = Yii::app()->createAbsoluteUrl('study/index', array('id' => $obj->id));
			Notification::_sendEmailBluk($toUsers, $subject, $template, $data);
		}
		else if ($type === 'newActivity')
		{
			$data = array();
			$data['studyUrl'] = Yii::app()->createAbsoluteUrl('study/index', array('id' => $obj['study']->id));
			$data['studyName'] = $obj['study']->title;
			$data['authorName'] = $obj['author']->getName();
			$data['comment'] = $obj['activity']->content;
			Notification::_sendEmailBluk($toUsers, $subject, $template, $data);	
		}
		else if ($type === 'activityReply')
		{

		}
		else if ($type === 'newTask')
		{

		}
		else if ($type === 'taskComplete')
		{

		}
		else if ($type === 'passwordReset') 
		{
			$data = array();
			$data['token'] =  Yii::app()->createAbsoluteUrl('site/changepass', array('k' => $obj['token']));
			Notification::_sendEmailBluk($toUsers, $subject, $template, $data);
		}
		else if ($type === 'newSignup') 
		{
			
			Notification::_sendEmailBluk($toUsers, $subject, $template, $obj);
		}
	}

	private static function _sendEmailBluk($toUsers, $subject, $template, $data)
	{
		$to = array();
		foreach ($toUsers as $user) {
            $email = $user->email;
            $contactEmail = trim($user->contactEmail);
            if(!empty($contactEmail)) {
                $email = $contactEmail;
            }
			$to[] =  array('email' => $email, 'name' => $user->getName(), 'type' => 'to');
		}
		if (!Yii::app()->params['emailNotifications']) return;
        $emailJson = array(
        	'key' => Yii::app()->params['mandrilKey'],
        	'message' => array(
        		'html' => Yii::app()->controller->renderPartial('//email/' . $template . 'Html', $data, true),
        		'text' => Yii::app()->controller->renderPartial('//email/' . $template, $data, true),
        		'subject' => $subject,
        		'from_email' => 'info@stirplate.io',
        		'from_name' => 'Stirplate.IO',
        		'to' => $to
        		
        	)
        );

        
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/json',
		        'content' => json_encode($emailJson)
		    )
		);

		$context  = stream_context_create($opts);
    $result = file_get_contents('https://mandrillapp.com/api/1.0/messages/send.json', false, $context);    
	}
}