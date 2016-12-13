<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 12/8/2016
 * Time: 10:49 AM
 */
class Feedback extends REST_Controller
{
    private $table_name;
    private $instance_id;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Feedback_model', 'User_model', 'Xform_model', 'Perm_model'));
        $this->load->library('Xform_comm');
        log_message('debug', 'Feedback Api controller initialized');
    }


    function index_get()
    {
        if (!$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Required username'), 202);
        }

        $user = $this->User_model->find_by_username($this->get('username'));
        log_message("debug", "username getting forms feedback is " . $this->get('username'));

        if ($user) {
            //TODO: call function for permission, return chat user (form_id) needed to see
            $my_perms = $this->Perm_model->get_my_perms($user->id);
            $cond = "FALSE OR (`perms` LIKE '%" . implode("%' OR `perms` LIKE '%", $my_perms) . "%')";

            $where = ' where ' . $cond;
            $table_name = 'xforms';

            //Perms module
            $perms = $this->db->query('SELECT * FROM ' . $table_name . ' ' . $where)->result();


            $i = 1;
            foreach ($perms as $perm) {
                $where_perm[$i] = $perm->form_id;
                $i++;
            }

            //Feedback Mapping
            $feedback_mapping = $this->Feedback_model->get_feedback_mapping($user->id);

            //check if mapping is not empty
            if ($feedback_mapping) {
                $where_array = explode(',', $feedback_mapping->users);
            } else {
                $where_array = $user->id;
            }

            //feedback List
            $feedback_list = $this->Feedback_model->get_feedback_list($where_perm, $where_array, $this->get("date_created"));

            foreach ($feedback_list as $value) {
                $first_name = $this->User_model->find_by_id($value->user_id)->first_name;
                $last_name = $this->User_model->find_by_id($value->user_id)->last_name;
                $chr_name = $first_name . ' ' . $last_name;
                $username = $this->User_model->find_by_id($user->id)->username;
                $form_name = $this->Xform_model->find_by_xform_id($value->form_id)->title;

                //get reply user
                if ($value->reply_by != 0) {
                    $reply_user = $this->Feedback_model->get_reply_user($value->reply_by);
                } else {
                    $reply_user = $value->reply_by;
                }

                $feedback[] = array(
                    'id' => $value->id,
                    'form_id' => $value->form_id,
                    'instance_id' => $value->instance_id,
                    'title' => $form_name,
                    'message' => $value->message,
                    'sender' => $value->sender,
                    'user' => $username,
                    'chr_name' => $chr_name,
                    'date_created' => $value->date_created,
                    'status' => $value->status,
                    'reply_by' => $reply_user
                );
            }
            //response
            $response = array("feedback" => $feedback, "status" => "success");
            $this->response($response, 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'User does not exist'));
        }
    }


    function notification_get()
    {
        if (!$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Required username'),202);
        }

        $user = $this->User_model->find_by_username($this->get('username'));
        log_message("debug", "username getting forms feedback is " . $this->get('username'));

        if ($user) {
            //TODO: call function for permission, return chat user (form_id) needed to see
            $my_perms = $this->Perm_model->get_my_perms($user->id);
            $cond = "FALSE OR (`perms` LIKE '%" . implode("%' OR `perms` LIKE '%", $my_perms) . "%')";

            $where = ' where ' . $cond;
            $table_name = 'xforms';

            //Perms module
            $perms = $this->db->query('SELECT * FROM ' . $table_name . ' ' . $where)->result();

            $i = 1;
            foreach ($perms as $perm) {
                $where_perm[$i] = $perm->form_id;
                $i++;
            }

            //Feedback Mapping
            $feedback_mapping = $this->Feedback_model->get_feedback_mapping($user->id);

            //check if mapping is not empty
            if ($feedback_mapping) {
                $where_array = explode(',', $feedback_mapping->users);
            } else {
                $where_array = $user->id;
            }

            //feedback list
            $feedback_list = $this->Feedback_model->get_feedback_list($where_perm, $where_array, $this->get('date_created'));

            foreach ($feedback_list as $value) {
                $username = $this->User_model->find_by_id($value->user_id)->first_name;
                $reply_user = $this->Feedback_model->get_reply_user($value->reply_by);
                $form_name = $this->Xform_model->find_by_xform_id($value->form_id)->title;

                $feedback[] = array(
                    'id' => $value->id,
                    'form_id' => $value->form_id,
                    'instance_id' => $value->instance_id,
                    'title' => $form_name,
                    'message' => $value->message,
                    'sender' => $value->sender,
                    'user' => $username,
                    'date_created' => $value->date_created,
                    'status' => $value->status,
                    'reply_by' => $reply_user
                );
            }
            //response
            $response = array("feedback" => $feedback, "status" => "success");
            $this->response($response, 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'User does not exist'));
        }
    }

    function feedback_post()
    {
        if (!$this->post('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Required username'));
        }

        //get user details
        $user = $this->User_model->find_by_username($this->post('username'));
        log_message("debug", "User posting feedback is " . $this->post('username'));

        if ($user) {
            //query details from feedback
            $query = $this->db->get_where('feedback', array('instance_id' => $this->post('instance_id')))->row();

            //update all feedback from this user
            $this->Feedback_model->update_user_feedback($this->post('instance_id'), 'server');

            $result = $this->Feedback_model->create_feedback(array(
                'user_id' => $query->user_id,
                'instance_id' => $this->post('instance_id'),
                'form_id' => $this->post('form_id'),
                'message' => $this->post("message"),
                'sender' => $this->post("sender"),
                'date_created' => date('Y-m-d H:i:s'),
                'status' => $this->post("status"),
                'reply_by' => 0
            ));

            if ($result === FALSE)
                $this->response(array('status' => 'failed', 'message' => 'Unknown error occured'));
            else
                $this->response(array('message' => 'Feedback was received successfully', 'status' => 'success'), 201);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'User does not exist'));
        }
    }


    function form_details_get()
    {
        if (!$this->get('table_name') || $this->get('instance_id')) {
            $this->response(array('status' => 'failed', 'message' => 'Invalid table name or instance Id'));
        } else {
            $this->table_name = $this->get('table_name');
            $this->instance_id = $this->get('instance_id');

            // get definition file name
            $form_details = $this->Feedback_model->get_form_details($this->table_name);
            $file_name = $form_details->filename;
            $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $file_name);
            $this->xform_comm->load_xml_definition($this->config->item("xform_tables_prefix"));
            $form_definition = $this->xform_comm->get_defn();
            $form_data = $this->get_form_data($form_definition, $this->get_fieldname_map($this->table_name));

            if ($form_data) {
                $response = array("form_details" => $form_data, "status" => "success");
            } else {
                $response = array("status" => "failed", "message" => "Nothing found");
            }
            $this->response($response, 200);
        }
    }


    function get_form_data($structure, $map)
    {
        $data = $this->Feedback_model->get_feedback_form_details($this->table_name, $this->instance_id);
        if (!$data) return false;
        $holder = array();
        // print_r($map);
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
            if (!array_key_exists('label', $val)) {
                $label = $field_name;
            } else {
                $label = $val['label'];
            }
            if (array_key_exists($field_name, $map)) {
                $field_name = $map[$field_name]['col_name'];
            }
            $l = $data->$field_name;
            if ($type == 'select1') {
                $l = $val['option'][$l];
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