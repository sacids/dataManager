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
    }

    //get feedback list
    function index_get()
    {
        if (!$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Username is required'), 202);
        }

        //get data
        $username = $this->get('username');
        $date_created = $this->get("date_created");

        //get user details
        $this->model->set_table('users');
        $user = $this->model->get_by('username', $username);

        log_message("debug", "username getting forms feedback is " . $username);

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
            $this->model->set_table('feedback_user_map');
            $feedback_mapping = $this->model->get_by('user_id', $user->id);

            //check if mapping is not empty
            if ($feedback_mapping) {
                $where_array = explode(',', $feedback_mapping->users);
            } else {
                $where_array = $user->id;
            }

            //feedback List
            $feedback_list = $this->Feedback_model->get_feedback_list($where_perm, $where_array, $date_created);

            if ($feedback_list) {
                $feedback = array();

                foreach ($feedback_list as $value) {
                    //user details
                    $this->model->set_table('users');
                    $user = $this->model->get_by('id', $value->user_id);

                    //form details
                    $this->model->set_table('xforms');
                    $form = $this->model->get_by('form_id', $value->form_id);

                    //get reply user
                    if ($value->reply_by != 0) $reply_user = $this->Feedback_model->get_reply_user($value->reply_by);
                    else $reply_user = $value->reply_by;

                    //calculate week number
                    $this->model->set_table($value->form_id);
                    $table = $this->model->as_array()->get_by('meta_instanceID', $value->instance_id);

//                    if (array_key_exists('meta_instanceName', $table))
//                        $label = ' - ' . $table['meta_instanceName'];
//                    else
//                        $label = '';

                    //feedback array
                    $feedback[] = array(
                        'id' => $value->id,
                        'form_id' => $value->form_id,
                        'instance_id' => $value->instance_id,
                        'title' => $form->title,
                        'message' => $value->message,
                        'sender' => $value->sender,
                        'user' => $username,
                        'chr_name' => $user->first_name . ' ' . $user->last_name,
                        'date_created' => $value->date_created,
                        'status' => $value->status,
                        'reply_by' => $reply_user
                    );
                }
                //response
                $this->response(array("status" => "success", "feedback" => $feedback), 200);

            } else {
                $this->response(array('status' => 'failed', 'message' => 'No feedback found'), 202);
            }
        } else {
            $this->response(array('status' => 'failed', 'message' => 'User does not exist'));
        }
    }

//post feedback
    function send_post()
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
                    'status' => $this->post("status"),
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
                if ($map[$field_name]['field_label'] != null) {
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