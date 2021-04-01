<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 24/09/2018
 * Time: 10:26
 */

class Group_model extends CI_Model
{
    public $table = 'groups';
    public $primary_key = 'id';

    //insert data
    function insert($data)
    {
        $result = $this->db->insert($this->table, $data);

        if ($result)
            return $this->db->insert_id();
        else
            return 0;
    }

    //update
    function update($where, $data)
    {
        return $this->db->update($this->table, $data, $where);
    }

    //update
    function delete($where)
    {
        return $this->db->delete($this->table, $where);
    }

    //get all regions
    function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    //find all
    function find_all($where)
    {
        return $this->db->get_where($this->table, $where)->result();
    }

    //get by
    function get_by($where)
    {
        return $this->db->get_where($this->table, $where)->row();
    }

}