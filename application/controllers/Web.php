<?php
/**
 * Créé avec PhpStorm.
 * Utilisateur : administrateur
 * Date : 10/09/2018
 * Heure : 10:51
 */

class Web extends CI_Controller
{
    private $data;

    function __construct()
    {
        parent::__construct();
    }

    // Page par défaut
    function index()
    {
        $this->data['title'] = 'Taarifa kwa wakati!';

        $stories = [];
        $this->data['stories'] = $stories;

        // Afficher la vue
        $this->load->view('web/header', $this->data);
        $this->load->view('web/index');
        $this->load->view('web/footer');
    }

    // Page "À propos"
    function about()
    {
        $this->data['title'] = 'À propos d\'Afyadata';

        // Afficher la vue
        $this->load->view('web/header', $this->data);
        $this->load->view('web/about');
        $this->load->view('web/footer');
    }

    // Créer un projet
    function create_project(){
        $this->data['title'] = 'Créer un projet';

        // Afficher la vue
        $this->load->view('web/header', $this->data);
        $this->load->view('web/create_project');
        $this->load->view('web/footer');
    }

    // Collecter des données
    function collect_data(){
        $this->data['title'] = 'Collecter des données';

        // Afficher la vue
        $this->load->view('web/header', $this->data);
        $this->load->view('web/collect_data');
        $this->load->view('web/footer');
    }

    // Analyser des données
    function analyze_data(){
        $this->data['title'] = 'Analyser des données';

        // Afficher la vue
        $this->load->view('web/header', $this->data);
        $this->load->view('web/analyze_data');
        $this->load->view('web/footer');
    }
}
