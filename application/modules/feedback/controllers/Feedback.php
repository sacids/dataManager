<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *Form Feedback Class
 *
 * @package     Data
 * @category    Controller
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Feedback extends MX_Controller
{
    private $data;
    private $user_id;
    private $controller;

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_auth');
        $this->load->helper(array('url', 'string'));
        log_message('debug', 'Feedback controller initialized');

        $this->user_id = $this->session->userdata("user_id");
        $this->controller = $this->router->fetch_class();
    }

    //check login user
    function is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }

    /**
     * @param $method_name
     * Check if user has permission
     */
    function has_allowed_perm($method_name)
    {
        if (!perms_role($this->controller, $method_name)) {
            show_error("You are not allowed to view this page", 401, "Unauthorized");
        }
    }


    /**
     * input null
     *
     * @return array
     */
    function lists()
    {
        $this->data['title'] = "Feedback";

        //check if logged in
        $this->is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        if (isset($_POST['search'])) {
            $form_name = $this->input->post("name", NULL);
            $username = $this->input->post("username", NULL);

            //search feedback
            $feedback = $this->Feedback_model->search_feedback($form_name, $username);

            if ($feedback) {
                $this->data['feedback'] = $feedback;
            }
        } else {
            $config = array(
                'base_url' => $this->config->base_url("feedback/lists"),
                'total_rows' => $this->Feedback_model->count_feedback(),
                'uri_segment' => 3,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->data['feedback_list'] = $this->Feedback_model->find_all($this->pagination->per_page, $page);
            $this->data["links"] = $this->pagination->create_links();
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("feedback/list");
        $this->load->view('footer');
    }


    /**
     * @param $instance_id
     * @return array
     */
    function user_feedback($instance_id)
    {
        $this->data['title'] = "Feedback Conversation";

        //check if logged in
        $this->is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $feedback = $this->Feedback_model->get_feedback_by_instance($instance_id);
        if (count($feedback) == 0) {
            show_error("User conversation not exists");
        }
        $this->data['feedback'] = $feedback;
        $this->data['instance_id'] = $instance_id;

        foreach ($this->data['feedback'] as $k => $feedback) {
            if ($feedback->sender == 'user')
                $this->data['feedback'][$k]->sender_name = $this->User_model->get_user_details($feedback->user_id);
            else
                $this->data['feedback'][$k]->sender_name = $this->User_model->get_user_details($feedback->reply_by);
        }

        //update all feedback from android app using instance_id
        $this->Feedback_model->update_user_feedback($instance_id, 'user');

        if ($_POST) {
            $message = $this->input->post('message');
            $fb = $this->Feedback_model->get_feedback_details_by_instance($instance_id);

            //Insert data from ajax
            $result = $this->Feedback_model->create_feedback(array(
                'form_id' => $fb->form_id,
                'message' => $message,
                'date_created' => date('Y-m-d H:i:s'),
                'instance_id' => $instance_id,
                'user_id' => $fb->user_id,
                'sender' => 'server',
                'status' => 'pending',
                'reply_by' => $this->user_id
            ));

            if ($result)
                redirect('feedback/user_feedback/' . $instance_id, 'refresh');
            else
                redirect('feedback/user_feedback/' . $instance_id, 'refresh');
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("user_feedback");
        $this->load->view('footer');
    }
}