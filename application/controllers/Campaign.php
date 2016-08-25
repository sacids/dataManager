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

    /**
     * Campaign List
     */
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


    /**
     * Add new campaign
     */
    function add_new()
    {
        //check if logged in
        $this->_is_logged_in();

        $data['title'] = "Add new Campaign";
        $data['forms'] = $this->Xform_model->get_form_list();

        $this->form_validation->set_rules("title", "Campaign Title", "required");
        $this->form_validation->set_rules("icon", "Campaign Icon", "callback_upload_campaign_image");
        $this->form_validation->set_rules("type", "Campaign Type", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            $this->load->view("campaign/add_new", $data);
            $this->load->view('footer');
        } else {

            $campaign_details = array(
                "title" => $this->input->post("title"),
                "description" => $this->input->post("description"),
                "type" => $this->input->post("type"),
                "form_id" => $this->input->post("form_id"),
                "date_created" => date("c"),
                "icon" => $_POST['icon']
            );

            $this->Campaign_model->create_campaign($campaign_details);

            $this->session->set_flashdata("message", display_message("Campaign successfully added"));
            redirect("campaign/add_new", "refresh");
        }
    }


    /**
     * Edit campaign
     * @param $campaign_id
     */
    function edit($campaign_id)
    {
        //check if logged in
        $this->_is_logged_in();

        $data['title'] = "Edit Campaign";
        $data['forms'] = $this->Xform_model->get_form_list();
        $data['campaign'] = $campaign = $this->Campaign_model->get_campaign_by_id($campaign_id);

        $this->form_validation->set_rules("title", $this->lang->line("label_campaign_title"), "required");
        $this->form_validation->set_rules("type", $this->lang->line("label_campaign_type"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            $this->load->view("campaign/edit", $data);
            $this->load->view('footer');
        } else {

            $campaign_details = array(
                "title" => $this->input->post("title"),
                "description" => $this->input->post("description"),
                "type" => $this->input->post("type"),
                "form_id" => $this->input->post("form_id")
            );

            $this->Campaign_model->update_campaign($campaign_id, $campaign_details);


            $this->session->set_flashdata("message", display_message("Campaign successfully edited"));
            redirect("campaign/edit/" . $campaign_id, "refresh");
        }
    }


    /**
     * upload campaign image
     * @return bool
     */
    function upload_campaign_image()
    {
        $config['upload_path'] = './assets/forms/data/images/';
        $config['allowed_types'] = 'png|jpg|jpeg|gif';
        $config['max_size'] = '1024';
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (isset($_FILES['icon']) && !empty($_FILES['icon']['name'])) {

            if ($this->upload->do_upload('icon')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $_POST['icon'] = $upload_data['file_name'];
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('upload_campaign_image', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('upload_campaign_image', "Upload campaign icon");
            return false;
        }
    }

}