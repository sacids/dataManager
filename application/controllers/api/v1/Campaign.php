<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 3:41 PM
 */
class Campaign extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Campaign_model'));
    }

    /**
     * get_campaign function
     *
     * @return response
     */
    function get_campaign()
    {
        //campaign result
        $campaign = $this->Campaign_model->get_campaign();

        if ($campaign) {
            $response = array("campaign" => $campaign, "status" => "success");

        } else {
            $response = array("status" => "success", "message" => "No content");

        }
        echo json_encode($response);
    }

}