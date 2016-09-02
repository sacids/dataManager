<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('User_model', 'Submission_model', 'Campaign_model', 'Feedback_model'));
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://sacids.com/index.php/dashboard
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/dashboard/<method_name>
     */
    public function index()
    {
        //statistics
        $this->data['active_users'] = $this->User_model->count_users();
        $this->data['published_forms'] = $this->Submission_model->count_published_forms();
        $this->data['active_campaign'] = $this->Campaign_model->count_active_campaign();
        $this->data['new_feedback'] = $this->Feedback_model->count_new_feedback();

        //submitted forms
        $this->data['submitted_forms'] = $this->Submission_model->get_submitted_forms();

        foreach ($this->data['submitted_forms'] as $k => $form) {
            $this->data['submitted_forms'][$k]->overall_form = $this->Submission_model->count_overall_submitted_forms($form->form_id);
            $this->data['submitted_forms'][$k]->monthly_form = $this->Submission_model->count_monthly_submitted_forms($form->form_id);
            $this->data['submitted_forms'][$k]->weekly_form = $this->Submission_model->count_weekly_submitted_forms($form->form_id);
        }

        $this->data['title'] = "Sacids Research Portal";
        $this->load->view('header', $this->data);
        $this->load->view('index');
        $this->load->view('footer');
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
