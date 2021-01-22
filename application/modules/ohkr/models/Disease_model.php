<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 30/08/2018
 * Time: 08:18
 */

class Disease_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data
     * @return int
     */
    function create_disease($data)
    {
        $result = $this->db->insert('ohkr_diseases', $data);

        if ($result)
            return $this->db->insert_id();
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    function update_disease($data, $id)
    {
        return $this->db->update('ohkr_diseases', $data, array('id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete_disease($id)
    {
        return $this->db->delete('ohkr_diseases', array('id' => $id));
    }

    /**
     * @return mixed
     */
    function count_diseases()
    {
        return $this->db
            ->get('ohkr_diseases')->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return array
     */
    function get_diseases_list($num, $start)
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->limit($num, $start)
            ->get('ohkr_diseases')->result();
    }

    /**
     * @return array
     */
    function find_all()
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->get('ohkr_diseases')->result();
    }

    /**
     * @param $id
     * @return mixed
     */
    function get_disease_by_id($id)
    {
        return $this->db
            ->get_where('ohkr_diseases', array('id' => $id))->row();
    }

    /**
     * @param $name
     * @return mixed
     */
    function get_disease_by_name($name)
    {
        return $this->db
            ->get_where('ohkr_diseases', array('title' => $name))->row();
    }

}