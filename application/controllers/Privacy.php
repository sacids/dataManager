<?php

/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 6/7/17
 * Time: 10:37 PM
 */
class Privacy extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->data['title'] = 'Privacy policy';

        //render view
        $this->load->view('header', $this->data);
        $this->load->view('auth/privacy_policy');
        $this->load->view('footer');
    }
}