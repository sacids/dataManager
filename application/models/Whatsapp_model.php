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
	 * @param $limit
	 * @param $offset
	 * @return mixed
	 */
	public function find_all_message($limit = 30, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		$this->db->order_by('date_sent_received', 'DESC');
		return $this->db->get(self::$table_name)->result();
	}

	/**
	 * @param $start_date
	 * @param $end_date
	 * @param $keyword
	 * @return mixed
	 */
	public function search_message($start_date = NULL, $end_date = NULL, $keyword = NULL)
	{
		if($start_date != NULL && $end_date != NULL)
			$this->db->where("date_sent_received BETWEEN '%$start_date`' AND '$end_date%'", NULL, FALSE);

		if ($keyword != NULL)
			$this->db->like("message", $keyword);

		$this->db->order_by('date_sent_received', 'DESC');
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