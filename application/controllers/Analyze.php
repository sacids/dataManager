<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Analyze extends CI_Controller {
	private $specie;
	private $symptoms;
	private $diagnosis;
	public function __construct() {
		parent::__construct ();
		
		$this->load->model ( array (
				'Analyze_model' 
		) );
	}
	
	public function json(){
		
	}
	
	public function xml(){
		
	}
	
	public function data(){

		print_r($this->input->get());
		$symptoms	= $this->input->get('symptoms');
		$specie		= $this->input->get('specie');
		
		if(!$symptoms){
			
			log_message('error', 'Symptoms not set');
			echo  'Invalid symptom';
		}elseif(!$specie){
			log_message('error', 'Specie not set');
			echo 'Invalid specie';
		}else{
			$this->set_specie($specie);
			$this->set_symptom($symptoms);
			
			echo $this->_analyze();
		}
	}
	
	public function set_symptom($symptoms){
		$this->symptoms = explode(",", $symptoms);
	}
	public function set_specie($specie){
		$this->specie	= $specie;
	}
	public function _analyze(){
		
		return 'data';
		
	}
}