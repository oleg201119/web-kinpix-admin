<?php
/**
 * Created by PhpStorm.
 * User: wangming
 * Date: 5/26/14
 * Time: 2:01 PM
 */

class GCM {

    protected $api_key;

    public $error;

    function __construct()
    {
        $this->_ci = get_instance();

        $this->_ci->config->load('gcm', true);

        $this->api_key = $this->_ci->config->item('GOOGLE_API_KEY', 'gcm');
    }

    function __destruct()
    {

    }

    public function send_notification($registatoin_ids, $message)
    {
        log_message('debug',"GCM: send_notification to '$registatoin_ids[0]'");

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $msg = array
        (
            'message' 		=> $message,
            'title'			=> 'New coffee added',
            'subtitle'		=> '',
            'tickerText'	=> '',
            'vibrate'	    => 1,
            'sound'		    => 1
        );

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $msg,
        );

        $headers = array(
            'Authorization: key=' . $this->api_key,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            log_message('debug',"GCM: curl_exec error: " . curl_error($ch));
            return false;
        }

        // Close connection
        curl_close($ch);
        return true;
    }
} 