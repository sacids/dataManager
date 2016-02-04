<?php
	/**
	 * Users_model.php
	 * model for users
	 *Author : Renfrid Ngolongolo
	 */

class Users_model extends CI_Model{
    function  __construct() {
        parent::__construct();
    }


	function get_users(){
		$users=$this->db->get('users')->result();
    	return $users;
	}

	function get_user_details($username){
		$query=$this->db->get_where('users',array('username' => $username));
		return $query->row();
	}
 	



    	
}

/* End of file users_model.php */
/* Location: ./application/model/survey_model.php */

