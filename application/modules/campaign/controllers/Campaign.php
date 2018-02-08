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
        $this->load->model(array('campaign/Campaign_model', 'Xform_model'));
        $this->imageUrl = base_url() . 'assets/forms/data/images/';
        $this->controller = $this->router->fetch_class();
    }

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

    //Listing campaign
    function lists()
    {
        $this->data['title'] = "Campaign List";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url' => $this->config->base_url("campaign/lists"),
            'total_rows' => $this->Campaign_model->count_active_campaign(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['campaign_list'] = $this->Campaign_model->get_campaign($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        foreach ($this->data['campaign_list'] as $k => $value) {
            $this->data['campaign_list'][$k]->xform = $this->Xform_model->get_form_by_jr_form_id($value->jr_form_id);
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("campaign/list");
        $this->load->view('footer');
    }


    //add new campaign
    function add_new()
    {
        $this->data['title'] = "Add new campaign";
        //check if logged in
        $this->_is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $this->data['form_list'] = $this->Xform_model->get_form_list();

        //form validation
        $this->form_validation->set_rules("name", $this->lang->line("label_campaign_title"), "required");
        $this->form_validation->set_rules("icon", "Icon", "callback_upload_campaign_image");
        $this->form_validation->set_rules("type", $this->lang->line("label_campaign_type"), "required");

        if ($this->form_validation->run() === TRUE) {

            $data = array(
                "title" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "type" => $this->input->post("type"),
                "jr_form_id" => $this->input->post("jr_form_id"),
                "date_created" => date("c"),
                "icon" => $_POST['icon']
            );
            $this->Campaign_model->create_campaign($data);

            $this->session->set_flashdata("message", display_message("Campaign added"));
            redirect("campaign/lists", "refresh");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
            'class' => 'form-control',
            'placeholder' => 'Enter campaign title'
        );

        $this->data['icon'] = array(
            'name' => 'icon',
            'id' => 'icon',
            'type' => 'file',
            'value' => $this->form_validation->set_value('icon'),
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'value' => $this->form_validation->set_value('description'),
            'rows' => '5',
            'class' => 'form-control',
            'placeholder' => 'Enter campaign description'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("campaign/add_new");
        $this->load->view('footer');
    }


    //Edit campaign
    function edit($campaign_id)
    {
        $this->data['title'] = "Edit Campaign";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $this->data['form_list'] = $this->Xform_model->get_form_list();

        $campaign = $this->Campaign_model->get_campaign_by_id($campaign_id);
        $this->data['campaign'] = $campaign;

        //form validation
        $this->form_validation->set_rules("name", $this->lang->line("label_campaign_title"), "required");
        $this->form_validation->set_rules("type", $this->lang->line("label_campaign_type"), "required");

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "title" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "type" => $this->input->post("type"),
                "jr_form_id" => $this->input->post("jr_form_id")
            );

            $this->Campaign_model->update_campaign($campaign_id, $data);

            $this->session->set_flashdata("message", display_message("Campaign updated"));
            redirect("campaign/lists", "refresh");
        }
        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $campaign->title),
            'class' => 'form-control'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'value' => $this->form_validation->set_value('description', $campaign->description),
            'rows' => '5',
            'class' => 'form-control'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("campaign/edit");
        $this->load->view('footer');
    }


    //change icon
    function change_icon($campaign_id)
    {
        $this->data['title'] = "Change campaign icon";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $this->data['campaign'] = $campaign = $this->Campaign_model->get_campaign_by_id($campaign_id);

        //form validation
        $this->form_validation->set_rules("icon", "Icon", "callback_upload_campaign_image");

        if ($this->form_validation->run() == true) {
            $data = array(
                "icon" => $_POST['icon']
            );
            $this->Campaign_model->update_campaign($campaign_id, $data);

            //delete icon path
            $icon_path = $this->imageUrl . $campaign->icon;
            delete_files($icon_path);

            //redirect with message
            $this->session->set_flashdata('message', display_message('Icon changed'));
            redirect('campaign/lists', 'refresh');
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("campaign/change_icon");
        $this->load->view('footer');
    }

    //delete campaign
    function delete($campaign_id)
    {
        $this->_is_logged_in();

        $this->has_allowed_perm($this->router->fetch_method());

        //delete college
        $this->db->delete('campaign', array('id' => $campaign_id));

        $this->session->set_flashdata('message', display_message('Campaign deleted', 'danger'));
        redirect('campaign/lists', 'refresh');
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