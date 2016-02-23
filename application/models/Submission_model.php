<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/8/2016
 * Time: 9:42 AM
 */
class Submission_model extends CI_Model
{
	private static $table_name = "submission_form";

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
		self::$table_name = $this->config->item("table_submission_form");
	}

	/**
	 * @param $data
	 * @return int id of the form data inserted
	 */
	public function create($data)
	{
		$this->db->insert(self::$table_name, $data);
		return $this->db->insert_id();
	}
}