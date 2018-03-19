<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 19/03/2018
 * Time: 11:47
 */

class Media_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data
     * @return bool
     */
    function create_media($data)
    {
        return $this->db->insert('media', $data);
    }

    /**
     * @return int
     */
    function count_media()
    {
        return $this->db->get('media')->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return array
     */
    function get_media_list($num, $start)
    {
        return $this->db
            ->limit($num, $start)
            ->order_by('date_created', 'DESC')
            ->get('media')->result();
    }

}