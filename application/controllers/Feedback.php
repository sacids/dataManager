<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *Form Feedback Class
 *
 * @package     Data
 * @category    Controller
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */

class Feedback extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model(array('Feedback_model','Users_model'));
        $this->load->library('form_auth');
        $this->load->helper(array('url', 'string'));
        log_message('debug', 'Feedback controller initialized');

        //$this->output->enable_profiler(TRUE);
    }


    /**
     * XML submission class
     *
     * @param  string  $str    Input string
     * @return response
     */

    function get_feedback()
    {
        //get form_id and last_feedback_id
        $form_id = $this->input->get('form_id');
        $last_id = $this->input->get('last_id');
        $user_id = 1;

        //IF Authentication PASSES
        $feedback_db = $this->Feedback_model->get_feedback($user_id, $form_id, $last_id);

        $feedback = array();
        foreach($feedback_db as $value):
            $feedback[] = array(
                'id'=> $value->id,
		        'user_id' => $value->user_id,
		        'form_id' => $value->form_id,
		        'message' => $value->message,
		        'date' => date('m-d-Y H:i:s',strtotime($value->created_at))
            );
        endforeach;

        //check if feedback array is empty
        if(empty($feedback)):
            echo json_encode(array("status"=>"success","message"=>"No content"));
        else:
            //print json feedback
            echo json_encode($feedback);
        endif;

    }
}