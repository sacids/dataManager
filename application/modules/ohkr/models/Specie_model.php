<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 30/08/2018
 * Time: 08:43
 */

class Specie_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data
     * @return int
     */
    function create_specie($data)
    {
        $result = $this->db->insert('ohkr_species', $data);

        if ($result)
            return $this->db->insert_id();
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    function update_specie($data, $id)
    {
        return $this->db->update('ohkr_species', $data, array('id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete_specie($id)
    {
        return $this->db->delete('ohkr_species', array('id' => $id));
    }

    /**
     * @return mixed
     */
    function count_species()
    {
        return $this->db
            ->get('ohkr_species')->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return array
     */
    function get_species_list($num, $start)
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->limit($num, $start)
            ->get('ohkr_species')->result();
    }

    /**
     * @return array
     */
    function find_all()
    {
        return $this->db
            ->order_by('title', 'ASC')
            ->get('ohkr_species')->result();
    }

    /**
     * @param $id
     * @return mixed
     */
    function get_specie_by_id($id)
    {
        return $this->db
            ->get_where('ohkr_species', array('id' => $id))->row();
    }

    /**
     * @param $name
     * @return mixed
     */
    function get_specie_by_name($name)
    {
        return $this->db
            ->get_where('ohkr_species', array('title' => $name))->row();
    }
}