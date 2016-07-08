<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 9:57 AM
 */
class Auth extends CI_Controller
{
    var $realm;

    function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model('User_model');
        $this->realm = 'Authorized users of Sacids Openrosa';
    }

    /**
     * @param $username
     * @param $password
     * @return digest_password
     */
    function digest($username, $password)
    {
        $response = array();

        //check if username and password exist
        if (!$username || !$password) {
            $response = array("status" => "failed", "message" => "Required username and password");
            echo json_encode($response);
            exit;
        }

        //digest password {if username and password exist}
        $digest_password = md5("{$username}:{$this->realm}:{$password}");

        if ($digest_password) {
            $response = array("status" => "success", "digest_password" => $digest_password);

        } else {
            $response = array("status" => "failed", "message" => "failed to create digest password");

        }

        echo json_encode($response);

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
            $response["error_msg"] = "Incorrect username or password";

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

            //digest password
            $digest_password = md5("{$username}:{$this->realm}:{$password}");

            $arrayName = explode(" ", $full_name);

            //Register user
            $additional_data = array(
                'first_name' => $arrayName[0],
                'last_name' => $arrayName[1],
                'phone' => $username,
                'digest_password' => $digest_password
            );
            $email = "";

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