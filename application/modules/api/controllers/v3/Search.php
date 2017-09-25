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
                $defn = $this->xform_comm->get_form_definition($sForm->form_id);

                $nn = array();
                $tmp2 = array();
                foreach ($defn as $v) {

                    if (!array_key_exists('label', $v)) continue;
                    $fn = $v['field_name'];
                    $lb = $v['label'];

                    if (in_array($fn, $flds)) {
                        $nn['label'] = $lb;
                        $nn['value'] = $fn;
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
        $field = $this->get('field');
        $search = $this->get('search_for');
        $form_id = $this->get('form_id');

        $this->model->set_table('xforms');
        $xform = $this->model->get_by('form_id', $form_id);

        $table = $xform->form_id;
        $filename = $xform->filename;

        $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $filename);
        $defn = $this->xform_comm->get_form_definition($table);

        //search results
        $this->model->set_table($table);
        $qr = $this->model->get_many_by($field, $search);

        if ($qr) {
            $result = array();

            foreach ($qr as $item) {
                $tmp2 = array();

                foreach ($defn as $var) {
                    if (!array_key_exists('label', $var)) continue;
                    $field_type = $var['type'];
                    $label = $var['label'];
                    $field_name = $var['field_name'];
                    $id = $item->id;

                    if ($field_type == 'geopoint' OR $field_type == 'binary') continue;
                    if ($field_type == 'select') {
                        $opts = $var['option'];

                        $tmp1 = explode(" ", $item->$field_name);
                        $t2 = '';
                        foreach ($tmp1 as $v1) {
                            $t2 .= ', ' . $opts[$v1];
                        }
                        $val = $t2;
                    } else {
                        $val = $item->$field_name;
                    }

                    $tmp2['label'] = $label;
                    $tmp2['value'] = $val;
                    array_push($result, $tmp2);
                }
            }

            //response
            $this->response(array('status' => 'success', 'form_details' => $result), 200);

        } else {
            $this->response(array("status" => "failed", "message" => "No search results found"), 202);
        }
    }

}