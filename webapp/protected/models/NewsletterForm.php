<?php
Yii::import('application.extensions.*');
require_once'Mailchimp/MailchimpStream.php';


/**
 * NewsletterForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class NewsletterForm extends CFormModel
{
    public $email;
    /**
     * @var Mailchimp
     */
    private $mc;
    public $spamblocker; 
    /**
     * Declares the validation rules.
     * The rules state that email is required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('email,spamblocker', 'required'),
            
            array('email', 'email')
        );
    }

    /**
     * @return bool add subscription in mailchimp
     */
    public function process()
    {
        try {
            $this->mc = new MailchimpStream(Yii::app()->params['mailChimpApiKey']);
            $this->mc->lists->subscribe(
                Yii::app()->params['mailChimpListId'],
                array('email' => $this->email)
            );

            return true;
        } catch (Mailchimp_Error $e) {
            $this->addError('email', $e->getMessage());
        }
        return false;
    }
}
