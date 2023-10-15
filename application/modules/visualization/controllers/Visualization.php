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
 * @copyright    Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/31/2016
 * Time: 10:10 AM
 */
class Visualization extends CI_Controller
{

    private $data;

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        //$this->output->enable_profiler(TRUE);
        $this->data['title'] = "Data Visualizations";
    }

    //charts
    public function chart($project_id, $form_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
            exit;
        }

        $project = $this->Project_model->get_project_by_id($project_id);
        if (!$project)
            show_error("Project not exist", 500);

        $data['project'] = $project;
        $data['xforms'] = $xforms = $this->Xform_model->get_form_list();

        $form = $this->Xform_model->find_by_id($form_id);
        $data['form'] = $form;


        if ($form) {
            // Capture selected x and y fields
            // Capture dates ranges if selected
            $form_details = $this->Xform_model->find_by_xform_id($form->form_id);
            $data['form_details'] = $form_details;

            $table_name = $form_details->form_id;
            $data['table_fields'] = $table_fields = $this->Xform_model->find_table_columns($table_name);
            $data['table_fields_data'] = $table_fields_data = $this->Xform_model->find_table_columns_data($table_name);
            $data['field_maps'] = $this->_get_mapped_table_column_name($form_details->form_id);

            $mapped_fields = array();
            foreach ($table_fields as $key => $column_name) {
                if (array_key_exists($column_name, $data['field_maps'])) {
                    $mapped_fields[$column_name] = $data['field_maps'][$column_name];
                } else {
                    $mapped_fields[$column_name] = $column_name;
                }
            }

            $custom_maps = $this->Xform_model->get_fieldname_map($table_name);

            foreach ($custom_maps as $f_map) {
                if (array_key_exists($f_map['col_name'], $mapped_fields)) {
                    $mapped_fields[$f_map['col_name']] = $f_map['field_label'];
                }
            }

            $data['table_fields'] = $mapped_fields;
            $data['mapped_fields'] = $mapped_fields;

            $this->form_validation->set_rules("axis", "Column to plot", "required");
            $this->form_validation->set_rules("group_by", "Select column to group by", "required");

            if ($this->form_validation->run() === TRUE) {

                $axis_column = $this->input->post("axis");

                $start_date = $this->input->post("startdate");
                $end_date = $this->input->post("enddate");

                $group_by_column = $this->input->post("group_by");
                $function = $this->input->post("function");

                $categories = array();
                $series = array("name" => array_key_exists($axis_column, $mapped_fields) ? $mapped_fields[$axis_column] : ucfirst(str_replace("_", " ", $axis_column)));
                $series_data = array();

                $data['chart_title'] = $function;

                $data['results'] = $results = $this->Xform_model->get_graph_data($table_name, $axis_column, $function, $group_by_column);

                $i = 0;
                foreach ($results as $result) {
                    if ($function == "COUNT") {
                        $categories[$i] = array_key_exists($result->$group_by_column, $mapped_fields) ? $mapped_fields[$result->$group_by_column] : $result->$group_by_column;
                        $series_data[$i] = $result->count;
                    }
                    if ($function == "SUM") {
                        $categories[$i] = array_key_exists($result->$axis_column, $mapped_fields) ? $mapped_fields[$result->$axis_column] : $result->$axis_column;
                        $categories[$i] = $result->$axis_column;
                        $series_data[$i] = $result->sum;
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

        $data['title'] = 'Chart';

        //links
        $data['links'] = [
            'overview' => anchor("xform/submission_stats/" . $project->id . '/' . $form->id, 'Overview', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'table' => anchor("xform/form_data/" . $project->id . '/' . $form->id, 'Table', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'charts' => anchor("visualization/visualization/chart/" . $project->id . '/' . $form->id, 'Charts', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
            'map' => anchor("visualization/visualization/map/" . $project->id . '/' . $form->id, 'Map', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'mapping_field' => anchor("xform/mapping/" . $project->id . '/' . $form->id, 'Mapping Fields', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'permission' => anchor("xform/permissions/" . $project->id . '/' . $form->id, 'Permissions', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'case_information' => anchor("xform/case_information/" . $project->id . '/' . $form->id, ' Notification de cas', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        //render view
        $this->load->view("header", $data);
        $this->load->view("chart");
        $this->load->view("footer");
    }

    /**
     * @param $form_id
     * @return array
     */
    function _get_mapped_table_column_name($form_id)
    {
        if (!$form_id)
            redirect("visualization/visualization");

        $table_name = $form_id;
        $map = $this->get_field_map($table_name);

        $form_details = $this->Feedback_model->get_form_details($form_id);
        $file_name = $form_details->filename;
        $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $file_name);
        $this->xform_comm->load_xml_definition($this->config->item("xform_tables_prefix"));
        $form_definition = $this->xform_comm->get_defn();
        $table_field_names = array();
        foreach ($form_definition as $fdfn) {
            $kk = $fdfn['field_name'];
            // check if column name was mapped to fieldmap table
            if (array_key_exists($kk, $map)) {
                $kk = $map[$kk];
            }
            if (array_key_exists("label", $fdfn)) {
                if ($fdfn['type'] == "select") {
                    $options = $fdfn['option'];
                    foreach ($options as $key => $value) {
                        // check if column name was mapped to fieldmap table
                        if (array_key_exists($key, $map)) {
                            $key = $map[$key];
                        }
                        $table_field_names[$key] = $value;
                    }
                } elseif ($fdfn['type'] == "int") {
                    $find_male = " m ";
                    $find_female = " f ";
                    $group_name = str_replace("_", " ", $fdfn['field_name']);
                    if (strpos($group_name, $find_male)) {
                        $table_field_names[$kk] = str_replace($find_male, " " . $fdfn['label'] . " ", $group_name);
                    } elseif (strpos($group_name, $find_female)) {
                        $table_field_names[$kk] = str_replace($find_female, " " . $fdfn['label'] . " ", $group_name);
                    } else {
                        $table_field_names[$kk] = $group_name . " " . $fdfn['label'];
                    }
                } else {
                    $table_field_names[$kk] = $fdfn['label'];
                }
            } else {
                $table_field_names[$kk] = $fdfn['field_name'];
            }
        }
        return $table_field_names;
    }

    private function get_field_map($table_name)
    {

        $arr = $this->Xform_model->get_fieldname_map($table_name);
        $map = array();
        foreach ($arr as $val) {
            $key = $val['field_name'];
            $label = $val['col_name'];
            $map[$key] = $label;
        }
        return $map;
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

            //$is_gps_field = (strpos($field->name, $gps_fields_initial == FALSE)) ? FALSE : TRUE;

            if ($field->type == "enum") {
                $axis_column = $field->name;
                $group_by_column = $field->name;
                $enum_field = $field->name;
                $function = "COUNT";
                break;
            } elseif ($field->type == "int" && $field->name != "id") {
                $axis_column = $field->name;
                $group_by_column = ($enum_field != NULL) ? $enum_field : $field->name;
                $function = "SUM";
                break;
            } elseif ($field->type == "varchar") { // && !$is_gps_field) {
                //Todo check here causes form jamii to bring errors
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
        $this->load->view("welcome_message");
    }

    //map
    public function map($project_id, $form_id = NULL)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
            exit;
        }
        //title
        $data['title'] = 'Map';

        //project
        $project = $this->Project_model->get_project_by_id($project_id);
        if (!$project)
            show_error("Project not exist", 500);

        $data['project'] = $project;

        $form = $this->Xform_model->find_by_id($form_id);
        $data['form'] = $form;

        //links
        $data['links'] = [
            'overview' => anchor("xform/submission_stats/" . $project->id . '/' . $form->id, 'Overview', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'table' => anchor("xform/form_data/" . $project->id . '/' . $form->id, 'Table', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'charts' => anchor("visualization/visualization/chart/" . $project->id . '/' . $form->id, 'Charts', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'map' => anchor("visualization/visualization/map/" . $project->id . '/' . $form->id, 'Map', ['class' => 'inline-block p-2 border-b-4 border-red-900']),
            'mapping_field' => anchor("xform/mapping/" . $project->id . '/' . $form->id, 'Mapping Fields', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'permission' => anchor("xform/permissions/" . $project->id . '/' . $form->id, 'Permissions', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
            'case_information' => anchor("xform/case_information/" . $project->id . '/' . $form->id, ' Notification de cas', ['class' => 'inline-block p-2 border-b-4 border-transparent']),
        ];

        if ($form) {
            $map_data = $this->_load_points($form->form_id);

            //render view
            $this->load->view("header", $data);
            $this->load->view("map", $map_data);
            $this->load->view("footer");
        } else {
            // Display some error message or rather get default form
        }
    }

    private function _load_points($form_id)
    {
        $xform = $this->Xform_model->find_by_xform_id($form_id);

        // TODO - enable limits/conditions for loading data
        $point_field = $this->Xform_model->get_point_field($form_id);
        if (!$point_field) {
            log_message('error', 'load points Table ' . $form_id . ' has no location field of type POINT');
            return FALSE;
        }

        $gps_prefix = substr($point_field, 0, -6);

        $form_data = $this->Xform_model->get_geospatial_data($form_id, 500);

        if (!$form_data) {
        }

        //todo Finish
        $field_maps = $this->_get_mapped_table_column_name($form_id);
        $data['mapped_fields'] = [];
        foreach ($form_data as $key => $value) {
            if (array_key_exists($key, $field_maps)) {
                $data['mapped_fields'][$field_maps[$key]] = $value;
            } else {
                $data['mapped_fields'][$key] = $value;
            }
        }

        //echo '<pre>';print_r($field_maps);echo '</pre>'; exit();
        //$form_data = $data['mapped_fields'];*/

        $addressPoints = '<script type="text/javascript"> var addressPoints = [';
        $first = 0;

        foreach ($form_data as $i => $val) {
            $data_string = "<h4>" . $xform->title . "</h4><small>" . $form_data[$i]['submitted_at'] . "</small><br><br>";

            foreach ($val as $key => $value) {
                if (!strpos($key, '_point')) {
                    if (preg_match('/(\.jpg|\.png|\.bmp)$/', $value)) {
                        $data_string .= str_replace('"', '\'', '<img src = "' . base_url() . 'assets/forms/data/images/' . $value . '" width="350" /><br/>');
                    } else {
                        if (array_key_exists($key, $field_maps) && substr($key, 0, 4) == '_xf_') {
                            $key =  $field_maps[$key];
                        } else {
                            continue;
                        }
                        $data_string .= $key . " : <b>" . str_replace('"', '', str_replace("'", "\'", urlencode(trim($value)))) . "</b><br/>";
                    }
                }
            }

            log_message("debug", "Single record " . $data_string);

            $lat = $val[$gps_prefix . '_lat'];
            $lng = $val[$gps_prefix . '_lng'];


            //TODO Replace a with form data.
            if (!$first++) {
                $addressPoints .= '[' . $lat . ', ' . $lng . ', "' . $data_string . '"]';
            } else {
                $addressPoints .= ',[' . $lat . ', ' . $lng . ', "' . $data_string . '"]';
            }
        }

        $addressPoints .= ']; </script>';
        $latlon = $lat . ', ' . $lng;

        $holder = array();
        $holder['addressPoints'] = $addressPoints;
        $holder['latlon'] = $latlon;

        return $holder;
    }
}
