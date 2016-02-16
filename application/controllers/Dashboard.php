<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://sacids.com/index.php/dashboard
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/dashboard/<method_name>
	 */
	public function index(){
		//echo $_SERVER['PHP_AUTH_DIGEST'];

		
		$this->data['title']="Sacids Research Portal";
		$this->load->view('header',$this->data);
		$this->load->view('index');
		$this->load->view('footer');
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
