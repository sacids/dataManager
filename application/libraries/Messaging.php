<?php

/**
 * Messaging class
 *
 * @package     Messaging
 * @category    Library
 * @author      Renfrid Ngolongolo
 * @link        http://multics.co.tz
 */
class Messaging
{
    private $ci;
    private $token_base_url;
    private $sms_base_url;
    private $headers;

    function __construct()
    {
        $this->ci = &get_instance();

        $this->token_base_url = 'https://api.orange.com/oauth/v3/token';
        $this->sms_base_url = 'https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B224622731178/requests';

        $this->headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'authorization: Basic ' . $this->ci->config->item("orange_token"),
        );
    }




    //action to send notification
    function send_sms($phone, $message)
    {
        //create token
        $api_token = $this->create_token();
        log_message("debug", "token => " . $api_token);

        //post data
        $post_data = [
            "outboundSMSMessageRequest" => [
                "address" => "tel:" . $phone,
                "senderAddress" => "tel:+224622731178",
                "outboundSMSTextMessage" => [
                    "message" => $message
                ]
            ]
        ];
        //convert array to json
        $json_data = json_encode($post_data);

        //initiate curl
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->sms_base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json_data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        log_message("debug", "orange response => " . json_encode($response));

        //return respose
        echo json_encode(['error' => false, "success_msg" => "Message sent"]);
    }

    function create_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->token_base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => $this->headers
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);

        //return access token
        return $response->access_token;
    }

    //generate message_id
    function generate_message_id()
    {
        //the characters you want in your id
        $characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $max = strlen($characters) - 1;
        $string = '';

        for ($i = 0; $i <= 10; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }

        return $string;
    }

    //remove 0 and + on start of mobile
    function cast_mobile($mobile)
    {
        if (preg_match("~^0\d+$~", $mobile)) {
            return '+224' . substr($mobile, 1);
        } else if (substr($mobile, 0, 3) != '224' & strlen($mobile) == 9) {
            return '+224' . $mobile;
        }else if (substr($mobile, 0, 3) == '224') {
            return '+224' . substr($mobile, 3);
        }
    }

    //remove 0 and add +
    function trim_zero_mobile($mobile)
    {
        if (preg_match("~^0\d+$~", $mobile)) {
            return '+224' . substr($mobile, 1);
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/libraries/Message.php */