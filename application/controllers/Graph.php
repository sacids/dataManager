<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/31/2016
 * Time: 10:10 AM
 */

class Graph extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'Xform_model',
			'User_model',
			'Submission_model'
		));
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->overview();
	}

	public function overview()
	{
		$data['title'] = "Overview";

		$data['xforms'] = $xforms = $this->Xform_model->get_form_list();
		$xforms_array = (array)$xforms;
		$data['first_record'] = $first_record = $xforms_array[0];

		$table_name = $first_record->form_id;
		$data['table_fields'] = $this->Xform_model->find_table_columns($table_name);
		$data['table_fields_data'] = $table_fields_data = $this->Xform_model->find_table_columns_data($table_name);

		// Ignore the first parts of GPS before _point

		foreach ($table_fields_data as $field) {

		}

		$x_axis_column = "dalili_aina_mifugo_dalili";
		$y_axis_column = "dalili_aina_mifugo_dalili";
		$y_axis_action = "COUNT";

		$data['results'] = $this->Xform_model->get_graph_data($table_name, $x_axis_column, $y_axis_column, $y_axis_action);


		$this->load->view("graph/overview", $data);
	}

	public function layout()
	{
		$this->load->view("graph/welcome_message");
	}
}