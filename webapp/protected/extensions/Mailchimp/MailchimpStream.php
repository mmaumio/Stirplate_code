<?php
/**
 * Replaces curl calls
 */
require_once 'Mailchimp.php';


class MailchimpStream extends  Mailchimp {

    public function call($url, $params) {
        $params['apikey'] = $this->apikey;
        $params = json_encode($params);

        $opts = array('http' =>
                      array(
                          'method'  => 'POST',
                          'header'  => 'Content-type: application/json',
                          'content' => $params
                      )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents($this->root . $url . '.json', false, $context);
        return $result;
    }

}


