<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 31/10/2017
 * Time: 14:14
 */

class XformPerms extends REST_Controller
{

    function configure_post()
    {
        $this->save_dbexp_post_vars();
        $xform_id = $this->session->userdata['post']['ele_id'];

        $this->model->set_table('xforms');
        $xform = $this->model->get($xform_id);
        $this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $xform->filename);
        $defn = $this->xform_comm->get_form_definition();


        $cols = $this->Xform_model->find_table_columns($xform->form_id);
        $nn = array();
        $nn[0] = 'None';
        foreach ($defn as $v) {

            if (!array_key_exists('label', $v)) continue;
            $fn = $v['field_name'];
            $lb = $v['label'];
            $nn[$fn] = $lb;
        }

        $this->model->set_table('xforms_config');
        if ($tmp = $this->model->get_by('xform_id', $xform_id)) {
            $this->db_exp->set_pri_id($tmp->id);
            $this->db_exp->set_default_action('edit');
        } else {
            $this->db_exp->set_default_action('insert');
        }

        $this->db_exp->set_table('xforms_config');
        $this->db_exp->set_hidden('xform_id', $xform_id);
        $this->db_exp->set_hidden('id');
        $this->db_exp->set_list('search_fields', $nn);
        $this->db_exp->render();
    }

    public function save_dbexp_post_vars()
    {
        $post = $this->input->post();
        $db_exp_submit = $this->input->post('db_exp_submit_engaged');
        if (!empty ($db_exp_submit) || @$post ['action'] == 'insert' || @$post ['action'] == 'edit' || @$post ['action'] == 'delete') {
        } else {
            $this->session->set_userdata('post', $post);
        }
    }

}