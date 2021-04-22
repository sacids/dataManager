<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    private $data;

    function __construct()
    {
        parent::__construct();
    }

    //check login
    function is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }

    //dashboard
    public function index()
    {
        $this->data['title'] = "Taarifa kwa wakati!";

        //check if logged in
        $this->is_logged_in();

        $filter_conditions = null;
        if (!$this->ion_auth->is_admin()) {
            $filter_conditions = $this->Acl_model->find_user_permissions(get_current_user_id(), Xform_model::$xform_table_name);
        }

        //statistics
        $this->data['data_collectors'] = $this->User_model->count_data_collectors();
        $this->data['published_forms'] = $this->Submission_model->count_published_forms();
        $this->data['new_feedback'] = $this->Feedback_model->count_new_feedback();

        $form_title = array();
        $overall_data = array();
        $monthly_data = array();
        $weekly_data = array();
        $daily_data = array();

        //submitted forms
        $submitted_forms = $this->Submission_model->get_submitted_forms($filter_conditions);

        $i = 0;
        foreach ($submitted_forms as $value) {
            $form_title[$i] = '<a href="' . site_url('xform/form_data/' . $value->project_id.'/'.$value->id) . '" >' . $value->title . '</a>';
            $overall_data[$i] = $this->Submission_model->count_overall_submitted_forms($value->form_id);
            $monthly_data[$i] = $this->Submission_model->count_monthly_submitted_forms($value->form_id);
            $weekly_data[$i] = $this->Submission_model->count_weekly_submitted_forms($value->form_id);
            $daily_data[$i] = $this->Submission_model->count_daily_submitted_forms($value->form_id);
            $i++;
        }

        $this->data['form_title'] = json_encode($form_title);
        $this->data['overall_data'] = json_encode($overall_data);
        $this->data['monthly_data'] = json_encode($monthly_data);
        $this->data['weekly_data'] = json_encode($weekly_data);
        $this->data['daily_data'] = json_encode($daily_data);

        //feedback
        $this->data['feedback'] = $this->Feedback_model->find_all(5, 0);

        //detected diseases
        $this->model->set_table('ohkr_detected_diseases');

        //$this->db->group_by('disease_id');
        $detected_diseases = $this->model->order_by('created_at', 'DESC')->limit(10)->get_all();
        $this->data['detected_diseases'] = $detected_diseases;

        foreach ($this->data['detected_diseases'] as $k => $v) {
            //disease
            $this->model->set_table('ohkr_diseases');
            $this->data['detected_diseases'][$k]->disease = $this->model->get($v->disease_id);
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view('index');
        $this->load->view('footer');
    }

}