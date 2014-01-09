<?php
/**
* This class contains General Functions for use in project. 
*/
class GeneralFunctions {


    /**
     * How many times has passed
     * @param unknown $time
     * @return string
     */
    /**
     * How many times has passed
     * @param unknown $time
     * @return string
     */
    public static function getPrettyTime($from, $to=null){
        
        if(trim($from)==='' || is_null($from) || trim($from)==='0000-00-00 00:00:00')
            return NULL;    
        
    	$from = strtotime($from);
    	$periods = array("second", "minute", "hour", "day", "week", "month", "year");
    	$lengths = array("60","60","24","7","4.35","12","10");
    
    	$now = time();
    	$difference = $now - $from;
    	$tense = "ago";
    
    	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
    		$difference /= $lengths[$j];
    	}
    
    	$difference = round($difference);
    
    	if($difference != 1) {
    		$periods[$j].= "s";
    	}
    	
    	
    	if($periods[$j] == "seconds") {
    		$result = "a moment ago ";
    	} else {
    		$result = "$difference $periods[$j] ago ";
    	}
    
    	return $result;    	
    }
	
    
    public static function getUsername($user_id=NULL){
        
        if(is_null($user_id)){
            $user_id = Yii::app()->session['uid'];
        }
        
        $user = User::model()->findByPk($user_id);
        
        return $user->firstName.'_'.$user->lastName;
        
    }	
    

	    
}