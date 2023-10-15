<?php defined('BASEPATH') or exit('No direct script access allowed');

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
    private $imageUrl;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model");

        $this->imageUrl = base_url() . 'assets/forms/data/images/';
    }

    //list all disease
    function disease_get()
    {
        $this->model->set_table('ohkr_diseases');
        $diseases = $this->model->get_all();

        if ($diseases) {
            $arr_disease = [];
            foreach ($diseases as $value) {
                $arr_disease[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'species' => $value->species,
                    'photo' => $this->imageUrl . $value->photo,
                    'description' => $value->description
                );
            }

            $this->response(array('status' => 'success', 'disease' => $arr_disease), 200);
        } else {
            $this->response(array('status' => 'failed', 'message' => 'Nenhuma doença encontrada'), 202);
        }
    }

    //list all symptoms
    function symptoms_get()
    {
        $this->model->set_table('ohkr_symptoms');
        $symptoms = $this->model->get_all();

        if ($symptoms) {
            $arr_symptoms = [];
            foreach ($symptoms as $value) {
                $arr_symptoms[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'code' => $value->code,
                    'photo' => $this->imageUrl . $value->photo,
                    'description' => $value->description
                );
            }

            $this->response(array('status' => 'success', 'symptom' => $arr_symptoms), 200);
        } else {
            $this->response(array('status' => 'failed', 'message' => 'Nenhum sintoma encontrado'), 204);
        }
    }
}
