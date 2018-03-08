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

        $this->load->view("header", $this->data);
        $this->load->view("acl/list_permissions", $this->data);
        $this->load->view("footer");
    }

    //create new permission
    function new_permission()
    {
        $this->data['title'] = "Add Perm";

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
            'class' => 'form-control',
            'placeholder' => 'Write permission name ...'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'rows' => 3,
            'value' => $this->form_validation->set_value('description'),
            'class' => 'form-control',
            'placeholder' => 'Write permission description ...'
        );


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
                set_flashdata(display_message("Failed to create permission", "error"));
            }
            redirect("auth/accesscontrol");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $perm->title),
            'class' => 'form-control',
            'placeholder' => 'Write permission name ...'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text area',
            'rows' => 3,
            'value' => $this->form_validation->set_value('description', $perm->description),
            'class' => 'form-control',
            'placeholder' => 'Write permission description ...'
        );

        //render view
        $this->load->view("header", $this->data);
        $this->load->view("acl/edit_permission", $this->data);
        $this->load->view("footer");
    }

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

        if (count($perm) == 0) {
            set_flashdata(display_message("Select a permission to add a new filter", "error"));
            redirect("auth/accesscontrol");
        }
        $this->data['perm'] = $perm;
        $this->data['tables'] = $this->db->list_tables();

        $this->data['permission_id'] = $permission_id;
        $this->data['permissions'] = $this->Acl_model->find_permissions();

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

//            for ($i = 0; $i < $filters_count; $i++) {
//                $condition .= " " . $filter_column[$i] . " " . $filter_operator[$i] . " '" . $filter_value[$i] . "' ";
//
//                if ($i < ($filters_count - 1)) {
//                    $condition .= " AND ";
//                }
//            }

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
            'class' => 'form-control',
            'placeholder' => 'Write filter name ...'
        );

        $this->data['filter_value'] = array(
            'name' => 'filter_value',
            'id' => 'filter_value',
            'type' => 'text',
            'value' => $this->form_validation->set_value('filter_value'),
            'class' => 'form-control',
            'placeholder' => 'Write filter value ...'
        );

        //render view
        $this->load->view("header", $this->data);
        $this->load->view("acl/new_filter", $this->data);
        $this->load->view("footer");
    }


    public function get_table_columns($table_name)
    {
        $table_columns = $this->db->list_fields($table_name);

        if ($table_columns) {
            foreach ($table_columns as $column_name) {
                echo '<option value="' . $column_name . '" ' . set_value("column[]", $column_name) . '>' . $column_name . '</option>';
            }
        } else {
            echo '<option value="">Choose column</option>';
        }
    }

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

    //assign permission
    public function assign_permission($user_id)
    {
        $this->data['title'] = "Assign User Permission";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$user_id) {
            set_flashdata(display_message("Select user to assign permission", "warning"));
            redirect("auth/users_list");
        }

        //find user perms
        $this->data['user'] = $this->User_model->find_by_id($user_id);
        $groups = $this->User_model->get_user_groups_by_id($user_id);

        $this->data['user_groups'] = "{ ";
        $i = 0;
        $count = count($groups);

        foreach ($groups as $group) {
            $this->data['user_groups'] .= ucfirst($group->name) . " " . $group->description;
            if ($i < ($count - 1)) {
                $this->data['user_groups'] .= " , ";
            }
            $i++;
        }
        $this->data['user_groups'] .= " }";
        $this->data['permissions_list'] = $this->Acl_model->find_permissions();

        //assigned members
        $perms = array();
        $assigned_perms_list = $this->db
            ->get_where('acl_users_permissions', array('user_id' => $user_id))->result();

        foreach ($assigned_perms_list as $v) {
            array_push($perms, $v->permission_id);
        }
        $this->data['assigned_perms'] = $perms;

        //if user prefer to assign
        if (isset($_POST['save'])) {
            if (empty($_POST['permissions'])) {
                //redirect with message
                $this->session->set_flashdata('message', display_message('No permission selected', 'danger'));
                redirect('auth/accesscontrol/assign_permission/' . $user_id, 'refresh');
            } else {
                //delete all user permission
                $this->Acl_model->delete_user_permission($user_id);

                foreach ($_POST['permissions'] as $perm_id) {
                    //insert perms
                    $users_permissions = [
                        "user_id" => $user_id,
                        "permission_id" => $perm_id,
                        "date_added" => date("Y-m-d H:i:s")
                    ];
                    $this->Acl_model->assign_users_permissions($users_permissions);
                }
            }

            //redirect with message
            $this->session->set_flashdata('message', display_message('You have assigned permission(s) successfully'));
            redirect("auth/accesscontrol/assign_permission/" . $user_id);
        }

        //render view
        $this->load->view("header", $this->data);
        $this->load->view("acl/assign_permission", $this->data);
        $this->load->view("footer");
    }
}