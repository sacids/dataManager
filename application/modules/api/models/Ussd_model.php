<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017. Southern African Center for Infectious disease Surveillance (SACIDS)
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
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * Date: 23-Mar-17
 * Time: 09:11
 */
class Ussd_model extends CI_Model
{
    const MOBILE_SERVICE_ID = 93;

    private $api_key;
    private $sms_push_url;
    private $user;
    private $sms_sender_id;

    function __construct()
    {
        parent::__construct();

        $this->sms_sender_id = '15200';
        $this->api_key = '7jl4QjSEKLwBAYWa0Z5YNn5FUdnrxkeY0CYkxIt8';
        $this->user = 'afyadata@sacids.org';
        $this->sms_push_url = 'http://154.118.230.108/msdg/public/quick_sms';
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
    }

    //push sms
    public function send_push_sms($post_data)
    {
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
        log_message("info", "http response code " . curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);
    }
}