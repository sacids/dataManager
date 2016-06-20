<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 9:57 AM
 */
class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model('User_model');
    }


    /**
     * @param type
     * @return mixed
     */
    function login()
    {
        //define response
        $response = array();

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        //login process validation
        $login_status = $this->ion_auth->login($username, $password);

        // invalid login create array
        if (!$login_status) {
            $response["error"] = TRUE;
            $response["error_msg"] = "Incorrect Login";

        } else if ($login_status) {
            $user = $this->User_model->find_by_username($username);

            $response["error"] = FALSE;
            $response["uid"] = $user->id;
            $response["user"]["username"] = $user->username;
            $response["user"]["first_name"] = $user->first_name;
            $response["user"]["last_name"] = $user->first_name;
            $response["user"]["created_at"] = date('Y-m-d H:i:s', strtotime($user->created_on));
        }

        // convert return array to json and echo
        echo json_encode($response);
    }

    function register()
    {
        //define response
        $response = array();

        //post variable
        $username = $this->input->post('username');
        $full_name = $this->input->post('full_name');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');

        //check username if exist
        $check_username = $this->check_username($username);

        if ($check_username) {
            $response["error"] = TRUE;
            $response["error_msg"] = "Mobile number exist in Afyadata database";

        } else if ($password != $password_confirm) {
            $response["error"] = TRUE;
            $response["error_msg"] = "Password does not match";

        } else {
            //Register member to the database
            $additional_data = array(
                'first_name' => $full_name,
            );
            $email = "afyadata@sacids.org";

            $this->ion_auth->register($username, $password, $email, $additional_data);
            $response["error"] = FALSE;
            $response["success_msg"] = "Account successfully created";

        }
        // convert return array to json and echo
        echo json_encode($response);
    }

    //check existence of username
    function check_username($username)
    {
        $query = $this->db->get_where('users', array('users.username' => $username));
        $count_row = $query->num_rows();
        if ($count_row > 0)
            return TRUE;
        else
            return FALSE;
    }
}