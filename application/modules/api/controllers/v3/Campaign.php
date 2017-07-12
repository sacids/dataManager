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
        $this->load->model('model');

        //variables
        $this->imageUrl = base_url() . 'assets/forms/data/images/';
    }

    //get campaign ;ist
    function index_get()
    {
        $this->model->set_table('campaign');
        $query = $this->model->get_all();

        //check if campaign exists
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
            $this->response(array("campaign" => $campaign, "status" => "success"), 200);

        } else {
            $this->response(array('status' => 'failed', 'message' => 'No campaign found'), 204);
        }
    }

}