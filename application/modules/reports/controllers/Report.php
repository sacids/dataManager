<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 27/09/2017
 * Time: 12:12
 */

class Report extends MX_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata("message", display_message("You must be logged in", "error"));
            redirect('auth/login', 'refresh');
            exit;
        }

        $this->load->model("Report_model");
        $this->load->model("Xform_model");
    }

    public function idwe()
    {
        $table_name = "ad_build_IDWE_Zanzibar_1506336659";

        //$table_columns = $this->Xform_model->find_table_columns($table_name);
        $mapped_table_columns = $this->Xform_model->find_all_field_name_maps($table_name, 0, 0);
        $group_by_columns = $this->Xform_model->find_all_field_name_maps($table_name, 0, 1);

        $reports = $this->Report_model->find_all_reports();
        $report_options = ['' => "Select Report"];
        foreach ($reports as $report) {
            $report_options[$report->id] = $report->title;
        }

        $options [''] = "Select column to chart";
        $group_by_options [''] = "Select column to group by";

        foreach ($mapped_table_columns as $column) {
            $options[$column->col_name] = $column->field_label;
        }

        foreach ($group_by_columns as $column) {
            $group_by_options[$column->col_name] = $column->field_label;
        }

        $this->data['chart_title'] = "Weekly report";
        $this->data['yaxis_title'] = "Count";
        $this->data['group_by_column'] = "_xf_1e0b70ceccc8a5457221fb938ee70caf";

        $this->form_validation->set_rules("report", "Report", "required");
        //$this->form_validation->set_rules("group_by", "Group by", "required");

        $this->data['report_type'] = null;
        $this->data['disease_name'] = null;

        $data_series = null;
        if ($this->form_validation->run() === true) {

            $report_id = (int)$this->input->post("report");
            $group_by_column = $this->input->post("group_by");


            $report_query = $this->Report_model->find_by_id($report_id);

            if ($report_id >= 2) {
                $this->data['report_type'] = "single_disease";
                $this->data['chart_title'] = $report_query->title;
                $this->data['disease_name'] = $report_query->title;
            }

            if ($group_by_column != null) {
                $condition = "Group by " . $this->security->xss_clean($group_by_column);
            } else {
                $condition = $report_query->where_condition;
            }
            $this->data['report_data'] = $this->Report_model->execute_query($report_query->sql_query, $condition);
            $this->data['group_by_column'] = $group_by_column;
            log_message("debug", "last query " . $this->db->last_query());
        } else {
            $result = $this->Report_model->find_all_reports(1);
            $report_query = array_shift($result);
            $this->data['report_data'] = $this->Report_model->execute_query($report_query->sql_query, $report_query->where_condition);
        }

        $this->data['series_data'] = json_encode($data_series);

        $this->data['options'] = $options;
        $this->data['group_by_options'] = $group_by_options;
        $this->data['reports'] = $report_options;

        $this->load->view("header", $this->data);
        $this->load->view("idwe", $this->data);
        $this->load->view("footer");
    }
}