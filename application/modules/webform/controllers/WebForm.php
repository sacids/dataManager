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
        $xForm_meta = $this->Xform_model->find_by_id($xform_id);

        if(!$xForm_meta){
            exit("Form not found");
        }

        $this->data['form_title'] = $xForm_meta->title;

        $this->data['web_form'] = $this->XformReader_model->render_form($xForm_meta->form_id, $xForm_meta->filename);

        $this->load->view("layout/header", $this->data);
        $this->load->view("render_form", $this->data);
    }
}