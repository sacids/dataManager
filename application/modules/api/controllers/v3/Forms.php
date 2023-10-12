<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 04/04/2018
 * Time: 08:22
 */

class Forms extends REST_Controller
{
    private $xFormReader;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model'));
        $this->xFormReader = new Xformreader_model();
    }

    //download forms
    function lists_get()
    {
        if (!$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Username is required'), 202);
        }

        $username = $this->get('username');

        $user = $this->User_model->find_by_username($username);

        if ($user) {
            $user_groups = $this->User_model->get_user_groups_by_id($user->id);
            $user_perms = array(0 => "P" . $user->id . "P");
            $i = 1;
            foreach ($user_groups as $ug) {
                $user_perms[$i] = "G" . $ug->id . "G";
                $i++;
            }

            $forms = $this->Xform_model->get_form_list_by_perms($user_perms, 30, 0, "published", 1);
            $forms_array = array();
            if ($forms) {
                foreach ($forms as $form) {
                    $forms_array[] = array(
                        'id' => $form->id,
                        'form_id' => $form->form_id,
                        'title' => $form->title,
                        'description' => $form->description,
                        'download_url' => base_url() . 'assets/forms/definition/' . $form->filename
                    );
                }
                $this->response(array("status" => "success", "forms" => $forms_array), 200);
            } else {
                $this->response(array('status' => 'failed', 'message' => 'Forms does not exist'));
            }
        } else {
            $this->response(array('status' => 'failed', 'message' => 'User does not exist'));
        }
    }

    function charts_get()
    {
        $filter_conditions = null;

        //submitted forms
        $submitted_forms = $this->Submission_model->get_submitted_forms($filter_conditions);

        //declare array
        $data_array = [];

        foreach ($submitted_forms as $value) {
            $form_title = '<a href="' . site_url('xform/form_data/' . $value->project_id . '/' . $value->id) . '" >' . $value->title . '</a>';

            if (isset($_GET['period']) && $_GET['period'] != null) {
                $period = $_GET['period'];

                if ($period == 'All')
                    $data = $this->Submission_model->count_overall_submitted_forms($value->form_id);
                else if ($period == 'Monthly')
                    $data = $this->Submission_model->count_monthly_submitted_forms($value->form_id);
                else if ($period == 'Weekly')
                    $data = $this->Submission_model->count_weekly_submitted_forms($value->form_id);
                else if ($period == 'Daily')
                    $data = $this->Submission_model->count_daily_submitted_forms($value->form_id);
            } else {
                $data = $this->Submission_model->count_overall_submitted_forms($value->form_id);
            }

            //create data array
            $data_array[] = [
                "survey" => $form_title,
                "data" =>  (int) $data
            ];
        }

        //response
        echo json_encode(['error' => FALSE, 'chart' => $data_array], 200);
    }
}
