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

            $this->session->set_flashdata("message", display_message("Campaign successfully added"));
            redirect("campaign/add_new", "refresh");
        }
    }


    function edit($campaign_id)
    {
        //check if logged in
        $this->_is_logged_in();

        $data['title'] = "Edit Campaign";
        $data['forms'] = $this->Xform_model->get_form_list();
        $data['campaign'] = $campaign = $this->Campaign_model->get_campaign_by_id($campaign_id);

        $this->form_validation->set_rules("title", $this->lang->line("label_campaign_title"), "required");
        $this->form_validation->set_rules("icon", $this->lang->line("label_campaign_icon"), "required");
        $this->form_validation->set_rules("type", $this->lang->line("label_campaign_type"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            $this->load->view("campaign/edit", $data);
            $this->load->view('footer');
        } else {

            //TODO Check if file already exist and prompt user.
            $campaign_details = array(
                "title" => $this->input->post("title"),
                "description" => $this->input->post("description"),
                "type" => $this->input->post("type"),
                "form_id" => $this->input->post("form_id"),
                "icon" => $this->input->post("icon")
            );

            $this->Campaign_model->update_campaign($campaign_id, $campaign_details);


            $this->session->set_flashdata("message", display_message("Campaign successfully edited"));
            redirect("campaign/edit/". $campaign_id, "refresh");
        }
    }

}