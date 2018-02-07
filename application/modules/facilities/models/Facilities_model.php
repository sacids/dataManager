<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 29/09/2017
 * Time: 13:05
 */
class Facilities_model extends CI_Model
{
    private $user_id;
    private static $table_name = "health_facilities";


    public function __construct()
    {
        parent::__construct();
        $this->user_id = $this->session->userdata('user_id');
    }

    /**
     * @return int
     */
    function count_facilities()
    {
        return $this->db->get(self::$table_name)->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return mixed
     */
    function get_facilities_list($num, $start)
    {
        return $this->db
            ->limit($num, $start)
            ->get(self::$table_name)->result();
    }

    /**
     * @param $id
     * @return mixed
     */
    function get_facility_by_id($id)
    {
        return $this->db->get_where(self::$table_name, array('id' => $id))->row();
    }

}