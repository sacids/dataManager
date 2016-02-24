<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/8/2016
 * Time: 9:42 AM
 */
class Submission_model extends CI_Model
{
	/**
	 * @var string default table name, if left blank, the value from config file will be used
	 */
	private static $table_name = "submission_form";

	/**
	 * Submission_model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->initialize_table();
	}

	/**
	 * Initializes table names from configuration files
	 */
	private function initialize_table()
	{
		if ($this->config->item("table_form_submission"))
			self::$table_name = $this->config->item("table_form_submission");
	}

	/**
	 * @param $data array with corresponding table fields
	 * @return int id of the form data inserted
	 */
	public function create($data)
	{
		$this->db->insert(self::$table_name, $data);
		return $this->db->insert_id();
	}

	/**
	 * @param $submission_id
	 * @return mixed
	 */
	public function delete_submission($submission_id)
	{
		$this->db->where("id", $submission_id);
		return $this->db->delete(self::$table_name);
	}
}