<?php

class EXPORT {

    public $error;

    function __construct()
    {
        $this->_ci = get_instance();

        $this->_ci->config->load('export', true);
    }

    function __destruct()
    {

    }
/*
    private function cleanData(&$str)
    {
        // escape tab characters
        $str = preg_replace("/\t/", "\\t", $str);

        // escape new lines
        $str = preg_replace("/\r?\n/", "\\n", $str);

        // convert 't' and 'f' to boolean values
        if($str == 't') $str = 'TRUE';
        if($str == 'f') $str = 'FALSE';

        // force certain number/date formats to be imported as strings
        if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
            $str = "'$str";
        }

        // escape fields that include double quotes
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    public function export_csv($filename, $rows, $header)
    {
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");

        $out = fopen("php://output", 'w');

        foreach($rows as $row)
        {
            array_walk($row, 'cleanData');
            fputcsv($out, array_values($row), ',', '"');
        }

        fclose($out);
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
*/
} 