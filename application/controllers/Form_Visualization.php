<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/31/2016
 * Time: 10:10 AM
 */
class Form_visualization extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'Xform_model',
			'User_model',
			'Submission_model'
		));

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->chart();
	}

	public function chart($form_id = NULL)
	{
		$data['xforms'] = $xforms = $this->Xform_model->get_form_list();

		if ($form_id != NULL) {

			// Capture selected x and y fields
			// Capture dates ranges if selected
			$form_details = $this->Xform_model->find_by_xform_id($form_id);
			$data['form_details'] = $form_details;

			$table_name = $form_details->form_id;
			$data['table_fields'] = $table_fields = $this->Xform_model->find_table_columns($table_name);
			$data['table_fields_data'] = $table_fields_data = $this->Xform_model->find_table_columns_data($table_name);

			$this->form_validation->set_rules("axis", "Column to plot", "required");
			$this->form_validation->set_rules("group_by", "Select column to group by", "required");

			if ($this->form_validation->run() === TRUE) {

				$axis_column = $this->input->post("axis");

				$start_date = $this->input->post("startdate");
				$end_date = $this->input->post("enddate");

				$group_by_column = $this->input->post("group_by");
				$function = $this->input->post("function");

				/*
				foreach ($table_fields as $field) {
					if ($field->name == $axis_column) {
						if ($field->type == "enum") {
							$function = "COUNT";
							$group_by_column = $field->name;
						} elseif ($field->type == "varchar") {
							$function = "COUNT";
						} elseif ($field->type == "int" || $field->type == "decimal") {
							//todo check for column where is age or something that does not need to added/summed
							$function = "SUM";
						}
					}
				}
				*/

				$categories = array();
				$series = array("name" => ucfirst(str_replace("_", " ", $axis_column)));
				$series_data = array();

				$data['$chart_title'] = $function;

				$data['results'] = $results = $this->Xform_model->get_graph_data($table_name, $axis_column, $function, $group_by_column);

				$i = 0;
				foreach ($results as $results) {
					if ($function == "COUNT") {
						$categories[$i] = $results->$group_by_column;
						$series_data[$i] = $results->count;
					}
					if ($function == "SUM") {
						$categories[$i] = $results->$axis_column;
						$series_data[$i] = $results->sum;
					}
					$i++;
				}
				$series["data"] = $series_data;
				$data['categories'] = json_encode($categories);
				$data['series'] = $series;

			} else {
				$data = $this->_load_default_graph_data($data, $xforms, $table_name);
			}
		} else {
			$data = $this->_load_default_graph_data($data, $xforms);
		}
		$this->load->view("header", $data);
		$this->load->view("graph/chart", $data);
		$this->load->view("footer", $data);
	}

	/**
	 * @param $data
	 * @param $xforms
	 * @param $table_name
	 * @return mixed
	 */
	public function _load_default_graph_data($data, $xforms, $table_name = NULL)
	{
		$data['title'] = "Overview";

		if ($table_name == NULL) {
			$xforms_array = (array)$xforms;
			$data['form_details'] = $first_loaded_xform = $xforms_array[0];
			$table_name = $first_loaded_xform->form_id;
		}
		$data['table_fields'] = $this->Xform_model->find_table_columns($table_name);
		$data['table_fields_data'] = $table_fields_data = $this->Xform_model->find_table_columns_data($table_name);

		// Ignore the first parts of GPS before _point
		$axis_column = NULL;
		$group_by_column = NULL;
		$function = "COUNT";

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
				$axis_column = $field->name;
				$group_by_column = $field->name;
				$enum_field = $field->name;
				$function = "COUNT";
			} elseif ($field->type == "int" && $field->name != "id") {
				$axis_column = $field->name;
				$group_by_column = ($enum_field != NULL) ? $enum_field : $field->name;
				$function = "SUM";
				break;
			} elseif ($field->type == "varchar" && !$is_gps_field) {
				//TODO Fix this condition here
				//($field->name != "meta_deviceID" && $field->name != "meta_instanceID") &&
				$axis_column = $field->name;
				$group_by_column = ($enum_field != NULL) ? $enum_field : $field->name;
				$function = "COUNT";
				break;
			}
		}

		log_message("debug", "x-axis column " . $axis_column . " y-axis column " . $group_by_column);


		$categories = array();
		$series = array("name" => ucfirst(str_replace("_", " ", $axis_column)));
		$series_data = array();

		$data['results'] = $results = $this->Xform_model->get_graph_data($table_name, $axis_column, $function, $group_by_column);

		$i = 0;
		$function = strtolower($function);
		foreach ($results as $result) {
			log_message("debug", "Result " . json_encode($result));
			$categories[$i] = $result->$group_by_column;
			$series_data[$i] = $result->$function;
			$i++;
		}
		$series["data"] = $series_data;
		$data['categories'] = json_encode($categories);
		$data['series'] = $series;
		return $data;
	}

	public function layout()
	{
		$this->load->view("graph/welcome_message");
	}
}