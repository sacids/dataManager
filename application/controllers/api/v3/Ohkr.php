<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 12/8/2016
 * Time: 12:40 PM
 */
class Ohkr extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ohkr_model");
    }


    function disease_get()
    {
        $diseases = $this->Ohkr_model->find_all_disease();

        if ($diseases) {
            $response = array("disease" => $diseases, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "No disease found");
        }
        $this->response($response, 200);
    }


    function symptom_get()
    {
        $symptoms = $this->Ohkr_model->find_all_symptoms();

        if ($symptoms) {
            $response = array("symptom" => $symptoms, "status" => "success");

        } else {
            $response = array("status" => "failed", "message" => "No symptom found");
        }
        $this->response($response, 200);
    }

}