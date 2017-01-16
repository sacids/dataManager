<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BCode extends CI_Controller{


    function __construct(){

        parent::__construct();
        $this->load->model(array('User_model', 'Submission_model', 'Campaign_model', 'Feedback_model'));
        $this->load->library('barcode');
        
        
    }

    function create(){

    }

    function display(){

        //print_r($this->barcode);

        $this->barcode->print = false;
        //echo '<div></div><img src="'.base_url('assets/public').'/jj.png"></div>';
        //return;

        $bc = 'A001';
        for($i = 0; $i < 50; $i++){

            $this->barcode->filepath = FCPATH."assets/public/barcodes/".$bc.".png";
            $this->barcode->render($bc);
            echo    '<div style="width: 440px; margin: 10px; border: 2px solid #000; float: left; padding: 5px;">
                        <div style="height: 65px; border-bottom: 2px solid #000;">&nbsp;</div>
                        <div style="font-size:13px; text-align: center;">Jina Kamili</div>
                        <div style="height: 50px; border-bottom: 2px solid #000;">&nbsp;</div>
                        <div style="font-size:13px; text-align: center;">Namba ya usajili</div>
                        <div style="padding: 5px; "><img style="margin-left: auto; margin-right: auto; display: block;" src="'.base_url('assets/public/barcodes/')."/".$bc.'.png"></div>
                        <div style="font-size:17px; text-align: center;">'.$bc.'</div>
                     </div>';

            $bc++;

        }

    }

}

