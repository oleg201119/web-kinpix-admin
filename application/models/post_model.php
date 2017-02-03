<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Post_model extends CI_Model {

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

    function get_photos($start, $limit)
    {
        $param_array = array();

        $sql = "SELECT
                    ownuserid,
                    ownfirstname,
                    ownlastname,
                    ownemail,

                    flaguserid,
                    flagfirstname,
                    flaglastname,
                    flagemail,

                    flagdate,

                    photoid,
                    photourl,
                    thumburl
                FROM
                    v_flagedphoto
                ";

        $sql .= " ORDER BY flagdate DESC";

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

    function delete_photo($photoid)
    {
        $sql = "DELETE FROM tbl_photo WHERE cip_photoid = ?";
        $param_array = array($photoid);
        $this->db->query($sql, $param_array);
    }

    function ignore_accusation($photoid)
    {
        $sql = "DELETE FROM tbl_flag WHERE cif_flg_photoid = ?";
        $param_array = array($photoid);
        $this->db->query($sql, $param_array);
    }

}