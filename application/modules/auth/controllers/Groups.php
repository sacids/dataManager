<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 25/11/2018
 * Time: 10:42
 */

class Groups extends MX_Controller
{
    private $data;
    private $controller;

    public function __construct()
    {
        parent::__construct();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->controller = $this->router->class;

        if (!$this->ion_auth->logged_in())
            redirect('auth/login', 'refresh');
    }

    //check if user allowed
    function has_allowed_perm($method_name)
    {
        if ($this->ion_auth->is_admin() || perms_role($this->controller, $method_name))
            return TRUE;
        else
            show_error("You are not allowed to view this page", 401, "Unauthorized");
    }


    //groups
    function lists()
    {
        $this->data['title'] = 'Groups';
        $this->has_allowed_perm($this->router->method);

        //groups
        $this->data['groups'] = $this->Group_model->get_all();

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $this->data);
        $this->load->view('groups/lists');
        $this->load->view('footer');
    }

    // create a new group
    public function create()
    {
        $this->data['title'] = 'Add Role';
        $this->has_allowed_perm($this->router->method);

        // validate form input
        $this->form_validation->set_rules('group_name', 'Role name', 'required|alpha_dash');
        $this->form_validation->set_rules('description', 'Role description', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group(strtolower($this->input->post('group_name')), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', display_message('Role added'));
                redirect("auth/groups/lists", 'refresh');
            }
        }
        // display the create group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name'),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'placeholder' => 'Write role name...',
            'required' => '',
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'rows' => 5,
            'value' => $this->form_validation->set_value('description'),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'placeholder' => 'Write role description...',
            'required' => '',
        );

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $this->data);
        $this->load->view('groups/create');
        $this->load->view('footer');
    }

    // edit a group
    public function edit($id)
    {
        $this->data['title'] = 'Edit Role';
        $this->has_allowed_perm($this->router->method);

        $group = $this->ion_auth->group($id)->row();
        if (!$id || empty($id) || !$group) {
            redirect('auth/groups/lists', 'refresh');
        }
        $this->data['group'] = $group;

        // validate form input
        $this->form_validation->set_rules('group_name', 'Role Name', 'required|alpha_dash');
        $this->form_validation->set_rules('group_description', 'Role description', 'required|trim');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, strtolower($_POST['group_name']), $_POST['group_description']);

                if ($group_update)
                    $this->session->set_flashdata('message', display_message('Role updated'));
                else
                    $this->session->set_flashdata('message', display_message('Failed to update role', 'danger'));

                redirect("auth/groups/lists", 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text area',
            'rows' => 5,
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $this->data);
        $this->load->view('groups/edit');
        $this->load->view('footer');
    }

    //assign perms
    function perms($id)
    {
        $this->data['title'] = 'Assign Perms';
        $this->has_allowed_perm($this->router->method);

        $group = $this->ion_auth->group($id)->row();
        if (!$id || empty($id) || !$group) {
            redirect('auth/groups/lists', 'refresh');
        }
        $this->data['group'] = $group;
        $this->data['perms'] = $this->perms_group_model->get_perms_all();

        //assigned perms
        $assigned_perms = [];
        $grp = $this->perms_group_model->get_by(['group_id' => $id]);
        ($grp) ? $grps = explode(',', $grp->perms) : $grps = [];

        foreach ($grps as $v) {
            array_push($assigned_perms, $v);
        }
        $this->data['assigned_perms'] = $assigned_perms;

        if (isset($_POST['save'])) {
            $perms = $this->input->post('perms');

            if ($perms) {
                $classes = [];
                foreach ($perms as $perm) {
                    $methods = $this->perms_method_model->get_by(['id' => $perm]);
                    array_push($classes, $methods->class_id);
                }

                $grp = $this->perms_group_model->get_by(['group_id' => $id]);

                if ($grp)
                    $this->perms_group_model->update(['group_id' => $id], ['classes' => join(',', array_unique($classes)), 'perms' => join(',', $perms)]);
                else
                    $this->perms_group_model->insert(['group_id' => $id, 'classes' => join(',', array_unique($classes)), 'perms' => join(',', $perms)]);

                $this->session->set_flashdata('message', display_message('Permissions saved'));
            } else {
                $this->session->set_flashdata('message', display_message('No any permissions not selected', 'danger'));
            }

            redirect('auth/groups/perms/' . $id);
        }

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $this->data);
        $this->load->view('groups/perms');
        $this->load->view('footer');
    }
}
