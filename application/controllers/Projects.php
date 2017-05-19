<?php

/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 5/5/17
 * Time: 12:13 PM
 */
class Projects extends CI_Controller
{
    private $controller;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('project_model'));

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

    //list projects
    function lists()
    {
        $this->data['title'] = "List projects";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url' => $this->config->base_url("projects/lists"),
            'total_rows' => $this->project_model->count_projects(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['project_list'] = $this->project_model->get_project_list($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("project/lists");
        $this->load->view('footer');
    }

    //add new project
    function add_new()
    {
        $this->data['title'] = "Add new project";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        //form validation
        $this->form_validation->set_rules('name', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'title' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s'),
                'owner' => $this->user_id
            );
            $id = $this->db->insert('project', $data);

            if ($id) {
                $this->session->set_flashdata('message', display_message('Project added'));
                redirect('projects/lists', 'refresh');
            } else {
                $this->session->set_flashdata('message', display_message('Failed to add project', 'danger'));
                redirect('projects/add_new', 'refresh');
            }
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
            'class' => 'form-control',
            'placeholder' => 'Enter project title'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'value' => $this->form_validation->set_value('description'),
            'rows' => '5',
            'class' => 'form-control',
            'placeholder' => 'Enter project description'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("project/add_new");
        $this->load->view('footer');
    }


    //edit project
    function edit($project_id)
    {
        $this->data['title'] = "Edit project";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        $project = $this->project_model->get_project_by_id($project_id);

        //form validation
        $this->form_validation->set_rules('name', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'title' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            $this->db->update('project', $data, array('id' => $project_id));

            $this->session->set_flashdata('message', display_message('Project updated'));
            redirect('projects/lists', 'refresh');
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $project->title),
            'class' => 'form-control'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'value' => $this->form_validation->set_value('description', $project->description),
            'rows' => '5',
            'class' => 'form-control'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("project/edit");
        $this->load->view('footer');
    }

}