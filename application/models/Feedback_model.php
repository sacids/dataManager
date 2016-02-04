<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Feedback Model class
 *
 * @package     Feedback_model
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Feedback_model extends CI_Model
{

    function  __construct() {
        parent::__construct();

    }



    function get_feedback($last_id = NULL, $user_id, $form_id){

        //if last feedback IS NOT NULL
        if($last_id != NULL):
            $this->db->where('id > ', $last_id);
        endif;
        $query=$this->db->get_where('feedback',
                            array('user_id' => $user_id, 'form_id' => $form_id))->result();
        //return array object
        return $query;
    }



}