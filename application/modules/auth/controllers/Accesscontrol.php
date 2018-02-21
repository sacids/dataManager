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

        $this->data['title'] = "Access control list";
    }


    function index()
    {
        $this->data['permissions'] = $this->Acl_model->find_permissions();

        $this->load->view("header", $this->data);
        $this->load->view("acl/list_permissions", $this->data);
        $this->load->view("footer");
    }


    function new_filter($permission_id = null)
    {

        if ($permission_id == null) {
            set_flashdata(display_message("Select a permission to add a new filter", "error"));
            redirect("auth/accesscontrol");
        }

        $this->form_validation->set_rules("filter", "Filter name", "required");
        $this->form_validation->set_rules("table", "Table name", "required");
        $this->form_validation->set_rules("filter_column", "Column name", "");
        $this->form_validation->set_rules("filter_operator", "Operator", "");
        $this->form_validation->set_rules("filter_value", "Value", "");
        $this->form_validation->set_rules("filter_permission", "Permission", "required");

        if ($this->form_validation->run() === false) {
            $this->data['tables'] = $this->db->list_tables();
            $this->data['permission_id'] = $permission_id;

            $this->data['permissions'] = $this->Acl_model->find_permissions();

            $this->load->view("header", $this->data);
            $this->load->view("acl/new_filter", $this->data);
            $this->load->view("footer");
        } else {

            $filter_column = $this->input->post("filter_column");
            $filter_operator = $this->input->post("filter_operator");
            $filter_value = $this->input->post("filter_value");

            $condition = null;
            $filters_count = count($filter_column);

            for ($i = 0; $i < $filters_count; $i++) {
                $condition .= " " . $filter_column[$i] . " " . $filter_operator[$i] . " '" . $filter_value[$i] . "' ";

                if ($i < ($filters_count - 1)) {
                    $condition .= " AND ";
                }
            }

            $filter = [
                "permission_id"   => $permission_id,
                "name"            => $this->input->post("filter"),
                "table_name"      => $this->input->post("table"),
                "where_condition" => $condition,
                "date_added"      => date("Y-m-d H:i:s")
            ];
            log_message("debug", "Filter information to save => " . json_encode($filter));

            if ($this->Acl_model->create_filter($filter)) {
                set_flashdata(display_message("Filter was successfully created"));
            } else {
                set_flashdata(display_message("Failed", "error"));
            }
            redirect("auth/accesscontrol/new_filter");
        }
    }

    function new_permission()
    {

        $this->form_validation->set_rules("permission", "Permission name", "required");
        $this->form_validation->set_rules("description", "Description", "");

        if ($this->form_validation->run() === false) {

            $this->load->view("header", $this->data);
            $this->load->view("acl/new_permission", $this->data);
            $this->load->view("footer");
        } else {
            $permission = [
                "title"       => $this->input->post("permission"),
                "description" => $this->input->post("description"),
                "date_added"  => date("Y-m-d H:i:s")
            ];

            if ($this->Acl_model->create_permission($permission)) {
                set_flashdata(display_message("Permission was successfully created"));
            } else {
                set_flashdata(display_message("Failed to create permission", "error"));
            }
            redirect("auth/accesscontrol");
        }
    }

    public function edit_permission($permission_id)
    {
        $this->load->view("header", $this->data);
        $this->load->view("acl/edit_permission", $this->data);
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

    public function assign_permission($user_id)
    {
        if (!$user_id) {
            set_flashdata(display_message("Select user to assign permission", "warning"));
            redirect("auth/users_list");
        }

        $this->form_validation->set_rules("user_id", "User id", "required");

        if ($this->form_validation->run() === false) {

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
            $this->data['permissions'] = $this->Acl_model->find_permissions();

            $this->load->view("header", $this->data);
            $this->load->view("acl/assign_permission", $this->data);
            $this->load->view("footer");
        } else {

            $post_permissions = $this->input->post("permissions");

            $count = count($post_permissions);

            $users_permissions = [];
            for ($j = 0; $j < $count; $j++) {
                $this->Acl_model->delete_user_permission($user_id, $post_permissions[$j]);
                $users_permissions[$j] = [
                    "user_id"       => $user_id,
                    "permission_id" => $post_permissions[$j],
                    "date_added"    => date("Y-m-d H:i:s")
                ];
            }

            if ($this->Acl_model->assign_users_permissions($users_permissions)) {
                set_flashdata(display_message("You have assigned permission(s) successfully"));
            } else {
                set_flashdata(display_message("Failed to assign permission", "error"));
            }
            redirect("auth/accesscontrol/assign_permission/" . $user_id);
        }
    }
}