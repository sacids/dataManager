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
            $this->response(array('status' => 'success', 'app_version' => $app_version), 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No app version available'), 204);

        }
    }

    //login
    function login_post()
    {
        if (!$this->post('code') || !$this->post('mobile') || !$this->post('password')) {
            $this->response(array('error' => TRUE, 'error_msg' => 'Required parameter are missing'), 202);
        }

        //post data
        $code = $this->post('code');
        $mobile = $this->post('mobile');
        $password = $this->post('password');

        //username
        $username = substr($code, 1) . $this->cast_mobile($mobile);

        if (!$this->ion_auth->login($username, $password)) {
            //return response for failure
            $this->response(array('error' => TRUE, 'error_msg' => 'Incorrect mobile or password'), 203);

        } else {
            //get user details after successfully
            $this->model->set_table('users');
            $user = $this->model->get_by('username', $username);

            //return response after successfully
            $response["error"] = FALSE;
            $response["uid"] = $user->id;
            $response["user"]["username"] = $user->username;
            $response["user"]["first_name"] = $user->first_name;
            $response["user"]["last_name"] = $user->last_name;

            //success response
            $this->response($response, 200);
        }
    }

    //register user details
    function register_post()
    {
        if (!$this->post('code') || !$this->post('mobile') || !$this->post('password') || !$this->post('password_confirm')) {
            $this->response(array('status' => TRUE, 'error_msg' => 'Required parameter are missing'), 202);
        }

        //post data
        $code = $this->post('code');
        $mobile = $this->post('mobile');
        $password = $this->post('password');
        $password_confirm = $this->post('password_confirm');

        //username
        $username = substr($code, 1) . $this->cast_mobile($mobile);

        //check mobile number existence
        if ($this->check_user_existence($username)) {
            //return error response
            $this->response(array('error' => TRUE, 'error_msg' => 'Mobile number used by another user'), 203);

        } else if ($password != $password_confirm) {
            //return error response
            $this->response(array('error' => TRUE, 'error_msg' => 'Password does not match'), 203);

        } else {
            //digest password
            $digest_password = md5("{$username}:{$this->realm}:{$password}");

            //additional data
            $additional_data = array(
                'first_name' => $this->post('first_name'),
                'last_name' => $this->post('last_name'),
                'phone' => $username,
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
                $response["user"]["last_name"] = $user->last_name;

                //success response
                $this->response($response, 200);
            } else {
                $this->response(array('error' => TRUE, 'error_msg' => 'Failed to create account'), 204);
            }
        }
    }

    //remove 0 on start of mobile
    function cast_mobile($mobile)
    {
        if (preg_match("~^0\d+$~", $mobile)) {
            return substr($mobile, 1);
        } else {
            return $mobile;
        }
    }

    //check existence of mobile
    function check_user_existence($username)
    {
        //count mobile existence
        $this->model->set_table('users');
        $user = $this->model->count_by('username', $username);

        if ($user > 0)
            return TRUE;
        else
            return FALSE;
    }
}