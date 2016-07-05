<?php

class Feedback extends CI_Controller
{
    private $table_name;
    private $instance_id;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Feedback_model', 'User_model', 'Xform_model'));
        $this->load->library('xform_comm');
        log_message('debug', 'Feedback Api controller initialized');
        //$this->output->enable_profiler(TRUE);
    }

    /**
     * get Feedback Api
     */
    function get_feedback()
    {
        $username = $this->input->get("username");
        $last_id = $this->input->post("last_id");
        $date_created = $this->input->post("date_created");

        //TODO: call function for permission, return chat user (form_id) needed to see


        $user = $this->User_model->find_by_username($username);
        log_message("debug", "username getting forms feedback is " . $username);

        if ($user) {
            $feedback_list = $this->Feedback_model->get_feedback_list($user->id);

            foreach ($feedback_list as $value) {
                $username = $this->User_model->find_by_id($value->user_id)->username;
                $reply_user = $this->User_model->find_by_id($value->reply_by)->username;
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

            $response = array("feedback" => $feedback, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "User does not exist");
        }
        echo json_encode($response);
    }



    /**
     * get Feedback Api
     */
    function get_notification_feedback()
    {
        $username = $this->input->get("username");
        $last_id = $this->input->post("last_id");

        //check if no username
        if (!$username) {
            $response = array("status" => "failed", "message" => "Required username");
            echo json_encode($response);
            exit;
        }

        //TODO: call function for permission, return chat user (form_id) needed to see

        $user = $this->User_model->find_by_username($username);
        log_message("debug", "username getting forms feedback is " . $username);

        if ($user) {
            $feedback_list = $this->Feedback_model->get_feedback_notification($user->id);

            foreach ($feedback_list as $value) {
                $username = $this->User_model->find_by_id($value->user_id)->username;
                $reply_user = $this->User_model->find_by_id($value->reply_by)->first_name;
                $form_name = $this->Xform_model->find_by_xform_id($value->form_id)->title;

                $feedback[] = array(
                    'id' => $value->id,
                    'form_id' => $value->form_id,
                    'instance_id' => $value->instance_id,
                    'title' => $form_name,
                    'message' => $value->message,
                    'sender' => $value->sender,
                    'user' => $username,
                    'date_created' => date("m-Y, H:i", strtotime($value->date_created)),
                    'status' => $value->status,
                    'reply_by' => $reply_user
                );
            }

            $response = array("feedback" => $feedback, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "User does not exist");
        }
        echo json_encode($response);
    }


    /**
     * post Feedback Api
     */
    function post_feedback()
    {
        $username = $this->input->post("username");

        //check if no username
        if (!$username) {
            $response = array("status" => "failed", "message" => "Required username");
            echo json_encode($response);
            exit;
        }

        //get user details
        $user = $this->User_model->find_by_username($username);
        log_message("debug", "User posting feedback is " . $username);

        if ($user) {
            $instance_id = $this->input->post("instance_id");
            //update all feedback from this user
            $this->Feedback_model->update_user_feedback($instance_id, 'server');

            $feedback = array(
                "user_id" => $user->id,
                "instance_id" => $instance_id,
                "form_id" => $this->input->post('form_id'),
                "message" => $this->input->post("message"),
                'sender' => $this->input->post("sender"),
                "date_created" => date('Y-m-d H:i:s'),
                "status" => $this->input->post("status")
            );

            if ($this->Feedback_model->create_feedback($feedback)) {
                $response = array("message" => "Feedback was received successfully", "status" => "success");

            } else {
                $response = array("status" => "failed", "message" => "Unknown error occured");

            }
        } else {
            $response = array("status" => "failed", "message" => "user does not exist");

        }
        echo json_encode($response);
    }

    /**
     * Form Feedback Api
     */
    function get_form_details()
    {
        $table_name     = $this->input->post('table_name'); //"ad_build_Dalili_Binadamu_Skolls_7";
        $instance_id    = $this->input->post('instance_id');
        $lang           = $this->input->post('language'); //"uuid:bdde9461-fccb-49ae-a099-284389a9bf7d";



        $this->table_name   = $table_name;
        $this->instance_id  = $instance_id;

        // get definition file name
        $form_details   = $this->Feedback_model->get_form_details($table_name);
        $file_name      = $form_details->filename;

        $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $file_name);
        $this->xform_comm->load_xml_definition($this->config->item("xform_tables_prefix"));

        $form_definition    = $this->xform_comm->get_defn();

        $form_data      = $this->get_form_data($form_definition,$this->get_fieldname_map($table_name));

        if ($form_data) {

            $response = array("form_details" => $form_data, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "Nothing found");

        }
        echo json_encode($response);
    }

    

    function get_form_data($structure,$map){

        $data   = $this->Feedback_model->get_feedback_form_details($this->table_name,$this->instance_id);

        if(!$data) return false;

        $holder = array();

       // print_r($map);
      //print_r($structure);

        $ext_dirs  = array(
            'jpg' => "images",
            'jpeg'=> "images",
            'png' => "images",
            '3gpp'=> 'audio',
            'amr' => 'audio',
            '3gp' => 'video',
            'mp4' => 'video');


        $c = 0;
        foreach($structure as $val){

            $tmp        = array();
            $field_name = $val['field_name'];
            $type       = $val['type'];

            if(!array_key_exists('label',$val)){
                $label = $field_name;
            }else {
                $label = $val['label'];
            }

            if(array_key_exists($field_name,$map)){
                $field_name = $map[$field_name]['col_name'];
            }

            $l  = $data->$field_name;

            if($type == 'select1'){
                $l = $val['option'][$l];
            }

            if($type == 'binary'){
                // check file extension
                $value = explode('.', $l);
                $file_extension = end($value);

                if(array_key_exists($file_extension,$ext_dirs)) {
                    $l = site_url('assets/forms/data').'/'.$ext_dirs[$file_extension].'/'.$l;
                }
            }

            if($type == 'select'){

                $tmp1 = explode(" ",$l);
                $arr = array();

                foreach($tmp1 as $item){
                    $item   = trim($item);
                    array_push($arr,$val['option'][$item]);
                }

                $l  = implode(",",$arr);
            }

            if(substr($label,0,5) == 'meta_') continue;

            $tmp['id']      = $c++;
            $tmp['label']   = $label;
            $tmp['type']    = $type;
            $tmp['value']   = $l;

            array_push($holder,$tmp);
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