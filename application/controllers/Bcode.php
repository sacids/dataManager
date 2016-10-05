<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BCode extends CI_Controller{


    function __construct(){

        parent::__construct();
        $this->load->model(array('User_model', 'Submission_model', 'Campaign_model', 'Feedback_model'));
        $this->load->library('Barcode');
        
        
    }

    function display(){

        print_r($this->Barcode);
        echo $this->barcode->render("JAMBO");
        return;

        for($i = 100000; $i < 100050; $i++){
            
            echo $this->barcode->render("JAMBO");

        }

    }

}

