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

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model(array('Campaign_model','Xform_model'));
    }

    function campaign_list()
    {
        $data['campaigns'] = $this->Campaign_model->get_campaign();

        //render view
        $data['title'] = "Campaign List";
        $this->load->view('header', $data);
       // $this->load->view("campaign/menu");
        $this->load->view("campaign/campaign_list");
        $this->load->view('footer');
    }

    function add_new()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['title'] = "Add new Campaign";
        $data['forms'] = $this->Xform_model->get_form_list();

        $this->form_validation->set_rules("title", "Campaign Title", "required");
        $this->form_validation->set_rules("icon", "Campaign Icon", "required");
        $this->form_validation->set_rules("form_id", "Form Id", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            //$this->load->view("campaign/menu");
            $this->load->view("campaign/add_new", $data);
            $this->load->view('footer');
        } else {

            //TODO Check if file already exist and prompt user.

            $campaign_details = array(
                "title" => $this->input->post("title"),
                "description" => $this->input->post("description"),
                "form_id" => $this->input->post("form_id"),
                "end_date" => date("c"),
                "icon" => $this->input->post("icon")
            );

            $this->Campaign_model->create_campaign($campaign_details);
            //get last insert id
            $campaign_id = $this->db->insert_id();
            $this->session->set_flashdata("message",display_message("Campaign successfully added"));
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
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
        } else {
            $response = array("status" => "success", "message" => "No content");
            $this->output
                ->set_status_header(204)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
        }
    }

}