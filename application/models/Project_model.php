<?php

/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 5/5/17
 * Time: 12:14 PM
 */
class Project_model extends CI_Model
{
	private $user_id;
	private static $table_name = "projects";
	private static $table_name_forms = "xforms";

	public function __construct()
	{
		parent::__construct();
		$this->user_id = $this->session->userdata('user_id');
	}

	/**
	 * @param $table_name
	 * @param $column
	 */
	function where_condition($table_name, $column)
	{
		if (!$this->ion_auth->in_group('admin')) {
			$this->db->where($table_name . '.' . $column, $this->user_id);
		}
	}

	/**
	 * @return int
	 */
	function count_projects()
	{
		$this->where_condition('projects', 'owner');
		return $this->db->get(self::$table_name)->num_rows();
	}

	/**
	 * @param $num
	 * @param $start
	 * @return mixed
	 */
	function get_project_list($num, $start)
	{
		$this->where_condition('projects', 'owner');

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

	function find_project_forms($project_id)
	{
		return $this->db->get_where(self::$table_name_forms, array('project_id' => $project_id))->result();
	}

	function count_project_forms($project_id)
	{
		return $this->db->get_where(self::$table_name_forms, array('project_id' => $project_id))->num_rows();
	}

}