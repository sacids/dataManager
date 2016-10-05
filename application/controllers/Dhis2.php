<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 09-Jun-16
 * Time: 09:49
 */
class Dhis2 extends CI_Controller
{

	private static $base_url = "http://127.0.0.1:8082/";
	private $endpoint;
	private static $API_RESOURCES = "api/resources";

	private static $ORGANISATION_UNITS = "api/organisationUnits";

	public static $API_USER_ACCOUNT_URL = "api/me/user-account";

	public static $PROGRAMS_URL = "api/me/assignedPrograms";
	public static $ANONYMOUS_EVENT_PARAM = "?type=3";
	public static $EVENT_URL = "api/events";
	public static $OPTION_SET_PARAM = "?fields=id,name,created,lastUpdated,
	externalAccess,version,options[id,name,code,created,lastUpdated]";
	public static $OPTION_SET_URL = "api/optionSets";

	public static $DATASETS_URL = "api/me/assignedDataSets";
	public static $DATASET_UPLOAD_URL = "api/dataValueSets";
	public static $DATASET_VALUES_URL = "api/dataSets";

	public static $FORM_PARAM = "form?ou=";
	public static $PERIOD_PARAM = "&pe=";


	function __construct()
	{
		parent::__construct();
	}

	function api_resources()
	{
		echo $this->_send_get_request($this->_get_absolute_url(self::$API_RESOURCES));
	}

	function organisation_units()
	{
		echo $this->_send_get_request($this->_get_absolute_url(self::$ORGANISATION_UNITS));
	}

	function user_account()
	{
		echo $this->_send_get_request($this->_get_absolute_url(self::$API_USER_ACCOUNT_URL));
	}

	function _set_api_end_point($endpoint)
	{
		$this->endpoint = $endpoint;
	}

	function _get_absolute_url($endpoint = NULL)
	{
		if ($endpoint == NULL) {
			if ($this->endpoint != NULL)
				$endpoint = $this->endpoint;
			else
				$endpoint = "resources";
		}
		return self::$base_url . $endpoint;
	}

	function _send_get_request($url)
	{
		$headers = array(
			//"Accept: text/xml",
			'Authorization: Basic ' . base64_encode("admin:district")
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);

		$http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//TODO Check status code and return response accordingly.
		curl_close($ch);
		return $response;
	}
}