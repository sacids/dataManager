<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 25/11/2018
 * Time: 10:25
 */

class Users_group_model extends CI_Model
{
    public $table = 'users_groups';
    public $primary_key = 'id';

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

    //update
    function delete($where)
    {
        return $this->db->delete($this->table, $where);
    }
}