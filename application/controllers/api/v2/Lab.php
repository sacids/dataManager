<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 3:42 PM
 */
class Lab extends CI_Controller
{
    function __construct(){
        // load model
        parent::__construct();
        $this->load->model(array('User_model', 'Xform_model', 'Perm_model'));
    }

    public function requests(){

        $key    = $this->input->get('k');
        $val    = $this->input->get('v');
        $tbl    = $this->input->get('t');

        $res    = array();

        if(empty($tbl)){
            $tbl    = 'ad_build_Lab_Request_1475596584';
        }
        if(empty($key)){
            $key    = '_xf_lrLt_2231';
        }

        if($data    = $this->Perm_model->get_table_data($tbl,$key,$val)){

            $res['details'] = $data;
            $res['status']  = 'success';
            $res['form_id'] = 'build_Lab_Request_1475596584';

        }else{

            $res['status']  = 'failed';
        }

        echo json_encode($res);

    }



}