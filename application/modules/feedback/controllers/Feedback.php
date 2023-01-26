<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *Form Feedback Class
 *
 * @package     Data
 * @category    Controller
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Feedback extends MX_Controller
{
    private $data;
    private $user_id;
    private $controller;

    private $label;
    private $search_value;

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_auth');
        $this->load->helper(array('url', 'string'));
        log_message('debug', 'Feedback controller initialized');

        $this->user_id = $this->session->userdata("user_id");
        $this->controller = "Feedback";
    }

    //check login user
    function is_logged_in()
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
     * input null
     *
     * @return array
     */
    function lists()
    {
        $this->data['title'] = "Feedback";

        //check if logged in
        $this->is_logged_in();
        $this->has_allowed_perm($this->router->fetch_method());

        if (isset($_POST['search'])) {
            $form_name = $this->input->post("name", NULL);
            $username = $this->input->post("username", NULL);

            //search feedback
            $feedback = $this->Feedback_model->search_feedback($form_name, $username);

            if ($feedback)
                $this->data['feedback_lists'] = $feedback;
            else
                $this->data['feedback_lists'] = [];
        } else {
            $config = array(
                'base_url' => $this->config->base_url("feedback/lists"),
                'total_rows' => $this->Feedback_model->count_feedback(),
                'uri_segment' => 3,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->data['feedback_lists'] = $this->Feedback_model->find_all($this->pagination->per_page, $page);
            $this->data["links"] = $this->pagination->create_links();
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("feedback/list");
        $this->load->view('footer');
    }


    /**
     * @param $instance_id
     * @return array
     */
    function details($instance_id)
    {
        $this->data['title'] = "Chat Conversation";

        //check if logged in
        $this->is_logged_in();
        //$this->has_allowed_perm($this->router->fetch_method());

        //feedback
        $feedback = $this->Feedback_model->get_feedback_by_instance($instance_id);

        if (!$feedback)
            show_error("User conversation not exists");

        //pass variables
        $this->data['feedback'] = $feedback;
        $this->data['instance_id'] = $instance_id;

        foreach ($this->data['feedback'] as $k => $feedback) {
            if ($feedback->sender == 'user')
                $this->data['feedback'][$k]->sender_name = $this->User_model->get_user_details($feedback->user_id);
            else
                $this->data['feedback'][$k]->sender_name = $this->User_model->get_user_details($feedback->reply_by);
        }

        //update all feedback from android app using instance_id
        $this->Feedback_model->update_user_feedback($instance_id, 'user');

        //form
        $this->model->set_table('xforms');
        $xform = $this->model->get_by(['form_id' => $feedback->form_id]);
        $this->data['form'] = $xform;

        //project
        $project = $this->Project_model->get_project_by_id($xform->project_id);

        if (!$project)
            show_error("Project not exist", 500);

        $this->data['project'] = $project;    


        //form data    
        $this->table_name = $xform->form_id;
        $this->label = 'meta_instanceID';
        $this->search_value = $instance_id;

        $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $xform->filename);
        $this->xform_comm->load_xml_definition($this->config->item("xform_tables_prefix"));
        $form_definition = $this->xform_comm->get_defn();

        //get form data
        $form_data = $this->get_form_data($form_definition, $this->get_fieldname_map($this->table_name));

        if ($form_data)
            $this->data['form_data'] = $form_data;
        else
            $this->data['form_data'] = [];


        //submit data
        if ($_POST) {
            $message = $this->input->post('message');
            $fb = $this->Feedback_model->get_feedback_details_by_instance($instance_id);

            //Insert data from ajax
            $result = $this->Feedback_model->create_feedback(array(
                'form_id' => $fb->form_id,
                'message' => $message,
                'date_created' => date('Y-m-d H:i:s'),
                'instance_id' => $instance_id,
                'user_id' => $fb->user_id,
                'sender' => 'server',
                'status' => 'pending',
                'reply_by' => $this->user_id
            ));

            if ($result)
                redirect('feedback/details/' . $instance_id, 'refresh');
            else
                redirect('feedback/details/' . $instance_id, 'refresh');
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("details");
        $this->load->view('footer');
    }

    //get form data
    function get_form_data($structure, $map)
    {
        //get feedback form details
        $this->model->set_table($this->table_name);
        $data = $this->model->get_by($this->label, $this->search_value);

        if (!$data) return false;
        $holder = array();

        $ext_dirs = array(
            'jpg' => "images",
            'jpeg' => "images",
            'png' => "images",
            '3gpp' => 'audio',
            'amr' => 'audio',
            '3gp' => 'video',
            'mp4' => 'video'
        );

        $c = 1;
        $id = $data->id;

        foreach ($structure as $val) {
            $tmp = array();
            $field_name = $val['field_name'];
            $type = $val['type'];

            //TODO : change way to get label
            if (array_key_exists($field_name, $map)) {
                if (!empty($map[$field_name]['field_label'])) {
                    $label = $map[$field_name]['field_label'];
                } else {
                    if (!array_key_exists('label', $val))
                        $label = $field_name;
                    else
                        $label = $val['label'];
                }
            }

            if (array_key_exists($field_name, $map)) {
                $field_name = $map[$field_name]['col_name'];
            }
            $l = $data->$field_name;


            if ($type == 'select1') {
                //$l = $val['option'][$l];
            }
            if ($type == 'binary') {
                // check file extension
                $value = explode('.', $l);
                $file_extension = end($value);
                if (array_key_exists($file_extension, $ext_dirs)) {
                    $l = site_url('assets/forms/data') . '/' . $ext_dirs[$file_extension] . '/' . $l;
                }
            }
            if ($type == 'select') {
                $tmp1 = explode(" ", $l);
                $arr = array();
                foreach ($tmp1 as $item) {
                    $item = trim($item);

                    if ($item != "NA")
                        array_push($arr, $val['option'][$item]);
                }
                $l = implode(",", $arr);
            }
            if (substr($label, 0, 5) == 'meta_') continue;
            $tmp['id'] = $id . $c++;
            $tmp['label'] = $label;
            $tmp['type'] = $type;
            $tmp['value'] = $l;
            array_push($holder, $tmp);
        }
        return $holder;
    }

    //get fieldname map
    private function get_fieldname_map($table_name)
    {
        $tmp = $this->Xform_model->get_fieldname_map($table_name);
        $map = array();
        foreach ($tmp as $part) {
            $key = $part['field_name'];
            $map[$key] = $part;
        }
        return $map;
    }
}
