<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 30/08/2018
 * Time: 08:29
 */

class Symptom_model extends CI_Model
{
    public $table = 'ohkr_symptoms';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data
     * @return int
     */
    function insert($data)
    {
        $result = $this->db->insert($this->table, $data);

        if ($result)
            return $this->db->insert_id();
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    function update($data, $id)
    {
        return $this->db->update($this->table, $data, array('id' => $id));
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    function update_by($data, $where)
    {
        return $this->db->update($this->table, $data, $where);
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete_by($where)
    {
        return $this->db->delete($this->table, $where);
    }

    /**
     * @return mixed
     */
    function count_all()
    {
        return $this->db->get($this->table)->num_rows();
    }

    /**
     * @return mixed
     */
    function count_many($where)
    {
        return $this->db->get($this->table, $where)->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return array
     */
    function get_all($num, $start)
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->limit($num, $start)
            ->get($this->table)->result();
    }

    /**
     * @return array
     */
    function find_all()
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->get($this->table)->result();
    }

    /**
     * @return array
     */
    function get_many($where)
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->get_where($this->table, $where)->result();
    }

    /**
     * @return array
     */
    function get($id)
    {
        return $this->db
            ->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * @return array
     */
    function get_by($where)
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->get_where($this->table, $where)->row();
    }
}
