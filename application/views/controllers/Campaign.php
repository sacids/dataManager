<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

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
    private $imageUrl;
    private $controller;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Campaign_model', 'Xform_model'));
        log_message('debug', 'Campaign controller initialized');

        $this->imageUrl = base_url() . 'assets/forms/data/images/';
        $this->controller = $this->router->fetch_class();
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
     * Campaign List
     */
    function lists()
    {
        //check if logged in
        $this->_is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

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

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

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
                "jr_form_id" => $this->input->post("form_id"),
                "featured" => $this->input->post("featured"),
                "date_created" => date("c"),
                "icon" => $_POST['icon']
            );

            $this->Campaign_model->create_campaign($campaign_details);

            $this->session->set_flashdata("message", display_message("Campaign successfully added"));
            redirect("campaign/lists", "refresh");
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

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

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
                "featured" => $this->input->post("featured"),
                "jr_form_id" => $this->input->post("form_id")
            );

            $this->Campaign_model->update_campaign($campaign_id, $campaign_details);


            $this->session->set_flashdata("message", display_message("Campaign successfully edited"));
            redirect("campaign/lists", "refresh");
        }
    }


    /**
     * @param $campaign_id
     */
    function change_icon($campaign_id)
    {
        //check if logged in
        $this->_is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $this->data['campaign'] = $campaign = $this->Campaign_model->get_campaign_by_id($campaign_id);

        //form validation
        $this->form_validation->set_rules("icon", "Campaign Icon", "callback_upload_campaign_image");

        if ($this->form_validation->run() == true) {
            $data = array(
                "icon" => $_POST['icon']
            );
            $this->Campaign_model->update_campaign($campaign_id, $data);

            //delete icon path
            $icon_path = $this->imageUrl . $campaign->icon;
            delete_files($icon_path);

            //redirect with message
            $this->session->set_flashdata('message', display_message('Campaign icon successfully changed'));
            redirect('campaign/lists', 'refresh');
        }

        //render view
        $this->data['title'] = "Change campaign icon";
        $this->load->view('header', $this->data);
        $this->load->view("campaign/change_icon");
        $this->load->view('footer');
    }


    /**
     * upload campaign image
     * @return bool
     */
    function upload_campaign_image()
    {
        $config['upload_path'] = './assets/forms/data/images/';
        $config['allowed_types'] = 'png|jpg|jpeg|gif';
        $config['max_size'] = '4000';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (isset($_FILES['icon']) && !empty($_FILES['icon']['name'])) {

            if ($this->upload->do_upload('icon')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $_POST['icon'] = $upload_data['file_name'];

                //Image Resizing
                $resize_conf['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $resize_conf['new_image'] = $this->upload->upload_path . 'thumb_' . $this->upload->file_name;
                $resize_conf['maintain_ratio'] = FALSE;
                $resize_conf['width'] = 800;
                $resize_conf['height'] = 600;

                // initializing image_lib
                $this->image_lib->initialize($resize_conf);
                $this->image_lib->resize();

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