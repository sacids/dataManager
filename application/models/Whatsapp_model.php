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
}