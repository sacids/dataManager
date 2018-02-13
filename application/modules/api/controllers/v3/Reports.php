<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 08/02/2018
 * Time: 09:06
 */

class Reports extends REST_Controller
{
    private $table_name;
    private $instance_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model', 'User_model', 'Xform_model', 'Feedback_model'));
    }

    //forms
    function forms_get()
    {
        if (!$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Required parameter are missing'), 202);
        }

        //get user details from database
        $user = $this->User_model->find_by_username($this->get('username'));

        //show status header if user not available in database
        if (count($user) == 0) {
            $this->response(array('status' => 'failed', 'message' => 'User not exist'), 202);
        }

        $user_groups = $this->User_model->get_user_groups_by_id($user->id);
        $user_perms = array(0 => "P" . $user->id . "P");
        $i = 1;
        foreach ($user_groups as $ug) {
            $user_perms[$i] = "G" . $ug->id . "G";
            $i++;
        }

        $forms = $this->Xform_model->get_form_list_by_perms($user_perms);

        if ($forms) {
            $form = array();

            foreach ($forms as $v) {
                //form data
                $this->model->set_table($v->form_id);
                $form_data = $this->model->get_all();

                foreach ($form_data as $value) {
                    $this->model->set_table('feedback');
                    $feedback = $this->model->count_by(array('instance_id' => $value->meta_instanceID));

                    //check for meta_instanceName
                    if (array_key_exists('meta_instanceName', $value))
                        $label = $value->meta_instanceName;
                    else
                        $label = $v->title;

                    //check for username
                    if (array_key_exists('meta_username', $value)) {
                        //find user
                        $user = $this->User_model->find_by_username($value->meta_username);

                        if ($user)
                            $user = $user->first_name . ' ' . $user->last_name;
                        else
                            $user = '';

                    } else {
                        $user = '';
                    }

                    //form array
                    $form[] = array(
                        'id' => $v->id,
                        'form_id' => $v->form_id,
                        'instance_id' => $value->meta_instanceID,
                        'instance_name' => $label,
                        'title' => $v->title,
                        'created_at' => $v->date_created,
                        'jr_form_id' => $v->jr_form_id,
                        'feedback' => $feedback,
                        'user' => $user
                    );
                }
            }
            $this->response(array("status" => "success", "forms" => $form), 200);
        } else {
            $this->response(array('status' => 'failed', 'message' => 'No campaign found'), 202);
        }
    }


    //form details
    function form_details_get()
    {
        if (!$this->get('table_name') || !$this->get('instance_id')) {
            $this->response(array('status' => 'failed', 'message' => 'Invalid table name or instance Id'), 202);
        }

        //get variables
        $this->table_name = $this->get('table_name');
        $this->instance_id = $this->get('instance_id');

        // get definition file name
        $this->model->set_table('xforms');
        $form_details = $this->model->get_by('form_id', $this->table_name);

        //set file defn
        $this->Xformreader_model->set_defn_file($this->config->item("form_definition_upload_dir") . $form_details->filename);
        $this->Xformreader_model->load_xml_definition();
        $form_definition = $this->Xformreader_model->get_defn();

        //get form data
        $form_data = $this->get_form_data($form_definition, $this->get_field_name_map($this->table_name));

        if ($form_data)
            $this->response(array("status" => "success", "form_details" => $form_data), 200);
        else
            $this->response(array("status" => "failed", "message" => "No details found"), 202);
    }

    //get feedback
    function feedback_get()
    {
        if (!$this->get('instance_id') || !$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Required parameter are missing'), 202);
        }

        //get user details from database
        $user = $this->User_model->find_by_username($this->get('username'));

        //show status header if user not available in database
        if (count($user) == 0) {
            $this->response(array('status' => 'failed', 'message' => 'User not exist'), 202);
        }

        //get feedback
        $this->model->set_table('feedback');
        $feedback = $this->model->get_many_by(array('instance_id' => $this->get('instance_id')));

        if ($feedback) {
            $feedback_array = array();
            foreach ($feedback as $value) {
                //feedback array
                $feedback_array[] = array(
                    'id' => $value->id,
                    'form_id' => $value->form_id,
                    'instance_id' => $value->instance_id,
                    'message' => $value->message,
                    'sender' => $value->sender,
                    'reply_by' => $value->reply_by,
                    'username' => $this->get('username'),
                    'date_created' => $value->date_created
                );
            }
            $this->response(array("status" => "success", "form_details" => $feedback_array), 200);
        } else {
            $this->response(array("status" => "failed", "message" => "No feedback found"), 202);
        }
    }

    //post feedback
    function send_feedback_post()
    {
        if (!$this->post('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Username is required'));
        }

        //get user details from database
        $user = $this->User_model->find_by_username($this->post('username'));

        log_message("debug", "User posting feedback is " . $user->username);

        if ($user) {
            //other post data
            $instance_id = $this->post('instance_id');

            //update all feedback from this user
            $this->Feedback_model->update_user_feedback($instance_id, 'server');

            $result = $this->db->insert('feedback',
                array(
                    'user_id' => $user->id,
                    'instance_id' => $this->post('instance_id'),
                    'form_id' => $this->post('form_id'),
                    'message' => $this->post("message"),
                    'sender' => $this->post("sender"),
                    'date_created' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'reply_by' => 0
                )
            );

            //check if feedback inserted
            if ($result)
                $this->response(array('status' => 'success', 'message' => 'Feedback received'), 200);
            else
                $this->response(array('status' => 'failed', 'message' => 'Unknown error occurred'), 202);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'User does not exist'), 203);
        }
    }


    //get form data
    function get_form_data($structure, $map)
    {
        //get feedback form details
        $this->model->set_table($this->table_name);
        $data = $this->model->get_by('meta_instanceID', $this->instance_id);

        if (!$data) return false;
        $holder = array();
        //print_r($map);
        //print_r($structure);

        $ext_dirs = array(
            'jpg' => "images",
            'jpeg' => "images",
            'png' => "images",
            '3gpp' => 'audio',
            'amr' => 'audio',
            '3gp' => 'video',
            'mp4' => 'video');

        $c = 1;
        $id = $data->id;

        foreach ($structure as $val) {
            $tmp = array();
            $field_name = $val['field_name'];
            $type = $val['type'];

            //TODO : change way to get label
            if (array_key_exists($field_name, $map)) {
                if ($map[$field_name]['field_label'] != null || $map[$field_name]['field_label'] != 0) {
                    $label = $map[$field_name]['field_label'];
                } else {
                    if (!array_key_exists('label', $val))
                        $label = $field_name;
                    else
                        $label = $val['label'];
                }
            } else {
                $label = $field_name;
            }

            if (array_key_exists($field_name, $map)) {
                $field_name = $map[$field_name]['col_name'];
            }
            $l = $data->$field_name;


            if ($type == 'select1') {
                //print_r($val);
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

                foreach ($tmp1 as $value) {
                    $code = trim($value);

                    if (strpos($code, 'A') === false) {
                        $item = $code;
                    } else {
                        $this->model->set_table('ohkr_symptoms');
                        $symptom = $this->model->get_by('code', $code);
                        if ($symptom)
                            $item = $symptom->title;
                        else
                            $item = $code;
                    }
                    array_push($arr, $item);
                }
                $l = implode(",", $arr);
            }

            if (substr($label, 0, 5) == 'meta_') continue;
            $tmp['id'] = $id . $c++;
            $tmp['label'] = str_replace('_', ' ', $label);
            $tmp['type'] = $type;
            $tmp['value'] = $l;
            array_push($holder, $tmp);
        }
        return $holder;
    }

    //get field name map
    function get_field_name_map($table_name)
    {
        $tmp = $this->Xform_model->get_fieldname_map($table_name, '0');
        $map = array();
        foreach ($tmp as $part) {
            $key = $part['field_name'];
            $map[$key] = $part;
        }
        return $map;
    }
}