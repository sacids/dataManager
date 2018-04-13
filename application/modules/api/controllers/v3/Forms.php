<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 04/04/2018
 * Time: 08:22
 */

class Forms extends REST_Controller
{
    private $xFormReader;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model'));

        $this->xFormReader = new Xformreader_model();
    }

    //download forms
    function lists_get()
    {
        if (!$this->get('username')) {
            $this->response(array('status' => 'failed', 'message' => 'Username is required'), 202);
        }

        $username = $this->get('username');

        $user = $this->User_model->find_by_username($username);

        if ($user) {
            $user_groups = $this->User_model->get_user_groups_by_id($user->id);
            $user_perms = array(0 => "P" . $user->id . "P");
            $i = 1;
            foreach ($user_groups as $ug) {
                $user_perms[$i] = "G" . $ug->id . "G";
                $i++;
            }

            $forms = $this->Xform_model->get_form_list_by_perms($user_perms);
            $forms_array = array();
            if ($forms) {
                foreach ($forms as $form) {
                    $forms_array[] = array(
                        'id' => $form->id,
                        'form_id' => $form->form_id,
                        'title' => $form->title,
                        'description' => $form->description,
                        'download_url' => base_url() . 'assets/forms/definition/' . $form->filename
                    );
                }
                $this->response(array("status" => "success", "forms" => $forms_array), 200);
            } else {
                $this->response(array('status' => 'failed', 'message' => 'Forms does not exist'));
            }
        } else {
            $this->response(array('status' => 'failed', 'message' => 'User does not exist'));
        }
    }
}