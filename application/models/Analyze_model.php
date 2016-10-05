<?php

/**
 * Feedback Model class
*
* @package     Campaign_model
* @author      Eric Beda
* @link        http://sacids.org
*/
class Analyze_model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
	}

	public function get_symptoms_ids($codes){

		return $this->db->select('id')->where_in('code',$codes)->get('ohkr_symptoms')->result_array();
	}
	public function get_specie_id($specie){

		return $this->db->select('id')->where('name',$specie)->get('ohkr_species')->row();
	}
	public function get_disease_for_specie($specie_id){

		return $this->db->select('id')->where('specie_id',$specie_id)->get('ohkr_diseases')->result_array();
	}
	public function analyze_disease($diseases, $symptoms){


		$this->db->select('disease_id')->select_sum('importance');
		//$where	= "specie_id = '".$specie_id."' and symptom_id in ('".$symptoms."') and disease_id in ('".$diseases."')";
		//$$this->db->where($where);
		$this->db->where_in('symptom_id',$symptoms)->where_in('disease_id',$diseases);
		$this->db->group_by('disease_id');
		$this->db->from('diseases_symptoms');
		$this->db->order_by('importance');

		return $this->db->get()->result_array();

	}

}