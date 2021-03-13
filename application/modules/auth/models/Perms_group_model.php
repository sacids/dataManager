<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 19/12/2018
 * Time: 11:05
 */

class Perms_group_model extends CI_Model
{
    public $table = 'perms_groups';
    public $primary_key = 'id';
    public $timestamps = FALSE;

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


    /**
     * @return array
     */
    function get_perms_all()
    {
        $module = array();
        $perms_module = $this->db
            ->order_by('sequence', 'ASC')->get('perms_class')->result();

        foreach ($perms_module as $key => $value) {
            $perms = $this->db->get_where('perms_methods', array('class_id' => $value->id))->result();

            foreach ($perms as $k => $v) {
                $module[$value->label][$v->method] = array($value->id, $v->id, $v->label);
            }
        }
        return $module;
    }
}