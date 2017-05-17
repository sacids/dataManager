<?php

/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 5/5/17
 * Time: 12:14 PM
 */
class Project_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param null $owner
     * @return mixed
     */
    function count_projects($owner = null)
    {
        if ($owner != null)
            $this->db->where('owner', $owner);

        return $this->db->get('projects')->num_rows();
    }

    /**
     * @param null $owner
     * @param $num
     * @param $start
     * @return mixed
     */
    function get_project_list($owner = null, $num, $start)
    {
        if ($owner != null)
            $this->db->where('owner', $owner);

        return $this->db
            ->limit($num, $start)
            ->get('projects')->result();
    }

    /**
     * @param $project_id
     * @return mixed
     */
    function get_project_by_id($project_id)
    {
        return $this->db->get_where('projects', array('id' => $project_id))->row();
    }

}