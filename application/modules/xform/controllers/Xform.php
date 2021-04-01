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

defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * XForm Class
 *
 * @package  XForm
 * @category Controller
 * @author   Eric Beda
 * @link     http://sacids.org
 */
class Xform extends MX_Controller
{
    private $data;
    private $xFormReader;

    private $user_id;
    private $user_submitting_feedback_id;
    private $sender; //Object
    private $mobile_app_language = "swahili";

    private $objPHPExcel;

     //todo: remove this when finish implementation
    const MOBILE_SERVICE_ID = 93;
    private $sms_sender_id;
    private $api_key;
    private $user;
    private $sms_push_url;

    public function __construct()
    {
        parent::__construct();

        $this->xFormReader = new Xformreader_model();
        $this->load->library('form_auth');
        $this->load->dbforge();

        $this->user_id = $this->session->userdata("user_id");
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><i class="fa fa-warning"></i>.', '</div>');

        //$this->objPHPExcel = new PHPExcel();

        //todo: remove this when finish implementation
        $this->sms_sender_id = '15200';
        $this->api_key = '7jl4QjSEKLwBAYWa0Z5YNn5FUdnrxkeY0CYkxIt8';
        $this->user = 'afyadata@sacids.org';
        $this->sms_push_url = 'http://154.118.230.108/msdg/public/quick_sms';
    }

    function _is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
            exit;
        }
    }

    public function index()
    {
        $this->forms();
    }

    /**
     * XML submission function
     * Author : Renfrid
     *
     * @return response
     */
    public function submission()
    {
        // Form Received in openrosa server
        $http_response_code = 201;

        // Get the digest from the http header
        if (isset($_SERVER ['PHP_AUTH_DIGEST']))
            $digest = $_SERVER ['PHP_AUTH_DIGEST'];

        // server realm and unique id
        $realm = $this->config->item("realm");
        $nonce = md5(uniqid());

        // Check if there was no digest, show login
        if (empty ($digest)) {
            // populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm, $nonce);
            log_message('debug', 'exiting, digest was not found');
            exit ();
        }

        // http_digest_parse
        $digest_parts = $this->form_auth->http_digest_parse($digest);

        // username obtained from http digest
        $username = $digest_parts ['username'];

        // get user details from database
        $user = $this->User_model->find_by_username($username);
        $this->sender = $user;
        $password = $user->digest_password; // digest password
        $db_username = $user->username; // username
        $this->user_submitting_feedback_id = $user->id;
        $uploaded_filename = NULL;


        if (isset($digest_parts['language'])) {
            $this->mobile_app_language = $digest_parts['language'];
        }

        // show status header if user not available in database
        if (empty ($db_username)) {
            // populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm, $nonce);
            exit ();
        }

        // Based on all the info we gathered we can figure out what the response should be
        $A1 = $password; // digest password
        $A2 = md5("{$_SERVER['REQUEST_METHOD']}:{$digest_parts['uri']}");
        $calculated_response = md5("{$A1}:{$digest_parts['nonce']}:{$digest_parts['nc']}:{$digest_parts['cnonce']}:{$digest_parts['qop']}:{$A2}");

        // If digest fails, show login
        if ($digest_parts ['response'] != $calculated_response) {
            // populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm, $nonce);
            exit ();
        }

        // IF passes authentication
        if ($_SERVER ['REQUEST_METHOD'] === "HEAD") {
            $http_response_code = 204;
        } elseif ($_SERVER ['REQUEST_METHOD'] === "POST") {

            foreach ($_FILES as $file) {
                // File details
                $file_name = $file ['name'];

                // check file extension
                $value = explode('.', $file_name);
                $file_extension = end($value);

                $inserted_form_id = NULL;

                if ($file_extension === 'xml') {
                    // path to store xml
                    $uploaded_filename = $file_name;
                    $path = $this->config->item("form_data_upload_dir") . $file_name;
                    // insert form details in database
                    $data = array(
                        'file_name' => $file_name,
                        'user_id' => $user->id,
                        "submitted_on" => date("Y-m-d h:i:s")
                    );

                    $inserted_form_id = $this->Submission_model->create($data);
                    log_message("debug", "submission inserted => " . $inserted_form_id);

                } elseif ($file_extension == 'jpg' or $file_extension == 'jpeg' or $file_extension == 'png') {
                    // path to store images
                    $path = $this->config->item("images_data_upload_dir") . $file_name;
                    //TODO Resize image here

                } elseif ($file_extension == '3gpp' or $file_extension == 'amr') {
                    // path to store audio
                    $path = $this->config->item("audio_data_upload_dir") . $file_name;

                } elseif ($file_extension == '3gp' or $file_extension == 'mp4') {
                    // path to store video
                    $path = $this->config->item("video_data_upload_dir") . $file_name;
                }

                // upload file to the server
                move_uploaded_file($file ['tmp_name'], $path);
            }
            // call function to insert xform data in a database
            if (!$this->insert_data($uploaded_filename)) {
                $this->Submission_model->delete_submission($inserted_form_id);
                   // @unlink($path);
            }
        }

        // return response
        echo $this->_get_response($http_response_code);
    }

	public function insert_data_mig(){
		
		$path	= "/var/www/html/afyadata/live/mig-1/";
		if($handle = opendir($path)){
			$i = 0;
			while(false !== ($file = readdir($handle))){
				if('.' === $file) continue;
				if('..' === $file) continue;
				
				//$datafile = $this->config->item("form_data_upload_dir") . $file;
				$datafile = $path.$file;
        			$this->xFormReader->set_data_file($datafile);
        			$this->xFormReader->load_xml_data();

        			$statement = $this->xFormReader->get_insert_form_data_query();
        			//log_message('debug', $statement);
        			$insert_result = $this->Xform_model->insert_data($statement);
        			log_message('debug',"insert mig". $insert_result);
				echo json_encode($file.' :NEW: '.$insert_result)." \n";

				if($i++ == 200){
					sleep(1);
				}
			}
			closedir($handle);
		}

		exit();
	}
    /**
     * inserts xform into database table
     * Author : Eric Beda
     *
     * @param string $filename
     * @return Mixed
     */
    public function insert_data($filename)
    {
        //$filename = 'CHR Dalili Mifugo_2018-05-23_14-45-36.xml';
        $this->lang->load("api", $this->mobile_app_language);

        $datafile = $this->config->item("form_data_upload_dir") . $filename;

        $this->xFormReader->set_data_file($datafile);
        $this->xFormReader->load_xml_data();

        $statement = $this->xFormReader->get_insert_form_data_query();
        log_message('debug', $statement);
        $insert_result = $this->Xform_model->insert_data($statement);

        $xForm_form = $this->Xform_model->find_by_xform_id($this->xFormReader->get_table_name());

         //todo : improve this => send message
        if ($xForm_form->send_sms == 1 && $insert_result) {
            //for now just query specific table
            $result = $this->db
                ->get_where('ad_build_Sample_results_form_1589715082020', ['id' => $insert_result])->row();
            log_message("DEBUG", "result => " . json_encode($insert_result));

            //health facility
            $facility = $this->db
                ->get_where('health_facilities', ['code' => substr($result->_xf_271560175ee2e3a0fc421a63cb30724a, 0, 3)])->row();

            $phones = explode(',', $facility->phone);

            //logs
            log_message("DEBUG", "phones => " . $facility->phone);
            log_message("DEBUG", "exploded phones => " . $phones);

            foreach ($phones as $phone) {
                log_message("DEBUG", "phone => " . $phone);
                $message = 'Brucella: Majibu ya maabara ya SUA tayari, ingia katika Afyadata kuangalia';
                $this->push($phone, $message);
            }
        }

        //deals with dhis2
        if ($xForm_form->allow_dhis == 1 && $insert_result) {
            $dhis_data_elements = $this->Xform_model->get_fieldname_map($this->xFormReader->get_table_name());
            $form_data = $this->Xform_model->find_form_data_by_id($xForm_form->form_id, $insert_result);
            $form_data_array = (array)$form_data;

            foreach ($form_data_array as $key => $value) {
                if (strpos($key, '_point') !== false) {
                    $form_data_array[$key] = utf8_encode($value);
                }
            }

            $prepare_data_set_array = array();
            foreach ($dhis_data_elements as $data_element) {
                if ($data_element['dhis_data_element'] != null || $data_element['dhis_data_element'] != "") {
                    $prepare_data_set_array[$data_element['dhis_data_element']] = $form_data_array[$data_element['col_name']];
                }
            }

            $data_set_values = [
                "dataSet" => $xForm_form->dhis_data_set,
                "completeDate" => date("Y-m-d"),
                "period" => date("Yd"),
                "orgUnit" => $xForm_form->org_unit_id,
                "name" => $xForm_form->title,
                "periodType" => $xForm_form->period_type,
                'dataValues' => $prepare_data_set_array
            ];

            $this->load->model("dhis2/Dhis2_model");
            $response = $this->Dhis2_model->post_data("api/dataSets", $data_set_values);
            log_message("debug", "Dhis2 server response " . $response);
        }

        //deals with symptoms
        if ($xForm_form->has_symptoms_field == 99 && $insert_result) {
            $symptoms_column_name = $this->Xform_model->find_form_map_by_field_type($xForm_form->form_id, "DALILI")->col_name;
            log_message("debug", "symptoms column name => " . json_encode($symptoms_column_name));

            $district_column_name = $this->Xform_model->find_form_map_by_field_type($xForm_form->form_id, "DISTRICT")->col_name;
            log_message("debug", "district column name => " . json_encode($district_column_name));

            $inserted_form_data = $this->Xform_model->find_form_data_by_id($xForm_form->form_id, $insert_result);
            log_message("debug", "inserted data => " . json_encode($inserted_form_data));

            $symptoms_reported = explode(" ", $inserted_form_data->$symptoms_column_name);
            $district = $inserted_form_data->$district_column_name;

            if ($xForm_form->has_specie_type_field == 1) {
                $species_column_name = $this->Xform_model->find_form_map_by_field_type($xForm_form->form_id, "SPECIE")->col_name;
                $species_name = $inserted_form_data->$species_column_name;
            } else {
                $species_name = "binadamu";
            }
            log_message("debug", "specie => " . $species_name);

            $specie = $this->Ohkr_model->find_species_by_name($species_name);
            log_message("debug", "specie db => " . json_encode($specie));

            if ($specie) {
                $request_data = [
                    "specie_id" => $specie->id,
                    "symptoms" => $symptoms_reported
                ];

                $result = $this->Alert_model->send_post_symptoms_request(json_encode($request_data));
                $json_object = json_decode($result);

                log_message("debug", "requested_data => " . json_encode($request_data));
                log_message("debug", "results => " . $result);

                if (isset($json_object->status) && $json_object->status == 1) {
                    $detected_diseases = [];

                    foreach ($json_object->data as $disease) {
                        $ungonjwa = $this->Ohkr_model->find_by_disease_name($disease->title);

                        $detected_diseases[] = [
                            "form_id" => $this->xFormReader->get_table_name(),
                            "disease_id" => $ungonjwa->id,
                            "location" => $district,
                            "instance_id" => $this->xFormReader->get_form_data()['meta_instanceID'],
                            "date_detected" => date("Y-m-d H:i:s")
                        ];
                    }
                    $this->Ohkr_model->save_detected_diseases($detected_diseases);
                }
            }

            if (count($symptoms_reported) > 0) {
                $message_sender_name = config_item("sms_sender_id");
                $request_url_endpoint = "sms/1/text/single";

                $suspected_diseases_array = array();
                $suspected_diseases = $this->Ohkr_model->find_diseases_by_symptoms_code($symptoms_reported);

                $message = $this->lang->line("message_data_received");
                $suspected_diseases_list = $message . "<br/>";

                if ($suspected_diseases) {

                    $i = 1;
                    foreach ($suspected_diseases as $disease) {

                        $suspected_diseases_list .= $i . "." . $disease->disease_name . "\n<br/>";

                        $suspected_diseases_array[$i - 1] = array(
                            "form_id" => $this->xFormReader->get_table_name(),
                            "disease_id" => $disease->disease_id,
                            "instance_id" => $this->xFormReader->get_form_data()['meta_instanceID'],
                            "date_detected" => date("Y-m-d H:i:s"),
                            "location" => $district
                        );

                        if (ENVIRONMENT == 'development' || ENVIRONMENT == "testing" || ENVIRONMENT == "production") {
                            //get response message
                            $this->model->set_table('ohkr_response_sms');
                            $sender_msg = $this->model->get_by(['disease_id' => $disease->disease_id, 'group_id' => 4]);

                            //$sender_msg = $this->Ohkr_model->find_sender_response_message($disease->disease_id, "sender");

                            if ($sender_msg) {
                                $this->_save_msg_and_send($sender_msg->id, $this->sender->phone, $sender_msg->message,
                                    $this->sender->first_name, $message_sender_name, $request_url_endpoint);
                            }

                            $response_messages = $this->Ohkr_model->find_response_messages_and_groups($disease->disease_id,
                                str_ireplace("_", " ", $district));

                            $counter = 1;
                            if ($response_messages) {
                                foreach ($response_messages as $sms) {
                                    $this->_save_msg_and_send($sms->rsms_id, $sms->phone, $sms->message, $sms->first_name,
                                        $message_sender_name, $request_url_endpoint);
                                    $counter++;
                                }
                            }
                        }
                        $i++;
                    }

                    $this->Ohkr_model->save_detected_diseases($suspected_diseases_array);
                } else {
                    $suspected_diseases_list = $this->lang->line("message_auto_detect_disease_failed");
                }

                $feedback = array(
                    "user_id" => $this->user_submitting_feedback_id,
                    "form_id" => $this->xFormReader->get_table_name(),
                    "message" => $suspected_diseases_list,
                    "date_created" => date('Y-m-d H:i:s'),
                    "instance_id" => $this->xFormReader->get_form_data()['meta_instanceID'],
                    "sender" => "server",
                    "status" => "pending"
                );

                $this->Feedback_model->create_feedback($feedback);
            } else {
                log_message("debug", "No symptom reported");
            }
        } else {

            log_message("debug", "Form does not have symptoms field or symptoms field is not specified in " . base_url("xform/edit_form/" . $xForm_form->id));

            $feedback = array(
                "user_id" => $this->user_submitting_feedback_id,
                "form_id" => $this->xFormReader->get_table_name(),
                "message" => $this->lang->line("message_feedback_data_received"),
                "date_created" => date('Y-m-d H:i:s'),
                "instance_id" => $this->xFormReader->get_form_data()['meta_instanceID'],
                "sender" => "server",
                "status" => "pending"
            );
            $this->Feedback_model->create_feedback($feedback);
        }

        log_message("debug", "Insert => " . $insert_result);
        return $insert_result;
    }

    /**
     * @param $response_msg_id
     * @param $phone
     * @param $message
     * @param $first_name
     * @param $message_sender_name
     * @param $request_url_endpoint
     * @internal param $sms
     */
    public function _save_msg_and_send($response_msg_id, $phone, $message, $first_name, $message_sender_name, $request_url_endpoint)
    {
        $sms_to_send = array(
            "response_msg_id" => $response_msg_id,
            "phone_number" => $phone,
            "date_sent" => date("Y-m-d h:i:s"),
            "status" => "PENDING"
        );

        if ($msg_id = $this->Ohkr_model->create_send_sms($sms_to_send)) {

            $sms_text = "Ndugu " . $first_name . ",\n" . $message;
            $sms_info = array(
                "from" => $message_sender_name,
                "to" => $phone,
                "text" => $sms_text
            );


            if ($send_result = $this->Alert_model->send_alert_sms($request_url_endpoint, $sms_info)) {
                $infobip_response = json_decode($send_result);
                $message = (array)$infobip_response->messages;
                if (is_array($message)) {
                    $message = array_shift($message);
                    $sms_updates = array(
                        "status" => "SENT",
                        "date_sent" => date("Y-m-d H:i:s"),
                        "infobip_msg_id" => $message->messageId,
                        "infobip_response" => $send_result
                    );
                    $this->Alert_model->update_sms_status($msg_id, $sms_updates);
                }
            }
        }
    }

    /**
     * Header Response
     *
     * @param string $http_response_code
     *            Input string
     * @param string $response_message
     *            Input string
     * @return string response
     */
    function _get_response($http_response_code, $response_message = "Asante kwa kutuma taarifa, Tumepokea fomu yako!")
    {
        // OpenRosa Success Response
        $response = '<OpenRosaResponse xmlns="http://openrosa.org/http/response">
                    <message nature="submit_success">' . $response_message . '</message>
                    </OpenRosaResponse>';

        $content_length = sizeof($response);
        // set header response
        header("X-OpenRosa-Version:1.0");
        header("X-OpenRosa-Accept-Content-Length:" . $content_length);
        header("Date:" . date('r'), FALSE, $http_response_code);
        return $response;
    }

    /**
     * Handles authentication and lists forms for AfyaData app to consume.
     * it handles <base-url>/formList requests from ODK app.
     */
    function form_list()
    {
        // Get the digest from the http header
        if (isset($_SERVER['PHP_AUTH_DIGEST']))
            $digest = $_SERVER['PHP_AUTH_DIGEST'];

        //server realm and unique id
        $realm = $this->config->item("realm");

        $nonce = md5(uniqid());

        // If there was no digest, show login
        if (empty($digest)) {
            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm, $nonce);
            exit;
        }

        //http_digest_parse
        $digest_parts = $this->form_auth->http_digest_parse($digest);

        //username from http digest obtained
        $username = $digest_parts['username'];

        //get user details from database
        $user = $this->User_model->find_by_username($username);
        $password = $user->digest_password; //digest password
        $db_user = $user->username; //username

        //show status header if user not available in database
        if (empty($db_user)) {
            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm, $nonce);
            exit;
        }

        // Based on all the info we gathered we can figure out what the response should be
        $A1 = $password; //digest password
        $A2 = md5("{$_SERVER['REQUEST_METHOD']}:{$digest_parts['uri']}");
        $valid_response = md5("{$A1}:{$digest_parts['nonce']}:{$digest_parts['nc']}:{$digest_parts['cnonce']}:{$digest_parts['qop']}:{$A2}");

        // If digest fails, show login
        if ($digest_parts['response'] != $valid_response) {
            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm, $nonce);
            exit;
        }

        $user_groups = $this->User_model->get_user_groups_by_id($user->id);
        $user_perms = array(0 => "P" . $user->id . "P");
        $i = 1;
        foreach ($user_groups as $ug) {
            $user_perms[$i] = "G" . $ug->id . "G";
            $i++;
        }

        $forms = $this->Xform_model->get_form_list_by_perms($user_perms, 30, 0, "published", 0);

        $xml = '<xforms xmlns="http://openrosa.org/xforms/xformsList">';

        foreach ($forms as $form) {

            // used to notify if anything has changed with the form, so that it may be updated on download
            $hash = md5($form->form_id . $form->date_created . $form->filename . $form->id . $form->title . $form->last_updated);

            $xml .= '<xform>';
            $xml .= '<formID>' . $form->form_id . '</formID>';
            $xml .= '<name>' . $form->title . '</name>';
            $xml .= '<version>1.1</version>';
            $xml .= '<hash>md5:' . $hash . '</hash>';
            $xml .= '<descriptionText>' . $form->description . '</descriptionText>';
            $xml .= '<downloadUrl>' . base_url() . 'assets/forms/definition/' . $form->filename . '</downloadUrl>';
            $xml .= '</xform>';
        }
        $xml .= '</xforms>';

        $content_length = sizeof($xml);
        //set header response
        header('Content-Type:text/xml; charset=utf-8');
        header('HTTP_X_OPENROSA_VERSION:1.0');
        header("X-OpenRosa-Accept-Content-Length:" . $content_length);
        header('X-OpenRosa-Version:1.0');
        header("Date:" . date('r'), FALSE);

        echo $xml;
    }

    /**
     * Add/upload new xform and set permissions for groups or users.
     * @param string $project_id
     */
    function add_new($project_id = "")
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['title'] = $this->lang->line("heading_add_new_form");

        //project
        $project = $this->Project_model->get_project_by_id($project_id);
        if (!$project) 
            show_error("Project not exist", 500);
        
        $data['project'] = $project;
        $data['project_id'] = $project_id;

        $this->form_validation->set_rules("title", $this->lang->line("validation_label_form_title"), "required|is_unique[xforms.title]");
        $this->form_validation->set_rules("access", $this->lang->line("validation_label_form_access"), "required");

        if ($this->form_validation->run() === FALSE) {

            $users = $this->User_model->find_all();
            $groups = $this->User_model->find_user_groups();

            $group_permissions = array();

            foreach ($groups as $group) {
                $group_permissions['G' . $group->id . 'G'] = $group->name;
            }
            $data['group_perms'] = $group_permissions;

            $user_permissions = [];
            foreach ($users as $user) {
                $user_permissions['P' . $user->id . 'P'] = $user->first_name . " " . $user->last_name;
            }

            $data['user_perms'] = $user_permissions;

            if ($this->input->is_ajax_request()) {
                $this->load->view("form/add_new", $data);
            } else {
                $this->load->view('header', $data);
                $this->load->view("add_new");
                $this->load->view('footer');
            }
        } else {
            $form_definition_upload_dir = $this->config->item("form_definition_upload_dir");

            if (!empty($_FILES['userfile']['name'])) {

                $config['upload_path'] = $form_definition_upload_dir;
                $config['allowed_types'] = '*';
                $config['max_size'] = '1024';
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload("userfile")) {
                    set_flashdata(display_message($this->upload->display_errors("", ""), "error"));
                    redirect("xform/add_new/{$project_id}", 'refresh');
                } else {
                    $xml_data = $this->upload->data();
                    $filename = $xml_data['file_name'];

                    $perms = $this->input->post("perms");

                    $all_permissions = "";
                    if ($perms) {
                        $all_permissions = join(",", $perms);
                    }

                    $create_table_statement = $this->xFormReader->initialize($filename);

                    if ($this->Xform_model->find_by_xform_id($this->xFormReader->get_table_name())) {
                        @unlink($form_definition_upload_dir . $filename);
                        $this->session->set_flashdata("message", display_message("Form ID is already used, try a different one", "danger"));
                        redirect("xform/add_new/{$project_id}");
                    } else {
                        $create_table_result = $this->Xform_model->create_table($create_table_statement);

                        if ($create_table_result) {

                            $form_details = array(
                                "form_id" => $this->xFormReader->get_table_name(),
                                "jr_form_id" => $this->xFormReader->get_jr_form_id(),
                                "project_id" => $project_id,
                                "title" => $this->input->post("title"),
                                "description" => $this->input->post("description"),
                                "filename" => $filename,
                                "access" => $this->input->post("access"),
                                "push" => $this->input->post("push"),
                                "status" => 1,
                                "perms" => $all_permissions,
                                "created_by" => get_current_user_id(),
                                "created_at" => date("Y-m-d H:i:s"),      
                            );

                            //todo: Check if form is built from ODK Aggregate Build to avoid errors during initialization

                            if ($this->Xform_model->create_xform($form_details)) {
                                $this->session->set_flashdata("message", display_message($this->lang->line("form_upload_successful")));
                            } else {
                                $this->session->set_flashdata("message", display_message($this->lang->line("form_upload_failed"), "danger"));
                            }
                        } else {
                            $this->session->set_flashdata("message", display_message($create_table_statement, "danger"));
                        }

                        redirect("xform/add_new/{$project_id}");
                    }
                }
            } else {
                $this->session->set_flashdata("message", display_message($this->lang->line("form_saving_failed"), "danger"));
                redirect("xform/add_new/{$project_id}");
            }
        }
    }

    /**
     * Create functions for searchable forms
     * Author : Renfrid Ngolongolo
     */
    //list searchable form
    function searchable_form_lists()
    {
        //check if logged in
        $this->_is_logged_in();

        $this->data['title'] = "List searchable form";

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url' => $this->config->base_url("xform/searchable_form_lists"),
            'total_rows' => $this->Xform_model->count_searchable_form(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['form_list'] = $this->Xform_model->get_searchable_form_list($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        foreach ($this->data['form_list'] as $k => $value) {
            $this->data['form_list'][$k]->xform = $this->Xform_model->get_form_by_id($value->xform_id);
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("searchable_form_list");
        $this->load->view('footer');
    }

    //add new searchable form
    function add_searchable_form()
    {
        $this->data['title'] = "Add searchable form";
        $this->_is_logged_in();

        //form validation
        $this->form_validation->set_rules("form_id", 'Form name', "required");
        $this->form_validation->set_rules("search_field", 'Search field', "required");

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "xform_id" => $this->input->post("form_id"),
                "search_fields" => $this->input->post("search_field"),
                "user_id" => $this->user_id
            );
            $this->db->insert('xforms_config', $data);

            $this->session->set_flashdata("message", display_message("Searchable form added"));
            redirect("xform/searchable_form_lists", "refresh");
        }

        //populate data
        $this->data['form_list'] = $this->Xform_model->get_form_list();

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("add_searchable_form");
        $this->load->view('footer');
    }

    //function to get user level
    function get_search_field($form_id)
    {
        $form_details = $this->Xform_model->get_form_by_id($form_id);

        $table_name = $form_details->form_id;
        $table_fields = $this->Xform_model->find_table_columns($table_name);
        $field_maps = $this->_get_mapped_table_column_name($form_details->form_id);

        foreach ($table_fields as $key => $value) {
            if (key_exists($value, $field_maps)) {
                echo '<option value="' . $value . '">' . $field_maps[$value] . '</option>';
            } else {
                echo '<option value="' . $value . '">' . $value . '</option>';
            }
        }
    }

    /**
     * @param $form_id
     * @param $project_id
     */
    function edit_form($project_id, $form_id)
    {
        $this->_is_logged_in();
        $data['title'] = $this->lang->line("heading_edit_form");

        $project = $this->Project_model->get_project_by_id($project_id);

        if (!$project) {
            show_error("Project not exist", 500);
        }
        $data['project'] = $project;

        //forms
        $form = $this->Xform_model->find_by_id($form_id);
        if (!$form_id) {
            show_error("Form does not exist", 500);
        }
        $data['form'] = $form;

        // TODO
        // Search field by table name from mapping fields
        $db_table_fields = $this->Xform_model->get_fieldname_map($form->form_id);

        //table fields
        $table_fields = $this->Xform_model->find_table_columns($form->form_id);

        if (count($db_table_fields) != count($table_fields)) {
            foreach ($table_fields as $tf) {
                if ($this->Xform_model->xform_table_column_exists($form->form_id, $tf) == 0) {
                    $details = [
                        "table_name" => $form->form_id,
                        "col_name" => $tf,
                        "field_name" => $tf,
                        "field_label" => str_replace("_", " ", $tf)
                    ];
                    $this->Xform_model->create_field_name_map($details);
                }
            }
        }

        $data['table_fields'] = $this->Xform_model->get_fieldname_map($form->form_id);

        $allow_dhis2_checked = (isset($_POST['allow_dhis2'])) ? 1 : 0;

        $this->form_validation->set_rules("title", $this->lang->line("validation_label_form_title"), "required");
        $this->form_validation->set_rules("access", $this->lang->line("validation_label_form_access"), "required");

        if ($allow_dhis2_checked) {
            $this->form_validation->set_rules("data_set", $this->lang->line("validation_label_data_set"), "required");
            $this->form_validation->set_rules("org_unit_id", $this->lang->line("validation_label_org_unit_id"), "required");
            $this->form_validation->set_rules("period_type", $this->lang->line("validation_label_period_type"), "required");
        }

        if ($this->form_validation->run() === FALSE) {
            $users = $this->User_model->find_all(500);
            $groups = $this->User_model->find_user_groups();

            $available_group_permissions = [];
            $available_user_permissions = [];

            foreach ($groups as $group) {
                $available_group_permissions['G' . $group->id . 'G'] = $group->name;
            }
            $data['group_perms'] = $available_group_permissions;

            foreach ($users as $user) {
                $available_user_permissions['P' . $user->id . 'P'] = $user->first_name . " " . $user->last_name;
            }
            $data['user_perms'] = $available_user_permissions;

            $current_permissions = explode(",", $form->perms);
            $data['current_perms'] = $current_permissions;

            $this->load->view('header', $data);
            $this->load->view("edit_form", $data);
            $this->load->view('footer');
        } else {
            $hides = $this->input->post("hide[]");
            $ids = $this->input->post("ids[]");
            $labels = $this->input->post("label[]");
            $field_types = $this->input->post("field_type[]");
            $chart_use = $this->input->post("chart_use[]");
            $type_option = $this->input->post("type[]");
            $dhis2_data_element = $this->input->post("data_element[]");

            if ($form) {
                $new_perms = $this->input->post("perms");

                $new_perms_string = "";
                if (count($new_perms) > 0) {
                    $new_perms_string = join(",", $new_perms);
                }

                $new_form_details = array(
                    "title" => $this->input->post("title"),
                    "description" => $this->input->post("description"),
                    "access" => $this->input->post("access"),
                    "push" => $this->input->post("push"),
                    "perms" => $new_perms_string,
                    "last_updated" => date("c"),
                    "allow_dhis" => $allow_dhis2_checked,
                    "dhis_data_set" => $this->input->post("data_set"),
                    "period_type" => $this->input->post("period_type"),
                    "org_unit_id" => $this->input->post("org_unit_id"),
                );

                $this->db->trans_start();
                $this->Xform_model->update_form($form_id, $new_form_details);

                $mapped_fields = [];
                $i = 0;
                foreach ($labels as $key => $value) {
                    $mapped_fields[$i]["field_label"] = $value;
                    $mapped_fields[$i]["id"] = $ids[$i];
                    $mapped_fields[$i]["field_type"] = $field_types[$i];
                    $mapped_fields[$i]["chart_use"] = $chart_use[$i];
                    $mapped_fields[$i]["type"] = $type_option[$i];
                    $mapped_fields[$i]["hide"] = 0;
                    $mapped_fields[$i]["dhis_data_element"] = $dhis2_data_element[$i];

                    if (!empty($hides) && in_array($ids[$i], $hides)) {
                        $mapped_fields[$i]["hide"] = 1;
                    }
                    $i++;
                }
                $this->Xform_model->update_field_name_maps($mapped_fields);
                $this->db->trans_complete();

                if ($this->db->trans_status()) {
                    $this->session->set_flashdata("message", display_message($this->lang->line("form_update_successful")));
                } else {
                    $this->session->set_flashdata("message", display_message($this->lang->line("form_update_failed"), "warning"));
                }
                redirect("xform/edit_form/{$project_id}/{$form_id}");
            } else {
                $this->session->set_flashdata("message", $this->lang->line("unknown_error_occurred"));
                redirect("projects");
            }
        }
    }

    /**
     * @param $form_id
     * @param $project_id
     */
    function delete_form($project_id, $form_id)
    {
        $this->_is_logged_in();
        $data['title'] = 'delete form';

        $project = $this->Project_model->get_project_by_id($project_id);

        if (count($project) == 0) {
            show_error("Project not exist", 500);
        }

        //forms
        $form = $this->Xform_model->find_by_id($form_id);
        if (!$form) {
            show_error("Form does not exist", 500);
        }

        //unlink file
        if (file_exists('./assets/forms/definition/' . $form->filename))
            unlink('./assets/forms/definition/' . $form->filename);

        //DROP TABLE IF EXISTS table_name
        $this->dbforge->drop_table($form->form_id, TRUE);

        //delete form
        $result = $this->db->delete('xforms', array('id' => $form_id));

        if ($result)
            $this->session->set_flashdata('message', display_message('Form deleted', 'danger'));

        //redirect
        redirect('projects/forms/' . $project_id, 'refresh');
    }

    /**
     * @param $xform_id
     * Archives the uploaded xforms so that they do not appear at first on the form lists page
     */
    function archive_xform($xform_id)
    {
        $this->_is_logged_in();

        if (!$xform_id) {
            $this->session->set_flashdata("message", $this->lang->line("select_form_to_delete"));
            redirect("projects");
            exit;
        }

        if ($this->Xform_model->archive_form($xform_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("form_archived_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_form"), "danger"));
        }
        redirect("projects");
    }

    /**
     * @param $xform_id
     */
    function restore_from_archive($xform_id)
    {
        $this->_is_logged_in();

        if (!$xform_id) {
            $this->session->set_flashdata("message", $this->lang->line("select_form_to_delete"));
            redirect("projects");
            exit;
        }

        if ($this->Xform_model->restore_xform_from_archive($xform_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("form_restored_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_restore_form"), "danger"));
        }
        redirect("projects");
    }

        /**
     * @param $project_id
     * @param $form_id
     */
    function ussd_form_data($project_id, $form_id)
    {
        $this->_is_logged_in();

        $project = $this->Project_model->get_project_by_id($project_id);

        if (count($project) == 0) {
            show_error("Project not exist", 500);
        }
        $data['project'] = $project;

        if (!$form_id) {
            set_flashdata(display_message($this->lang->line("select_form_to_delete"), "error"));
            redirect('xform/ussd_form_data/' . $project_id . '/' . $form_id, 'refresh');
            exit;
        }

        $form = $this->Xform_model->find_by_id($form_id);

        if ($form) {
            $data['title'] = $form->title . " form";
            $data['form'] = $form;

            //data lists
            $this->model->set_table('ad_build_fao_data');
            $data['data_list'] = $this->model->order_by('submitted_at', 'DESC')->get_all();

            $this->load->view('header', $data);
            $this->load->view("ussd_form_data_details");
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata("message", display_message("Form does not exists", "danger"));
            redirect("projects/lists");
        }
    }

    /**
     * @param $project_id
     * @param $form_id
     */
    function form_data($project_id, $form_id)
    {
        $this->_is_logged_in();

        $project = $this->Project_model->get_project_by_id($project_id);

        if (!$project) {
            show_error("Project not exist", 500);
        }
        $data['project'] = $project;

        if (!$form_id) {
            set_flashdata(display_message($this->lang->line("select_form_to_delete"), "error"));
            redirect('xform/form_data/' . $project_id . '/' . $form_id, 'refresh');
            exit;
        }

        $form = $this->Xform_model->find_by_id($form_id);

        $where_condition = null;
        if (!$this->ion_auth->is_admin()) {
            $where_condition = $this->Acl_model->find_user_permissions($this->user_id, $form->form_id);
        }

        //if $_POST['export']
        //todo add a check if is idwe form
        if (isset($_POST['export'])) {
            //check if week number selected
            if ($this->input->post('week') == null) {
                set_flashdata(display_message('You should select week number', 'danger'));
                redirect('xform/form_data/' . $project_id . '/' . $form_id, 'refresh');
            }

            //week number
            $week_number = $this->input->post('week');
            $this->export_IDWE($form_id, $week_number);
        }

        if ($form) {
            $data['title'] = $form->title . " form";
            $data['form'] = $form;
            $data['table_fields'] = $this->Xform_model->find_table_columns($form->form_id);
            $data['field_maps'] = $this->_get_mapped_table_column_name($form->form_id);

            $mapped_fields = array();
            foreach ($data['table_fields'] as $key => $column) {
                if (array_key_exists($column, $data['field_maps'])) {
                    $mapped_fields[$column] = $data['field_maps'][$column];
                } else {
                    $mapped_fields[$column] = $column;
                }
            }

            $custom_maps = $this->Xform_model->get_fieldname_map($form->form_id);

            foreach ($custom_maps as $f_map) {
                if (array_key_exists($f_map['col_name'], $mapped_fields)) {
                    $mapped_fields[$f_map['col_name']] = $f_map['field_label'];
                }
            }

            $data['mapped_fields'] = $mapped_fields;

            $config = array(
                'base_url' => $this->config->base_url("xform/form_data/" . $project_id . '/' . $form_id),
                'total_rows' => $this->Xform_model->count_all_records($form->form_id, $where_condition),
                'uri_segment' => 5,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            $data['form_id'] = $form->form_id;

            //Prevents the filters from applying to a different form
            if ($this->session->userdata("filters_form_id") != $form_id) {
                $this->session->unset_userdata("filters_form_id");
                $this->session->unset_userdata("form_filters");
            }

            if (isset($_POST["apply"]) || $this->session->userdata("form_filters")) {
                if (!isset($_POST["apply"])) {
                    $selected_columns = $this->session->userdata("form_filters");
                } else {
                    $selected_columns = $_POST;
                    $selected_columns = array('id' => "ID") + $selected_columns;

                    unset($selected_columns['apply']);
                    $this->session->set_userdata("filters_form_id", $form_id);
                    $this->session->set_userdata(array("form_filters" => $selected_columns));
                }
                $data['selected_columns'] = $selected_columns;
                $data['form_data'] = $this->Xform_model->find_form_data_by_fields($form->form_id, $selected_columns, $this->pagination->per_page, $page, $where_condition);
            } else {
                $data['form_data'] = $this->Xform_model->find_form_data($form->form_id, $this->pagination->per_page, $page, $where_condition);
            }

            $data["links"] = $this->pagination->create_links();

            $this->load->view('header', $data);
            $this->load->view("form_data_details");
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata("message", display_message("Form does not exists", "danger"));
            redirect("projects/lists");
        }
    }

    /**
     * Author: Renfrid
     * Export form data to excel
     *
     * @param null $form_id
     */
    function excel_export_form_data($form_id)
    {
        $where_condition = null;
        if (!$this->ion_auth->is_admin()) {
            $where_condition = $this->Acl_model->find_user_permissions($this->user_id, $form_id);
        }

        if ($this->session->userdata("form_filters")) {
            $form_filters = $this->session->userdata("form_filters");
            $serial = 0;
            foreach ($form_filters as $column_name) {
                $inc = 1;
                $column_title = $this->xFormReader->getColumnLetter($serial);
                $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_title . $inc, $column_name);
                $serial++;
            }
            $form_data = $this->Xform_model->find_form_data_by_fields($form_id, $form_filters, 5000, 0, $where_condition);
        } else {
            //table fields
            $table_fields = $this->Xform_model->find_table_columns($form_id);
            $field_maps = $this->_get_mapped_table_column_name($form_id);

            $mapped_fields = array();
            foreach ($table_fields as $key => $column) {
                if (array_key_exists($column, $field_maps)) {
                    $mapped_fields[$column] = $field_maps[$column];
                } else {
                    $mapped_fields[$column] = $column;
                }
            }

            $custom_maps = $this->Xform_model->get_fieldname_map($form_id);
            foreach ($custom_maps as $f_map) {
                if (array_key_exists($f_map['col_name'], $mapped_fields)) {
                    $mapped_fields[$f_map['col_name']] = $f_map['field_label'];
                }
            }

            $serial = 0;
            foreach ($mapped_fields as $key => $column) {
                $inc = 1;
                $column_title = $this->xFormReader->getColumnLetter($serial);
                if (array_key_exists($column, $field_maps))
                    $column_name = $field_maps[$column];
                else
                    $column_name = $column;

                $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_title . $inc, $column_name);
                $serial++;
            }
            $form_data = $this->Xform_model->find_form_data($form_id, 5000, 0, $where_condition);
        }

        $inc = 2;
        foreach ($form_data as $data) {
            $serial = 0;
            foreach ($data as $key => $entry) {
                $column_title = $this->xFormReader->getColumnLetter($serial);
                if (preg_match('/(\.jpg|\.png|\.bmp)$/', $entry)) {
                    $column_value = '';
                } else {
                    $column_value = $entry;
                }

                $this->objPHPExcel->getActiveSheet()->setCellValue($column_title . $inc, $column_value);
                $serial++;
            }
            $inc++;
        }

        //name the worksheet
        $this->objPHPExcel->getActiveSheet()->setTitle("Form Data");

        $filename = "Exported_" . $form_id . "_" . date("Y-m-d") . ".xlsx"; //save our workbook as this file name

        //header
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", FALSE);
        header("Pragma: no-cache");
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        ob_end_clean();

        $objWriter->save('php://output');
    }

    //export csv data
    function csv_export_form_data($form_id)
    {

        // file name
        $filename = "Exported_" . $form_id . "_" . date("Ymd") . ".csv"; //save our workbook as this file name

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $where_condition = null;
        if (!$this->ion_auth->is_admin()) {
            $where_condition = $this->Acl_model->find_user_permissions($this->user_id, $form_id);
        }

        //table fields
        $table_fields = $this->Xform_model->find_table_columns($form_id);
        $field_maps = $this->_get_mapped_table_column_name($form_id);

        $mapped_fields = array();
        foreach ($table_fields as $key => $column) {
            if (array_key_exists($column, $field_maps)) {
                $mapped_fields[$column] = $field_maps[$column];
            } else {
                $mapped_fields[$column] = $column;
            }
        }

        $custom_maps = $this->Xform_model->get_fieldname_map($form_id);
        foreach ($custom_maps as $f_map) {
            if (array_key_exists($f_map['col_name'], $mapped_fields)) {
                $mapped_fields[$f_map['col_name']] = $f_map['field_label'];
            }
        }

        $header = array();

        $serial = 0;
        foreach ($mapped_fields as $key => $column) {
            if (array_key_exists($column, $field_maps))
                $column_name = $field_maps[$column];
            else
                $column_name = $column;

            array_push($header, $column_name);

            $serial++;
        }

        // file creation
        $file = fopen('php://output', 'w');

        fputcsv($file, $header);

        //deals with data
        $form_data = $this->Xform_model->find_form_data($form_id, 5000, 0, $where_condition);

        foreach ($form_data as $data) {
            fputcsv($file, (array)$data);
        }
        fclose($file);
        exit;
    }


    //function to export
    function export_submission_form()
    {
        //variable html1
        $html1 = '';

        // Set some content to print
        $html1 .= "SACIDS TANZANIA\r";
        $html1 .= "SUBMISSION FORM REPORT\r";

        // Set document properties
        $this->objPHPExcel->getProperties()->setCreator("Renfrid Ngolongolo")
            ->setLastModifiedBy("Renfrid Ngolongolo")
            ->setTitle("Sacids Tanzania")
            ->setSubject("Submission Form")
            ->setDescription("Submission Form Report")
            ->setKeywords("Submission Form")
            ->setCategory("Submission Form");

        //activate worksheet number 1
        $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $html1);
        $this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
        $this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);

        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
            array('font' => array("bold" => true))
        );
        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);

        // Add some data
        $this->objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'S/n')
            ->setCellValue('B2', 'UserId')
            ->setCellValue('C2', 'Name')
            ->setCellValue('D2', 'Phone')
            ->setCellValue('E2', 'Filename')
            ->setCellValue('F2', 'Submitted At');

        //set column dimensions
//        //$this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
//        $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
//        $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
//        $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
//        $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        // set headers
        $header = 'A2:F2';
        $header_style = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '83C9FC')

            ),
            'font' => array(
                'bold' => false,
                'size' => '12',
                'color' => array('rgb' => '000000')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $this->objPHPExcel->getActiveSheet()->getStyle($header)->applyFromArray($header_style);

        //submission list
        $this->model->set_table('submission_form');
        $submission_list = $this->model->order_by('id', 'DESC')->get_all();

        $serial = 1;
        $inc = 3;
        foreach ($submission_list as $value) {
            $this->model->set_table('users');
            $user = $this->model->get_by(array('id' => $value->user_id));

            if ($user) {
                $name = $user->first_name . ' ' . $user->last_name;
                $phone = $user->phone;
            } else {
                $name = '';
                $phone = '';
            }

            //data
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $inc, $serial);
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $inc, $value->user_id);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $inc, $name);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $inc, $phone);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $inc, $value->file_name);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $inc, $value->submitted_on);
            $inc++;
            $serial++;
        }

        // Rename worksheet
        $this->objPHPExcel->getActiveSheet()->setTitle('SUBMISSION FORM REPORT');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="submission-form.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    //exporting Zanzibar IDWE
    public function export_IDWE($form_id, $week_number)
    {
        //form details
        $this->model->set_table('xforms');
        $xform = $this->model->get_by('id', $form_id);

        //table fields
        $table_fields = $this->Xform_model->find_table_columns($xform->form_id);

        $columns = count($table_fields);

        $last_column = $this->xFormReader->columnLetter($columns);

        //variable html1
        $html1 = '';

        // Set some content to print
        $html1 .= "INFECTIOUS DISEASE WEEK ENDING REPORT (IDWE)\r";
        $html1 .= $week_number . "th WK  BY HEALTH FACILITIES AND DISTRICTS IN ZANZIBAR.\r";

        // Set document properties
        $this->objPHPExcel->getProperties()
            ->setCreator("Sacids")
            ->setLastModifiedBy("Renfrid")
            ->setTitle("AfyaData IDWE Report")
            ->setSubject("Zanzibar IDWE")
            ->setDescription("Infectious Disease Week Ending Report")
            ->setKeywords("IDWE, Zanzibar")
            ->setCategory("IDWE REPORT");

        //activate worksheet number 1
        $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $html1);
        $this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last_column . '1');
        $this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);

        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
            array('font' => array("bold" => true))
        );
        $this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);


        //Header Columns
        $this->objPHPExcel->getActiveSheet()->mergeCells('A3:A6');
        $this->objPHPExcel->getActiveSheet()->setCellValue('A3', 'Week Number');
        $this->objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setTextRotation(90);

        $this->objPHPExcel->getActiveSheet()->mergeCells('B3:B6');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B3', 'Year');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setTextRotation(90);

        $this->objPHPExcel->getActiveSheet()->mergeCells('C3:C6');
        $this->objPHPExcel->getActiveSheet()->setCellValue('C3', 'Region');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setTextRotation(90);

        $this->objPHPExcel->getActiveSheet()->mergeCells('D3:D6');
        $this->objPHPExcel->getActiveSheet()->setCellValue('D3', 'District');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setTextRotation(90);

        $this->objPHPExcel->getActiveSheet()->mergeCells('E3:E6');
        $this->objPHPExcel->getActiveSheet()->setCellValue('E3', 'S/N');

        $this->objPHPExcel->getActiveSheet()->mergeCells('F3:F6');
        $this->objPHPExcel->getActiveSheet()->setCellValue('F3', 'Health Facilities');
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setTextRotation(90);

        $this->objPHPExcel->getActiveSheet()->freezePane('G7');

        $diseases = array(
            'Malaria',
            'Cholera',
            'Bloody Diarrhoea',
            'Animal Bites',
            'Measles',
            'CS Meningitis',
            'Yellow Fever',
            'AFP',
            'Dengue Fever',
            'Neonatal Tetanus',
            'Plague',
            'Rabies',
            'Small Pox',
            'Trypanosomiasis',
            'Viral Haemorrhagic Fevers',
            'Keratoconjuctivitis',
            'Human Influenza Sari',
            'Anthrax'
        );

        $d = 0;

        for ($i = 6, $c = 0; $i < 150; $i++, $c++) {

            if (!($c % 8)) {
                $r = $this->xFormReader->columnLetter($i) . '3:' . $this->xFormReader->columnLetter($i + 7) . '3';
                $this->objPHPExcel->getActiveSheet()->mergeCells($r);
                $this->objPHPExcel->getActiveSheet()->setCellValue($this->xFormReader->columnLetter($i) . '3', $diseases[$d]);
                //echo " " . $c . ":" . $d;
                $d++;

                if (!($c % 4)) {

                    for ($k = 0; $k < 2; $k++) {
                        $r = $this->xFormReader->columnLetter($i + $k * 4) . '4:' . $this->xFormReader->columnLetter($i + $k * 4 + 3) . '4';
                        $this->objPHPExcel->getActiveSheet()->mergeCells($r);
                        $v = ($k % 2) ? ' > 5 yrs ' : ' < 5 yrs';
                        $this->objPHPExcel->getActiveSheet()->setCellValue($this->xFormReader->columnLetter($i + $k * 4) . '4', $v);

                    }
                    //$nne .= '<td colspan="4">  < 5 yrs </td><td colspan="4">  > 5 yrs </td>';

                    if (!($c % 2)) {

                        for ($k = 0; $k < 4; $k++) {
                            $r = $this->xFormReader->columnLetter($i + $k * 2) . '5:' . $this->xFormReader->columnLetter($i + $k * 2 + 1) . '5';
                            $this->objPHPExcel->getActiveSheet()->mergeCells($r);
                            $v = ($k % 2) ? 'C' : 'D';
                            $this->objPHPExcel->getActiveSheet()->setCellValue($this->xFormReader->columnLetter($i + $k * 2) . '5', $v);
                        }
                    }

                }
            }

            $v = ($c % 2) ? 'F' : 'M';
            $this->objPHPExcel->getActiveSheet()->setCellValue($this->xFormReader->columnLetter($i) . '6', $v);
        }


        // get values from DB
        $this->model->set_table($xform->form_id);
        $this->model->order_by('_xf_da0f48ffc452923e77a8c70e393ed5ac', 'ASC');
        $this->model->order_by('_xf_0c37672a5ed28b81b30d37d52b20f57e', 'ASC');
        $this->model->order_by('_xf_3b4caf4273007b260d666188609c6e2a', 'ASC');
        $data = $this->model->as_array()->get_many_by('_xf_20de688d974183449850b0d32a15de47', $week_number);

        $idwe_data = array();
        $sn = 1;
        foreach ($data as $row) {
            $c = 0;
            $tmp = array();
            foreach ($row as $k => $v) {
                if ($c == 0) {
                    array_push($tmp, $row['_xf_20de688d974183449850b0d32a15de47']);
                    array_push($tmp, date('Y', strtotime($row['_xf_1e0b70ceccc8a5457221fb938ee70caf'])));
                    array_push($tmp, ucfirst(str_replace('_', ' ', $row['_xf_da0f48ffc452923e77a8c70e393ed5ac'])));
                    array_push($tmp, ucfirst(str_replace('_', ' ', $row['_xf_0c37672a5ed28b81b30d37d52b20f57e'])));
                    array_push($tmp, $sn++);
                    array_push($tmp, ucfirst(str_replace('_', ' ', $row['_xf_3b4caf4273007b260d666188609c6e2a'])));
                }
                //print data
                if ($c > 6) {
                    if (substr($k, 0, 4) == '_xf_') array_push($tmp, $v);
                }
                $c++;
            }
            array_push($idwe_data, $tmp);
        }

        $this->objPHPExcel->getActiveSheet()->fromArray($idwe_data, 0, 'A7', true);

        // set headers
        $header = 'A3:ET6';
        $header_style = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '83C9FC')

            ),
            'font' => array(
                'bold' => false,
                'size' => '12',
                'color' => array('rgb' => '000000')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $this->objPHPExcel->getActiveSheet()->getStyle($header)->applyFromArray($header_style);

        // set boarders
        $borders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $c = sizeof($idwe_data) + 6;
        $range = 'A3:ET' . $c;
        $this->objPHPExcel->getActiveSheet()->getStyle($range)->applyFromArray($borders);

        // Rename worksheet
        $this->objPHPExcel->getActiveSheet()->setTitle('FORM REPORT');

        $filename = date("Y") . "_WEEK_" . $week_number . ".xlsx"; //save our workbook as this file name

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    //get health Facility name
    function get_health_facility_details($username = null)
    {
        if ($username != null) {
            $user = $this->User_model->find_by_username($username);

            if ($user->facility != null) {
                $facility = $this->Facilities_model->get_facility_by_id($user->facility);

                if ($facility)
                    return $facility->name;
                else
                    return '';
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    //get health Facility name
    function get_district_details($username = null)
    {
        if ($username != null) {
            $user = $this->User_model->find_by_username($username);

            if ($user->district != null) {
                $this->model->set_table('district');
                $district = $this->model->get_by('id', $user->district);

                if ($district)
                    return $district->name;
                else
                    return '';
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    /**
     * @param null $xform_id
     */
//    function csv_export_form_data($xform_id = NULL)
//    {
//        if ($xform_id == NULL) {
//            $this->session->set_flashdata("message", display_message("You must select a form", "danger"));
//            redirect("projects");
//        }
//        $table_name = $xform_id;
//        $query = $this->db->query("select * from {$table_name} order by id ASC ");
//        $this->_force_csv_download($query, "Exported_CSV_for_" . $table_name . "_" . date("Y-m-d") . ".csv");
//    }

    /**
     * @param $query
     * @param string $filename
     */
//    function _force_csv_download($query, $filename = '.csv')
//    {
//        $this->load->dbutil();
//        $this->load->helper('file');
//        $this->load->helper('download');
//        $delimiter = ",";
//        $newline = "\r\n";
//        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
//        force_download($filename, $data);
//    }

    /**
     * @param null $xform_id
     */
    function xml_export_form_data($xform_id = NULL)
    {
        if ($xform_id == NULL) {
            $this->session->set_flashdata("message", display_message("You must select a form", "danger"));
            redirect("projects");
        }

        $table_name = $xform_id;
        $query = $this->db->query("select * from {$table_name} order by id ASC ");
        $this->_force_xml_download($query, "Exported_CSV_for_" . $table_name . "_" . date("Y-m-d") . ".xml");
    }

    /**
     * @param $query
     * @param string $filename
     */
    function _force_xml_download($query, $filename = '.xml')
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $config = array(
            'root' => 'afyadata',
            'element' => 'form_data',
            'newline' => "\n",
            'tab' => "\t"
        );
        $data = $this->dbutil->xml_from_result($query, $config);
        force_download($filename, $data);
    }

    /**
     * @param $form_id
     */
    function map_fields($form_id)
    {
        if (!$form_id) {
            set_flashdata(display_message("You must select a form", "danger"));
            redirect("projects");
        }

        $this->form_validation->set_rules("save", "Save changes", "required");

        if ($this->form_validation->run() == FALSE) {
            $data['form_id'] = $form_id;
            $data['field_maps'] = $field_maps = $this->Xform_model->get_fieldname_map($form_id);

            $this->load->view('header', $data);
            $this->load->view("map_form_fields");
            $this->load->view('footer');
        } else {
            $fields = $this->input->post();
            unset($fields['save']);
            $this->Xform_model->update_field_map_labels($form_id, $fields);
            $this->session->set_flashdata("message", display_message("Field mapping successfully updated"));
            redirect("xform/map_fields/" . $form_id, "refresh");
        }
    }

    /**
     * @param $form_id
     * @return array
     */
    function _get_mapped_table_column_name($form_id)
    {
        if (!$form_id)
            $form_id = "ad_build_week_report_skolls_b_1767716170";

        $this->xFormReader->set_table_name($form_id);
        $map = $this->xFormReader->get_field_map();

        $form_details = $this->Feedback_model->get_form_details($form_id);

        $file_name = $form_details->filename;
        $this->xFormReader->set_defn_file($this->config->item("form_definition_upload_dir") . $file_name);
        $this->xFormReader->load_xml_definition($this->config->item("xform_tables_prefix"));

        $form_definition = $this->xFormReader->get_defn();
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

    /**
     * @param $project_id
     * @param $xform_id
     * Deletes as single or multiple entries for a given form table and id(s)
     */
    function delete_entry($project_id, $xform_id)
    {
        $this->form_validation->set_rules("entry_id[]", "Entry ID", "required");
        if ($this->form_validation->run() === FALSE) {
            $this->form_data($xform_id);
        } else {
            $table_name = $this->input->post("table_name");
            $entry_ids = $this->input->post("entry_id");
            $deleted_entry_count = 0;
            foreach ($entry_ids as $entry_id) {
                //TODO Implement delete media files too.
                if ($this->Xform_model->delete_form_data($table_name, $entry_id)) {
                    $deleted_entry_count++;
                }
            }
            $message = ($deleted_entry_count == 1) ? "entry" : "entries";
            $this->session->set_flashdata("message", display_message($deleted_entry_count . " " . $message . " deleted successfully"));
            redirect("xform/form_data/" . $project_id . '/' . $xform_id, "refresh");
        }
    }

    public function form_overview($xform_id)
    {
        $data['form'] = $this->Xform_model->find_by_xform_id($xform_id);
        $data['title'] = "Overview {$data['form']->title} Form";

        $db_columns = $this->Xform_model->find_all_field_name_maps($data['form']->form_id, 0);
        $date_column = "meta_start"; //todo used mapping table to get date column name else prompt user to mark date column name
        $gps_latitude_column = NULL;
        $gps_longitude_column = NULL;
        $date_column_set_automatically = FALSE;

        if ($db_columns) {
            $selected_columns = [];

            $data['selected_columns'] = [];
            $i = 0;
            foreach ($db_columns as $c) {
                if ($c->hide != 1) {
                    $data['selected_columns'][$i] = (!empty($c->field_label)) ? $c->field_label : $c->field_name;
                    $selected_columns[$c->col_name] = $c->col_name;

                    $pattern = "/tarehe|date/i";
                    if ((preg_match($pattern, $c->field_label) || preg_match($pattern, $c->field_name) && !$date_column_set_automatically)) {
                        $date_column = $c->col_name;
                        $date_column_set_automatically = TRUE;
                    }
                }

                $gps_latitude_pattern = "/GPS_lat|_lat|latitude/i";
                if ((preg_match($gps_latitude_pattern, $c->field_label) || preg_match($gps_latitude_pattern, $c->field_name))) {
                    $gps_latitude_column = $c->col_name;
                }

                $gps_longitude_pattern = "/GPS_lng|_lng|longitude/i";
                if ((preg_match($gps_longitude_pattern, $c->field_label) || preg_match($gps_longitude_pattern, $c->field_name))) {
                    $gps_longitude_column = $c->col_name;
                }
                $i++;
            }
            $data['form_data'] = $this->Xform_model->find_form_data_by_fields($data['form']->form_id, $selected_columns, 10);
        } else {
            $data['table_fields'] = $this->Xform_model->find_table_columns($data['form']->form_id);
            $data['field_maps'] = $this->_get_mapped_table_column_name($data['form']->form_id);

            $data['mapped_fields'] = array();
            foreach ($data['table_fields'] as $key => $column) {
                if (array_key_exists($column, $data['field_maps'])) {
                    $data['mapped_fields'][$column] = $data['field_maps'][$column];
                } else {
                    $data['mapped_fields'][$column] = $column;
                }
            }
            $data['form_data'] = $this->Xform_model->find_form_data($data['form']->form_id, 10);
        }

        if ($gps_latitude_column != NULL && $gps_longitude_column != NULL) {
            $data['lat_column'] = $gps_latitude_column;
            $data['lng_column'] = $gps_longitude_column;
            $data['map_data'] = $this->Xform_model->find_form_data_by_fields($data['form']->form_id, [$gps_latitude_column => 1, $gps_longitude_column => 1], 100);
        }

        $current_year_submissions = $this->Xform_model->find_submissions_count_by_duration($data['form']->form_id, $date_column, "year");
        $submissions = $this->Xform_model->find_submissions_count_by_duration($data['form']->form_id, $date_column, "last7days");

        $categories = array();
        $series = array();
        $i = 0;
        foreach ($submissions as $submission) {
            $categories[$i] = $submission->$date_column;
            $series[$i] = $submission->submissions_count;
            $i++;
        }
        $data['categories'] = json_encode($categories);
        $data['series'] = array(
            "name" => "Data submissions",
            "series" => str_replace('"', "", json_encode($series))
        );
        $data['report_title'] = "Last 7 Days submissions";

        $current_year_categories = array();
        $current_year_series = array();
        $ci = 0;
        foreach ($current_year_submissions as $submission) {
            $categories[$ci] = $submission->$date_column;
            $series[$ci] = $submission->submissions_count;
            $ci++;
        }
        $data['current_year_categories'] = json_encode($current_year_categories);
        $data['current_year_series'] = array(
            "name" => "Data submissions",
            "series" => str_replace('"', "", json_encode($current_year_series))
        );

        $data['current_year_report_title'] = date("Y") . " submissions";

        $data['recent_feedback'] = $this->Feedback_model->find_by_xform_id($data['form']->form_id, 10);
        $data['load_map'] = TRUE;

        $this->load->view("header", $data);
        $this->load->view("form_overview", $data);
        $this->load->view("footer", $data);
    }

       //push message
    function push($recipients, $message)
    {
        $date_time = date('Y-m-d H:i:s');
        $message = array(
            'recipients' => $recipients,
            'message' => $message,
            'datetime' => $date_time,
            'sender_id' => $this->sms_sender_id,
            'mobile_service_id' => self::MOBILE_SERVICE_ID
        );

        $post_data = array('data' => json_encode($message), 'datetime' => $date_time);
        log_message("DEBUG", json_encode($post_data));
        echo $post_data['data'];

        if (!is_array($post_data)) {
            log_message("error", "Data received is not array");
            return FALSE;
        }

        //HASH the JSON with the generated user API key using SHA-256 method.
        $hash = hash_hmac('sha256', $post_data['data'], $this->api_key, TRUE);

        $http_header = array(
            'X-Auth-Request-Hash:' . base64_encode($hash),
            'X-Auth-Request-Id:' . $this->user,
            'X-Auth-Request-Type:api'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->sms_push_url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        //echo "http response code " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
        log_message("info", "http response code " . curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);

        print_r($response);
    }
}
