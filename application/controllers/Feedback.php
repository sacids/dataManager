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
    private $user_id;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Feedback_model', 'User_model', 'Xform_model'));
        $this->load->library('form_auth');
        $this->load->helper(array('url', 'string'));
        log_message('debug', 'Feedback controller initialized');

        $this->user_id = $this->session->userdata("user_id");
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
    function lists()
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
                $this->data['feedback'] = $feedback;
            }
        } else {
            $config = array(
                'base_url'    => $this->config->base_url("feedback/lists"),
                'total_rows'  => $this->Feedback_model->count_feedback(),
                'uri_segment' => 3,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->data['feedback'] = $this->Feedback_model->find_all($this->pagination->per_page, $page);
            $this->data["links"] = $this->pagination->create_links();
        }

        //render view
        $this->data['title'] = "Feedback List";
        $this->load->view('header', $this->data);
        $this->load->view("feedback/feedback_list");
        $this->load->view('footer');
    }


    /**
     * @param $instance_id
     * @return array
     */
    function user_feedback($instance_id)
    {
        //check if logged in
        $this->_is_logged_in();

        //update all feedback from android app using instance_id
        $this->Feedback_model->update_user_feedback($instance_id, 'user');


        if ($_POST) {
            $message = $this->input->post('message');
            $feedback = $this->Feedback_model->get_feedback_details_by_instance($instance_id);

            //Insert data from ajax
            $feedback_details = array(
                'form_id' => $feedback->form_id,
                'message' => $message,
                'date_created' => date('Y-m-d H:i:s'),
                'instance_id' => $instance_id,
                'user_id' => $feedback->user_id,
                'sender' => 'server',
                'status' => 'pending',
                'reply_by' => $this->user_id
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

}