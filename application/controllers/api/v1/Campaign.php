<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 3:41 PM
 */
class Campaign extends CI_Controller
{

    private $imageUrl;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Campaign_model'));

        //variables
        $this->imageUrl = base_url() . 'assets/forms/data/images/';
    }

    /**
     * get_campaign function
     *
     * @return response
     */
    function get_campaign()
    {
        $query = $this->Campaign_model->get_campaign_list();

        if ($query) {
            foreach ($query as $value) {
                $campaign[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'type' => $value->type,
                    'form_id' => $value->form_id,
                    'icon' => $this->imageUrl . $value->icon,
                    'description' => $value->description,
                    'date_created' => $value->date_created
                );
            }
            $response = array("campaign" => $campaign, "status" => "success");

        } else {
            $response = array("status" => "success", "message" => "No campaign found");

        }
        echo json_encode($response);
    }

}