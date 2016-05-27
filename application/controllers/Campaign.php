<?php

/**
 *Campaign Class
 *
 * @package     Data
 * @category    Controller
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Campaign extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Campaign_model', 'Xform_model'));
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

    function campaign_list()
    {
        //check if logged in
        $this->_is_logged_in();

        $data['campaigns'] = $this->Campaign_model->get_campaign();

        //render view
        $data['title'] = "Campaign List";
        $this->load->view('header', $data);
        $this->load->view("campaign/campaign_list");
        $this->load->view('footer');
    }

    function add_new()
    {
        //check if logged in
        $this->_is_logged_in();

        $data['title'] = "Add new Campaign";
        $data['forms'] = $this->Xform_model->get_form_list();

        $this->form_validation->set_rules("title", "Campaign Title", "required");
        $this->form_validation->set_rules("icon", "Campaign Icon", "required");
        $this->form_validation->set_rules("type", "Campaign Type", "required");
        //$this->form_validation->set_rules("form_id", "Form Id", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            $this->load->view("campaign/add_new", $data);
            $this->load->view('footer');
        } else {

            //TODO Check if file already exist and prompt user.
            $campaign_details = array(
                "title" => $this->input->post("title"),
                "description" => $this->input->post("description"),
                "type" => $this->input->post("type"),
                "form_id" => $this->input->post("form_id"),
                "date_created" => date("c"),
                "icon" => $this->input->post("icon")
            );

            $this->Campaign_model->create_campaign($campaign_details);
            //get last insert id
            $campaign_id = $this->db->insert_id();
            $this->session->set_flashdata("message", display_message("Campaign successfully added"));
            redirect("campaign/add_new", "refresh");
        }
    }


    /**
     * get_campaign function
     *
     * @return response
     */
    function get_campaign()
    {
        //campaign result
        $campaign = $this->Campaign_model->get_campaign();

        if ($campaign) {
            $response = array("campaign" => $campaign, "status" => "success");

        } else {
            $response = array("status" => "success", "message" => "No content");

        }
        echo json_encode($response);
    }

}