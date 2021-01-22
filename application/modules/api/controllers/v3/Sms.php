<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 05/05/2020
 * Time: 11:50
 */

class Sms extends CI_Controller
{
    const MOBILE_SERVICE_ID = 93;
    private $sms_sender_id;
    private $api_key;
    private $user;
    private $sms_push_url;

    function __construct()
    {
        parent::__construct();

        $this->sms_sender_id = 'AfyaData';
        $this->api_key = '7jl4QjSEKLwBAYWa0Z5YNn5FUdnrxkeY0CYkxIt8';
        $this->user = 'afyadata@sacids.org';
        $this->sms_push_url = 'http://154.118.230.108/msdg/public/quick_sms';
    }

    //push message
    function push()
    {
        $date_time = date('Y-m-d H:i:s');
        $message = array(
            'recipients' => '255717705746,255753437856',
            'message' => 'Testing message from AfyaData API ' . $date_time,
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