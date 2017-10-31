<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 12/8/2016
 * Time: 12:44 PM
 */
class Search extends REST_Controller
{
    private $table_name;
    private $label;
    private $search_value;

    function __construct()
    {
        // load model
        parent::__construct();
        $this->load->model(array('model', 'Xform_model', 'Perm_model'));
        $this->load->library(array('Xform_comm'));
    }

    //search init
    public function init_get()
    {
        $this->model->set_table('xforms_config');
        $forms = $this->model->get_all();

        if ($forms) {
            $result = array();
            $tmp = array();

            foreach ($forms as $form) {
                $this->model->set_table('xforms');
                $sForm = $this->model->get($form->xform_id);

                //variable
                $tmp['xform_id'] = $sForm->form_id;
                $tmp['jr_form_id'] = $sForm->jr_form_id;
                $tmp['title'] = $sForm->title;
                $tmp['form_id'] = $form->xform_id;

                $flds = explode(',', $form->search_fields);

                $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $sForm->filename);
                $defn = $this->xform_comm->get_form_definition();
                $map = $this->get_fieldname_map($sForm->form_id);

                //print_r($map);

                $nn = array();
                $tmp2 = array();


                foreach ($defn as $v) {
                    if (!array_key_exists('label', $v)) continue;
                    $fn = $v['field_name'];
                    $lb = $v['label'];

                    //check column mapping
                    if (array_key_exists($fn, $map))
                        $col_name = $map[$fn]['col_name'];
                    else
                        $col_name = $fn;

                    if (in_array($col_name, $flds)) {
                        $nn['label'] = $lb;
                        $nn['value'] = $col_name;
                        array_push($tmp2, $nn);
                    }
                }
                $tmp['search_fields'] = $tmp2;

                array_push($result, $tmp);
            }

            //response
            $this->response(array('status' => 'success', 'searchable_form' => $result), 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No form found'), 202);
        }
    }

    //form search
    public function form_get()
    {
        if (!$this->get('field') || !$this->get('search_for') || !$this->get('form_id')) {
            $this->response(array('status' => 'failed', 'message' => 'Parameters are missing'), 202);
        }

        //get variable
        $form_id = $this->get('form_id');
        $this->label = $this->get('field');
        $this->search_value = $this->get('search_for');

        $this->model->set_table('xforms');
        $xform = $this->model->get_by('id', $form_id);

        //table name
        $this->table_name = $xform->form_id;

        $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $xform->filename);
        $this->xform_comm->load_xml_definition($this->config->item("xform_tables_prefix"));
        $form_definition = $this->xform_comm->get_defn();

        //get form data
        $form_data = $this->get_form_data($form_definition, $this->get_fieldname_map($this->table_name));

        if ($form_data)
            $this->response(array("status" => "success", "form_details" => $form_data), 200);
        else
            $this->response(array("status" => "failed", "message" => "No search results found"), 202);
    }

    //get form data
    function get_form_data($structure, $map)
    {
        //get feedback form details
        $this->model->set_table($this->table_name);
        $data = $this->model->get_by($this->label, $this->search_value);

        if (!$data) return false;
        $holder = array();
        //print_r($map);
        //print_r($structure);

        $ext_dirs = array(
            'jpg' => "images",
            'jpeg' => "images",
            'png' => "images",
            '3gpp' => 'audio',
            'amr' => 'audio',
            '3gp' => 'video',
            'mp4' => 'video');

        $c = 1;
        $id = $data->id;

        foreach ($structure as $val) {
            $tmp = array();
            $field_name = $val['field_name'];
            $type = $val['type'];

            //TODO : change way to get label
            if (array_key_exists($field_name, $map)) {
                if (!empty($map[$field_name]['field_label'])) {
                    $label = $map[$field_name]['field_label'];
                } else {
                    if (!array_key_exists('label', $val))
                        $label = $field_name;
                    else
                        $label = $val['label'];
                }
            }

            if (array_key_exists($field_name, $map)) {
                $field_name = $map[$field_name]['col_name'];
            }
            $l = $data->$field_name;


            if ($type == 'select1') {
                //$l = $val['option'][$l];
            }
            if ($type == 'binary') {
                // check file extension
                $value = explode('.', $l);
                $file_extension = end($value);
                if (array_key_exists($file_extension, $ext_dirs)) {
                    $l = site_url('assets/forms/data') . '/' . $ext_dirs[$file_extension] . '/' . $l;
                }
            }
            if ($type == 'select') {
                $tmp1 = explode(" ", $l);
                $arr = array();
                foreach ($tmp1 as $item) {
                    $item = trim($item);
                    array_push($arr, $val['option'][$item]);
                }
                $l = implode(",", $arr);
            }
            if (substr($label, 0, 5) == 'meta_') continue;
            $tmp['id'] = $id . $c++;
            $tmp['label'] = $label;
            $tmp['type'] = $type;
            $tmp['value'] = $l;
            array_push($holder, $tmp);
        }
        return $holder;
    }

    //get fieldname map
    private function get_fieldname_map($table_name)
    {
        $tmp = $this->Xform_model->get_fieldname_map($table_name);
        $map = array();
        foreach ($tmp as $part) {
            $key = $part['field_name'];
            $map[$key] = $part;
        }
        return $map;
    }

}