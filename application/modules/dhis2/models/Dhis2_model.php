<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 17/01/2018
 * Time: 13:33
 */

class Dhis2_model extends CI_Model
{

    private static $base_url = "http://192.168.43.215:8082/";
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
    public static $DATASET_UPLOAD_URL = "api/26/dataValueSets";
    public static $DATA_VALUES_URL = "api/dataValues";
    public static $DATASET_VALUES_URL = "api/dataSets";

    public static $FORM_PARAM = "form?ou=";
    public static $PERIOD_PARAM = "&pe=";


    public function post_data($url_endpoint, $data)
    {
        $headers = array(
            "Accept:application/json",
            "Content-Type:application/json",
            //'Authorization: Basic ' . base64_encode("admin:district")
            'Authorization: Basic ' . base64_encode("gakyoo:Afyadata2018!")
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->get_absolute_url($url_endpoint));
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

    public function get_absolute_url($endpoint = NULL)
    {
        if ($endpoint == NULL) {
            if ($this->endpoint != NULL)
                $endpoint = $this->endpoint;
            else
                $endpoint = "resources";
        }
        log_message("debug", "Dhis2 called url " . self::$base_url . $endpoint);
        return self::$base_url . $endpoint;
    }
}