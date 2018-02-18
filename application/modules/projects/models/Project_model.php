<?php

/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 5/5/17
 * Time: 12:14 PM
 */
class Project_model extends CI_Model
{
    /**
     * @var
     */
    private $user_id;
    /**
     * @var string
     */
    public static $table_name = "projects";
    /**
     * @var string
     */
    private static $table_name_forms = "xforms";

    /**
     * Project_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->user_id = $this->session->userdata('user_id');
    }

    /**
     * @param null $owner
     * @param null $filter_condition
     * @return int
     */
    function count_projects($owner = null, $filter_condition = null)
    {
        if ($filter_condition != null)
            $this->db->where($filter_condition, "", false);

        if ($owner != null)
            $this->db->where('owner', $owner);

        return $this->db->get(self::$table_name)->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @param null $owner
     * @param null $filter_condition
     * @return mixed
     */
    function get_project_list($num, $start, $owner = null, $filter_condition = null)
    {
        if ($filter_condition != null && $owner != null) {
            $this->db->where('owner', $owner);
            $this->db->or_where($filter_condition, "", false);
        } else {
            if ($owner != null)
                $this->db->where('owner', $owner);

            if ($filter_condition != null)
                $this->db->where('owner', $owner);
        }

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

    /**
     * @param $project_id
     * @param null $filter_condition
     * @return mixed
     */
    function find_project_forms($project_id, $filter_condition = null)
    {
        if ($filter_condition != null) {
            $this->db->where($filter_condition, "", false);
        }

        return $this->db->get_where(self::$table_name_forms, array('project_id' => $project_id))->result();
    }

    /**
     * @param $project_id
     * @param null $filter_condition
     * @return mixed
     */
    function count_project_forms($project_id, $filter_condition = null)
    {
        if ($filter_condition != null) {
            $this->db->where($filter_condition, "", false);
        }

        return $this->db->get_where(self::$table_name_forms, array('project_id' => $project_id))->num_rows();
    }

    public function add_project($project_details)
    {
        return $this->db->insert(self::$table_name, $project_details);
    }

}