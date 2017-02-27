<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 11/5/16
 * Time: 1:34 PM
 */
class Search extends CI_Controller{

    function __construct(){
        // load model
        parent::__construct();
        $this->load->model(array('model', 'Xform_model', 'Perm_model'));
        $this->load->library(array('Xform_comm'));
    }

    public function init(){

        $this->model->set_table('xforms_config');
        $forms  = $this->model->get_all();

        $this->model->set_table('xforms');
        $result = array();
        $tmp    = array();

        foreach($forms as $form){
            $sForm                  = $this->model->get($form->xform_id);
            $tmp['xform_id']     = $sForm->form_id;
            $tmp['jr_form_id']   = $sForm->jr_form_id;
            $tmp['title']        = $sForm->title;
            $tmp['form_id']      = $form->xform_id;

            $flds   = explode(',',$form->search_fields);

            $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $sForm->filename);
            $defn	= $this->xform_comm->get_form_definition($sForm->form_id);

            $nn     = array();
            $tmp2   = array();
            foreach($defn as $v){

                if(!array_key_exists('label',$v)) continue;
                $fn	= $v['field_name'];
                $lb	= $v['label'];

                if(in_array($fn,$flds)){
                    //$nn[$fn] = $lb;
                    $nn['label']    = $lb;
                    $nn['value']    = $fn;
                    array_push($tmp2,$nn);
                }
            }
            $tmp['search_fields']    = $tmp2;

            array_push($result,$tmp);
        }

        $tmp3['searchable_form']    = $result;
        $tmp3['status']             = 'success';

        echo json_encode($tmp3);

    }


    public function form(){

        $field      = $this->input->get('field');
        $search     = $this->input->get('search_for');
        $form_id    = $this->input->get('form_id');

        $this->model->set_table('xforms');
        $xform      = $this->model->get($form_id);
        $table      = $xform->form_id;
        $filename   = $xform->filename;

        $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $filename);
        $defn	= $this->xform_comm->get_form_definition($table);

        $this->model->set_table($table);
        $qr         = $this->model->get_by($field,$search);
        $qr         = $this->model->get_many_by($field,$search);
        $result     = array();

        //print_r($defn);
        foreach($qr as $item){

            $nn     = array();
            $tmp2   = array();
            //print_r($item); echo '</pre>';
            foreach($defn as $var){

                if(!array_key_exists('label',$var)) continue;
                $field_type     = $var['type'];
                $label          = $var['label'];
                $field_name     = $var['field_name'];
                $id             = $item->id;

                if($field_type == 'geopoint' OR $field_type == 'binary') continue;
                if($field_type == 'select') {
                    $opts = $var['option'];

                    $tmp1 = explode(" ", $item->field_name);
                    $t2 = '';
                    foreach ($tmp1 as $v1) {
                        $t2 .= ', ' . $opts[$v1];
                    }
                    $val    = $t2;
                }else{
                    $val    = $item->field_name;
                }

                //$nn[$label]     = $val;
                $tmp2['label']  = $label;
                $tmp2['value']  = $val;
                array_push($result,$tmp2);
                //$result[$id]    = $nn;

            }

        }
        $tmp3['form_details']   = $result;
        $tmp3['status']         = 'success';
        echo json_encode($tmp3);

    }

}