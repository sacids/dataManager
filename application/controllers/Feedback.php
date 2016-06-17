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

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Feedback_model', 'User_model', 'Xform_model'));
        $this->load->library('form_auth');
        $this->load->helper(array('url', 'string'));
        log_message('debug', 'Feedback controller initialized');
        //$this->output->enable_profiler(TRUE);
    }

    /**
     * Check login
     *
     * @return response
     */
    function _is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }


    /**
     * input null
     *
     * @return array
     */
    function feedback_list()
    {
        //check if logged in
        $this->_is_logged_in();

        if (isset($_POST['search'])) {
            //TODO searching here
            $form_name = $this->input->post("name", NULL);
            $username = $this->input->post("username", NULL);

            //search feedback
            $feedback = $this->Feedback_model->search_feedback($form_name, $username);

            if ($feedback) {
                $data['feedback'] = $feedback;
            }
        } else {
            $data['feedback'] = $this->Feedback_model->find_all();
        }

        //render view
        $data['title'] = "Feedback List";
        $this->load->view('header', $data);
        $this->load->view("feedback/feedback_list");
        $this->load->view('footer');
    }


    /**
     * input instance_id
     *
     * @return array
     */
    function user_feedback($instance_id)
    {
        //check if logged in
        $this->_is_logged_in();

        if ($_POST) {
            $message = $this->input->post('message');
            //$user_id = $this->session->userdata('user_id');
            $feedback = $this->Feedback_model->get_feedback_details_by_instance($instance_id);
            //Insert data from ajax
            $feedback_details = array(
                'form_id' => $feedback->form_id,
                'message' => $message,
                'date_created' => date("c"),
                'instance_id' => $instance_id,
                'user_id' => $feedback->user_id,
                'sender' => 'server'
            );
            $this->Feedback_model->create_feedback($feedback_details);
        }

        //render view
        $data['feedback'] = $this->Feedback_model->get_feedback_by_instance($instance_id);
        $data['instance_id'] = $instance_id;
        $data['title'] = "Feedback List";
        $this->load->view('header', $data);
        $this->load->view("feedback/user_feedback_list");
        $this->load->view('footer');
    }




    /**
     * get Feedback Api
     */
    function get_feedback()
    {
        $username = $this->input->get("username");

        //check if no username
        if (!$username) {
            $response = array("status" => "failed", "message" => "Required username");
            echo json_encode($response);
            exit;
        }

        //TODO: call function for permission, return chat user (form_id) needed to see


        $user = $this->User_model->find_by_username($username);
        log_message("debug", "username getting forms feedback is " . $username);

        if ($user) {
            $feedback_list = $this->Feedback_model->get_feedback_list();

            foreach($feedback_list as $value){
                $username = $this->User_model->find_by_id($value->user_id)->username;
                $form_name = $this->Xform_model->find_by_xform_id($value->form_id)->title;

                $feedback[] = array(
                    'id' => $value->id,
                    'form_id' => $value->form_id,
                    'instance_id' => $value->instance_id,
                    'title' => $form_name,
                    'message' =>$value->message,
                    'sender' => $value->sender,
                    'user' => $username,
                    'date_created' => date("m-Y, H:i", strtotime($value->date_created)),
                    'status' => $value->status
                );
            }

            $response = array("feedback" => $feedback, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "User does not exist");
        }
        echo json_encode($response);
    }


    /**
     * post Feedback Api
     */
    function post_feedback()
    {
        $username = $this->input->post("username");
        //$form_id = str_replace("-", "_", $this->input->get('form_id'));

        log_message("debug", "User posting feedback is " . $username);

        //get user details
        $user = $this->User_model->find_by_username($username);

        if ($user) {
            $feedback = array(
                "user_id" => $user->id,
                "instance_id" => $this->input->post("instance_id"),
                "form_id" => $this->input->post('form_id'),
                "message" => $this->input->post("message"),
                'sender' => $this->input->post("sender"),
                "date_created" => date("c"),
                "status" => $this->input->post("status")
            );

            if ($this->Feedback_model->create_feedback($feedback)) {
                $response = array("message" => "Feedback was received successfully", "status" => "success");

            } else {
                $response = array("status" => "failed", "message" => "Unknown error occured");

            }
        } else {
            $response = array("status" => "failed", "message" => "user does not exist");

        }

        echo json_encode($response);

    }

}