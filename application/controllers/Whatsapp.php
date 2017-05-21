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
 * @copyright    Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 4/21/2016
 * Time: 5:17 PM
 */
class Whatsapp extends CI_Controller
{
    private $controller;
    private $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Whatsapp_model");
        $this->controller = $this->router->fetch_class();
        $this->user_id = $this->session->userdata('user_id');
    }

    /**
     * Check login
     *
     * @return response
     */
    function _is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }

    /**
     * @param $method_name
     * Check if user has permission
     */
    function has_allowed_perm($method_name)
    {
        if (!perms_role($this->controller, $method_name)) {
            show_error("You are not allowed to view this page", 401, "Unauthorized");
        }
    }

    //import file
    function import()
    {
        $this->data['title'] = "Import message file";

        $this->_is_logged_in();

        //form validation
        $this->form_validation->set_rules('txt_file', 'Message file', 'callback_upload_txt_file_path');

        if ($this->form_validation->run() == TRUE) {
            $txt_file_path = './assets/whatsapp/' . $_POST['txt_file'];

            $handle = fopen($txt_file_path, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== FALSE) {
                    $message = $this->_extract_line_message($line);
                    $this->Whatsapp_model->create($message);
                }
                fclose($handle);
            } else {
                log_message("debug", "error opening the file.");
            }
            //redirect
            $this->session->set_flashdata('message', display_message('Message file imported'));
            redirect('whatsapp/message_list', 'refresh');
        }
        //populate data
        $this->data['txt_file'] = array(
            'name' => 'txt_file',
            'id' => 'txt_file',
            'type' => 'file',
            'value' => $this->form_validation->set_value('txt_file'),
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("whatsapp/import");
        $this->load->view('footer');
    }

    public function index()
    {

        if ($this->form_validation->run()) {
            $this->_show_upload_form();
        } else {
            $file_upload_path = APPPATH . DS . ".." . DS . "assets" . DS . "whatsapp";


            $handle = fopen($file_upload_path . DS . "WhatsAppChatwithWanaCHRsNgorongoro.txt", "r");
            if ($handle) {
                while (($line = fgets($handle)) !== FALSE) {
                    $message = $this->_extract_line_message($line);
                    $this->Whatsapp_model->create($message);
                }
                fclose($handle);
            } else {
                log_message("debug", "error opening the file.");
            }
        }
    }

    function _show_upload_form()
    {
        echo form_open_multipart("whatsapp");
        echo form_upload("userfile");
        echo form_close();
    }

    function _extract_line_message($line)
    {
        //TODO Check if all three parts are in array to avoid undefined index errors
        $first_split = explode('-', $line, 2);
        $date_sent_received = $first_split[0];

        $second_split = explode(':', $first_split[1], 2);
        $username = $second_split[0];
        $message = $second_split[1];

        $date_obj = strtotime(str_replace("/", "-", trim($date_sent_received)));
        //$date_obj = date_create_from_format('d/m/Y, H:i A',trim($date_sent_received));

        $chat = array(
            "fullname" => trim($username),
            "message" => trim($message),
            //"date_sent_received" => $date_obj->format('Y-m-d h:i'),
            "date_sent_received" => date('Y-m-d H:i:s', $date_obj),
            "user_id" => $this->user_id,
            "date_created" => date("c")
        );

        log_message("debug", json_encode($chat));
        return $chat;
    }

    function test()
    {
        //echo strtotime(str_replace("/","-","25/02/2016, 3:07 PM"));
        $date = date_create_from_format('d/m/Y, H:i A', "25/02/2016, 3:07 PM");
        echo "<pre>";
        print_r($date);
        echo $date->format('Y-m-d h:i:s');
    }


    public function message_list()
    {
        //check login
        $this->_is_logged_in();

        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        if (isset($_POST['search'])) {
            //TODO searching here
            $start_date = $this->input->post("start_date", NULL);
            $end_date = $this->input->post("end_date", NULL);
            $keyword = $this->input->post("keyword", NULL);

            //search
            $data['messages'] = $this->Whatsapp_model->search_message($start_date, $end_date, $keyword);

        } else {

            $config = array(
                'base_url' => $this->config->base_url("whatsapp/message_list"),
                'total_rows' => $this->Whatsapp_model->count_message(),
                'uri_segment' => 3,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['messages'] = $this->Whatsapp_model->find_all_message($this->pagination->per_page, $page);
            $data["links"] = $this->pagination->create_links();
        }

        //render view
        $data['title'] = "Message List";
        $this->load->view('header', $data);
        $this->load->view("whatsapp/message_list", $data);
        $this->load->view('footer');
    }

    function csv_export_data()
    {
        //check permission
        $this->has_allowed_perm($this->router->fetch_method());

        $table_name = "whatsapp";
        $query = $this->db->query("select * from {$table_name} order by id ASC ");
        $this->_force_csv_download($query, "Exported_CSV_for_" . $table_name . "_" . date("Y-m-d") . ".csv");
    }

    function _force_csv_download($query, $filename = '.csv')
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download($filename, $data);
    }

    //function to upload excel file
    function upload_txt_file_path()
    {
        $config['upload_path'] = './assets/whatsapp/';
        $config['allowed_types'] = 'txt';
        $config['max_size'] = '20000';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;

        //initialize config
        $this->upload->initialize($config);

        if (isset($_FILES['txt_file']) && !empty($_FILES['txt_file']['name'])) {
            if ($this->upload->do_upload('student_file')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $excel_path = $upload_data['full_path'];

                //POST variables
                $_POST['txt_file'] = $upload_data['file_name'];
                $_POST['txt_path'] = $upload_data['full_path'];

                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('upload_txt_file_path', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('upload_txt_file_path', "Attach txt file");
            return false;
        }
    }
}