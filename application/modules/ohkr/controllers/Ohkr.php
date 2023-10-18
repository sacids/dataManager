<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/29/2016
 * Time: 4:17 PM
 */
class Ohkr extends MX_Controller
{
    private $data;
    private $controller;

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('ion_auth', 'form_validation', 'user_agent', 'upload'));
        $this->load->model(array("Ohkr_model", "Perm_model", "User_model", "Disease_model", "Symptom_model", "Specie_model"));
        log_message('debug', 'Ohkr controller initialized');
        //$this->load->library("Db_exp");
        $this->controller = "Ohkr";

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }


    /**
     * @param $method_name
     * Check if user has permission
     */
    function has_allowed_perm($method_name)
    {
        if (!perms_role($this->controller, $method_name)) {
            show_error("You are not allowed to view this page", 401, "Unauthorized");
        }
    }


    public function index()
    {
        $this->disease_list();
    }

    /*==============================================
    Maladies
    ==============================================*/
    //lists
    function disease_list()
    {
        $this->data['title'] = "Maladies";
        $this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url' => $this->config->base_url("ohkr/diseases/"),
            'total_rows' => $this->Disease_model->count_all(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['diseases'] = $this->Disease_model->get_all($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        foreach ($this->data['diseases'] as $k => $v) {
            $species = explode(',', $v->species);

            $arr_species = [];
            foreach ($species as $val) {
                $specie = $this->Specie_model->get_by(['id' => $val]);
                if ($specie)
                    $arr_species[] = $specie->title;
            }
            $this->data['diseases'][$k]->species = join(', ', $arr_species);
        }

        //links
        $this->data['page_links'] = [
            'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("ohkr/diseases/lists");
        $this->load->view('footer');
    }

    //add new disease
    public function add_new_disease()
    {
        $data['title'] = "Add new";
        $this->has_allowed_perm($this->router->fetch_method());

        //populate data
        $data['species'] = $this->Specie_model->get_all(100, 0);
        $data['groups'] = $this->User_model->find_user_groups();

        //validation
        $this->form_validation->set_rules("name", $this->lang->line("label_disease_name"), "required");
        $this->form_validation->set_rules("species[]", $this->lang->line("label_specie_name"), "trim");
        $this->form_validation->set_rules("photo", "Photo", "callback_upload_photo");
        $this->form_validation->set_rules("description", $this->lang->line("label_description"), "required");

        //validation == false
        if ($this->form_validation->run($this) === FALSE) {
            //links
            $data['links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptômes', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            //render view
            $this->load->view('header', $data);
            $this->load->view("ohkr/diseases/add_new", $data);
            $this->load->view('footer');
        } else {
            //species
            $arr_species = [];
            if (isset($_POST['species'])) {
                $species = $_POST['species'];

                if ($species) {
                    foreach ($species as $val) {
                        array_push($arr_species, $val);
                    }
                }
            }

            //check for photo
            if (isset($_POST['photo']) && $_POST['photo'] != null)
                $photo = $_POST['photo'];

            //data array
            $data = array(
                "title" => $this->input->post("name"),
                "species" => join(',', $arr_species),
                "description" => $this->input->post("description"),
                "photo" => $photo
            );

            //create disease
            $disease_id = $this->Disease_model->insert($data);

            if ($disease_id) {
                file_get_contents(base_url("api/v3/intel/set_epi_map"));
                $this->session->set_flashdata("message", display_message($this->lang->line("add_disease_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_disease")));
            }
            redirect("ohkr/diseases");
        }
    }

    /**
     * edit disease
     *
     * @param $disease_id
     */
    public function edit_disease($id)
    {
        $data['title'] = "Edit Disease";
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_edit")));
            redirect("ohkr/diseases");
            exit;
        }

        //disease
        $disease = $this->Disease_model->get($id);

        if (!$disease)
            show_error("Maladie non trouvée", 404);

        $data['disease'] = $disease;

        //populate data
        $data['species'] = $this->Specie_model->get_all(100, 0);
        $data['messages'] = $this->Ohkr_model->find_response_sms_by_disease_id($id);

        //validation
        $this->form_validation->set_rules("name", $this->lang->line("label_disease_name"), "required");
        $this->form_validation->set_rules("species[]", $this->lang->line("label_specie_name"), "trim");
        $this->form_validation->set_rules("photo", "Photo", "callback_upload_photo");
        $this->form_validation->set_rules("description", $this->lang->line("label_description"), "required");

        //validation == false
        if ($this->form_validation->run($this) === FALSE) {
            //species
            $species = explode(',', $disease->species);

            $arr_species = [];
            if ($species) {
                foreach ($species as $specie_id) {
                    array_push($arr_species, $specie_id);
                }
            }
            $data['assigned_species'] = $arr_species;

            //links
            $data['links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptômes', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            //render view
            $this->load->view('header', $data);
            $this->load->view("ohkr/diseases/edit", $data);
            $this->load->view('footer');
        } else {
            //species
            $arr_species = [];
            if (isset($_POST['species'])) {
                $species = $_POST['species'];

                if ($species) {
                    foreach ($species as $val) {
                        array_push($arr_species, $val);
                    }
                }
            }

            //check for photo
            $photo = $disease->photo;
            if (isset($_POST['photo']) && $_POST['photo'] != null)
                $photo = $_POST['photo'];


            //data array
            $data = array(
                "title" => $this->input->post("name"),
                "species" => join(',', $arr_species),
                "description" => $this->input->post("description"),
                "photo" => $photo
            );

            if ($this->Disease_model->update($data, $id)) {
                file_get_contents(base_url("api/v3/intel/set_epi_map"));
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_disease_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_disease")));
            }
            redirect("ohkr/diseases/edit/" . $id, "refresh");
        }
    }

    /**
     * @param $disease_id
     */
    function delete_disease($id)
    {
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_delete")));
            redirect("ohkr/disease_list");
            exit;
        }

        //disease
        $disease = $this->Disease_model->get($id);

        if (!$disease)
            show_error("Maladie non trouvée", 404);

        //delete
        if ($this->Disease_model->delete($id)) {
            file_get_contents(base_url("api/v3/intel/set_epi_map"));
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_disease_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_disease")));
        }
        redirect("ohkr/diseases", "refresh");
    }

    /*==============================================
    Specie
    ==============================================*/
    public function species_list()
    {
        $data['title'] = "Espèces";
        $this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url' => $this->config->base_url("ohkr/species/"),
            'total_rows' => $this->Specie_model->count_all(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['species'] = $this->Specie_model->get_all($this->pagination->per_page, $page);
        $data["links"] = $this->pagination->create_links();


        //links
        $data['page_links'] = [
            'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $data);
        $this->load->view("ohkr/species/lists", $data);
        $this->load->view('footer');
    }

    //add new
    public function add_new_specie()
    {
        $data['title'] = "Add new specie";
        $this->has_allowed_perm($this->router->fetch_method());

        //validation
        $this->form_validation->set_rules(
            "specie",
            $this->lang->line("label_specie"),
            "required|is_unique[" . $this->config->item("table_species") . ".title]"
        );

        //validation = false
        if ($this->form_validation->run() === FALSE) {
            //links
            $data['page_links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            //render view
            $this->load->view('header', $data);
            $this->load->view("ohkr/species/add_new", $data);
            $this->load->view('footer');
        } else {
            $data = array(
                "title" => $this->input->post("specie")
            );

            if ($this->Specie_model->insert($data)) {
                file_get_contents(base_url("api/v3/intel/set_epi_map"));
                $this->session->set_flashdata("message", display_message($this->lang->line("add_specie_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_specie")));
            }
            redirect("ohkr/species");
        }
    }

    //edit
    public function edit_specie($specie_id)
    {
        $data['title'] = "Edit specie";
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$specie_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_specie_to_edit")));
            redirect("ohkr/species");
            exit;
        }

        $specie = $this->Specie_model->get($specie_id);

        if (!$specie)
            show_error("Specie not found", 404);

        $data['specie'] = $specie;

        //validation
        $this->form_validation->set_rules("specie", $this->lang->line("label_specie"), "required");

        //validattion == false
        if ($this->form_validation->run() === FALSE) {
            //links
            $data['page_links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            //render view
            $this->load->view('header', $data);
            $this->load->view("ohkr/species/edit");
            $this->load->view('footer');
        } else {
            $data = array(
                "title" => $this->input->post("specie")
            );

            if ($this->Specie_model->update($data, $specie_id)) {
                file_get_contents(base_url("api/v3/intel/set_epi_map"));
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_specie_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_specie")));
            }
            redirect(uri_string());
        }
    }

    //delete species
    function delete_specie($specie_id)
    {
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$specie_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_specie_to_delete")));
            redirect("ohkr/species");
            exit;
        }

        //specie
        $specie = $this->Specie_model->get($specie_id);

        if (!$specie)
            show_error("Specie not found", 404);

        if ($this->Specie_model->delete($specie_id)) {
            file_get_contents(base_url("api/v3/intel/set_epi_map"));
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_specie_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_specie")));
        }
        redirect("ohkr/species", "refresh");
    }


    /*==============================================
    Symptoms
    ==============================================*/
    //lists
    public function symptoms_list()
    {
        $data['title'] = "Symptomes";
        $this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url' => $this->config->base_url("ohkr/symptoms/"),
            'total_rows' => $this->Symptom_model->count_all(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['symptoms'] = $this->Symptom_model->get_all($this->pagination->per_page, $page);
        $data["links"] = $this->pagination->create_links();

        //links
        $data['page_links'] = [
            'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'symptoms' => anchor('ohkr/symptoms', 'Symptomes', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $data);
        $this->load->view("ohkr/symptoms/lists");
        $this->load->view('footer');
    }

    //add new symptom
    function add_new_symptom()
    {
        $data['title'] = "Ajout de symptomes";
        $this->has_allowed_perm($this->router->fetch_method());

        //validation
        $this->form_validation->set_rules("name", $this->lang->line("label_symptom_name"), "required");
        $this->form_validation->set_rules("code", $this->lang->line("label_symptom_code"), "required|is_unique[ohkr_symptoms.code]");
        $this->form_validation->set_rules("photo", "Photo", "callback_upload_photo");

        //validation == false
        if ($this->form_validation->run($this) === FALSE) {
            //links
            $data['links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptômes', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            //render view
            $this->load->view('header', $data);
            $this->load->view("ohkr/symptoms/add_new", $data);
            $this->load->view('footer');
        } else {
            //check for photo
            if (isset($_POST['photo']) && $_POST['photo'] != null)
                $photo = $_POST['photo'];

            $data = array(
                "title" => $this->input->post("name"),
                "code" => $this->input->post("code"),
                "photo" => $photo,
                "description" => $this->input->post("description")
            );

            if ($this->Symptom_model->insert($data)) {
                file_get_contents(base_url("api/v3/intel/set_epi_map"));
                $this->session->set_flashdata("message", display_message($this->lang->line("add_symptom_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_symptom")));
            }
            redirect("ohkr/symptoms");
        }
    }

    /*edit symptom
     * @param $symptom_id
     */
    public function edit_symptom($symptom_id)
    {
        $data['title'] = "Modification de symptome";
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$symptom_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_symptom_to_edit")));
            redirect("ohkr/symptoms");
            exit;
        }

        //symptom
        $symptom = $this->Symptom_model->get($symptom_id);

        if (!$symptom)
            show_error("Symptome non trouvé", 404);

        $data['symptom'] = $symptom;

        //validation
        $this->form_validation->set_rules("name", $this->lang->line("label_symptom_name"), "required");
        $this->form_validation->set_rules("code", $this->lang->line("label_symptom_code"), "required");
        $this->form_validation->set_rules("photo", "Photo", "callback_upload_photo");

        //validation == false
        if ($this->form_validation->run($this) === FALSE) {
            //links
            $data['links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptômes', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            //render view
            $this->load->view('header', $data);
            $this->load->view("ohkr/symptoms/edit", $data);
            $this->load->view('footer');
        } else {
            //check for photo
            $photo = $symptom->photo;
            if (isset($_POST['photo']) && $_POST['photo'] != null)
                $photo = $_POST['photo'];

            //data    
            $data = array(
                "title" => $this->input->post("name"),
                "code" => $this->input->post("code"),
                "photo" => $photo,
                "description" => $this->input->post("description")
            );

            if ($this->Symptom_model->update($data, $symptom_id)) {
                file_get_contents(base_url("api/v3/intel/set_epi_map"));
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_symptom_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_symptom")));
            }
            redirect("ohkr/symptoms");
        }
    }

    //delete
    function delete_symptom($symptom_id)
    {
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$symptom_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_symptom_to_delete")));
            redirect("ohkr/symptoms_list");
            exit;
        }

        //symptom
        $symptom = $this->Symptom_model->get($symptom_id);

        if (!$symptom)
            show_error("Symptome non trouvé", 404);

        if ($this->Symptom_model->delete($symptom_id)) {
            file_get_contents(base_url("api/v3/intel/set_epi_map"));
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_symptom_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_symptom")));
        }
        redirect("ohkr/symptoms", "refresh");
    }


    /*==============================================
    Disease Symptoms
    ==============================================*/
    //disease symptoms
    public function disease_symptoms_list($disease_id)
    {
        $data['title'] = "";
        $this->has_allowed_perm($this->router->fetch_method());

        //disease
        $disease = $this->Disease_model->get($disease_id);

        if (!$disease)
            show_error("Maladie non trouvée", 500);

        $data['disease'] = $disease;

        //save disease symptoms
        if (isset($_POST['save'])) {
            //form validation
            $this->form_validation->set_rules("symptom_id", $this->lang->line("label_symptom_name"), "required");
            $this->form_validation->set_rules("specie_id[]", "Specie", "required");
            $this->form_validation->set_rules("importance", "Importance", "required");

            if ($this->form_validation->run() === TRUE) {
                //iterate specie
                foreach ($this->input->post('specie_id') as $specie_id) {
                    log_message("debug", "specie => " . $specie_id);
                    log_message("debug", "symptom => " . $this->input->post("symptom_id"));

                    //check existence of symptom for specie
                    $this->model->set_table('ohkr_disease_symptoms');
                    $sp = $this->model->get_by(['disease_id' => $disease_id, 'specie_id' => $specie_id, 'symptom_id' => $this->input->post("symptom_id")]);
                    log_message("debug", json_encode($sp));

                    if (!$sp) {
                        $id = $this->model->insert(
                            [
                                "disease_id" => $disease_id,
                                "specie_id" => $specie_id,
                                "symptom_id" => $this->input->post("symptom_id"),
                                "importance" => $this->input->post("importance")
                            ]
                        );

                        if ($id)
                            file_get_contents(base_url("api/v3/intel/set_epi_map"));
                    }
                }

                $this->session->set_flashdata("message", display_message($this->lang->line("add_symptom_successful")));
                redirect("ohkr/disease_symptoms/" . $disease_id, "refresh");
            }
        }
        //populate data
        $data['importance'] = array(
            'name' => 'importance',
            'id' => 'importance',
            'type' => 'text',
            'value' => $this->form_validation->set_value('importance'),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'placeholder' => 'Write  system importance...',
            'required' => ''
        );

        //symptoms
        $data['symptoms'] = $this->Symptom_model->get_all(1000, 0);

        //species
        $data['species'] = $this->Specie_model->get_all(1000, 0);

        //disease symptoms
        $this->model->set_table('ohkr_disease_symptoms');
        $diseases_symptoms = $this->model->get_many_by(['disease_id' => $disease_id]);
        $data['diseases_symptoms'] = $diseases_symptoms;

        foreach ($data['diseases_symptoms'] as $k => $v) {
            $data['diseases_symptoms'][$k]->disease = $this->Disease_model->get($v->disease_id);
            $data['diseases_symptoms'][$k]->symptom = $this->Symptom_model->get($v->symptom_id);
            $data['diseases_symptoms'][$k]->specie = $this->Specie_model->get($v->specie_id);
        }

        //links
        $data['page_links'] = [
            'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $data);
        $this->load->view("ohkr/disease_symptoms/lists");
        $this->load->view('footer');
    }


    //edit disease symptom
    public function edit_disease_symptom($disease_id, $disease_symptom_id)
    {
        $data['title'] = "Modifier les symptômes de la maladie";
        $this->has_allowed_perm($this->router->fetch_method());

        $disease = $this->Disease_model->get($disease_id);
        if (!$disease)
            show_error("Maladie non trouvée", 500);

        $data['disease'] = $disease;

        //disease symptoms
        $this->model->set_table('ohkr_disease_symptoms');
        $disease_symptom = $this->model->get($disease_symptom_id);

        if (!$disease_symptom)
            show_error("Symptôme de la maladie non trouvé", 500);

        $data['disease_symptom'] = $disease_symptom;

        //symptoms
        $data['symptoms'] = $this->Symptom_model->get_all(1000, 0);

        //species
        $data['species'] = $this->Specie_model->get_all(1000, 0);

        //assigned species
        $assigned_species = [];

        //form validation
        $this->form_validation->set_rules("symptom_id", $this->lang->line("label_symptom_name"), "required");
        $this->form_validation->set_rules("importance", "Importance", "required");

        if ($this->form_validation->run() === TRUE) {
            $symptoms = array(
                "symptom_id" => $this->input->post("symptom_id"),
                "disease_id" => $disease_id,
                "importance" => $this->input->post("importance")
            );

            if ($this->Ohkr_model->update_disease_symptom($disease_symptom_id, $symptoms)) {
                file_get_contents(base_url("api/v3/intel/set_epi_map"));
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_symptom_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_symptom")));
            }
            redirect("ohkr/disease_symptoms/" . $disease_id, "refresh");
        }

        //populate data
        $data['importance'] = array(
            'name' => 'importance',
            'id' => 'importance',
            'type' => 'text',
            'value' => $this->form_validation->set_value('importance', $disease_symptom->importance),
            'class' => 'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
            'placeholder' => 'Write  system importance...'
        );

        //links
        $data['page_links'] = [
            'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view('header', $data);
        $this->load->view("ohkr/disease_symptoms/edit");
        $this->load->view('footer');
    }

    //delete disease symptoms
    function delete_disease_symptom($disease_id, $disease_symptom_id)
    {
        $data['title'] = "Supprimer le symptôme de la maladie";
        $this->has_allowed_perm($this->router->fetch_method());

        $disease = $this->Disease_model->get($disease_id);
        if (!$disease)
            show_error("Maladie non trouvée", 500);

        $data['disease'] = $disease;

        //delete
        if ($this->Ohkr_model->delete_disease_symptom($disease_symptom_id)) {
            file_get_contents(base_url("api/v3/intel/set_epi_map"));
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_symptom_successful"), 'danger'));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_symptom")));
        }
        redirect("ohkr/disease_symptoms_list/" . $disease_id);
    }


    //disease symptoms
    public function disease_faq($disease_id)
    {
        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $data['title'] = "FAQ sur les maladies";
        $data['disease'] = $this->Ohkr_model->get_disease_by_id($disease_id);
        $data['faq'] = $this->Ohkr_model->find_disease_faq($disease_id);

        $this->load->view('header', $data);
        $this->load->view("ohkr/disease_faq");
        $this->load->view('footer');
    }


    public function add_disease_faq($disease_id)
    {
        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$disease_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_add")));
            redirect("ohkr/disease_faq/" . $disease_id);
            exit;
        }

        $data['title'] = "Ajouter des FAQ sur les maladies";
        $data['disease'] = $this->Ohkr_model->get_disease_by_id($disease_id);

        $this->form_validation->set_rules("question", $this->lang->line("label_question"), "required");
        $this->form_validation->set_rules("answer", $this->lang->line("label_answer"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            $this->load->view("ohkr/add_disease_faq");
            $this->load->view('footer');
        } else {
            $faq = array(
                "disease_id" => $disease_id,
                "question" => $this->input->post("question"),
                "answer" => $this->input->post("answer")
            );

            if ($this->Ohkr_model->add_disease_faq($faq)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("add_faq_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_add_faq")));
            }
            redirect("ohkr/disease_faq/" . $disease_id, "refresh");
        }
    }


    public function edit_disease_faq($disease_id, $faq_id)
    {
        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$faq_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_faq_to_edit")));
            redirect("ohkr/disease_faq/" . $disease_id);
            exit;
        }

        $data['title'] = "Edit Disease Faq";
        $data['disease'] = $this->Ohkr_model->get_disease_by_id($disease_id);

        $data['faq'] = $this->Ohkr_model->get_disease_faq_by_id($faq_id);

        //form validation
        $this->form_validation->set_rules("question", $this->lang->line("label_question"), "required");
        $this->form_validation->set_rules("answer", $this->lang->line("label_answer"), "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $data);
            $this->load->view("ohkr/edit_disease_faq");
            $this->load->view('footer');
        } else {
            $faq = array(
                "question" => $this->input->post("question"),
                "answer" => $this->input->post("answer")
            );

            if ($this->Ohkr_model->update_disease_faq($faq_id, $faq)) {
                $this->session->set_flashdata("message", display_message($this->lang->line("edit_faq_successful")));
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_edit_faq")));
            }
            redirect("ohkr/disease_faq/" . $disease_id, "refresh");
        }
    }


    function delete_disease_faq($disease_id, $faq_id)
    {
        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        if (!$faq_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_faq_to_delete")));
            redirect("ohkr/disease_faq/" . $disease_id);
            exit;
        }


        if ($this->Ohkr_model->delete_disease_faq($faq_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("delete_faq_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_faq")));
        }
        redirect("ohkr/disease_faq/" . $disease_id);
    }


    public function manage_specie_disease()
    {
        $this->save_dbexp_post_vars();

        $ele_id = $this->session->userdata['post']['ele_id'];
        $arr = $this->Perm_model->get_field_data('specie_id,disease_id', 'diseases_symptoms', $ele_id);

        $cond = " specie_id = '" . $arr['specie_id'] . "' AND disease_id = '" . $arr['disease_id'] . "'";

        $available_symptoms = $this->get_available_symptoms($arr);

        $this->db_exp->set_table('diseases_symptoms');
        $this->db_exp->set_hidden($arr);
        $this->db_exp->set_hidden('date_created');
        $this->db_exp->set_search_condition($cond);

        $action = $this->input->post('action');
        if ($action == 'insert' || $action == 'edit') {
            $this->db_exp->set_select('symptom_id', $available_symptoms);
            $this->db_exp->set_hidden('id');
        } else {
            $this->db_exp->set_db_select('symptom_id', 'symptoms', 'id', 'name');
        }
        $this->db_exp->render('row_list');
    }

    private function get_available_symptoms($arr)
    {

        $s_arr = array();
        $submitted_symptoms = $this->Ohkr_model->get_submitted_symptoms($arr);
        foreach ($submitted_symptoms as $val) {

            $id = $val['symptom_id'];
            $s_arr[$id] = '';
        }

        $a_arr = array();
        $available_symptoms = $this->Ohkr_model->get_all_symptoms();
        foreach ($available_symptoms as $val) {

            if ($val['id'] == 0) continue;

            $id = $val['id'];
            $name = $val['name'];
            $a_arr[$id] = $name;
        }

        $tmp = array_diff_key($a_arr, $s_arr);
        //print_r($tmp);
        return $tmp;
    }

    public function save_dbexp_post_vars()
    {
        $post = $this->input->post();
        $db_exp_submit = $this->input->post('db_exp_submit_engaged');
        if (!empty($db_exp_submit) || @$post['action'] == 'insert' || @$post['action'] == 'edit') {
        } else {
            $this->session->set_userdata('post', $post);
        }
    }



    //add response message
    public function add_new_response_sms($disease_id)
    {
        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        if (!$disease_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_edit")));
            redirect("ohkr/disease_list");
            exit;
        }

        //disease
        $disease = $this->Disease_model->get($disease_id);

        if (!$disease)
            show_error("Maladie non trouvée", 500);

        $data['disease'] = $disease;

        $data['title'] = "Ajouter un nouveau SMS d'alerte de maladie";
        $data['disease_id'] = $disease_id;

        $data['groups'] = $this->User_model->find_user_groups();

        $this->form_validation->set_rules("group", $this->lang->line("label_recipient_group"), "required");
        $this->form_validation->set_rules("message", $this->lang->line("label_alert_message"), "required");
        $this->form_validation->set_rules("status", $this->lang->line("label_status"), "required");

        if ($this->form_validation->run() === FALSE) {
            //disease symptoms
            $this->model->set_table('ohkr_response_sms');
            $diseases_responses = $this->model->get_many_by(['disease_id' => $disease_id]);
            $data['diseases_responses'] = $diseases_responses;

            foreach ($data['diseases_responses'] as $k => $v) {
                $data['diseases_responses'][$k]->group = $this->Group_model->get_by(['id' => $v->group_id]);
            }

            //links
            $data['page_links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            $this->load->view('header', $data);
            $this->load->view("ohkr/response_sms/add", $data);
            $this->load->view('footer');
        } else {
            $message = array(
                "disease_id" => $disease_id,
                "group_id" => $this->input->post("group"),
                "message" => $this->input->post("message"),
                "type" => "TEXT",
                "status" => "Enabled",
                "date_created" => date("Y-m-d H:i:s")
            );

            if ($this->Ohkr_model->create_response_sms($message)) {
                $this->session->set_flashdata("message", display_message("Alert SMS was successfully created"));
            } else {
                $this->session->set_flashdata("message", display_message("warning", "Failed to add new alert SMS"));
            }
            redirect("ohkr/add_new_response_sms/" . $disease_id);
        }
    }

    //Edit response message
    public function edit_response_sms($sms_id)
    {
        //check permission
        // $this->has_allowed_perm($this->router->fetch_method());

        if (!$sms_id) {
            $this->session->set_flashdata("message", display_message($this->lang->line("select_disease_to_edit")));
            redirect("ohkr/disease_list");
            exit;
        }

        $data['title'] = "Modifier la réponse SMS de la maladie";
        $data['message'] = $this->Ohkr_model->find_response_sms_by_id($sms_id);
        $data['groups'] = $this->User_model->find_user_groups();

        $this->form_validation->set_rules("group", $this->lang->line("label_recipient_group"), "required");
        $this->form_validation->set_rules("message", $this->lang->line("label_alert_message"), "required");

        if ($this->form_validation->run() === FALSE) {
            //links
            $data['page_links'] = [
                'diseases' => anchor('ohkr/diseases', 'Maladies', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'symptoms' => anchor('ohkr/symptoms', 'Symptoms', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
                'species' => anchor('ohkr/species', 'Espèces', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            ];

            $this->load->view('header', $data);
            $this->load->view("ohkr/response_sms/edit", $data);
            $this->load->view('footer');
        } else {
            $message = array(
                "group_id" => $this->input->post("group"),
                "message" => $this->input->post("message"),
                "status" => "Enabled",
                "date_modified" => date("Y-m-d H:i:s")
            );

            if ($this->Ohkr_model->update_response_sms($sms_id, $message)) {
                $this->session->set_flashdata("message", display_message("Alert SMS was successfully updated"));
            } else {
                $this->session->set_flashdata("message", display_message("warning", "Failed to update alert SMS"));
            }
            redirect("ohkr/edit_response_sms/" . $sms_id);
        }
    }

    public function delete_response_sms($sms_id)
    {
        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        $message = $this->Ohkr_model->find_response_sms_by_id($sms_id);

        if ($this->Ohkr_model->delete_response_sms($sms_id)) {
            $this->session->set_flashdata("message", display_message("Alert SMS was successfully deleted"));
        } else {
            $this->session->set_flashdata("message", display_message("warning", "Failed to delete alert SMS"));
        }
        redirect("ohkr/add_new_response_sms/" . $message->disease_id);
    }

    /*==============================================
    Callback function
    ==============================================*/
    function upload_photo()
    {
        $config['upload_path'] = './assets/forms/data/images/';
        $config['allowed_types'] = 'png|jpg|jpeg|gif';
        $config['max_size'] = '4000';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
            if ($this->upload->do_upload('photo')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $_POST['photo'] = $upload_data['file_name'];

                //Image Resizing
                $resize_conf['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $resize_conf['new_image'] = $this->upload->upload_path . 'thumb_' . $this->upload->file_name;
                $resize_conf['maintain_ratio'] = FALSE;
                $resize_conf['width'] = 800;
                $resize_conf['height'] = 600;

                // initializing image_lib
                $this->image_lib->initialize($resize_conf);
                $this->image_lib->resize();

                return true;
            }
        }
        return true;
    }

    //api to upload image
    function api_upload_photo()
    {
        $config['upload_path'] = './assets/forms/data/images/';
        $config['allowed_types'] = 'png|jpg|jpeg|gif|webp';
        $config['max_size'] = '4000';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;

        log_message("debug", "reached hapa => upload image");

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (isset($_FILES['upload']) && !empty($_FILES['upload']['name'])) {
            if ($this->upload->do_upload('upload')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();

                //Image Resizing
                $resize_conf['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $resize_conf['new_image'] = $this->upload->upload_path . 'thumb_' . $this->upload->file_name;
                $resize_conf['maintain_ratio'] = FALSE;
                $resize_conf['width'] = 800;
                $resize_conf['height'] = 600;

                // initializing image_lib
                $this->image_lib->initialize($resize_conf);
                $this->image_lib->resize();

                echo base_url('assets/forms/data/images/') . $upload_data['file_name'];
            } else {
                echo json_encode(['error' => $this->upload->display_errors()]);
            }
        } else {
            echo json_encode(['error' => "Failed to upload image"]);
        }
    }
}
