<?php
date_default_timezone_set('Africa/Nairobi');

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 3:42 PM
 */
class Lab extends CI_Controller
{
    const MOBILE_SERVICE_ID = 93;
    private $sms_sender_id;
    private $api_key;
    private $user;
    private $sms_push_url;

    function __construct()
    {
        // load model
        parent::__construct();

        $this->sms_sender_id = '15200';
        $this->api_key = '7jl4QjSEKLwBAYWa0Z5YNn5FUdnrxkeY0CYkxIt8';
        $this->user = 'afyadata@sacids.org';
        $this->sms_push_url = 'http://154.118.230.108/msdg/public/quick_sms';
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

    function test()
    {
        $facility = $this->db->get_where('health_facilities', ['code' => substr('SRG16', 0, 3)])->row();
        $phones = explode(',', $facility->phone);

        foreach ($phones as $phone) {
            echo $phone;
            $message = 'Majibu ya maabara ya SUA tayari, ingia katika Afyadata kuangalia';
            $this->push($phone, $message);
        }
    }


    //get results
    function results()
    {
        if ($this->input->get('username') == null) {
            echo json_encode(array("status" => "failed", "message" => "Required parameter missing"));
            exit();
        }

        //username
        $username = $this->input->get('username');

        //user health facilities
        $this->model->set_table('user_health_facilities');
        $user_hf = $this->model->get_by(['username' => $username]);

        if ($user_hf) {
            $facility_ids = explode(',', $user_hf->health_facility_ids);

            //health facilities
            $facilities = $this->db->where_in('id', $facility_ids)->get('health_facilities')->result();

            if ($facilities) {
                $res_array = [];
                foreach ($facilities as $facility) {
                    $results = $this->db
                        ->like('_xf_271560175ee2e3a0fc421a63cb30724a', $facility->code, 'after')
                        ->order_by('submitted_at', 'DESC')
                        ->get('ad_build_Sample_results_form_1589715082020')->result();

                    if ($results) {
                        foreach ($results as $val) {
                            //get details from front line
                            $patient = $this->db
                                ->get_where('ad_build_clinician_1283331234529180520',
                                    ['_xf_97ec8c6f99c8dfe34679782c060b528d' => $val->_xf_271560175ee2e3a0fc421a63cb30724a])->row();

                            if ($patient) {
                                //find rose bengal results
                                $rose_bengal_data = $this->db->get_where('ad_build_Rose_Bengal_Results_158980803030',
                                    ['_xf_1081331606aa34175e574c53a764ebf0' => $patient->_xf_97ec8c6f99c8dfe34679782c060b528d])->row();

                                $rose_bengal_result = 'NA';
                                if ($rose_bengal_data)
                                    $rose_bengal_result = $rose_bengal_data->_xf_d9e56ce2bd10d1c7faa554d2b1826910;


                                //array
                                $res_array[] = [
                                    'id' => $val->id,
                                    'facility_name' => $facility->name,
                                    'patient_name' => $patient->_xf_650ad80ca14caa5f0e0dde5742811587,
                                    'age' => $patient->_xf_ec0c9332aa8e8195404c7d072b8dc0e8,
                                    'sex' => $patient->_xf_27e177f79abab493a9294c8f22a2f9da,
                                    'barcode' => $patient->_xf_97ec8c6f99c8dfe34679782c060b528d,
                                    'phone' => $patient->_xf_09fad5eae7f7f22a099cbd04a71c0e4d,
                                    'referred' => strtoupper($patient->_xf_1a61b8eafc059271b15b82cd4a4f595c),
                                    'status' => ($val->status == 0) ? 'UNCHECKED' : 'CHECKED',
                                    'rose_bengal_results' => strtoupper($rose_bengal_result),
                                    'results' => strtoupper($val->_xf_24c67cb06cc2cb8c50ad41b2c5d8be6f),
                                    'comments' => $val->_xf_bd76f983918e6a0638d540d609b4de6a,
                                    'submitted_at' => date('d-m-Y H:i', strtotime($val->submitted_at))
                                ];
                            }
                        }
                    }
                }
                echo json_encode(array("results" => $res_array, "status" => "success"));
            } else {
                echo json_encode(array("status" => "failed", "message" => "No health facility does not exists"));
            }
        } else {
            echo json_encode(array("status" => "failed", "message" => "User does not exists"));
        }
    }

    //send message
    function send_message()
    {
        if ($this->input->post('username') == null && $this->input->post('patientNo') == null) {
            echo json_encode(array("status" => "failed", "message" => "Required parameter missing"));
            exit();
        }

        //details
        $username = $this->input->post('username');
        $patientNo = $this->input->post('patientNo');
        log_message("DEBUG", "username => ".$username);

        //user
        $user = $this->User_model->find_by_username($username);

        if ($user) {
            //get patient details
            $patient = $this->db
                ->get_where('ad_build_clinician_1283331234529180520',
                    ['_xf_97ec8c6f99c8dfe34679782c060b528d' => $patientNo])->row();

            if ($patient) {
                //health facility
                $facility = $this->db->get_where('health_facilities', ['code' => substr($patientNo, 0, 3)])->row();

                $message = 'Brucella: Ndugu ' . $patient->_xf_650ad80ca14caa5f0e0dde5742811587 . ',  unaombwa kufika kituo cha afya ' . $facility->name . ' kumuona daktari.';

                //send message
                $this->push($this->cast_mobile($patient->_xf_09fad5eae7f7f22a099cbd04a71c0e4d), $message);

                //if referred => send message to chr
                if ($patient->_xf_1a61b8eafc059271b15b82cd4a4f595c == 'yes') {
                    $message = 'Brucella: Tunakuomba kumkumbusha ndugu ' . $patient->_xf_650ad80ca14caa5f0e0dde5742811587 . ' kufika kituo cha afya ' . $facility->name . ' kumuona daktari.';

                    //send message
                    $this->push($this->cast_mobile($patient->_xf_f66b74031557d6eeed317d9b30785b50), $message);
                }

                //update status
                $data = [
                    'replied_at' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'message' => 'Afyadata: ' . $message
                ];
                $result = $this->db->update('ad_build_Sample_results_form_1589715082020', $data, ['_xf_271560175ee2e3a0fc421a63cb30724a' => $patientNo]);

                //todo: 

                if ($result)
                    echo json_encode(array('status' => 'success', 'message' => 'Message sent'), 200);
                else
                    echo json_encode(array('status' => 'failed', 'message' => 'Unknown error occurred'), 202);
            } else {
                echo json_encode(array("status" => "failed", "message" => "Patient does not exists"));
            }
        } else {
            echo json_encode(array("status" => "failed", "message" => "User does not exists"));
        }
    }

    //remove 0 and + on start of mobile
    function cast_mobile($mobile)
    {
        if (preg_match("~^0\d+$~", $mobile)) {
            return '255' . substr($mobile, 1);
        } else {
            return '255' . $mobile;
        }
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