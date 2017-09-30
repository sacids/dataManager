<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 29/09/2017
 * Time: 13:02
 */
class Facilities extends MX_Controller
{
    private $controller;
    private $data;
    private $user_id;

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $this->load->model(array('Facilities_model', 'model'));
        $this->user_id = $this->session->userdata("user_id");
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


    //list health facilities
    function lists()
    {
        $this->data['title'] = "List health facilities";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url' => $this->config->base_url("facilities/lists"),
            'total_rows' => $this->Facilities_model->count_facilities(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['facilities_list'] = $this->Facilities_model->get_facilities_list($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        foreach ($this->data['facilities_list'] as $k => $v) {
            $this->model->set_table('district');
            $this->data['facilities_list'][$k]->district = $this->model->get_by('id', $v->district);
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("lists");
        $this->load->view('footer');
    }

    //add new project
    function add_new()
    {
        $this->data['title'] = "Add new facility";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        //form validation
        $this->form_validation->set_rules('name', 'Facility Name', 'required|trim');
        $this->form_validation->set_rules('district', 'District', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'district' => $this->input->post('district'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->user_id
            );
            $id = $this->db->insert('health_facilities', $data);

            if ($id) {
                $this->session->set_flashdata('message', display_message('Facility added'));
                redirect('facilities/lists', 'refresh');
            } else {
                $this->session->set_flashdata('message', display_message('Failed to add facility', 'danger'));
                redirect('facilities/add_new', 'refresh');
            }
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
            'class' => 'form-control',
            'placeholder' => 'Enter facility name'
        );

        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text area',
            'rows' => '5',
            'value' => $this->form_validation->set_value('address'),
            'class' => 'form-control',
            'placeholder' => 'Write facility address ....'
        );

        $this->data['latitude'] = array(
            'name' => 'latitude',
            'id' => 'latitude',
            'type' => 'text',
            'value' => $this->form_validation->set_value('latitude'),
            'class' => 'form-control',
            'placeholder' => 'Enter latitude'
        );

        $this->data['longitude'] = array(
            'name' => 'longitude',
            'id' => 'longitude',
            'type' => 'text',
            'value' => $this->form_validation->set_value('longitude'),
            'class' => 'form-control',
            'placeholder' => 'Enter longitude'
        );

        $this->model->set_table('district');
        $this->data['district_list'] = $this->model->get_all();


        //render view
        $this->load->view('header', $this->data);
        $this->load->view("add_new");
        $this->load->view('footer');
    }


    //edit project
    function edit($facility_id)
    {
        $this->data['title'] = "Edit facility";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        $facility = $this->Facilities_model->get_facility_by_id($facility_id);
        $this->data['facility'] = $facility;

        //form validation
        $this->form_validation->set_rules('name', 'Facility Name', 'required|trim');
        $this->form_validation->set_rules('district', 'District', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'district' => $this->input->post('district'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->user_id
            );

            $this->db->update('health_facilities', $data, array('id' => $facility_id));

            $this->session->set_flashdata('message', display_message('Facility updated'));
            redirect('facilities/lists', 'refresh');
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $facility->name),
            'class' => 'form-control'
        );

        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text area',
            'rows' => '5',
            'value' => $this->form_validation->set_value('address', $facility->address),
            'class' => 'form-control'
        );

        $this->data['latitude'] = array(
            'name' => 'latitude',
            'id' => 'latitude',
            'type' => 'text',
            'value' => $this->form_validation->set_value('latitude', $facility->latitude),
            'class' => 'form-control'
        );

        $this->data['longitude'] = array(
            'name' => 'longitude',
            'id' => 'longitude',
            'type' => 'text',
            'value' => $this->form_validation->set_value('longitude', $facility->longitude),
            'class' => 'form-control'
        );

        $this->model->set_table('district');
        $this->data['district_list'] = $this->model->get_all();

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("edit");
        $this->load->view('footer');
    }

    //delete facility
    function delete($facility_id)
    {
        $this->_is_logged_in();

        //$this->has_allowed_perm($this->router->fetch_method());

        //delete college
        $this->db->delete('health_facilities', array('id' => $facility_id));

        $this->session->set_flashdata('message', display_message('Health Facility deleted', 'danger'));
        redirect('facilities/lists', 'refresh');
    }

}