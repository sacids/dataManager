<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 3/20/2017
 * Time: 11:31 AM
 */
class Ussd extends CI_Controller
{
	const MOBILE_SERVICE_ID = 93;
	private $sms_sender_id;

	function __construct()
	{
		parent::__construct();
		$this->sms_sender_id = $this->config->item("ega_api_sms_sender_id");
		$this->load->model("Ussd_model");
	}

	//push message
	function sms_push()
	{
		$date_time = date('Y-m-d H:i:s');
		$message = array(
			'recipients'        => '255717705746,255753437856,255712404118',
			'message'           => 'Testing message from AfyaData API ' . $date_time,
			'datetime'          => $date_time,
			'sender_id'         => $this->sms_sender_id,
			'mobile_service_id' => self::MOBILE_SERVICE_ID
		);
		$post_data = array('data' => json_encode($message), 'datetime' => $date_time);
		$response = $this->Ussd_model->send_push_sms($post_data);
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
				'name'    => 'Renfrid Ngolongolo',
				'gender'  => 'Male'
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
			'status'    => TRUE,
			'sms_reply' => TRUE,
			'sms_text'  => 'Ombi lako limepokelewa kwa nambari ya kumbukumbu AFYADATA'
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
			'message'        => 'Request Received Successfully.',
			'reply'          => 1
		);

		echo json_encode($response);
	}
}