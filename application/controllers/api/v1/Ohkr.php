<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/21/2016
 * Time: 11:11 AM
 */
class Ohkr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("Ohkr_model");
    }



    function get_diseases()
    {
        $diseases = $this->Ohkr_model->find_all_disease();

        if ($diseases) {
            $response = array("disease" => $diseases, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "No disease found");
        }
        echo json_encode($response);
    }



    function get_symptoms()
    {
        $symptoms = $this->Ohkr_model->find_all_symptoms();

        if ($symptoms) {
            $response = array("symptom" => $symptoms, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "No symptom found");
        }
        echo json_encode($response);
    }

}