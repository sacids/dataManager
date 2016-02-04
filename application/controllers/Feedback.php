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
        $last_id = $this->input->get('id');

        // Get the digest from the http header
        $digest = $_SERVER['PHP_AUTH_DIGEST'];

        //server realm and unique id
        $realm = 'Authorized users of Sacids Openrosa';
        $nonce = md5(uniqid());

        // If there was no digest, show login
        if (empty($digest)):

            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm,$nonce);
            exit;
        endif;

        //http_digest_parse
        $digest_parts = $this->form_auth->http_digest_parse($digest);

        //username from http digest obtained
        $valid_user = $digest_parts['username'];

        //get user details from database
        $user=$this->Users_model->get_user_details($valid_user);
        $valid_pass = $user->digest_password; //digest password
        $user_id = $user->id; //user_id
        $db_user = $user->username; //username

        //show status header if user not available in database
        if(empty($db_user)):
            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm,$nonce);
            exit;
        endif;


        // Based on all the info we gathered we can figure out what the response should be
        $A1 = $valid_pass; //digest password
        $A2 = md5("{$_SERVER['REQUEST_METHOD']}:{$digest_parts['uri']}");
        $valid_response = md5("{$A1}:{$digest_parts['nonce']}:{$digest_parts['nc']}:{$digest_parts['cnonce']}:{$digest_parts['qop']}:{$A2}");

        // If digest fails, show login
        if ($digest_parts['response']!=$valid_response):
            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm,$nonce);
            exit;
        endif;


        //IF Authentication PASSES
        $feedback_db = $this->Feedback_model->get_feedback($last_id, $user_id, $form_id);

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