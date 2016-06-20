<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 3:42 PM
 */
class Feedback extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Feedback_model', 'User_model', 'Xform_model'));
        log_message('debug', 'Feedback Api controller initialized');
    }

    /**
     * get Feedback Api
     */
    function get_feedback()
    {
        $username = $this->input->get("username");

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
            $feedback_list = $this->Feedback_model->get_feedback_list();

            foreach($feedback_list as $value){
                $username = $this->User_model->find_by_id($value->user_id)->username;
                $form_name = $this->Xform_model->find_by_xform_id($value->form_id)->title;

                $feedback[] = array(
                    'id' => $value->id,
                    'form_id' => $value->form_id,
                    'instance_id' => $value->instance_id,
                    'title' => $form_name,
                    'message' =>$value->message,
                    'sender' => $value->sender,
                    'user' => $username,
                    'date_created' => date("m-Y, H:i", strtotime($value->date_created)),
                    'status' => $value->status
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
            $feedback = array(
                "user_id" => $user->id,
                "instance_id" => $this->input->post("instance_id"),
                "form_id" => $this->input->post('form_id'),
                "message" => $this->input->post("message"),
                'sender' => $this->input->post("sender"),
                "date_created" => date("c"),
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

}