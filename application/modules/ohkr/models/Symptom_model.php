<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 30/08/2018
 * Time: 08:29
 */

class Symptom_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data
     * @return int
     */
    function create_symptom($data)
    {
        $result = $this->db->insert('ohkr_symptoms', $data);

        if ($result)
            return $this->db->insert_id();
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    function update_symptom($data, $id)
    {
        return $this->db->update('ohkr_symptoms', $data, array('id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete_symptom($id)
    {
        return $this->db->delete('ohkr_symptoms', array('id' => $id));
    }

    /**
     * @return mixed
     */
    function count_symptoms()
    {
        return $this->db
            ->get('ohkr_symptoms')->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return array
     */
    function get_symptoms_list($num, $start)
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->limit($num, $start)
            ->get('ohkr_symptoms')->result();
    }

    /**
     * @return array
     */
    function find_all()
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->get('ohkr_symptoms')->result();
    }

    /**
     * @param $id
     * @return mixed
     */
    function get_symptom_by_id($id)
    {
        return $this->db
            ->get_where('ohkr_symptoms', array('id' => $id))->row();
    }

}