<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 09/06/2019
 * Time: 11:28
 */

class Perms_method_model extends CI_Model
{
    public $table = 'perms_methods';
    public $primary_key = 'id';
    public $timestamps = FALSE;

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