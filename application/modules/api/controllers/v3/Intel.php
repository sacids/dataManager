<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 6/20/17
 * Time: 2:56 PM
 */
require(APPPATH.'libraries/REST_Controller.php');

class Intel extends REST_Controller{

    public $resp    = array();

    public function __construct(){
        parent::__construct();

        $this->resp     = array();
    }

    public function set_epi_map_get(){

        $this->model->set_table('ohkr_disease_symptoms');

        $query  = $this->db->query('SELECT specie_id, disease_id, SUM(importance) as imp FROM `ohkr_disease_symptoms` group by specie_id, disease_id');
        $epi_map    = array();
        foreach ($query->result() as $row) {
            $epi_map[$row->specie_id][$row->disease_id]    = $row->imp;
        }

        $epi_map_json   = json_encode($epi_map);
        write_file(FCPATH.'assets/Intel/epi_map.json',$epi_map_json);

        $query  = "SELECT id, title FROM ohkr_diseases";
        $sql    = $this->db->query($query);
        $disease_map    = array();
        foreach($sql->result() as $row){
            $disease_map[$row->id]  = $row->title;
        }

        $disease_map_json   = json_encode($disease_map);
        write_file(FCPATH.'assets/Intel/disease_map.json',$disease_map_json);

    }


    public function disease_post(){


        $stream     = $this->input->raw_input_stream;
        $req        = json_decode($stream,true);
        log_message('DEBUG','Epi Intel: Received request '.$stream);

        $epi_map_json   = file_get_contents(FCPATH.'assets/Intel/epi_map.json');
        $epi_map        = json_decode($epi_map_json,true);

        // check if well formated json all fields are included
        if(array_key_exists('specie_id',$req)){
            $specie_id  = $req['specie_id'];
            $diseases   = array_keys($epi_map[$specie_id]);
            $diseases   = "('" . implode("','",$diseases) . "')";
        }else{
            $this->resp['status']   = '0';
            $this->resp['data']     = 'Specie ID not specified';

            echo json_encode($this->resp);
            return;
        }

        if(array_key_exists('symptoms',$req)){
            $code   = $req['symptoms'];
            $code   = str_replace(",","','",$code);
            $code   = "('" . $code . "')";

            $query      = "SELECT id FROM ohkr_symptoms WHERE code IN $code";
            $sql        = $this->db->query($query);
            $symptoms   = array();
            foreach($sql->result() as $row){
                array_push($symptoms,$row->id);
            }

            $symptoms   = "('" . implode("','",$symptoms) . "')";


        }else{
            $this->resp['status']   = '0';
            $this->resp['data']     = 'Symptoms not specified';

            echo json_encode($this->resp);
            return;
        }

        $query  = "SELECT disease_id, sum(importance) as imp FROM ohkr_disease_symptoms WHERE symptom_id IN $symptoms AND disease_id IN $diseases GROUP BY disease_id ORDER BY imp DESC";
        $sql     = $this->db->query($query);

        //echo $query;

        $disease_map_json   = file_get_contents(FCPATH.'assets/Intel/disease_map.json');
        $disease_map        = json_decode($disease_map_json,true);

        $score    = array();

        if($sql->num_rows() == 0){
            $this->resp['status']   = '0';
            $this->resp['data']     = 'No match found';

            echo json_encode($this->resp);
            return;
        }

        foreach ($sql->result() as $row) {

            $sc  = $row->imp/$epi_map[$specie_id][$row->disease_id]*100;
            $sc  = number_format((float)$sc,2, '.', '');

            $tmp    = array();
            $tmp['title']       = $disease_map[$row->disease_id];
            $tmp['score']       = $sc; // need to do error checking

            array_push($score,$tmp);

        }

        $this->resp['status']   = '1';
        $this->resp['data']     = $score;

        echo json_encode($this->resp);
    }
}