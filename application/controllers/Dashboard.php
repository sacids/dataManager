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
        //check if logged in
        $this->_is_logged_in();

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
            $this->data['submitted_forms'][$k]->daily_form = $this->Submission_model->count_daily_submitted_forms($form->form_id);
        }

        $this->data['title'] = "Taarifa kwa wakati!";
        $this->load->view('header', $this->data);
        $this->load->view('index');
        $this->load->view('footer');
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
