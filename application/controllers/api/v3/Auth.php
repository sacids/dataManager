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

    function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model(array('User_model'));
        $this->initial = 255;
    }
}