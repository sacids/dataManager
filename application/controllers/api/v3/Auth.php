<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 12/8/2016
 * Time: 12:46 PM
 */
class Auth extends REST_Controller
{
    private $initial;
    private $realm;

    function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model(array('User_model'));
        $this->initial = 255;
        $this->realm = 'Authorized users of Sacids Openrosa';
    }


    /**
     * App Version
     */
    function version_get()
    {
        $app_version = $this->db->get_where('app_version', array('status' => 'current'))->row();

        if ($app_version) {
            $this->response(array('app_version' => $app_version, 'status' => 'success'), 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No app version available'), 204);

        }
    }


    function login_post()
    {
        if (!$this->post('username') || !$this->post('password')) {
            $this->response(array('error' => TRUE, 'error_msg' => 'Required parameter are missing'), 202);
        }

        //substring last 9 character
        $username = $this->initial . substr($this->post('username'), -9);

        if (!$this->ion_auth->login($username, $this->post('password'))) {
            $this->response(array('error' => TRUE, 'error_msg' => 'Incorrect username or password'), 204);

        } else {
            $user = $this->User_model->find_by_username($username);

            //return response after successfully
            $response["error"] = FALSE;
            $response["uid"] = $user->id;
            $response["user"]["username"] = $user->username;
            $response["user"]["first_name"] = $user->first_name;
            $response["user"]["last_name"] = $user->first_name;
            $response["user"]["created_at"] = date('Y-m-d H:i:s', strtotime($user->created_on));

            $this->response($response, 200);
        }

    }


    function register_post()
    {
        if (!$this->post('username') || !$this->post('password') || !$this->post('password_confirm')) {
            $this->response(array('status' => TRUE, 'error_msg' => 'Required parameter are missing'), 202);
        }

        //substring last 9 character
        $username = $this->initial . substr($this->post('username'), -9);

        if ($this->check_username($username)) {
            $this->response(array('error' => TRUE, 'error_msg' => 'Mobile number used by another user'), 204);

        } else if ($this->post('password') != $this->post('password_confirm')) {
            $this->response(array('error' => TRUE, 'error_msg' => 'Password does not match'), 204);

        } else {

            //digest password
            $digest_password = md5("{$username}:{$this->realm}:{$this->post('password')}");

            $arrayName = explode(" ", $this->post('full_name'));

            //Register user
            $additional_data = array(
                'first_name' => $arrayName[0],
                'last_name' => $arrayName[1],
                'phone' => $username,
                'digest_password' => $digest_password
            );

            if ($this->ion_auth->register($username, $this->post('password'), $email = 'afyadata@sacids.org', $additional_data)) {
                $this->response(array('error' => FALSE, 'success_msg' => 'User creation successfully'), 201);

            } else {
                $this->response(array('error' => TRUE, 'error_msg' => 'Failed to create user'), 204);
            }
        }

    }

    //check existence of username
    function check_username($username)
    {
        $query = $this->db->get_where('users', array('users.username' => $username))->num_rows();
        if ($query > 0)
            return TRUE;
        else
            return FALSE;
    }
}