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
            $this->response(array('disease' => $diseases, 'status' => 'success'), 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No disease found'), 204);
        }
    }


    function symptom_get()
    {
        $symptoms = $this->Ohkr_model->find_all_symptoms();

        if ($symptoms) {
            $this->response(array('symptom' => $symptoms, 'status' => 'success'), 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No symptom found'), 204);
        }

    }

}