<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 3/20/2017
 * Time: 11:31 AM
 */
class Ussd extends CI_Controller
{
    private $api_key;
    private $sms_push_url;
    private $user;

    function __construct()
    {
        parent::__construct();

        $this->api_key = 'HaPbQDXbUtCBd9CWlkfmB56QdvA8kIGwb41qklNS';
        $this->sms_push_url = 'http://msdg.ega.go.tz/msdg/public/quick_sms';
        $this->user = 'kadefue@sua.ac.tz';
    }


    //push message
    function sms_push()
    {
        $date_time = date('Y-m-d H:i:s');

        $message = array(
            'recipients' => '255717705746, 255753437856',
            'message' => 'Testing message',
            'datetime' => $date_time,
            'sender_id' => '15200',
            'mobile_service_id' => 93
        );

        $post_data = array('data' => json_encode($message), 'datetime' => $date_time);

        //HASH the JSON with the generated user API key using SHA-256 method.
        $hash = hash_hmac('sha256', $post_data['data'], $this->api_key, true);

        //Encode the hash using Base 64 Encode method
        $base64_value = base64_encode($hash);

        $http_header = array(
            'X-Auth-Request-Hash:' . $base64_value,
            'X-Auth-Request-Id:' . $this->user,
            'X-Auth-Request-Type:api'
        );

        //Initialise connection using PHP CURL
        $ch = curl_init();

        //set option of URL to post to
        curl_setopt($ch, CURLOPT_URL, $this->sms_push_url);

        //set option of request method -----HTTP POST Request
        curl_setopt($ch, CURLOPT_POST, true);

        //The HTTP Header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);

        //This line sets the parameters to post to the URL
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        //This line makes sure that the response is gotten back to the $response object(see below) and not echoed
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //This line executes the RPC call
        $response = curl_exec($ch); //and assigns the result to $response object

        echo $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //Close the stream
        curl_close($ch);

        echo $response;
    }

    //receive menu from EGA
    function verify()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        if ($value['data'] == 123456) {
            $response = array(
                'success' => TRUE,
                'name' => 'Renfrid Ngolongolo',
                'gender' => 'Male'
            );

            log_message("debug", 'search key  ' . $value['data']);

        } else {
            $response = array(
                'success' => FALSE
            );
        }
        echo json_encode($response);
    }

    //receive menu from EGA
    function received_packet()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        log_message("debug", 'ussd_message  ' . $post_data);

        //response
        $response = array(
            'status' => TRUE,
            'sms_reply' => TRUE,
            'sms_text' => 'Ombi lako limepokelewa kwa nambari ya kumbukumbu AFYADATA'
        );

        echo json_encode($response);
    }

    //pull message
    function sms_pull()
    {
        //receive as json
        $post_data = file_get_contents("php://input");

        $value = json_decode($post_data, TRUE);

        //variables
        $message = $value['message'];
        $msisdn = $value['msisdn'];
        $transaction_id = $value['transaction_id'];
        $sent_time = $value['sent_time'];

        log_message("debug", 'pull_message ' . $post_data);

        //response
        $response = array(
            'transaction_id' => $transaction_id,
            'message' => 'Request Received Successfully.',
            'reply' => 1
        );

        echo json_encode($response);
    }


    //push message
    function push_sms()
    {
        $post_data['data'] = array(
            'recipients' => '255717705746',
            'message' => 'Testing message',
            'datetime' => date('Y-m-d H:i:s'),
            'sender_id' => '15200',
            'mobile_service_id' => 93
        );


        //HASH the JSON with the generated user API key using SHA-256 method.
        $hash = hash_hmac('sha256', json_encode($post_data['data']), $this->api_key);

        //Encode the hash using Base 64 Encode method
        $base64_value = base64_encode($hash);

        $http_header = array(
            'X-Auth-Request-Hash:' . $base64_value,
            'X-Auth-Request-Id:kadefue@sua.ac.tz',
            'X-Auth-Request-Type:api'
        );

        //Initialise connection using PHP CURL
        $ch = curl_init();

        //set option of URL to post to
        curl_setopt($ch, CURLOPT_URL, $this->sms_push_url);

        //set option of request method -----HTTP POST Request
        curl_setopt($ch, CURLOPT_POST, true);

        //The HTTP Header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);

        //This line sets the parameters to post to the URL
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        //This line makes sure that the response is gotten back to the $response object(see below) and not echoed
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //This line executes the RPC call
        $response = curl_exec($ch); //and assigns the result to $response object

        echo $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //Close the stream
        curl_close($ch);

        echo $response;
    }

}