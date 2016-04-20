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
            $from = $this->input->post("from", NULL);
            $to = $this->input->post("to", NULL);

            $feedback = $this->Feedback_model->search_feedback($form_name, $from, $to);

            if ($feedback) {
                $data['feedback'] = $feedback;
            }
        } else {
            $data['feedback'] = $this->Feedback_model->find_all();
        }

        $data['user'] = $this->User_model->get_users();
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
            $user_id = $this->session->userdata('user_id');
            $feedback = $this->Feedback_model->get_feedback_details_by_instance($instance_id);
            //Insert data from ajax
            $feedback_details = array(
                'form_id' => $feedback->form_id,
                'message' => $message,
                'date_created' => date("c"),
                'instance_id' => $instance_id,
                'user_from' => $user_id,
                'user_to' => $feedback->user_to,
                'sender' => 'server'
            );
            $query = $this->Feedback_model->create_feedback($feedback_details);
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
     * XML submission class
     *
     * @return response
     */

    function get_feedback()
    {

        //TODO Returning feedback instance_id
        //get form_id and last_feedback_id
        $username = $this->input->get("username");
        $instance_id = $this->input->get('instance_id'); // todo get feedback by instance id
        //$form_id = $this->input->get('form_id');
        $form_id = str_replace("-", "_", $this->input->get('form_id'));
        $last_id = $this->input->get('last_id');

        if (!$username) {
            $response = array("status" => "failed", "message" => "Required username");
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response))
                ->_display();
        }

        $user = $this->User_model->find_by_username($username);
        log_message("debug", "username getting feedback is " . $username);
        if ($user) {
            if ($form_id)
                $feedback = $this->Feedback_model->get_feedback($user->id, $form_id, $last_id);
            else
                $feedback = $this->Feedback_model->get_feedback($user->id); //Todo add last id later

            if ($feedback) {
                $response = array("feedback" => $feedback, "status" => "success");
                $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($response))
                    ->_display();
            } else {
                $response = array("status" => "success", "message" => "No content");
                $this->output
                    ->set_status_header(204)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($response))
                    ->_display();
            }
        } else {
            $response = array("status" => "failed", "message" => "User does not exist");
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response))
                ->_display();
        }

    }

    function post_feedback()
    {
        $username = $this->input->post("username");
        //$form_id = $this->input->get('form_id');
        $form_id = str_replace("-", "_", $this->input->get('form_id'));

        log_message("debug", "User posting feedback is " . $username);
        $user = $this->User_model->find_by_username($username);

        if ($user) {
            $feedback = array(
                "user_id" => $user->id,
                "instance_id" => $this->input->post("instance_id"),
                "form_id" => $this->input->post("form_id"),
                "message" => $this->input->post("message"),
                'sender' => $this->input->post("sender"),
                "date_created" => date("c")
            );

            if ($this->Feedback_model->create_feedback($feedback)) {
                $response = array("message" => "Feedback was received successfully", "status" => "success");
                $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($response))
                    ->_display();
            } else {
                $response = array(
                    "status" => "failed",
                    "message" => "Unknown error occured"
                );
                $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($response))
                    ->_display();
            }
        } else {
            $response = array(
                "status" => "failed",
                "message" => "user does not exist"
            );
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response))
                ->_display();
        }
    }
}