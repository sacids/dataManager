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
            $user_id = $this->input->post("user", NULL);

            $feedback = $this->Feedback_model->search_feedback($form_name, $user_id);

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
     * Feedback forms
     */
    function feedback_forms()
    {
        $username = $this->input->get("username");

        //check if no username
        if (!$username) {
            $response = array("status" => "failed", "message" => "Required username");
            echo json_encode($response);
            exit;
        }

        $user = $this->User_model->find_by_username($username);
        log_message("debug", "username getting forms feedback is " . $username);

        if ($user) {
            $forms = $this->Feedback_model->get_forms_feedback($user->id);

            //print_r($forms);

            foreach ($forms as $values) {
                $form [] = array(
                    'form_id' => $values->form_id,
                    'instance_id' => $values->instance_id,
                    'title' => $this->Feedback_model->get_form_name($values->form_id),
                    'date_created' => date('j F, Y H:i:s', strtotime($values->date_created))
                );
            }

            $response = array("forms" => $form, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "User does not exist");
        }
        echo json_encode($response);
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
        $instance_id = $this->input->get('instance_id');
        $form_id = str_replace("-", "_", $this->input->get('form_id'));
        $last_id = $this->input->get('last_id');

        if (!$username) {
            $response = array("status" => "failed", "message" => "Required username");
            echo json_encode($response);
            exit;
        }

        $user = $this->User_model->find_by_username($username);
        log_message("debug", "username getting feedback is " . $username);

        if ($user) {
            if ($instance_id)
                $feedback = $this->Feedback_model->get_feedback($user->id, $instance_id);
            else
                $feedback = $this->Feedback_model->get_feedback_notification($user->id, $last_id);

            if ($feedback) {
                $response = array("feedback" => $feedback, "status" => "success");

            } else {
                $response = array("status" => "success", "message" => "No feedback content");

            }
        } else {
            $response = array("status" => "failed", "message" => "User does not exist");

        }
        echo json_encode($response);

    }

    function post_feedback()
    {
        $username = $this->input->post("username");
        $form_id = str_replace("-", "_", $this->input->get('form_id'));
        $instance_id = $this->input->post("instance_id");

        log_message("debug", "User posting feedback is " . $username);
        $user = $this->User_model->find_by_username($username);

        if ($user) {
            $feedback = array(
                "user_id" => $user->id,
                "instance_id" => $instance_id,
                "form_id" => $form_id,
                "message" => $this->input->post("message"),
                'sender' => $this->input->post("sender"),
                "date_created" => date("c")
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