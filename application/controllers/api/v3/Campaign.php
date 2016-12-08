<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 11/2/2016
 * Time: 3:53 PM
 */
class Campaign extends REST_Controller
{
    private $imageUrl;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Campaign_model'));

        //variables
        $this->imageUrl = base_url() . 'assets/forms/data/images/';
    }


    function index_get()
    {
        $query = $this->Campaign_model->get_campaign_list();

        if ($query) {
            foreach ($query as $value) {
                $campaign[] = array(
                    'id' => $value->id,
                    'title' => $value->title,
                    'type' => $value->type,
                    'jr_form_id' => $value->jr_form_id,
                    'featured' => $value->featured,
                    'icon' => $this->imageUrl . $value->icon,
                    'description' => $value->description,
                    'date_created' => $value->date_created
                );
            }
            //response
            $response = array("campaign" => $campaign, "status" => "success");
            $this->response($response, 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No campaign found'));
        }
    }

}