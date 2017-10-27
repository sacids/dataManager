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

class XmlElement
{
    var $name;
    var $attributes;
    var $content;
    var $children;
}

/**
 * XForm Class
 *
 * @package  XForm
 * @category Controller
 * @author   Eric Beda
 * @link     http://sacids.org
 */
class Xform extends CI_Controller
{
    private $form_defn;
    private $form_data;
    private $xml_defn_filename;
    private $xml_data_filename;
    private $table_name;
    private $jr_form_id;
    private $xarray;

    private $user_id;
    private $user_submitting_feedback_id;
    private $sender; //Object

    private $objPHPExcel;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'Xform_model',
            'User_model',
            'Feedback_model',
            'facilities/Facilities_model',
            'Submission_model',
            'Ohkr_model',
            'model',
            'Alert_model'
        ));

        $this->load->library('form_auth');
        $this->load->library('db_exp');
        $this->load->library('xform_comm');
        $this->user_id = $this->session->userdata("user_id");
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><i class="fa fa-warning"></i>.', '</div>');

        $this->objPHPExcel = new PHPExcel();
    }

    public function index()
    {
        $this->forms();
    }

    /**
     * List all available forms
     */
    function forms()
    {
        $this->_is_logged_in();

        $data['title'] = $this->lang->line("heading_form_list");

        if (!$this->input->post("search")) {
            $config = array(
                'base_url'    => $this->config->base_url("xform/forms"),
                'total_rows'  => $this->Xform_model->count_all_xforms("published"),
                'uri_segment' => 3,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            if ($this->ion_auth->is_admin()) {
                $data['forms'] = $this->Xform_model->get_form_list(NULL, $this->pagination->per_page, $page, "published");
            } else {
                $data['forms'] = $this->Xform_model->get_form_list($this->user_id, $this->pagination->per_page, $page, "published");
            }
            $data["links"] = $this->pagination->create_links();

        } else {
            $form_name = $this->input->post("name", NULL);
            $access = $this->input->post("access", NULL);
            $status = $this->input->post("status", NULL);

            if ($this->ion_auth->is_admin()) {
                $forms = $this->Xform_model->search_forms(NULL, $form_name, $access, $status);
            } else {
                $forms = $this->Xform_model->search_forms($this->user_id, $form_name, $access, $status);
            }

            if ($forms) {
                $this->session->set_flashdata("message", display_message("Found " . count($forms) . " matching forms"));
                $data['forms'] = $forms;
            }
        }

        $this->load->view('header', $data);
        $this->load->view("form/index");
        $this->load->view('footer');
    }

    function _is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
            exit;
        }
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
        // show status header if user not available in database
        if (empty ($db_username)) {
            // populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm, $nonce);
            log_message('debug', 'username is not available');
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
            log_message('debug', 'Digest does not match');
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
                        'file_name'    => $file_name,
                        'user_id'      => $user->id,
                        "submitted_on" => date("Y-m-d h:i:s")
                    );


                    $inserted_form_id = $this->Submission_model->create($data);

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
            if (!$this->_insert($uploaded_filename)) {
                if ($this->Submission_model->delete_submission($inserted_form_id))
                    @unlink($path);
            }
        }

        // return response
        $this->get_response($http_response_code);
    }

    /**
     * inserts xform into database table
     * Author : Eric Beda
     *
     * @param string $filename
     * @return Mixed
     */
    public function _insert($filename)
    {
        // call forms
        $this->set_data_file($this->config->item("form_data_upload_dir") . $filename);
        $this->load_xml_data();

        // get mysql statement used to insert form data into corresponding table

        $statement = $this->get_insert_form_data_query();
        $result = $this->Xform_model->insert_data($statement);

        if ($result && isset($this->form_data['Dalili_Dalili'])) {
            $symptoms_reported = explode(" ", $this->form_data['Dalili_Dalili']);
            // taarifa_awali_Wilaya is the database field name in the mean time
            $district = $this->form_data['taarifa_awali_Wilaya'];

            $specie_id = 1; //binadamu

            $request_data = [
                "specie_id" => $specie_id,
                "symptoms"  => $symptoms_reported
            ];

            $result = $this->Alert_model->send_post_symptoms_request(json_encode($request_data));
            $json_object = json_decode($result);

            if (isset($json_object->status) && $json_object->status == 1) {
                $detected_diseases = [];

                foreach ($json_object->data as $disease) {
                    $ungonjwa = $this->Ohkr_model->find_by_disease_name($disease->title);

                    $detected_diseases[] = [
                        "form_id"       => $this->table_name,
                        "disease_id"    => $ungonjwa->id,
                        "location"      => $district,
                        "instance_id"   => $this->form_data['meta_instanceID'],
                        "date_detected" => date("Y-m-d H:i:s")
                    ];
                }
                $this->Ohkr_model->save_detected_diseases($detected_diseases);
            } else {
                //todo do something when no disease found
            }

            if (count($symptoms_reported) > 0) {
                $message_sender_name = "AfyaData";
                $request_url_endpoint = "sms/1/text/single";

                $suspected_diseases_array = array();
                $suspected_diseases = $this->Ohkr_model->find_diseases_by_symptoms_code($symptoms_reported);

                $suspected_diseases_list = "Tumepokea fomu yako, kutokana na taarifa ulizotuma haya ndiyo magonjwa yanayodhaniwa ni:\n<br/>";
                //$suspected_diseases_list = "We received your information, according to submitted data suspected disease might be:\n<br/>";

                if ($suspected_diseases) {

                    $i = 1;
                    foreach ($suspected_diseases as $disease) {

                        $suspected_diseases_list .= $i . "." . $disease->disease_name . "\n<br/>";

                        $suspected_diseases_array[$i - 1] = array(
                            "form_id"       => $this->table_name,
                            "disease_id"    => $disease->disease_id,
                            "instance_id"   => $this->form_data['meta_instanceID'],
                            "date_detected" => date("Y-m-d H:i:s"),
                            "location"      => $district
                        );

                        if (ENVIRONMENT == 'development' || ENVIRONMENT == "testing") {
                            $sender_msg = $this->Ohkr_model->find_sender_response_message($disease->disease_id, "sender");

                            if ($sender_msg) {
                                $this->_save_msg_and_send($sender_msg->rsms_id, $this->sender->phone, $sender_msg->message,
                                    $this->sender->first_name, $message_sender_name, $request_url_endpoint);
                            }

                            $response_messages = $this->Ohkr_model->find_response_messages_and_groups($disease->disease_id,
                                $district);

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
                    $suspected_diseases_list = "Tumepokea taarifa, Hatukuweza kudhania ugonjwa kutokana na taarifa ulizotuma kwa sasa,
					tafadhali wasiliana na wataalam wetu kwa msaada zaidi";
                    //$suspected_diseases_list = "We received your information, but we could not suspect any disease with specified symptoms.
                    //Please contact with our team for more details.";

                    log_message("debug", "Could not find disease with the specified symptoms");
                }

                $feedback = array(
                    "user_id"      => $this->user_submitting_feedback_id,
                    "form_id"      => $this->table_name,
                    "message"      => $suspected_diseases_list,
                    "date_created" => date('Y-m-d H:i:s'),
                    "instance_id"  => $this->form_data['meta_instanceID'],
                    "sender"       => "server",
                    "status"       => "pending"
                );
                $this->Feedback_model->create_feedback($feedback);
            } else {
                log_message("debug", "No symptom reported");
            }
        } else {
            $feedback = array(
                "user_id"      => $this->user_submitting_feedback_id,
                "form_id"      => $this->table_name,
                "message"      => "Asante kwa kutuma taarifa, Tumepokea fomu yako.",
                "date_created" => date('Y-m-d H:i:s'),
                "instance_id"  => $this->form_data['meta_instanceID'],
                "sender"       => "server",
                "status"       => "pending"
            );
            $this->Feedback_model->create_feedback($feedback);
            log_message("debug", "Dalili_Dalili index is not set implement dynamic way of getting dalili field");
        }
        return $result;
    }

    /**
     * @param $filename
     */
    public function set_data_file($filename)
    {
        $this->xml_data_filename = $filename;
    }

    /**
     * sets form_data variable to an array containing all fields of a filled xform file submitted
     * Author : Eric Beda
     */
    private function load_xml_data()
    {
        // get submitted file
        $file_name = $this->get_data_file();

        // load file into a string
        $xml = file_get_contents($file_name);

        // convert string into an object
        $rxml = $this->xml_to_object($xml);

        // array to hold values and field names;
        $this->form_data = array(); // TODO move to constructor
        $prefix = $this->config->item("xform_tables_prefix");
        //log_message("debug", "Table prefix " . $prefix);

        // set table name
        $this->table_name = $prefix . str_replace("-", "_", $rxml->attributes ['id']);

        // set form definition structure
        $file_name = $this->Xform_model->get_form_definition_filename($this->table_name);
        $this->set_defn_file($this->config->item("form_definition_upload_dir") . $file_name);
        $this->load_xml_definition();

        // set form data
        foreach ($rxml->children as $val) {
            $this->get_path('', $val);
        }
    }

    /**
     * @return mixed
     */
    public function get_data_file()
    {
        return $this->xml_data_filename;
    }

    /**
     * @param $xml
     * @return mixed
     */
    private function xml_to_object($xml)
    {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $tags);
        xml_parser_free($parser);

        $elements = array(); // the currently filling [child] XmlElement array
        $stack = array();
        foreach ($tags as $tag) {

            $index = count($elements);
            if ($tag ['type'] == "complete" || $tag ['type'] == "open") {
                $elements [$index] = new XmlElement ();
                $elements [$index]->name = $tag ['tag'];

                if (!empty ($tag ['attributes'])) {
                    $elements [$index]->attributes = $tag ['attributes'];
                }

                if (!empty ($tag ['value'])) {
                    $elements [$index]->content = $tag ['value'];
                }

                if ($tag ['type'] == "open") { // push
                    $elements [$index]->children = array();
                    $stack [count($stack)] = &$elements;
                    $elements = &$elements [$index]->children;
                }
            }

            if ($tag ['type'] == "close") { // pop
                $elements = &$stack [count($stack) - 1];
                unset ($stack [count($stack) - 1]);
            }
        }

        return $elements [0]; // the single top-level element
    }
    /**
     * Recursive function that runs through xml xform object and uses array keys as
     * absolute path of variable, and sets its value to the data submitted by user
     * Author : Eric Beda
     *
     * @param string $name of xml element
     * @param object $obj
     */

    // TO DO : Change function name to be more representative

    /**
     * @param string $name
     * @param object $obj
     */
    private function get_path($name, $obj)
    {
        $name .= "_" . $obj->name;

        if (is_array($obj->children)) {
            foreach ($obj->children as $val) {
                $this->get_path($name, $val);
            }
        } else {
            $column_name = substr($name, 1);
            //shorten long column names
            if (strlen($column_name) > 64) {
                $column_name = shorten_column_name($column_name);
            }
            $this->form_data [$column_name] = $obj->content;
        }
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
            "phone_number"    => $phone,
            "date_sent"       => date("Y-m-d h:i:s"),
            "status"          => "PENDING"
        );

        if ($msg_id = $this->Ohkr_model->create_send_sms($sms_to_send)) {

            $sms_text = "Ndugu " . $first_name . ",\n" . $message;
            $sms_info = array(
                "from" => $message_sender_name,
                "to"   => $phone,
                "text" => $sms_text
            );


            if ($send_result = $this->Alert_model->send_alert_sms($request_url_endpoint, $sms_info)) {
                $infobip_response = json_decode($send_result);
                $message = (array)$infobip_response->messages;
                $message = array_shift($message);
                $sms_updates = array(
                    "status"           => "SENT",
                    "date_sent"        => date("c"),
                    "infobip_msg_id"   => $message->messageId,
                    "infobip_response" => $send_result
                );
                $this->Alert_model->update_sms_status($msg_id, $sms_updates);
            }
        }
    }

    /**
     * Create query string for inserting data into table from submitted xform data
     * file
     * Author : Eric Beda
     *
     * @return boolean|string
     */
    private function get_insert_form_data_query()
    {

        $table_name = $this->table_name;
        $form_data = $this->form_data;
        $map = $this->get_field_map();

        $has_geopoint = FALSE;
        $col_names = array();
        $col_values = array();
        $points_v = array();
        $points_n = array();

        //echo '<pre>'; print_r($this->form_defn);
        foreach ($this->form_defn as $str) {

            $type = $str['type'];
            $cn = $str['field_name'];

            $cv = $this->form_data[$cn];

            if ($cv == '' || $cn == '') continue;

            // check if column name was mapped to fieldmap table
            if (array_key_exists($cn, $map)) {
                $cn = $map[$cn];
            }

            array_push($col_names, $cn);
            array_push($col_values, $cv);

            if ($type == 'select') {
                $options = explode(' ', $cv);
                foreach ($options as $opt) {
                    $opt = trim($opt);

                    if (array_key_exists($cn . '_' . $opt, $map)) {
                        $opt = $map[$cn . '_' . $opt];
                    }

                    array_push($col_values, 1);
                    array_push($col_names, $opt);

                }
            }

            if ($type == 'geopoint') {

                $has_geopoint = TRUE;
                $geopoints = explode(" ", $cv);

                $lat = $geopoints [0];
                array_push($col_values, $lat);
                array_push($col_names, $cn . '_lat');

                $lng = $geopoints [1];
                array_push($col_values, $lng);
                array_push($col_names, $cn . '_lng');

                $alt = $geopoints [2];
                array_push($col_values, $alt);
                array_push($col_names, $cn . '_alt');

                $acc = $geopoints [3];
                array_push($col_values, $acc);
                array_push($col_names, $cn . '_acc');

                $point = "GeomFromText('POINT($lat $lng)')";
                array_push($points_v, $point);
                array_push($points_n, $cn . '_point');
            }
        }

        if ($has_geopoint) {
            $field_names = "(`" . implode("`,`", $col_names) . "`,`" . implode("`,`", $points_n) . "`)";
            $field_values = "('" . implode("','", $col_values) . "'," . implode("`,`", $points_v) . ")";
        } else {
            $field_names = "(`" . implode("`,`", $col_names) . "`)";
            $field_values = "('" . implode("','", $col_values) . "')";
        }

        $query = "INSERT INTO {$table_name} {$field_names} VALUES {$field_values}";

        return $query;
    }

    /**
     * Header Response
     *
     * @param string $http_response_code
     *            Input string
     * @param string $response_message
     *            Input string
     * @return response
     */
    function get_response($http_response_code, $response_message = "Asante!, Fomu imepokelewa")
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
        echo $response;
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

        $forms = $this->Xform_model->get_form_list_by_perms($user_perms);

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
        $data['project_id'] = $project_id;

        $this->form_validation->set_rules("title", $this->lang->line("validation_label_form_title"), "required|is_unique[xforms.title]");
        $this->form_validation->set_rules("access", $this->lang->line("validation_label_form_access"), "required");

        if ($this->form_validation->run() === FALSE) {

            $users = $this->User_model->get_users();
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
                $this->load->view("form/add_new");
                $this->load->view('footer');
            }
        } else {
            $form_definition_upload_dir = $this->config->item("form_definition_upload_dir");

            if (!empty($_FILES['userfile']['name'])) {

                $config['upload_path'] = $form_definition_upload_dir;
                $config['allowed_types'] = 'xml';
                $config['max_size'] = '1024';
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload("userfile")) {
                    $this->session->set_flashdata("message", "<div class='warning'>" . $this->upload->display_errors("", "") . "</div>");
                    redirect("xform/add_new/{$project_id}");
                } else {
                    $xml_data = $this->upload->data();
                    $filename = $xml_data['file_name'];

                    $perms = $this->input->post("perms");

                    $all_permissions = "";
                    if (count($perms) > 0) {
                        $all_permissions = join(",", $perms);
                    }

                    $create_table_statement = $this->_initialize($filename);

                    if ($this->Xform_model->find_by_xform_id($this->table_name)) {
                        @unlink($form_definition_upload_dir . $filename);
                        $this->session->set_flashdata("message", display_message("Form ID is already used, try a different one", "danger"));
                        redirect("xform/add_new/{$project_id}");
                    } else {
                        $create_table_result = $this->Xform_model->create_table($create_table_statement);
                        //log_message("debug", "Create table result " . $create_table_result);

                        if ($create_table_result) {

                            $form_details = array(
                                "user_id"      => $this->session->userdata("user_id"),
                                "form_id"      => $this->table_name,
                                "jr_form_id"   => $this->jr_form_id,
                                "title"        => $this->input->post("title"),
                                "description"  => $this->input->post("description"),
                                "filename"     => $filename,
                                "date_created" => date("c"),
                                "access"       => $this->input->post("access"),
                                "perms"        => $all_permissions,
                                "project_id"   => $project_id
                            );

                            //TODO Check if form is built from ODK Aggregate Build to avoid errors during initialization

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
        $this->data['title'] = "List searchable form";

        //check if logged in
        $this->_is_logged_in();

        //check permission
        //$this->has_allowed_perm($this->router->fetch_method());

        $config = array(
            'base_url'    => $this->config->base_url("xform/searchable_form_lists"),
            'total_rows'  => $this->Xform_model->count_searchable_form(),
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
        $this->load->view("form/searchable_form_list");
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
                "xform_id"      => $this->input->post("form_id"),
                "search_fields" => $this->input->post("search_field"),
                "user_id"       => $this->user_id
            );
            $this->db->insert('xforms_config', $data);

            $this->session->set_flashdata("message", display_message("Searchable form added"));
            redirect("xform/searchable_form_lists", "refresh");
        }

        //populate data
        $this->data['form_list'] = $this->Xform_model->get_form_list();

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("form/add_searchable_form");
        $this->load->view('footer');
    }

    //function to get user level
    function get_search_field($form_id)
    {
        $form_details = $this->Xform_model->get_form_by_id($form_id);

        $table_name = $form_details->form_id;
        $table_fields = $this->Xform_model->find_table_columns($table_name);
        $field_maps = $this->_get_mapped_table_column_name($form_details->form_id);

        //print_r($field_maps);

        foreach ($table_fields as $key => $value) {
            if (key_exists($value, $field_maps)) {
                echo '<option value="' . $value . '">' . $field_maps[$value] . '</option>';
            } else {
                echo '<option value="' . $value . '">' . $value . '</option>';
            }
        }
    }

    /**
     * Creates appropriate tables from an xform definition file
     * Author : Eric Beda
     *
     * @param string $file_name
     *            definition file
     * @return string with create table statement
     */
    public function _initialize($file_name)
    {
        //log_message("debug", "File to load " . $file_name);

        // create table structure
        $this->set_defn_file($this->config->item("form_definition_upload_dir") . $file_name);

        $this->load_xml_definition();

        // TODO: change function name to get_something suggested get_form_table_definition
        return $this->get_create_table_sql_query();
    }

    public function init_test()
    {
        $this->set_defn_file($this->config->item("form_definition_upload_dir") . 'testo.xml');
        $this->load_xml_definition();

        // TODO: change function name to get_something suggested get_form_table_definition
        echo '<pre>';
        print_r($this->get_create_table_sql_query());
    }

    /**
     * @param $filename
     */
    public function set_defn_file($filename)
    {
        $this->xml_defn_filename = $filename;
    }

    /**
     * Create an array representative of xform definition file for easy transversing
     * Author : Eric Beda
     */
    private function load_xml_definition()
    {
        $file_name = $this->get_defn_file();
        $xml = file_get_contents($file_name);
        $rxml = $this->xml_to_object($xml);

        // TODO reference by names instead of integer keys
        $instance = $rxml->children [0]->children [1]->children [0]->children [0];

        $prefix = $this->config->item("xform_tables_prefix");
        //log_message("debug", "Table prefix during creation " . $prefix);
        $jr_form_id = $instance->attributes ['id'];
        $table_name = $prefix . str_replace("-", "_", $jr_form_id);

        // get array rep of xform
        $this->form_defn = $this->get_form_definition();

        //log_message("debug", "Table name " . $table_name);
        $this->table_name = $table_name;
        $this->jr_form_id = $jr_form_id;
    }

    /**
     * @return mixed
     */
    public function get_defn_file()
    {
        return $this->xml_defn_filename;
    }

    /**
     * Return a double array containing field path as key and a value containing
     * array filled with its corresponding attributes
     * Author : Eric Beda
     *
     * @return array
     */
    private function get_form_definition()
    {

        // retrieve object describing definition file
        $rxml = $this->xml_to_object(file_get_contents($this->get_defn_file()));


        // get the binds compononent of xform
        $binds = $rxml->children [0]->children [1]->children;
        //echo '<pre>'; print_r($rxml->children [1]->children);
        // get the body section of xform
        $tmp2 = $rxml->children [0]->children [1]->children [1]->children [0]->children;
        $tmp2 = $rxml->children [1]->children;
        // container
        $xarray = array();

        foreach ($binds as $key => $val) {

            if ($val->name == 'bind') {

                $attributes = $val->attributes;
                $nodeset = $attributes ['nodeset'];

                $xarray [$nodeset] = array();
                $xarray [$nodeset] ['field_name'] = str_replace("/", "_", substr($nodeset, 6));

                // set each attribute key and corresponding value
                foreach ($attributes as $k2 => $v2) {

                    $xarray [$nodeset] [$k2] = $v2;
                }
            }
        }
        $this->xarray = $xarray;
        $this->_iterate_defn_file($tmp2, FALSE);
        return $this->xarray;
    }

    /**
     * @param $arr
     * @param bool $ref
     */
    function _iterate_defn_file($arr, $ref = FALSE)
    {

        $i = 0;
        foreach ($arr as $val) {

            switch ($val->name) {

                case 'group':
                    $this->_iterate_defn_file($val->children);
                    break;
                case 'input':
                    $nodeset = $val->attributes['ref'];
                    $this->xarray[$nodeset]['label'] = '0';
                    break;
                case 'select':
                case 'select1':
                    $nodeset = $val->attributes['ref'];
                    $this->_iterate_defn_file($val->children, $nodeset);
                    break;
                case 'item':
                    $l = $val->children[0]->content;
                    $v = $val->children[1]->content;
                    $this->xarray[$ref]['option'][$v] = $l;
                    break;
            }
        }

    }

    /**
     * creates query corresponding to mysql table structure of an xform definition file
     * Author : Eric Beda
     *
     * @return string statement for creating table structure of xform
     */
    private function get_create_table_sql_query()
    {
        $structure = $this->form_defn;
        $tbl_name = $this->table_name;

        // initiate statement, set id as primary key, autoincrement
        $statement = "CREATE TABLE $tbl_name ( id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY ";

        // loop through xform definition array
        $counter = 0;
        foreach ($structure as $key => $val) {

            // check if type is empty
            if (empty ($val ['type']))
                continue;


            $field_name = $val['field_name'];
            $col_name = $this->_map_field($field_name);

            if (array_key_exists('label', $val)) {
                $field_label = $val['label'];
            } else {
                $tmp = explode('/', $val['nodeset']);
                $field_label = array_pop($tmp);
            }
            $type = $val ['type'];

            // check if field is required
            if (!empty ($val ['required'])) {
                $required = 'NOT NULL';
            } else {
                $required = '';
            }

            if ($type == 'string' || $type == 'binary' || $type == 'barcode') {
                $statement .= ", $col_name VARCHAR(300) $required";

            }

            if ($type == 'select1') {
                // Mysql recommended way of handling single quotes for queries is by using two single quotes at once.
                if (!$val['option']) {
                    // itemset
                    $statement .= ", $col_name  VARCHAR(300) $required";
                } else {
                    $tmp3 = array_keys($val ['option']);
                    $statement .= ", $col_name ENUM('" . implode("','", str_replace("'", "''", $tmp3)) . "') $required";
                }
            }

            if ($type == 'select') {
                $statement .= ", $col_name TEXT $required ";

                foreach ($val['option'] as $key => $select_opts) {

                    $key = $this->_map_field($col_name . '_' . $key);
                    if (!$key) {
                        // failed need to exit
                    }
                    $statement .= ", " . $key . " ENUM('1','0') DEFAULT '0' NOT NULL ";
                }
            }

            if ($type == 'text') {
                $statement .= ", $col_name TEXT $required ";
            }

            if ($type == 'date') {
                $statement .= ", $col_name DATE $required ";
            }

            if ($type == 'dateTime') {
                $statement .= ", $col_name datetime $required";
            }

            if ($type == 'time') {
                $statement .= ", $col_name TIME $required";
            }

            if ($type == 'int') {
                $statement .= ", $col_name INT(20) $required ";
            }

            if ($type == 'decimal') {
                $statement .= ", $col_name DECIMAL $required ";
            }

            if ($type == 'geopoint') {

                $statement .= "," . $col_name . " VARCHAR(150) $required ";
                $statement .= "," . $col_name . "_point POINT $required ";
                $statement .= "," . $col_name . "_lat DECIMAL(38,10) $required ";
                $statement .= "," . $col_name . "_lng DECIMAL(38,10) $required ";
                $statement .= "," . $col_name . "_acc DECIMAL(38,10) $required ";
                $statement .= "," . $col_name . "_alt DECIMAL(38,10) $required ";
            }

            $statement .= "\n";
        }

        $statement .= ")";
        return $statement;
    }

    /**
     * @param $field_name
     * @return bool|string
     */
    private function _map_field($field_name)
    {

        if (substr($field_name, 0, 5) == 'meta_') {
            return $field_name;
        }

        $fn = '_xf_' . md5($field_name);

        $data = array();
        $data['table_name'] = $this->table_name;
        $data['col_name'] = $fn;
        $data['field_name'] = $field_name;

        if ($this->Xform_model->add_to_field_name_map($data)) {
            return $fn;
        }

        //log_message('error', 'failed to map field');
        return FALSE;
    }

    /**
     * @param $arr
     * @return bool|string
     */
    private function _add_to_fieldname_map($arr)
    {

        $ut = microtime();
        $pre = '';
        $prefix = explode("_", $field_name);
        foreach ($prefix as $parts) {
            $pre .= substr($value, 0, 1);
        }

        $pre = $pre . '_' . $ut;

        if ($this->Xform_model->set_field_name($pre, $field_name)) {
            return $pre;
        } else {
            return FALSE;
        }
    }

    /**
     * @return array of shortened field names mapped to xform xml file labels
     */
    private function get_field_map()
    {

        $arr = $this->Xform_model->get_fieldname_map($this->table_name);
        $map = array();
        foreach ($arr as $val) {
            $key = $val['field_name'];
            $label = $val['col_name'];
            $map[$key] = $label;
        }
        return $map;
    }

    /**
     * @param $xform_id
     */
    function edit_form($xform_id)
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$xform_id) {
            $this->session->set_flashdata("message", $this->lang->line("select_form_to_edit"));
            redirect("xform/forms");
            exit;
        }

        $data['title'] = $this->lang->line("heading_edit_form");
        $data['form'] = $form = $this->Xform_model->find_by_id($xform_id);

        // TODO
        // Search field by table name from mapping fields
        $db_table_fields = $this->Xform_model->get_fieldname_map($form->form_id);

        $table_fields = $this->Xform_model->find_table_columns($form->form_id);
        if (count($db_table_fields) != count($table_fields)) {
            foreach ($table_fields as $tf) {
                if (!$this->Xform_model->xform_table_column_exists($form->form_id, $tf)) {
                    $details = [
                        "table_name"  => $form->form_id,
                        "col_name"    => $tf,
                        "field_name"  => $tf,
                        "field_label" => str_replace("_", " ", $tf)
                    ];
                    $this->Xform_model->create_field_name_map($details);
                }
            }
        }
        $data['table_fields'] = $this->Xform_model->get_fieldname_map($form->form_id);
        ///$data['table_fields'] = $db_table_fields;

        $this->form_validation->set_rules("title", $this->lang->line("validation_label_form_title"), "required");
        $this->form_validation->set_rules("access", $this->lang->line("validation_label_form_access"), "required");

        if ($this->form_validation->run() === FALSE) {
            $users = $this->User_model->get_users(200);
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
            $this->load->view("form/edit_form", $data);
            $this->load->view('footer');
        } else {
            $hides = $this->input->post("hide[]");
            $ids = $this->input->post("ids[]");
            $labels = $this->input->post("label[]");
            $field_types = $this->input->post("field_type[]");
            $chart_use = $this->input->post("chart_use[]");
            $type_option = $this->input->post("type[]");

            if ($form) {
                $new_perms = $this->input->post("perms");

                $new_perms_string = "";
                if (count($new_perms) > 0) {
                    $new_perms_string = join(",", $new_perms);
                }
                $new_form_details = array(
                    "title"        => $this->input->post("title"),
                    "description"  => $this->input->post("description"),
                    "access"       => $this->input->post("access"),
                    "perms"        => $new_perms_string,
                    "last_updated" => date("c")
                );

                $this->db->trans_start();
                $this->Xform_model->update_form($xform_id, $new_form_details);

                $mapped_fields = [];
                $i = 0;
                foreach ($labels as $key => $value) {
                    $mapped_fields[$i]["field_label"] = $value;
                    $mapped_fields[$i]["id"] = $ids[$i];
                    $mapped_fields[$i]["field_type"] = $field_types[$i];
                    $mapped_fields[$i]["chart_use"] = $chart_use[$i];
                    $mapped_fields[$i]["type"] = $type_option[$i];
                    $mapped_fields[$i]["hide"] = 0;

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
                redirect("xform/edit_form/{$xform_id}");
            } else {
                $this->session->set_flashdata("message", $this->lang->line("unknown_error_occurred"));
                redirect("xform/forms");
            }
        }
    }

    /**
     * @param $xform_id
     * Archives the uploaded xforms so that they do not appear at first on the form lists page
     */
    function archive_xform($xform_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$xform_id) {
            $this->session->set_flashdata("message", $this->lang->line("select_form_to_delete"));
            redirect("xform/forms");
            exit;
        }

        if ($this->Xform_model->archive_form($xform_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("form_archived_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_delete_form"), "danger"));
        }
        redirect("xform/forms");
    }

    /**
     * @param $xform_id
     */
    function restore_from_archive($xform_id)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if (!$xform_id) {
            $this->session->set_flashdata("message", $this->lang->line("select_form_to_delete"));
            redirect("xform/forms");
            exit;
        }

        if ($this->Xform_model->restore_xform_from_archive($xform_id)) {
            $this->session->set_flashdata("message", display_message($this->lang->line("form_restored_successful")));
        } else {
            $this->session->set_flashdata("message", display_message($this->lang->line("error_failed_to_restore_form"), "danger"));
        }
        redirect("xform/forms");
    }

    /**
     * @param $form_id
     */
    function form_data($form_id)
    {
        $this->_is_logged_in();

        if (!$form_id) {
            $this->session->set_flashdata("message", $this->lang->line("select_form_to_delete"));
            redirect("xform/forms");
            exit;
        }

        //if $_POST['export']
        if (isset($_POST['export'])) {
            //check if week number selected
            if ($this->input->post('week') == null) {
                $this->session->set_flashdata('message', display_message('You should select week number', 'danger'));
                redirect('xform/form_data/' . $form_id, 'refresh');
            }

            //week number
            $week_number = $this->input->post('week');
            $this->export_IDWE($form_id, $week_number);
        }

        $form = $this->Xform_model->find_by_id($form_id);

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
                'base_url'    => $this->config->base_url("xform/form_data/" . $form_id),
                'total_rows'  => $this->Xform_model->count_all_records($form->form_id),
                'uri_segment' => 4,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
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
                $data['form_data'] = $this->Xform_model->find_form_data_by_fields($form->form_id, $selected_columns, $this->pagination->per_page, $page);
            } else {
                $data['form_data'] = $this->Xform_model->find_form_data($form->form_id, $this->pagination->per_page, $page);
            }
            $data["links"] = $this->pagination->create_links();

            $this->load->view('header', $data);
            $this->load->view("form/form_data_details");
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
    function excel_export_form_data($form_id = NULL)
    {
        //get form data
        if ($this->session->userdata("form_filters")) {
            $form_filters = $this->session->userdata("form_filters");
            $serial = 0;
            foreach ($form_filters as $column_name) {
                $inc = 1;
                $column_title = $this->getColumnLetter($serial);
                $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_title . $inc, $column_name);
                $serial++;
            }
            $form_data = $this->Xform_model->find_form_data_by_fields($form_id, $form_filters, 5000);
        } else {
            //table fields
            $table_fields = $this->Xform_model->find_table_columns($form_id);
            //mapping field
            $field_maps = $this->_get_mapped_table_column_name($form_id);
            $serial = 0;
            foreach ($table_fields as $key => $column) {

                $inc = 1;
                $column_title = $this->getColumnLetter($serial);

                if (array_key_exists($column, $field_maps)) {
                    $column_name = $field_maps[$column];
                } else {
                    $column_name = $column;
                }
                $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_title . $inc, $column_name);
                $serial++;
            }
            $form_data = $this->Xform_model->find_form_data($form_id);
        }

        $inc = 2;
        foreach ($form_data as $data) {
            $serial = 0;
            foreach ($data as $key => $entry) {
                $column_title = $this->getColumnLetter($serial);
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

    //exporting Zanzibar IDWE
    public function export_IDWE($form_id, $week_number)
    {
        //form details
        $this->model->set_table('xforms');
        $xform = $this->model->get_by('id', $form_id);

        //table fields
        $table_fields = $this->Xform_model->find_table_columns($xform->form_id);

        $columns = count($table_fields);

        $last_column = $this->columnLetter($columns);

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
                $r = $this->columnLetter($i) . '3:' . $this->columnLetter($i + 7) . '3';
                $this->objPHPExcel->getActiveSheet()->mergeCells($r);
                $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnLetter($i) . '3', $diseases[$d]);
                //echo " " . $c . ":" . $d;
                $d++;

                if (!($c % 4)) {

                    for ($k = 0; $k < 2; $k++) {
                        $r = $this->columnLetter($i + $k * 4) . '4:' . $this->columnLetter($i + $k * 4 + 3) . '4';
                        $this->objPHPExcel->getActiveSheet()->mergeCells($r);
                        $v = ($k % 2) ? ' > 5 yrs ' : ' < 5 yrs';
                        $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnLetter($i + $k * 4) . '4', $v);

                    }
                    //$nne .= '<td colspan="4">  < 5 yrs </td><td colspan="4">  > 5 yrs </td>';

                    if (!($c % 2)) {

                        for ($k = 0; $k < 4; $k++) {
                            $r = $this->columnLetter($i + $k * 2) . '5:' . $this->columnLetter($i + $k * 2 + 1) . '5';
                            $this->objPHPExcel->getActiveSheet()->mergeCells($r);
                            $v = ($k % 2) ? 'C' : 'D';
                            $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnLetter($i + $k * 2) . '5', $v);

                        }
                    }

                }
            }

            $v = ($c % 2) ? 'F' : 'M';
            $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnLetter($i) . '6', $v);

        }


        // get values from DB
        $this->model->set_table($xform->form_id);
        $this->model->order_by('_xf_da0f48ffc452923e77a8c70e393ed5ac', 'ASC');
        $this->model->order_by('_xf_0c37672a5ed28b81b30d37d52b20f57e', 'ASC');
        $this->model->order_by('_xf_3b4caf4273007b260d666188609c6e2a', 'ASC');
        $data = $this->model->as_array()->get_many_by('_xf_20de688d974183449850b0d32a15de47', $week_number);

        //echo '<pre>';
        //print_r($data);

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
            'fill'      => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '83C9FC')

            ),
            'font'      => array(
                'bold'  => false,
                'size'  => '12',
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
    function csv_export_form_data($xform_id = NULL)
    {
        if ($xform_id == NULL) {
            $this->session->set_flashdata("message", display_message("You must select a form", "danger"));
            redirect("xform/forms");
        }
        $table_name = $xform_id;
        $query = $this->db->query("select * from {$table_name} order by id ASC ");
        $this->_force_csv_download($query, "Exported_CSV_for_" . $table_name . "_" . date("Y-m-d") . ".csv");
    }

    /**
     * @param $query
     * @param string $filename
     */
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

    /**
     * @param null $xform_id
     */
    function xml_export_form_data($xform_id = NULL)
    {
        if ($xform_id == NULL) {
            $this->session->set_flashdata("message", display_message("You must select a form", "danger"));
            redirect("xform/forms");
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
            'root'    => 'afyadata',
            'element' => 'form_data',
            'newline' => "\n",
            'tab'     => "\t"
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
            $this->session->set_flashdata("message", display_message("You must select a form", "danger"));
            redirect("xform/forms");
        }

        $this->form_validation->set_rules("save", "Save changes", "required");

        if ($this->form_validation->run() == FALSE) {
            $data['form_id'] = $form_id;
            $data['field_maps'] = $field_maps = $this->Xform_model->get_fieldname_map($form_id);

            $this->load->view('header', $data);
            $this->load->view("form/map_form_fields");
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

        $this->table_name = $form_id;
        $map = $this->get_field_map();

        $this->load->library("Xform_comm");
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

    /**
     * @param $xform_id
     * Deletes as single or multiple entries for a given form table and id(s)
     */
    function delete_entry($xform_id)
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
            redirect("xform/form_data/" . $xform_id, "refresh");
        }
    }

    /**
     * get column name from number
     *
     * @param $number
     * @return string
     */
    function getColumnLetter($number)
    {
        $numeric = $number % 26;
        $suffix = chr(65 + $numeric);
        $prefNum = intval($number / 26);
        if ($prefNum > 0) {
            $prefix = $this->getColumnLetter($prefNum - 1) . $suffix;
        } else {
            $prefix = $suffix;
        }
        return $prefix;
    }

    //getColumnLetter
    function columnLetter($n)
    {
        for ($r = ""; $n >= 0; $n = intval($n / 26) - 1)
            $r = chr($n % 26 + 0x41) . $r;
        return $r;
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
            "name"   => "Data submissions",
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
            "name"   => "Data submissions",
            "series" => str_replace('"', "", json_encode($current_year_series))
        );

        $data['current_year_report_title'] = date("Y") . " submissions";

        $data['recent_feedback'] = $this->Feedback_model->find_by_xform_id($data['form']->form_id, 10);
        $data['load_map'] = TRUE;

        $this->load->view("header", $data);
        $this->load->view("form/form_overview", $data);
        $this->load->view("footer", $data);
    }

    function configure()
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

    function test_disease_detection()
    {
        $specie_id = 11; //binadamu
        $symptoms = "A02,A03,A04,A05,A06,A07,A08,A09,A10";
        //field name _xf_dd_1341

        $request_data = [
            "specie_id" => $specie_id,
            "symptoms"  => $symptoms
        ];

        $result = $this->Alert_model->send_post_symptoms_request(json_encode($request_data));
        $json_object = json_decode($result);

        if ($json_object->status == 1) {
            $detected_diseases = [];

            foreach ($json_object->data as $disease) {
                $ungonjwa = $this->Ohkr_model->find_by_disease_name($disease->title);

                $detected_diseases[] = [
                    //"form_id"       => $this->jr_form_id,
                    "disease_id"    => $ungonjwa->id,
                    //"instance_id"   => $instance_id,
                    "date_detected" => date("Y-m-d H:i:s")
                ];
            }
            $this->Ohkr_model->save_detected_diseases($detected_diseases);
        } else {
            //no disease found
        }
    }
}