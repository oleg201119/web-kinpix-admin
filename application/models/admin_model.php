<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_model extends CI_Model {

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

    function check_user($username, $password)
    {
        $sql = "SELECT * FROM tbl_admin WHERE cip_username=? AND ci_password=?";
        $param_array = array($username, md5($password));
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() > 0)
        {
            return $query->row(0)->ci_adminflag;
        }
        else
        {
            return -1;
        }
    }

    function check_username($username)
    {
        $sql = "SELECT * FROM tbl_admin WHERE cip_username=?";
        $param_array = array($username);
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() == 0)
        {
            return 1;
        }
        else
        {
            return -1;
        }
    }

    function change_password($username, $password)
    {
        $sql = "UPDATE tbl_admin SET ci_password=? WHERE cip_username=?";
        $param_array = array(md5($password), $username);
        $this->db->query($sql, $param_array);
    }

    function get_admins($start, $limit)
    {
        $param_array = array();

        $sql = "SELECT
                    cip_username username,
                    ci_adminflag adminflag
                FROM tbl_admin";

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

    function new_admin($username, $password, $adminflag)
    {
        // Check username
        $sql = "SELECT *  FROM tbl_admin WHERE cip_username=?";
        $param_array = array($username);
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() > 0)
        {
            return -1;
        }

        // Insert
        $sql = "INSERT INTO tbl_admin
                SET
                    cip_username=?,
                    ci_password=?,
                    ci_adminflag=?
                ";
        $param_array = array($username, md5($password), $adminflag);
        $this->db->query($sql, $param_array);

        return 1;
    }

    function edit_admin($username_old, $username, $password, $adminflag)
    {
        if (strlen($password) > 0)
        {
            // change username & password
            $sql = "UPDATE tbl_admin SET cip_username=?, ci_password=?, ci_adminflag=? WHERE cip_username=?";
            $param_array = array($username, md5($password), $adminflag, $username_old);
            $this->db->query($sql, $param_array);
        }
        else
        {
            $sql = "UPDATE tbl_admin SET cip_username=?, ci_adminflag=? WHERE cip_username=?";
            $param_array = array($username, $adminflag, $username_old);
            $this->db->query($sql, $param_array);
        }
    }

    function delete_admin($username)
    {
        $sql = "DELETE FROM tbl_admin WHERE cip_username=?";
        $param_array = array($username);
        $this->db->query($sql, $param_array);
    }

    function get_settings()
    {
        $sql = "SELECT ci_comprate comprate, ci_autosignflag autosignflag FROM tbl_adminconfig";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() > 0)
        {
            return array(
                'comprate'  => $query->row(0)->comprate,
                'autosignflag'  => $query->row(0)->autosignflag
            );
        }
        else
        {
            return array(
                'comprate'  => 100,
                'autosignflag'  => 0
            );
        }
    }

    function set_settings($comprate, $autosignflag)
    {
        $sql = "UPDATE tbl_adminconfig SET ci_comprate=?, ci_autosignflag=?";
        $param_array = array($comprate, $autosignflag);
        $this->db->query($sql, $param_array);
    }

    function get_screencontent($screen)
    {
        $id = 0;

        if ($screen == 'about') {
            $id = 1;
        }

        if ($screen == 'help') {
            $id = 2;
        }

        if ($screen == 'feedback') {
            $id = 3;
        }

        if ($screen == 'privacy') {
            $id = 4;
        }

        if ($screen == 'terms') {
            $id = 5;
        }

        $sql = "SELECT ci_content FROM tbl_content WHERE cip_id=?";
        $param_array = array($id);
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() == 0)
            return "";
        else
            return $query->row(0)->ci_content;
    }

    function set_screencontent($screen, $content)
    {
        $id = 0;

        if ($screen == 'about') {
            $id = 1;
        }

        if ($screen == 'help') {
            $id = 2;
        }

        if ($screen == 'feedback') {
            $id = 3;
        }

        if ($screen == 'privacy') {
            $id = 4;
        }

        if ($screen == 'terms') {
            $id = 5;
        }

        $sql = "UPDATE tbl_content SET ci_content=? WHERE cip_id=?";
        $param_array = array($content, $id);
        $this->db->query($sql, $param_array);
    }
}