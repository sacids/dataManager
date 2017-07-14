<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 3:42 PM
 */
class Lab extends CI_Controller
{
    function __construct()
    {
        // load model
        parent::__construct();
        $this->load->model(array('User_model', 'Xform_model', 'Perm_model'));
    }

    public function requests()
    {
        $key = $this->input->get('k');
        $val = $this->input->get('v');
        $tbl = $this->input->get('t');

        $res = array();

        if (empty($tbl)) {
            $tbl = 'ad_build_Lab_Request_1475596584';
        }
        if (empty($key)) {
            $key = '_xf_lrLt_2231';
        }

        if ($data = $this->Perm_model->get_table_data($tbl, $key, $val)) {
            //TODO: return lab result in json
            $res['details'] = $data;
            $res['status'] = 'success';
            $res['form_id'] = 'build_Lab_Request_1475596584';

        } else {

            $res['status'] = 'failed';
        }

        echo json_encode($res);

    }


    public function get_forms()
    {
        if ($this->input->get('form_type') == null) {
            $response = array("status" => "failed", "message" => "Required parameter missing");
        } else {

            //TODO: identify something to know if it lab request or lab result
            $form_type = $this->input->get('form_type');

            $query = $this->db->get_where('xforms', array(''))->result();

            if ($query) {
                foreach ($query as $value) {
                    $form[] = array(
                        'jr_form_id' => $value->jr_form_id
                    );
                }
                $response = array("form" => $form, "status" => "success");
            } else {
                $response = array("status" => "success", "message" => "No form found");
            }
        }
        echo json_encode($response);
    }


}