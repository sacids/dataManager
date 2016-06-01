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
    private static $table_name_disease = "ohkr_diseases";
    private static $table_name_species = "ohkr_species";
    private static $table_name_symptoms = "ohkr_symptoms";
    private static $table_name_scd = "ohkr_scd";

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
        $this->db->select('disease.id, disease.description, disease.title as disease_title, specie.title as specie_title')
            ->join(self::$table_name_species . " specie ", "disease.specie_id = specie.id")
            ->limit($limit, $offset);
        return $this->db->get(self::$table_name_disease . " disease")->result();
    }

    /**
     * @param $disease_id
     * @return mixed
     */
    public function get_disease_by_id($disease_id)
    {
        $this->db->select('disease.id, disease.description, disease.title as d_title, specie.id as s_id, specie.title as s_title')
            ->join(self::$table_name_species . " specie ", "disease.specie_id = specie.id");
        return $this->db->get_where(self::$table_name_disease . " disease", array('disease.id' => $disease_id))->row();
    }

    /**
     * @return int
     */
    public function count_disease()
    {
        $this->db->from(self::$table_name_disease);
        return $this->db->count_all_results();
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
        $this->db->select("scd.id, scd. disease_id, scd.importance, symptom.title as symptom_title")
            ->join(self::$table_name_symptoms . " symptom", "scd.symptom_id = symptom.id");
        return $this->db->get_where(self::$table_name_scd . " scd" , array("disease_id" => $disease_id))->result();
    }

    public function get_disease_symptom_by_id($disease_symptom_id)
    {
        return $this->db->get_where(self::$table_name_scd, array('id' => $disease_symptom_id))->row();
    }

    public function add_disease_symptom($symptoms)
    {
        return $this->db->insert(self::$table_name_scd, $symptoms);
    }

    public function update_disease_symptom($id, $symptom)
    {
        $this->db->where("id", $id);
        return $this->db->update(self::$table_name_scd, $symptom);
    }

    public function delete_disease_symptom($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete(self::$table_name_scd);
    }
	
	public function get_submitted_symptoms($arr){
		
		return $this->db->select('symptom_id')->get_where('diseases_symptoms',$arr)->result_array();
	}
	
	public function get_all_symptoms(){
		return $this->db->select('id,name')->get('symptoms')->result_array();
	}
}