<?php

/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 25/10/2017
 * Time: 08:07
 */

class AccessControl extends MX_Controller
{
    private $data = [];

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            set_flashdata(display_message("You don't have access to this page"));
            redirect('dashboard', 'refresh');
        }

        $this->data['title'] = "Access Control List";
    }

    //permission list
    function index()
    {
        $this->data['permissions'] = $this->Acl_model->find_permissions();

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
        ];

        $this->load->view("header", $this->data);
        $this->load->view("acl/list_permissions", $this->data);
        $this->load->view("footer");
    }

    //create new permission
    function new_permission()
    {
        $this->data['title'] = "Add New";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        //form validation
        $this->form_validation->set_rules("name", "Permission name", "required");
        $this->form_validation->set_rules("description", "Description", "");

        if ($this->form_validation->run() === true) {
            $permission = [
                "title" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "date_added" => date("Y-m-d H:i:s")
            ];

            if ($this->Acl_model->create_permission($permission)) {
                set_flashdata(display_message("Permission was successfully created"));
            } else {
                set_flashdata(display_message("Failed to create permission", "error"));
            }
            redirect("auth/accesscontrol");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'required' => '',
            'placeholder' => 'Write permission name ...'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'rows' => 3,
            'value' => $this->form_validation->set_value('description'),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'placeholder' => 'Write permission description ...'
        );

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
        ];

        //render view
        $this->load->view("header", $this->data);
        $this->load->view("acl/new_permission", $this->data);
        $this->load->view("footer");
    }

    //edit permission
    public function edit_permission($permission_id)
    {
        $this->data['title'] = "Edit Perm";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $perm = $this->Acl_model->find_permission_by_id($permission_id);
        $this->data['perm'] = $perm;

        //form validation
        $this->form_validation->set_rules("name", "Permission name", "required");
        $this->form_validation->set_rules("description", "Description", "");

        if ($this->form_validation->run() === true) {
            $permission = [
                "title" => $this->input->post("name"),
                "description" => $this->input->post("description")
            ];

            if ($this->Acl_model->update_permission($permission, $permission_id)) {
                set_flashdata(display_message("Permission was successfully updated"));
            } else {
                set_flashdata(display_message("Failed to update permission", "error"));
            }
            redirect("auth/accesscontrol");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $perm->title),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'required' => '',
            'placeholder' => 'Write permission name ...'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'rows' => 3,
            'value' => $this->form_validation->set_value('description', $perm->description),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'placeholder' => 'Write permission description ...'
        );

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
        ];

        //render view
        $this->load->view("header", $this->data);
        $this->load->view("acl/edit_permission", $this->data);
        $this->load->view("footer");
    }

    //delete permission
    function delete_permission($permission_id)
    {
        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $perm = $this->Acl_model->find_permission_by_id($permission_id);

        if (!$perm)
            show_error('Permission not found', 500);

        //delete perms
        if ($this->db->delete('acl_permissions', array('id' => $permission_id))) {
            //delete filters
            $this->db->delete('acl_filters', ['permission_id' => $permission_id]);

            set_flashdata(display_message("Permission was successfully deleted"));
        } else {
            set_flashdata(display_message("Failed to delete permission", "error"));
        }
        redirect("auth/accesscontrol");
    }


    /*========== Permission Filters===========*/
    //add new filter
    function new_filter($permission_id)
    {
        $this->data['title'] = "Add New Filter";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $perm = $this->Acl_model->find_permission_by_id($permission_id);

        if (!$perm) {
            set_flashdata(display_message("Select a permission to add a new filter", "error"));
            redirect("auth/accesscontrol");
        }
        $this->data['perm'] = $perm;
        $this->data['tables'] = $this->db->list_tables();

        $this->data['permission_id'] = $permission_id;
        $this->data['permissions'] = $this->Acl_model->find_permissions();

        //filters
        $this->data['filters'] = $this->Acl_model->find_filters(100, 0, $permission_id);

        //form validation
        $this->form_validation->set_rules("filter", "Filter name", "required|trim");
        $this->form_validation->set_rules("table", "Table name", "required|trim");
        $this->form_validation->set_rules("filter_permission", "Permission", "required|trim");
        $this->form_validation->set_rules("filter_column", "Column name", "required|trim");
        $this->form_validation->set_rules("filter_operator", "Operator", "required|trim");
        $this->form_validation->set_rules("filter_value", "Value", "required|trim");

        if ($this->form_validation->run() === true) {
            $filter_column = $this->input->post("filter_column");
            $filter_operator = $this->input->post("filter_operator");
            $filter_value = $this->input->post("filter_value");

            $condition = null;
            $condition .= " " . $filter_column . " " . $filter_operator . " '" . $filter_value . "' ";

            $filter = [
                "permission_id" => $permission_id,
                "name" => $this->input->post("filter"),
                "table_name" => $this->input->post("table"),
                "where_condition" => $condition,
                "date_added" => date("Y-m-d H:i:s")
            ];
            log_message("debug", "Filter information to save => " . json_encode($filter));

            if ($this->Acl_model->create_filter($filter)) {
                set_flashdata(display_message("Filter was successfully created"));
            } else {
                set_flashdata(display_message("Failed", "error"));
            }
            redirect("auth/accesscontrol/new_filter/" . $permission_id);
        }

        //populate data
        $this->data['filter'] = array(
            'name' => 'filter',
            'id' => 'filter',
            'type' => 'text',
            'value' => $this->form_validation->set_value('filter'),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'required' => '',
            'placeholder' => 'Write filter name ...'
        );

        $this->data['filter_value'] = array(
            'name' => 'filter_value',
            'id' => 'filter_value',
            'type' => 'text',
            'value' => $this->form_validation->set_value('filter_value'),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'required' => '',
            'placeholder' => 'Write filter value ...'
        );

        //links
        $this->data['links'] = [
            'Users' => anchor("auth/users/lists", 'Users', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Roles' => anchor("auth/groups/lists", 'Roles', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'Perms' => anchor("auth/accesscontrol", 'Perms', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
        ];

        //render view
        $this->load->view("header", $this->data);
        $this->load->view("acl/new_filter", $this->data);
        $this->load->view("footer");
    }

    //delete
    function delete_filter($permission_id, $filter_id)
    {
        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $perm = $this->Acl_model->find_permission_by_id($permission_id);

        if (!$perm) {
            set_flashdata(display_message("Select a permission to add a new filter", "error"));
            redirect("auth/accesscontrol");
        }

        //filter
        $filter = $this->db->get_where('acl_filters', ['id' => $filter_id])->row();

        if (!$filter)
            show_error('Filter not exists', 500);

        //delete perms
        if ($this->db->delete('acl_filters', ['id' => $filter_id])) {
            set_flashdata(display_message("Permission filter was successfully deleted"));
        } else {
            set_flashdata(display_message("Failed to delete permission filter", "error"));
        }
        redirect("auth/accesscontrol/new_filter/" . $permission_id);
    }

    //filters
    public function filters($permission_id)
    {
        $permission_filters = NULL;
        if ($permission_id) {
            $permission_filters = $this->Acl_model->find_filters(100, 0, $permission_id);
            $permission_filters_count = $this->Acl_model->count_permission_filters($permission_id);
        }

        if ($this->input->is_ajax_request()) {
            if ($permission_filters != NULL) {
                echo json_encode(['status' => "success", "count" => $permission_filters_count, "filters" => $permission_filters]);
            } else {
                echo json_encode(['status' => "success", "count" => $permission_filters_count]);
            }
        } else {
            $this->data['filters'] = $permission_filters;
        }
    }

    /*========================================================
    filter functions
    ========================================================*/
    public function get_table_columns($table_name)
    {
        $table_columns = $this->db->list_fields($table_name);

        if ($table_columns) {
            foreach ($table_columns as $column_name) {
                echo '<option value="' . $column_name . '" ' . set_value("column[]", $column_name) . '>' . $column_name . '</option>';
            }
        } else {
            echo '<option value="">-- Select --</option>';
        }
    }
}
