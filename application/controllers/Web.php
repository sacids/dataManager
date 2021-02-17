<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/09/2018
 * Time: 10:51
 */

class Web extends CI_Controller
{
    private $data;

    function __construct()
    {
        parent::__construct();
    }

    //default
    function index()
    {
        $this->data['title'] = 'Taarifa kwa wakati!';

        $stories = [];
        $this->data['stories'] = $stories;

        //render view
        $this->load->view('web/header', $this->data);
        $this->load->view('web/index');
        $this->load->view('web/footer');
    }

    //about page
    function about()
    {
        $this->data['title'] = 'About Afyadata';

        //render view
        $this->load->view('web/header', $this->data);
        $this->load->view('web/about');
        $this->load->view('web/footer');
    }

    //create project
    function create_project(){
        $this->data['title'] = 'Create Project';

        //render view
        $this->load->view('web/header', $this->data);
        $this->load->view('web/create_project');
        $this->load->view('web/footer');
    }

    //collect data
    function collect_data(){
        $this->data['title'] = 'Collect Data';

        //render view
        $this->load->view('web/header', $this->data);
        $this->load->view('web/collect_data');
        $this->load->view('web/footer');
    }

    //analyze data
    function analyze_data(){
        $this->data['title'] = 'Analyze Data';

        //render view
        $this->load->view('web/header', $this->data);
        $this->load->view('web/analyze_data');
        $this->load->view('web/footer');
    }

}