<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model {

    /*******************************************************************************************************************
     *
     * Model function
     *
     ******************************************************************************************************************/
    function __construct()
    {
        parent::__construct();
    }

    function convert_value($array)
    {
        $result = array();
        if (count($array) < 1)
            return $result;

        foreach ($array as $item)
        {
            foreach ($item as $key => $value)
            {
                if (is_null($value) || $value === null)
                    $item[$key] = "";
                else if (is_array($value))
                    $item[$key] = $this->convert_value($value);
            }

            array_push($result, $item);
        }
        return $result;
    }

    function get_total_user()
    {
        $sql = "SELECT COUNT(*) total_user FROM v_userview";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        return $query->row(0)->total_user;
    }

    function search_user($search_field, $search_val, $sort_field, $order_field, $start, $limit)
    {
        $param_array = array();

        $sql = "SELECT
                    userid,
                    accounttype,
                    totalphoto,
                    totalfriends,
                    IF (lastlogindate1 IS NULL, '', DATE_FORMAT(lastlogindate1, '%d/%m/%Y')) lastlogindate,
                    last30dayslogincount,
                    last90dayslogincount,
                    last30daysphotocount,
                    last90daysphotocount,
                    deviceplatform,
                    email,
                    pin,
                    firstname,
                    lastname,
                    city,
                    state,
                    country,
                    DATE_FORMAT(accountcreatedate1, '%d/%m/%Y') accountcreatedate,
                    IF (accountsuspenddate1 IS NULL, '', DATE_FORMAT(accountsuspenddate1, '%d/%m/%Y')) accountsuspenddate,
                    IF (iaplastdate1 IS NULL, '', DATE_FORMAT(iaplastdate1, '%d/%m/%Y')) iaplastdate,
                    iaptype,
                    accountstatus
                FROM v_userview";

        if ($search_val != "")
        {
            $sql .= " WHERE " . $search_field . " like " . "?";
            $param_array[] = "%" . $search_val . "%";
        }
        
        if ($sort_field == "accountsuspenddate")
        	$sort_field = "accountsuspenddate1";
        else if ($sort_field == "accountcreatedate")
        	$sort_field = "accountcreatedate1";
        else if ($sort_field == "lastlogindate")
        	$sort_field = "lastlogindate1";
	        
        $sql .= " ORDER BY " . $sort_field . " " . $order_field;

        // Get total count
        $query = $this->db->query($sql, $param_array);
        $total_count = $query->num_rows();
        $query->free_result();

        // Get page content
        $sql .= " LIMIT $start, $limit";
        $query = $this->db->query($sql, $param_array);
        $data_count = $query->num_rows();
        $content = $this->convert_value($query->result_array());
        $query->free_result();

        return array(
            "data"          => $content,
            "data_count"    => $data_count,
            "total_count"   => $total_count
        );
    }

    function export_user($search_field, $search_val, $sort_field, $order_field)
    {
        $param_array = array();

        $sql = "SELECT
                    firstname AS 'First Name',
                    lastname AS 'Last Name',
                    email AS 'Email Address',
                    pin AS 'PIN',
                    DATE_FORMAT(accountcreatedate1, '%d/%m/%Y') AS 'Account Creation Date',
                    accounttype AS 'Account Type',
                    accountstatus AS 'Account Status',
                    totalphoto AS 'Total Photos',
                    totalfriends AS 'Total Friends',
                    deviceplatform AS 'User Platform',
                    IF (lastlogindate1 IS NULL, '', DATE_FORMAT(lastlogindate1, '%d/%m/%Y')) AS 'Last Activity Date',
                    last30dayslogincount AS 'Activity in the last 0-30 days',
                    last90dayslogincount AS 'Activity in the last 31-90 days',
                    last30daysphotocount AS 'Shared Photos in the last 0-30 days',
                    last90daysphotocount AS 'Shared Photos in the last 31-90 days',
                    city AS 'City',
                    state AS 'State',
                    country AS 'Country',
                    IF (iaplastdate1 IS NULL, '', DATE_FORMAT(iaplastdate1, '%d/%m/%Y')) AS 'Last In-App Purchase Date',
                    iaptype AS 'In-App Purchase Type',
                    IF (accountsuspenddate1 IS NULL, '', DATE_FORMAT(accountsuspenddate1, '%d/%m/%Y')) AS 'Date Last Suspended'
                FROM v_userview";

        if ($search_val != "")
        {
            $sql .= " WHERE " . $search_field . " like " . "?";
            $param_array[] = "%" . $search_val . "%";
        }

        if ($sort_field == "accountsuspenddate")
        	$sort_field = "accountsuspenddate1";
        else if ($sort_field == "accountcreatedate")
        	$sort_field = "accountcreatedate1";
        else if ($sort_field == "lastlogindate")
        	$sort_field = "lastlogindate1";
        
        $sql .= " ORDER BY " . $sort_field . " " . $order_field;

        $this->load->dbutil();
        $query = $this->db->query($sql, $param_array);

        return $this->dbutil->csv_from_result($query, ",", "\r\n");
    }

    function update_userstate($userid, $state)
    {
        $date = new DateTime();
        $now = $date->format("Y-m-d H:i:s");

        if ($state == 1) // active
        {
        	$strQuery = "UPDATE tbl_user SET ci_accdate = NOW() WHERE cip_userid = $userid AND ci_accdate IS NULL";
        	$this->db->query($strQuery);
            $sql = "UPDATE tbl_user SET ci_userflag=? WHERE cip_userid=?";
            $param_array = array($state, $userid);
        }
        else if ($state == 2) // suspended
        {
            $sql = "UPDATE tbl_user SET ci_userflag=?, ci_supdate=? WHERE cip_userid=?";
            $param_array = array($state, $now, $userid);
        }
        else
        {
            $sql = "UPDATE tbl_user SET ci_userflag=? WHERE cip_userid=?";
            $param_array = array($state, $userid);
        }

        $this->db->query($sql, $param_array);

        // Get email
        $sql = "SELECT ci_email email, ci_verifycode verifycode FROM tbl_user WHERE cip_userid = ?";
        $param_array = array($userid);
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() == 1)
        {
            $row = $query->row_array();
            return $row;
        }

        return null;
    }

    function accept_user($userid)
    {
        $info = $this->update_userstate($userid, 1);

        if ($info)
        {
            $this->load->library('email');
            $config['protocol'] = 'smtp';
            $config['wordwrap'] = TRUE;
            $config['smtp_user'] = "schwartz@kinleague.com";
            $config['smtp_pass'] = "6FR7PFaQJNv5mkwHrWDyRA";
            $config['smtp_port'] = "587";
            $config['smtp_host'] = "smtp.mandrillapp.com";

            $this->email->initialize($config);

            $this->email->subject('Your KinPix verification code.');
            $this->email->from('support@kinpix.co', 'KinPix');
            $this->email->to($info['email']);
            $this->email->set_mailtype("html");

            $data['verifycode'] = $info['verifycode'];
            $data['email'] = $info['email'];
            $message = $this->load->view('email/verify_email', $data, true);
            $this->email->message($message);
            $status = $this->email->send();
        }
    }

    function reject_user($userid)
    {
        $this->delete_user($userid);
    }

    function delete_user($userid)
    {
        $sql = "DELETE FROM tbl_user WHERE cip_userid=?";
        $param_array = array($userid);
        $this->db->query($sql, $param_array);
    }

    function suspend_user($userid)
    {
        $info = $this->update_userstate($userid, 2);
    }

    function unsuspend_user($userid)
    {
        $info = $this->update_userstate($userid, 1);
    }

    function maillist()
    {
        $sql = "SELECT ci_email FROM tbl_user WHERE ci_userflag = 1 AND ci_verifyed = 1";
        $query = $this->db->query($sql);

        $result = array();
        foreach ($query->result_array() as $idx)
            array_push($result, $idx["ci_email"]);
        return implode(",", $result);
    }

    function send_update_mail($item)
    {
        $msg = "$item are updated. Please check";
        $mailaddrs = $this->maillist();
        if (strlen($mailaddrs) < 5)
            return;

        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['wordwrap'] = TRUE;
        $config['smtp_user'] = "schwartz@kinleague.com";
        $config['smtp_pass'] = "6FR7PFaQJNv5mkwHrWDyRA";
        $config['smtp_port'] = "587";
        $config['smtp_host'] = "smtp.mandrillapp.com";

        $this->email->initialize($config);

        $this->email->subject('KinPix Notification.');
        $this->email->from('support@kinpix.co', 'KinPix');
        $this->email->to($mailaddrs);
        $this->email->set_mailtype("html");

        $this->email->message($msg);
        $status = $this->email->send();
    }

    function change_usertype($userid, $usertype)
    {
        $sql = "UPDATE tbl_user SET ci_userlevel=? WHERE cip_userid=?";
        $param_array = array($usertype, $userid);
        $this->db->query($sql, $param_array);
        
        $this->db->insert("tbl_iaphistory", array("cif_iapuserid"=>$userid, "ci_leveltype"=>$usertype));
    }
}