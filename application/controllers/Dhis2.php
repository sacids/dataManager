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

	private static $ORGANISATION_UNITS = "api/organisationUnits?page=";

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

	function api()
	{
		$this->api_resources();
	}

	function api_resources()
	{
		echo $this->_send_get_request($this->_get_absolute_url(self::$API_RESOURCES));
	}

	function organisation_units($page = 1)
	{
		echo $this->_send_get_request($this->_get_absolute_url(self::$ORGANISATION_UNITS . $page));
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
			//"Content-Type:text/xml",
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

	function _post_data($url, $data)
	{
		$headers = array(
			"Content-Type:application/json",
			'Authorization: Basic ' . base64_encode("gakyoo:AfyaData123")
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		$response = curl_exec($ch);

		$http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		log_message("debug", "Dhis2 Post request status " . $http_status_code);
		//TODO Check status code and return response accordingly.
		curl_close($ch);
		return $response;
	}


	function create_dataset()
	{

		$dhis2_data = array(
			"dataSet"      => "AuMIR3qLjI8",
			"completeDate" => date("Y-m-d"),
			"period"       => "201702",
			"orgUnit"      => "dwTq2CbVWhC", //AfyaDataTest  id for Morogoro Regional Hospital
			"name"         => "AfyaDataTest DHIS2",// . date("Y-m-d H:i:s"),
			"periodType"   => "Daily",
//			"attributeOptionCombo" => "jgxivsFwmyR",
			"dataValues"   => array(
				array(
					"dataElement" => "Ht3Nw94dOP7",
//					"categoryOptionCombo" => "HllvX50cXC0",
					"period"      => "20170201",
					"value"       => mt_rand(1, 50),
					"comment"     => "HIV Cases report",
				),//HIV AIDS Cases
				array(
					"dataElement" => "IjezpgJWhMB",
//					"categoryOptionCombo" => "HllvX50cXC0",
					"period"      => "20170201",
					"value"       => mt_rand(1, 5),
					"comment"     => "Malaria cases"
				), //Malaria cases
				array(
					"dataElement" => "RQSBQrKmCOt",
//					"categoryOptionCombo" => "HllvX50cXC0",
					"period"      => "20170201",
					"value"       => mt_rand(0, 20),
					"comment"     => "Typhoid cases"
				),//Cholera Cases
			)
		);

		log_message("debug", "Data to DHIS2 " . json_encode($dhis2_data));

		header("Content-Type:text/json");
		$response = $this->_post_data($this->_get_absolute_url(self::$DATASET_VALUES_URL), $dhis2_data);
		echo $response;
	}

	function send_data_values()
	{

		$data_values = array();
		for ($i = 1; $i <= 28; $i++) {
			$data_values["dataValue"][] = array(
				"dataElement"         => "IjezpgJWhMB",//Malaria
				"categoryOptionCombo" => "HllvX50cXC0",
				"period"              => "201702" . $i,
				"value"               => mt_rand(0, 200)
			);
			$data_values['dataValue'][] = array(
				"dataElement"         => "Ht3Nw94dOP7", //HIV
				"categoryOptionCombo" => "HllvX50cXC0",
				"period"              => "201702" . $i,
				"value"               => mt_rand(0, 200)
			);
			$data_values["dataValue"][] = array(
				"dataElement"         => "RQSBQrKmCOt",//Cholera
				"categoryOptionCombo" => "HllvX50cXC0",
				"period"              => "201702" . $i,
				"value"               => mt_rand(0, 200)
			);
		}
		//echo json_encode($data_values);
		log_message("debug", json_encode($data_values));
		header("Content-Type:text/json");
		$response = $this->_post_data($this->_get_absolute_url(
			self::$DATASET_UPLOAD_URL . "?dryRun=false&importStrategy=CREATE"), $data_values);
		echo $response;
	}

	function get()
	{
		echo $this->_send_get_request($this->_get_absolute_url(self::$DATASETS_URL));
	}
}