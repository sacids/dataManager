<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 12/8/2016
 * Time: 12:44 PM
 */
class Search extends REST_Controller
{
    function __construct()
    {
        // load model
        parent::__construct();
        $this->load->model(array('model', 'Xform_model', 'Perm_model'));
        $this->load->library(array('Xform_comm'));
    }

    
}