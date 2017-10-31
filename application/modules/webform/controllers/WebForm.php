<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 09/10/2017
 * Time: 09:54
 */

class WebForm extends MX_Controller
{
    private $data = [];

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
            exit;
        }

        $this->load->model("Xform_model");
        $this->load->model("XformReader_model");

        $this->data['title'] = "Web form";
    }


    public function index()
    {
        $this->renderForm(2);
    }

    public function renderForm($xform_id = null)
    {
        $xForm = $this->Xform_model->find_by_id($xform_id);

        if (!$xForm) {
            exit("Form not found");
        }

        $this->data['form_title'] = $xForm->title;

        $this->data['web_form'] = $this->XformReader_model->render_form($xForm->form_id,$xForm->filename);

        $this->load->view("layout/header", $this->data);
        $this->load->view("render_form", $this->data);
    }

    public function save()
    {
        $input = $this->input->post();


        echo "<pre>";
        print_r($input);
    }
}