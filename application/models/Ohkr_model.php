<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/29/2016
 * Time: 4:19 PM
 */
class Ohkr_model extends CI_Model
{
	//default table if not defined in conf/sacids.php
	private static $table_name_disease = "diseases";
	private static $table_name_species = "species";
	private static $table_name_symptoms = "symptoms";
	private static $table_name_disease_symptoms = "diseases_symptoms";

	public function __construct()
	{
		parent::__construct();
		if ($this->config->item("table_diseases"))
			self::$table_name_disease = $this->config->item("table_diseases");

		if ($this->config->item("table_species"))
			self::$table_name_species = $this->config->item("table_species");

		if ($this->config->item("table_symptoms"))
			self::$table_name_symptoms = $this->config->item("table_symptoms");
	}

	public function add_disease($disease)
	{
		return $this->db->insert(self::$table_name_disease, $disease);
	}

	public function find_all_disease($limit = 10, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get(self::$table_name_disease)->result();
	}

	/**
	 * @param $disease_id
	 * @return mixed
	 */
	public function get_disease_by_id($disease_id)
	{
		return $this->db->get_where(self::$table_name_disease, array('id' => $disease_id))->row();
	}

	public function update_disease($id, $disease)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_name_disease, $disease);
	}

	public function delete_disease($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete(self::$table_name_disease);
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

	/**
	 * @param $specie_id
	 * @return mixed
	 */
	public function get_specie_by_id($specie_id)
	{
		return $this->db->get_where(self::$table_name_species, array('id' => $specie_id))->row();
	}

	public function update_specie($id, $specie)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_name_species, $specie);
	}

	public function delete_specie($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete(self::$table_name_species);
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

	/**
	 * @param $symptom_id
	 * @return mixed
	 */
	public function get_symptom_by_id($symptom_id)
	{
		return $this->db->get_where(self::$table_name_symptoms, array('id' => $symptom_id))->row();
	}

	public function update_symptom($id, $symptom)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_name_symptoms, $symptom);
	}

	public function delete_symptom($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete(self::$table_name_symptoms);
	}

	public function find_disease_symptoms($disease_id)
	{
		$query = $this->db->select('ds.id, s.name as symptom_name, sp.name as specie_name,ds.importance')
			->join(self::$table_name_symptoms . " s", 's.id = ds.symptom_id')
			->join(self::$table_name_species . " sp", 'sp.id = ds.specie_id')
			->get_where(self::$table_name_disease_symptoms . " ds", array('ds.disease_id' => $disease_id))->result();
		return $query;
	}

	public function get_disease_symptom_by_id($disease_symptom_id)
	{
		return $this->db->get_where(self::$table_name_disease_symptoms, array('id' => $disease_symptom_id))->row();
	}

	public function add_disease_symptom($symptoms)
	{
		return $this->db->insert(self::$table_name_disease_symptoms, $symptoms);
	}

	public function update_disease_symptom($id, $symptom)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_name_disease_symptoms, $symptom);
	}

	public function delete_disease_symptom($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete(self::$table_name_disease_symptoms);
	}
}