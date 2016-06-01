<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Analyze extends CI_Controller {
	private $specie;
	private $symptoms;
	private $diagnosis;
	public function __construct() {
		parent::__construct ();

		$this->symptoms_id = array();
		$this->specie_id = 1;

		$this->load->model ( array (
				'Analyze_model' 
		) );
	}
	
	public function json(){
		
	}
	
	public function xml(){
		
	}
	
	public function data(){

		$symptoms	= $this->input->post('symptoms');
		$specie		= $this->input->post('specie');
		
		if(!$symptoms){
			
			log_message('error', 'Symptoms not set');
			echo  'Invalid symptom';
		}elseif(!$specie){
			log_message('error', 'Specie not set thus leaving default to 1 - human');
			
		}else {
			$this->set_specie($specie);
			$this->set_symptom($symptoms);
		}
	}
	
	public function set_symptom($symptoms){

		// get id's of submitted symptom codes
		$codes			= explode(',',$symptoms);
		foreach($codes as $key => $val){
			$codes[$key]	= trim($val);
		}
		$res = $this->Analyze_model->get_symptoms_ids($codes);
		foreach($res as $val){
			array_push($this->symptoms_id,$val['id']);
		}
	}
	public function set_specie($specie){
		// get id of specie
		if($result	= $this->Analyze_model->get_specie_id($specie)){
			$this->specie_id		= $result->id;
			return 1;
		}else{
			$this->specie_id	= 0;
			log_message('error', 'Specie not known in our db - invalid');

			echo 'invalid specie'; exit();
			return 0;
		}

	}
	public function _analyze(){

		$res	= $this->Analyze_model->get_disease_for_specie($this->specie_id);
		$available_disease	= array();
		foreach($res as $val){
			array_push($available_disease,$val['id']);
		}
		return $this->Analyze_model->analyze_disease($available_disease,$this->symptoms_id);

		
	}
}