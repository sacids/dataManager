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
    private $default_email;
    private $realm;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model');

        $this->realm = 'Authorized users of Sacids Openrosa';
        $this->default_email = 'afyadata@sacids.org';
    }


    //App Version
    function version_get()
    {
        //get current app version
        $this->model->set_table('app_version');
        $app_version = $this->model->get_by('status', 'current');

        if ($app_version) {
            $this->response(array('app_version' => $app_version, 'status' => 'success'), 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No app version available'), 204);

        }
    }

    //login
    function login_post()
    {
        if (!$this->post('phone') || !$this->post('password')) {
            $this->response(array('error' => TRUE, 'error_msg' => 'Required parameter are missing'), 202);
        }

        //post data
        $phone = $this->post('phone');
        $password = $this->post('password');
        //assign phone to username
        $username = $phone;

        if (!$this->ion_auth->login($username, $password)) {
            //return response for failure
            $this->response(array('error' => TRUE, 'error_msg' => 'Incorrect mobile or password'), 204);

        } else {
            //get user details after successfully
            $this->model->set_table('users');
            $user = $this->model->get_by('username', $username);

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

    //register user details
    function register_post()
    {
        if (!$this->post('first_name') || !$this->post('last_name') || !$this->post('phone') || !$this->post('password')) {
            $this->response(array('status' => TRUE, 'error_msg' => 'Required parameter are missing'), 202);
        }

        //post data
        $first_name = $this->post('first_name');
        $last_name = $this->post('last_name');
        $phone = $this->post('phone');
        $password = $this->post('password');

        //assign phone to username
        $username = $phone;

        //check mobile number existence
        if ($this->check_mobile_existence($username)) {
            //return error response
            $this->response(array('error' => TRUE, 'error_msg' => 'Mobile used by another user'), 204);

        } else {
            //digest password
            $digest_password = md5("{$username}:{$this->realm}:{$password}");

            //Register user
            $additional_data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'digest_password' => $digest_password
            );

            if ($id = $this->ion_auth->register($username, $password, $this->default_email, $additional_data)) {
                //get user details after successfully
                $this->model->set_table('users');
                $user = $this->model->get_by('id', $id);

                //return response after successfully
                $response["error"] = FALSE;
                $response["uid"] = $user->id;
                $response["user"]["username"] = $user->username;
                $response["user"]["first_name"] = $user->first_name;
                $response["user"]["last_name"] = $user->first_name;
                $response["user"]["created_at"] = date('Y-m-d H:i:s', strtotime($user->created_on));

                $this->response($response, 200);
                //$this->response(array('error' => FALSE, 'success_msg' => 'User creation successfully'), 201);
            } else {
                $this->response(array('error' => TRUE, 'error_msg' => 'Failed to create account'), 204);
            }
        }
    }

    //check existence of mobile
    function check_mobile_existence($mobile)
    {
        //count mobile existence
        $this->model->set_table('users');
        $user = $this->model->count_by('username', $mobile);

        if ($user > 0)
            return TRUE;
        else
            return FALSE;
    }
}