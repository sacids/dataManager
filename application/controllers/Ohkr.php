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
        $this->load->model("Perm_model");
        $this->load->library("Db_exp");
    }

    /**
     * Check login
     *
     * @return response
     */
    function _is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }


    public function index()
    {
        $this->disease_list();
    }

    public function disease_list()
    {
        //check login
        $this->_is_logged_in();

        $config = array(
            'base_url' => $this->config->base_url("ohkr/disease_list"),
            'total_rows' => $this->Ohkr_model->count_disease(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['diseases'] = $this->Ohkr_model->find_all_disease($this->pagination->per_page, $page);
        $data["links"] = $this->pagination->create_links();

        //render data
        $data['title'] = "Diseases List";
        $this->load->view('header', $data);
        $this->load->view("ohkr/disease_list");
        $this->load->view('footer');
    }

    public function add_new_disease()
    {
        //check login
        $this->_is_logged_in();

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

            if ($this->Ohkr_model->add_disease($disease)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("add_disease_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_disease")));
            }
            redirect("ohkr/add_new_disease");
        }
    }

    public function edit_disease($disease_id)
    {
        //check login
        $this->_is_logged_in();

        if (!$disease_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_edit")));
            redirect("ohkr/disease_list");
            exit;
        }

        $data['title'] = "Edit Disease";
        $data['disease'] = $this->Ohkr_model->get_disease_by_id($disease_id);

        $this->form_validation->set_rules("name", $this->lang->line("label_disease_name"), "required");

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/edit_disease", $data);
            $this->load->view('footer');
        } else {
            $disease = array(
                "name" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "date_created" => date("c")
            );

            if ($this->Ohkr_model->update_disease($disease_id, $disease)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_disease_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_disease")));
            }
            redirect("ohkr/edit_disease/" . $disease_id, "refresh");
        }

    }

    function delete_disease($disease_id)
    {
        //check login
        $this->_is_logged_in();

        if (!$disease_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_delete")));
            redirect("ohkr/disease_list");
            exit;
        }

        if ($this->Ohkr_model->delete_disease($disease_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_disease_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_disease")));
        }
        redirect("ohkr/disease_list","refresh");
    }

    public function species_list()
    {
        //check login
        $this->_is_logged_in();

        $config = array(
            'base_url' => $this->config->base_url("ohkr/species_list"),
            'total_rows' => $this->Ohkr_model->count_species(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['species'] = $this->Ohkr_model->find_all_species($this->pagination->per_page, $page);
        $data["links"] = $this->pagination->create_links();

        //render view
        $data['title'] = "Species List";
        $this->load->view('header', $data);
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
                $this->session->set_flashdata("message", display_message($this->lang->line("add_specie_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_specie")));
            }
            redirect("ohkr/add_new_specie");
        }
    }

    public function edit_specie($specie_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$specie_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_specie_to_edit")));
            redirect("ohkr/species_list");
            exit;
        }

        $data['title'] = "Edit specie";
        $data['specie'] = $this->Ohkr_model->get_specie_by_id($specie_id);

        $this->form_validation->set_rules("specie", $this->lang->line("label_specie"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/edit_specie");
            $this->load->view('footer');
        } else {
            $specie = array(
                "name" => $this->input->post("specie")
            );

            if ($this->Ohkr_model->update_disease($specie_id,$specie)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_specie_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_specie")));
            }
            redirect("ohkr/edit_specie/".$specie_id);
        }
    }

    function delete_specie($specie_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$specie_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_specie_to_delete")));
            redirect("ohkr/species_list");
            exit;
        }

        if ($this->Ohkr_model->delete_specie($specie_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_specie_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_specie")));
        }
        redirect("ohkr/species_list","refresh");
    }


    public function symptoms_list()
    {
        //check login
        $this->_is_logged_in();

        $config = array(
            'base_url' => $this->config->base_url("ohkr/symptoms_list"),
            'total_rows' => $this->Ohkr_model->count_symptoms(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['symptoms'] = $this->Ohkr_model->find_all_symptoms($this->pagination->per_page, $page);
        $data["links"] = $this->pagination->create_links();

        //render view
        $data['title'] = "Symptoms List";
        $this->load->view('header', $data);
        $this->load->view("ohkr/symptoms_list");
        $this->load->view('footer');
    }

    public function add_new_symptom()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['title'] = "Add new symptom";

        $this->form_validation->set_rules("name", $this->lang->line("label_symptom_name"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            $this->load->view("ohkr/add_new_symptom", $data);
            $this->load->view('footer');
        } else {
            $symptoms = array(
                "name" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "date_created" => date("c")
            );

            if ($this->Ohkr_model->add_symptom($symptoms)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("add_symptom_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_symptom")));
            }
            redirect("ohkr/add_new_symptom");
        }
    }

    public function edit_symptom($symptom_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$symptom_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_symptom_to_edit")));
            redirect("ohkr/symptoms_list");
            exit;
        }

        $data['title'] = "Edit symptom";
        $data['symptom'] = $this->Ohkr_model->get_symptom_by_id($symptom_id);

        $this->form_validation->set_rules("name", $this->lang->line("label_symptom_name"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/edit_symptom", $data);
            $this->load->view('footer');
        } else {
            $symptoms = array(
                "name" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "date_created" => date("c")
            );

            if ($this->Ohkr_model->update_symptom($symptom_id, $symptoms)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_symptom_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_symptom")));
            }
            redirect("ohkr/edit_symptom/".$symptom_id);
        }
    }

    function delete_symptom($symptom_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$symptom_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_symptom_to_delete")));
            redirect("ohkr/symptoms_list");
            exit;
        }

        if ($this->Ohkr_model->delete_symptom($symptom_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_symptom_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_symptom")));
        }
        redirect("ohkr/symptoms_list","refresh");
    }

    public function disease_symptoms($disease_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

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
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$disease_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_add")));
            redirect("ohkr/disease_symptoms/".$disease_id);
            exit;
        }

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
                $this->session->set_flashdata("message", display_message($this->lang->line("add_symptom_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_symptom")));
            }
            redirect("ohkr/disease_symptoms/" . $disease_id, "refresh");
        }
    }

    public function edit_disease_symptom($disease_id, $disease_symptom_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$disease_symptom_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_symptom_to_edit")));
            redirect("ohkr/disease_symptoms/".$disease_id);
            exit;
        }

        $data['title'] = "Edit Disease Symptom";
        $disease_symptom = $this->Ohkr_model->get_disease_symptom_by_id($disease_symptom_id);
        $data['specie'] = $this->Ohkr_model->get_specie_by_id($disease_symptom->specie_id);
        $data['symptom'] = $this->Ohkr_model->get_symptom_by_id($disease_symptom->symptom_id);
        $data['importance'] = $disease_symptom->importance;
        $data['disease_symptom_id'] = $disease_symptom_id;

        $data['disease'] = $this->Ohkr_model->get_disease_by_id($disease_id);
        $data['species'] = $this->Ohkr_model->find_all_species(30, 0);
        $data['symptoms'] = $this->Ohkr_model->find_all_symptoms(30, 0);

        $this->form_validation->set_rules("symptom", $this->lang->line("label_symptom_name"), "required");
        $this->form_validation->set_rules("specie", $this->lang->line("label_specie_name"), "required");
        $this->form_validation->set_rules("importance", "Importance", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            //$this->load->view("ohkr/menu");
            $this->load->view("ohkr/edit_disease_symptom");
            $this->load->view('footer');
        } else {
            $symptoms = array(
                "symptom_id" => $this->input->post("symptom"),
                "specie_id" => $this->input->post("specie"),
                "disease_id" => $disease_id,
                "importance" => $this->input->post("importance")
            );

            if ($this->Ohkr_model->update_disease_symptom($disease_symptom_id, $symptoms)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_symptom_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_symptom")));
            }
            redirect("ohkr/disease_symptoms/" . $disease_id, "refresh");
        }
    }


    function delete_disease_symptom($disease_id, $disease_symptom_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$disease_symptom_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_symptom_to_delete")));
            redirect("ohkr/disease_symptoms/".$disease_id);
            exit;
        }


        if ($this->Ohkr_model->delete_disease_symptom($disease_symptom_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_symptom_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_symptom")));
        }
        redirect("ohkr/disease_symptoms/".$disease_id);
    }
    
    
    public function manage_specie_disease(){
    	
    	$this->save_dbexp_post_vars();
    	
    	$ele_id	= $this->session->userdata['post']['ele_id'];
    	$arr	= $this->Perm_model->get_field_data('specie_id,disease_id', 'diseases_symptoms', $ele_id);
   		
    	$available_symptoms	= $this->get_available_symptoms($arr);
    	
    	$this->db_exp->set_table('diseases_symptoms');
    	$this->db_exp->set_hidden($arr);
    	$this->db_exp->set_hidden('date_created');
    	
    	$action = $this->input->post ( 'action' );
    	if($action == 'insert' || $action == 'edit'){
    		$this->db_exp->set_select('symptom_id', $available_symptoms);
    	$this->db_exp->set_hidden('id');
    	}else{
    		$this->db_exp->set_db_select('symptom_id', 'symptoms', 'id', 'name');
    	}
    	$this->db_exp->render('row_list'); 	
    	
    }
    
    private function get_available_symptoms($arr){
    	
    	$s_arr	= array();
    	$submitted_symptoms	= $this->Ohkr_model->get_submitted_symptoms($arr);
    	foreach($submitted_symptoms as $val){
    		
    		$id		= $val['symptom_id'];
    		$s_arr[$id]	= '';
    	}
	
    	$a_arr	= array();
    	$available_symptoms	= $this->Ohkr_model->get_all_symptoms();
    	foreach($available_symptoms as $val){

    		if($val['id'] == 0) continue;
    		
    		$id		= $val['id'];
    		$name	= $val['name'];
    		$a_arr[$id]	= $name;
    	}
    	
    	$tmp	= array_diff_key($a_arr, $s_arr);
    	//print_r($tmp);
    	return $tmp;
    }
    
    public function save_dbexp_post_vars() {
    	$post = $this->input->post ();
    	$db_exp_submit = $this->input->post ( 'db_exp_submit_engaged' );
    	if (! empty ( $db_exp_submit ) || @$post ['action'] == 'insert' || @$post ['action'] == 'edit') {
    	} else {
    		$this->session->set_userdata ( 'post', $post );
    	}
    }
    
}