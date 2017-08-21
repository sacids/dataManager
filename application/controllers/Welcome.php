<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller
{

	private $data;

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->data['title'] = 'Taarifa kwa wakati';

		//render view
		$this->load->view('layout/header', $this->data);
		$this->load->view('view');
		$this->load->view('layout/footer');
	}

	public function health_map()
	{
		$this->load->model("Xform_model");

		$geo_data = $this->Xform_model->get_geospatial_data("ad_build_afyadata_demo_1500530768");

		$geo_data_array = [];
		$count = 0;
		foreach ($geo_data as $data) {
			if (isset($data['_xf_c6a6184e0be6372480cae841cc28dba4'])) {
				$geo_data_array[$count]['event'] = $data['_xf_72485ff63b11061b01c236b9c62b58bd'];
				$points = explode(" ", $data['_xf_c6a6184e0be6372480cae841cc28dba4']);
				$geo_data_array[$count]['lat'] = $points[0];
				$geo_data_array[$count]['lng'] = $points[1];
				$count++;
			}
		}
		$data['geo_data_json'] = json_encode($geo_data_array);
		$data['load_map'] = TRUE;

		$this->load->view('layout/header', $data);
		$this->load->view('health_map_view', $data);
		$this->load->view('layout/footer');
	}
}
