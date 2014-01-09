<?php

class Omniscience extends CController
{
      /**
       * get users from a project
       */
      public static function getUsers($projectId){
        return CHtml::listData(ProjectUser::model()->findAll(array('condition' => 'projectId ='.$projectId)),'userId',function($model){
            return CHtml::encode($model->user->firstName.' '.$model->user->lastName);
        });
       }
       
       /**
        *  checks if user with email of keith is present
        */
       public static function Keithid(){
           $user = User::model()->findByAttributes(array('email'=>'keith@stirplate.io'));
           if(isset($user) && !empty($user)){
               return $user->id;
           }else{
               $user = new User;
               $user->email = 'keith@stirplate.io';
               $user->firstName = 'Keith';
               $user->lastName = 'Gonzales';
               $user->contactEmail = 'keith@stirplate.io';
               if($user->save()){
                   return $user->id;
               }
           }
       }
       
}
?>
