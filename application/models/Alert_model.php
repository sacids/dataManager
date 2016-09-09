<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 26-Aug-16
 * Time: 12:01
 */
class Alert_model extends CI_Model
{

	private static $info_bip_base_url = "https://api.infobip.com/";
	private $user_agent = "curl/7.35.0 (AfyaData Alerts; Ubuntu 14.04.2 LTS;) Gecko/20100101 adSMS/1";
	private $headers = array(
		'accept:application/json',
		'content-Type:application/json',
		'authorization: Basic base64pwd',
		'accept-encoding:gzip'
	);

	private static $table_name_sent_sms = "ohkr_sent_sms";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $url
	 * @param $sms_details
	 * @param $mode String SINGLE/MULTIPLE
	 * @return mixed
	 */
	public function send_alert_sms($url, $sms_details, $mode = "SINGLE")
	{
		$post_fields = json_encode($sms_details);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, static::$info_bip_base_url . $url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

		//todo Check if response code is 200 or 300 then is successful otherwise return false
		$response = curl_exec($ch);
		$http_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return ($http_response_code == 200 || $http_response_code == 300) ? $response : FALSE;
	}

	/**
	 * @param $url
	 * @return mixed
	 */
	public function get_delivery_status($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	/**
	 * @param $id
	 * @param $sms
	 * @return mixed
	 */
	public function update_sms_status($id, $sms)
	{
		$this->db->where("id", $id);
		$this->db->limit(1);
		return $this->db->update(self::$table_name_sent_sms, $sms);
	}
}