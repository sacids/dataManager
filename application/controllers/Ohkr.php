<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/29/2016
 * Time: 4:17 PM
 */
class Ohkr extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $this->load->model("Ohkr_model");
    }


    public function index()
    {
        $this->disease_list();
    }

    public function disease_list()
    {
        $data['title'] = "Diseases List";
        $data['diseases'] = $this->Ohkr_model->find_all(30, 0);

        //render data
        $this->load->view('header', $data);
        $this->load->view("ohkr/disease_list");
        $this->load->view('footer');
    }

    public function add_new_disease()
    {
        $data['title'] = "Add new";

        $this->form_validation->set_rules("name", $this->lang->line("label_disease_name"), "required");

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/add_new_disease", $data);
            $this->load->view('footer');
        } else {
            $disease = array(
                "name" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "date_created" => date("c")
            );

            if ($this->Ohkr_model->add($disease)) {
                $this->session->set_flashdata("message", $this->lang->line("add_disease_successful"));
            } else {
                $this->session->set_flashdata("message", $this->lang->line("error_failed_to_add_disease"));
            }
            redirect("ohkr/add_new_disease");
        }
    }

    public function edit_disease()
    {

    }

    public function species_list()
    {
        $data['title'] = "Species List";
        $data['species'] = $this->Ohkr_model->find_all_species(30, 0);

        $this->load->view('header', $data);
        //$this->load->view("ohkr/menu");
        $this->load->view("ohkr/species_list", $data);
        $this->load->view('footer');
    }

    public function add_new_specie()
    {
        $data['title'] = "Add new specie";

        $this->form_validation->set_rules("specie", $this->lang->line("label_specie"),
            "required|is_unique[" . $this->config->item("table_species") . ".name]");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/add_new_specie", $data);
            $this->load->view('footer');
        } else {
            $specie = array(
                "name" => $this->input->post("specie"),
                "date_created" => date("c")
            );

            if ($this->Ohkr_model->add_specie($specie)) {
                $this->session->set_flashdata("message", $this->lang->line("add_specie_successful"));
            } else {
                $this->session->set_flashdata("message", $this->lang->line("error_failed_to_add_specie"));
            }
            redirect("ohkr/add_new_specie");
        }
    }


    public function add_new_symptom()
    {
        $data['title'] = "Add new symptoms";

        $this->form_validation->set_rules("name", $this->lang->line("label_symptom_name"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/add_new_symptom", $data);
            $this->load->view('footer');
        } else {
            $symptoms = array(
                "name" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "date_created" => date("c")
            );

            if ($this->Ohkr_model->add_symptom($symptoms)) {
                $this->session->set_flashdata("message", $this->lang->line("add_symptom_successful"));
            } else {
                $this->session->set_flashdata("message", $this->lang->line("error_failed_to_add_symptom"));
            }
            redirect("ohkr/add_new_symptom");
        }
    }

    public function symptoms_list()
    {
        $data['title'] = "Symptoms List";
        $data['symptoms'] = $this->Ohkr_model->find_all_symptoms(30, 0);

        $this->load->view('header', $data);
        //$this->load->view("ohkr/menu");
        $this->load->view("ohkr/symptoms_list");
        $this->load->view('footer');
    }

    public function disease_symptoms($disease_id)
    {
        $data['title'] = "Disease Symptoms";
        $data['disease'] = $this->Ohkr_model->get_disease_by_id($disease_id);
        $data['symptoms'] = $this->Ohkr_model->find_disease_symptoms($disease_id);

        $this->load->view('header', $data);
        //$this->load->view("ohkr/menu");
        $this->load->view("ohkr/disease_symptoms_list");
        $this->load->view('footer');
    }

    public function add_disease_symptom($disease_id)
    {
        $data['title'] = "Add Disease Symptom";
        $data['disease'] = $this->Ohkr_model->get_disease_by_id($disease_id);
        $data['species'] = $this->Ohkr_model->find_all_species(30, 0);
        $data['symptoms'] = $this->Ohkr_model->find_all_symptoms(30, 0);

        $this->form_validation->set_rules("symptom", $this->lang->line("label_symptom_name"), "required");
        $this->form_validation->set_rules("specie", $this->lang->line("label_specie_name"), "required");
        $this->form_validation->set_rules("importance", "Importance", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/add_disease_symptom");
            $this->load->view('footer');
        } else {
            $symptoms = array(
                "symptom_id" => $this->input->post("symptom"),
                "specie_id" => $this->input->post("specie"),
                "disease_id" => $disease_id,
                "importance" => $this->input->post("importance"),
                "date_created" => date("c")
            );

            if ($this->Ohkr_model->add_disease_symptom($symptoms)) {
                $this->session->set_flashdata("message", $this->lang->line("add_symptom_successful"));
            } else {
                $this->session->set_flashdata("message", $this->lang->line("error_failed_to_add_symptom"));
            }
            redirect("ohkr/add_disease_symptom/".$disease_id, "refresh");
        }
    }
}