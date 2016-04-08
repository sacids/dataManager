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

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');

		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->overview();
	}

	public function overview($form_id = NULL)
	{
		$data['xforms'] = $xforms = $this->Xform_model->get_form_list();

		if ($form_id != NULL) {

			// Capture selected x and y fields
			// Capture dates ranges if selected
			$form_details = $this->Xform_model->find_by_id($form_id);
			$data['form_details'] = $form_details;

			$table_name = $form_details->form_id;
			$data['table_fields'] = $this->Xform_model->find_table_columns($table_name);
			$data['table_fields_data'] = $table_fields_data = $this->Xform_model->find_table_columns_data($table_name);

			$this->form_validation->set_rules("xaxis","Column to use as x-axis","required");
			$this->form_validation->set_rules("yaxis","Column to use as y-axis","required");

			if($this->form_validation->run() === FALSE){

			}else {

			}
		} else {

			$data['title'] = "Overview";


			$xforms_array = (array)$xforms;
			$data['form_details'] = $first_loaded_xform = $xforms_array[0];

			$table_name = $first_loaded_xform->form_id;
			$data['table_fields'] = $this->Xform_model->find_table_columns($table_name);
			$data['table_fields_data'] = $table_fields_data = $this->Xform_model->find_table_columns_data($table_name);

			// Ignore the first parts of GPS before _point
			$x_axis_column = NULL;
			$y_axis_column = NULL;
			$y_axis_action = "COUNT";

			$gps_point_field = NULL;
			$gps_fields_initial = NULL;
			$enum_fields = array();
			$i = 0;
			foreach ($table_fields_data as $field) {
				if (strpos($field->name, '_point') == TRUE) {
					$gps_point_field = $field->name;
					$gps_fields_initial = str_replace('_point', "", $gps_point_field);
					log_message("debug", "GPS point field name is " . $gps_point_field);
					log_message("debug", "GPS point fields initial is " . $gps_fields_initial);

				}
				if ($field->type == "enum") {
					$enum_fields[$i] = $field->name;
				}
				$i++;
			}

			if (count($enum_fields) > 0) {
				$enum_field = $enum_fields[array_rand($enum_fields, 1)];
			} else {
				$enum_field = NULL;
			}
			foreach ($table_fields_data as $field) {

				$is_gps_field = (strpos($field->name, $gps_fields_initial == FALSE)) ? FALSE : TRUE;

				if ($field->type == "enum") {
					$x_axis_column = $field->name;
					$y_axis_column = $field->name;
					$enum_field = $field->name;
					$y_axis_action = "COUNT";
				} elseif ($field->type == "int" && $field->name != "id") {
					$x_axis_column = $field->name;
					$y_axis_column = ($enum_field != NULL) ? $enum_field : $field->name;
					$y_axis_action = "COUNT";
					break;
				} elseif ($field->type == "varchar" && !$is_gps_field) {
					//TODO Fix this condition here
					//($field->name != "meta_deviceID" && $field->name != "meta_instanceID") &&
					$x_axis_column = $field->name;
					$y_axis_column = ($enum_field != NULL) ? $enum_field : $field->name;
					$y_axis_action = "COUNT";
					break;
				}
			}

			log_message("debug", "x-axis column " . $x_axis_column . " y-axis column " . $y_axis_column);


			$categories = array();
			$series = array("name" => ucfirst(str_replace("_", " ", $x_axis_column)));
			$series_data = array();

			$data['results'] = $result = $this->Xform_model->get_graph_data($table_name, $x_axis_column, $y_axis_column, $y_axis_action);

			$i = 0;
			foreach ($result as $result) {
				if ($y_axis_action == "COUNT") {
					$categories[$i] = $result->$y_axis_column;
					$series_data[$i] = $result->count;
				}
				if ($y_axis_action == "SUM") {
					$categories[$i] = $result->$x_axis_column;
					$series_data[$i] = $result->sum;
				}
				$i++;
			}
			$series["data"] = $series_data;
			$data['categories'] = json_encode($categories);
			$data['series'] = $series;
		}
		$this->load->view("graph/overview", $data);
	}

	public
	function layout()
	{
		$this->load->view("graph/welcome_message");
	}
}