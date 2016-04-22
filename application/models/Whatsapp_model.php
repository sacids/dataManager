<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 4/21/2016
 * Time: 5:37 PM
 */
class Whatsapp_model extends CI_Model
{

	private static $table_name = "whatsapp";

	public function __construct()
	{
		parent::__construct();
	}

	public function create($message)
	{
		return $this->db->insert(self::$table_name, $message);
	}

	/**
	 * @return int
	 */
	public function find_all_message($limit = 30, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get(self::$table_name)->result();
	}


	/**
	 * @return int
	 */
	public function count_message()
	{
		$this->db->from(self::$table_name);
		return $this->db->count_all_results();
	}
}