<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/29/2016
 * Time: 4:19 PM
 */
class Disease_model extends CI_Model
{
	//default table if not defined in conf/sacids.php
	private static $table_name = "diseases";
	private static $table_name_species = "species";
	private static $table_name_symptoms = "symptoms";

	public function __construct()
	{
		parent::__construct();
		if ($this->config->item("table_diseases"))
			self::$table_name = $this->config->item("table_diseases");

		if ($this->config->item("table_species"))
			self::$table_name_species = $this->config->item("table_species");

		if ($this->config->item("table_symptoms"))
			self::$table_name_symptoms = $this->config->item("table_symptoms");
	}

	public function add($disease)
	{
		return $this->db->insert(self::$table_name, $disease);
	}

	public function find_all($limit = 10, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get(self::$table_name)->result();
	}

	public function update($id, $disease)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_name, $disease);
	}

	public function add_specie($specie)
	{
		return $this->db->insert(self::$table_name_species, $specie);
	}

	public function find_all_species($limit = 30, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get(self::$table_name_species)->result();
	}

	public function add_symptom($symptoms)
	{
		return $this->db->insert(self::$table_name_symptoms, $symptoms);
	}

	public function find_all_symptoms($limit = 30, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get(self::$table_name_symptoms)->result();
	}
}