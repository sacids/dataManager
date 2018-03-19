<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 19/03/2018
 * Time: 10:43
 */

class Media extends MX_Controller
{
    private $data;
    private $_uploaded;

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    //media list
    function lists()
    {
        $this->data['title'] = 'Media Manager';

        //pagination
        $config = array(
            'base_url' => $this->config->base_url("newsletters/media/lists"),
            'total_rows' => $this->Media_model->count_media(),
            'uri_segment' => 4,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $this->data['media_list'] = $this->Media_model->get_media_list($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("media/lists");
        $this->load->view('footer');
    }

    //upload files
    function upload()
    {
        $this->data['title'] = 'Upload Media';

        //now we set a callback as rule for the upload field
        $this->form_validation->set_rules('attachment[]', 'Upload image', 'callback_upload_attachments');

        //was something posted?
        if ($this->input->post()) {
            //run the validation
            if ($this->form_validation->run($this) === TRUE) {
                foreach ($this->_uploaded as $v) {
                    $data = array(
                        'name' => $v,
                        'created_by' => get_current_user_id(),
                        'date_created' => date('Y-m-d H:i:s')
                    );
                    $this->Media_model->create_media($data);
                }

                //create json file
                $this->json_lists();

                //redirect
                $this->session->set_flashdata("message", display_message("Media uploaded"));
                redirect("newsletters/media/lists", "refresh");
            }
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("media/upload");
        $this->load->view('footer');
    }

    //create  media json
    function json_lists()
    {
        $media_list = $this->Media_model->find_all_media();

        if ($media_list) {
            foreach ($media_list as $value) {
                $posts[] = array('image' => base_url('assets/uploads/media/' . $value->name), 'folder' => './assets/uploads/media');
            }
            $fp = fopen('./assets/uploads/media/image_lists.json', 'w');
            fwrite($fp, json_encode($posts));
            fclose($fp);
        }
    }

    /*============================================================
       CALLBACK FUNCTIONS
       =============================================================*/
    // now the callback validation that deals with the upload of files
    function upload_attachments()
    {
        // we retrieve the number of files that were uploaded
        $number_of_files = sizeof($_FILES['attachment']['tmp_name']);

        // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
        $files = $_FILES['attachment'];

        // first make sure that there is no error in uploading the files
        for ($i = 0; $i < $number_of_files; $i++) {
            if ($_FILES['attachment']['error'][$i] != 0) {
                // save the error message and return false, the validation of uploaded files failed
                $this->form_validation->set_message('upload_attachments', 'Couldn\'t upload the file(s)');
                return FALSE;
            }
        }


        // we first load the upload library
        $config['upload_path'] = './assets/uploads/media';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000000';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;

        // we first load the upload library
        $this->load->library(array('upload'));

        // now, taking into account that there can be more than one file, for each file we will have to do the upload
        for ($i = 0; $i < $number_of_files; $i++) {
            $_FILES['attachment']['name'] = $files['name'][$i];
            $_FILES['attachment']['type'] = $files['type'][$i];
            $_FILES['attachment']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['attachment']['error'] = $files['error'][$i];
            $_FILES['attachment']['size'] = $files['size'][$i];

            //now we initialize the upload library
            $this->upload->initialize($config);

            if ($this->upload->do_upload('attachment')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();

                $this->_uploaded[$i] = $upload_data['file_name'];
            } else {
                $this->form_validation->set_message('upload_attachments', $this->upload->display_errors());
                return FALSE;
            }
        }
        return TRUE;
    }

}