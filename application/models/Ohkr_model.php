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
	private static $table_name_diseases = "ohkr_diseases";
	private static $table_name_species = "ohkr_species";
	private static $table_name_symptoms = "ohkr_symptoms";
	private static $table_disease_symptoms = "ohkr_disease_symptoms";
	private static $table_name_faq = "ohkr_faq";
	private static $table_name_response_sms = "ohkr_response_sms";
	private static $table_name_sent_sms = "ohkr_sent_sms";
	private static $table_name_users = "users";
	private static $table_name_user_groups = "groups";
	private static $table_name_users_groups = "users_groups";
	private static $table_name_detected_diseases = "ohkr_detected_diseases";

	public function __construct()
	{
		parent::__construct();
		if ($this->config->item("table_diseases"))
			self::$table_name_diseases = $this->config->item("table_diseases");

		if ($this->config->item("table_species"))
			self::$table_name_species = $this->config->item("table_species");

		if ($this->config->item("table_symptoms"))
			self::$table_name_symptoms = $this->config->item("table_symptoms");
	}

	public function add_disease($disease)
	{
		$this->db->insert(self::$table_name_diseases, $disease);
		return $this->db->insert_id();

	}

	public function find_all_disease($limit = 30, $offset = 0)
	{
		$this->db->select('disease.id, disease.description, disease.title as disease_title, specie.title as specie_title')
			->join(self::$table_name_species . " specie ", "disease.specie_id = specie.id")
			->limit($limit, $offset);
		return $this->db->get(self::$table_name_diseases . " disease")->result();
	}

	/**
	 * @param $disease_id
	 * @return mixed
	 */
	public function get_disease_by_id($disease_id)
	{
		$this->db->select('disease.id, disease.description, disease.title as d_title, specie.id as s_id, specie.title as s_title')
			->join(self::$table_name_species . " specie ", "disease.specie_id = specie.id");
		return $this->db->get_where(self::$table_name_diseases . " disease", array('disease.id' => $disease_id))->row();
	}

	/**
	 * @return int
	 */
	public function count_disease()
	{
		$this->db->from(self::$table_name_diseases);
		return $this->db->count_all_results();
	}

	public function update_disease($id, $disease)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_name_diseases, $disease);
	}

	public function delete_disease($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete(self::$table_name_diseases);
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

	/**
	 * @return int
	 */
	public function count_species()
	{
		$this->db->from(self::$table_name_species);
		return $this->db->count_all_results();
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

	/**
	 * @return int
	 */
	public function count_symptoms()
	{
		$this->db->from(self::$table_name_symptoms);
		return $this->db->count_all_results();
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
		$this->db->select("ds.id, ds. disease_id, ds.importance, symptom.title as symptom_title")
			->join(self::$table_name_symptoms . " symptom", "ds.symptom_id = symptom.id");
		return $this->db->get_where(self::$table_disease_symptoms . " ds", array("disease_id" => $disease_id))->result();
	}

	public function get_disease_symptom_by_id($disease_symptom_id)
	{
		return $this->db->get_where(self::$table_disease_symptoms, array('id' => $disease_symptom_id))->row();
	}

	public function add_disease_symptom($symptoms)
	{
		return $this->db->insert(self::$table_disease_symptoms, $symptoms);
	}

	public function update_disease_symptom($id, $symptom)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_disease_symptoms, $symptom);
	}

	public function delete_disease_symptom($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete(self::$table_disease_symptoms);
	}


	public function get_submitted_symptoms($arr)
	{

		return $this->db->select('symptom_id')->get_where('diseases_symptoms', $arr)->result_array();
	}

	public function get_all_symptoms()
	{
		return $this->db->select('id,name')->get('symptoms')->result_array();
	}

	//FAQ
	public function find_disease_faq($disease_id)
	{
		return $this->db->get_where(self::$table_name_faq, array("disease_id" => $disease_id))->result();
	}

	public function get_disease_faq_by_id($faq_id)
	{
		return $this->db->get_where(self::$table_name_faq, array('id' => $faq_id))->row();
	}

	public function add_disease_faq($faq)
	{
		return $this->db->insert(self::$table_name_faq, $faq);
	}

	public function update_disease_faq($id, $faq)
	{
		$this->db->where("id", $id);
		return $this->db->update(self::$table_name_faq, $faq);
	}

	public function delete_disease_faq($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete(self::$table_name_faq);
	}

	public function create_response_sms($sms)
	{
		$this->db->insert(self::$table_name_response_sms, $sms);
		return $this->db->insert_id();
	}

	public function find_response_sms_by_id($sms_id)
	{
		$this->db->from(self::$table_name_response_sms);
		$this->db->where("id", $sms_id);
		return $this->db->get()->row();
	}

	public function find_response_sms_by_disease_id($disease_id)
	{
		$this->db->select("u.*, rs.*, rs.id as id");
		$this->db->from(self::$table_name_response_sms . " rs");
		$this->db->where("disease_id", $disease_id);
		$this->db->join(self::$table_name_user_groups . " u", "u.id = rs.group_id");
		return $this->db->get()->result();
	}

	public function update_response_sms($sms_id, $sms)
	{
		$this->db->where("id", $sms_id);
		return $this->db->update(self::$table_name_response_sms, $sms);
	}

	public function delete_response_sms($sms_id)
	{
		$this->db->where("id", $sms_id);
		return $this->db->delete(self::$table_name_response_sms);
	}

	public function create_send_sms($sms_to_send)
	{
		$this->db->insert(self::$table_name_sent_sms, $sms_to_send);
		return $this->db->insert_id();
	}

	public function find_diseases_by_symptoms_code($code = array())
	{

		if (!is_array($code)) {
			return FALSE;
		} else {
			$this->db->select("d.title as disease_name, count(d.title) as occurrence_count, d.id as disease_id, sds.*,ds.*");
			$this->db->from(self::$table_disease_symptoms . " sds");
			$this->db->join(self::$table_name_diseases . " d", "d.id = sds.disease_id");
			$this->db->join(self::$table_name_symptoms . " ds", "ds.id = sds.symptom_id");
			$this->db->where_in("code", $code);
			$this->db->group_by("d.title");
			return $this->db->get()->result();
		}
	}

	public function find_response_messages_and_groups($disease_id, $district)
	{
		$this->db->distinct();
		$this->db->select("username, u.first_name, u.last_name, u.phone, g.name as group_name,
		rsms.id as rsms_id, rsms.message", FALSE);
		$this->db->from(self::$table_name_response_sms . " rsms");
		$this->db->join(self::$table_name_users_groups . " ug", "ug.group_id = rsms.group_id");
		$this->db->join(self::$table_name_users . " u", "u.id = ug.user_id");
		$this->db->join(self::$table_name_user_groups . " g", "g.id = ug.group_id");
		$this->db->group_by("username");
		$this->db->where("u.district", $district);
		$this->db->where("rsms.disease_id", $disease_id);
		return $this->db->get()->result();
	}

	public function save_detected_diseases($diseases_batch = array())
	{
		return $this->db->insert_batch(self::$table_name_detected_diseases, $diseases_batch);
	}
}