<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 4/21/2016
 * Time: 5:17 PM
 */
class Whatsapp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Whatsapp_model");
	}

	public function index()
	{

		if ($this->form_validation->run()) {
			$this->_show_upload_form();
		} else {
			$file_upload_path = APPPATH . DS . ".." . DS . "assets" . DS . "whatsapp";


			$handle = fopen($file_upload_path . DS . "WhatsAppChatwithWanaCHRsNgorongoro.txt", "r");
			if ($handle) {
				while (($line = fgets($handle)) !== FALSE) {
					$message = $this->_extract_line_message($line);

					echo "<pre>";
					print_r($message);
					$this->Whatsapp_model->create($message);
				}
				fclose($handle);
			} else {
				log_message("debug", "error opening the file.");
			}
		}
	}

	function _show_upload_form()
	{
		echo form_open_multipart("whatsapp");
		echo form_upload("userfile");
		echo form_close();
	}

	function _extract_line_message($line)
	{
		//TODO Check if all three parts are in array to avoid undefined index errors
		$first_split = explode('-', $line, 2);
		$date_sent_received = $first_split[0];

		$second_split = explode(':', $first_split[1], 2);
		$username = $second_split[0];
		$message = $second_split[1];

		$date_obj = date_create_from_format('d/m/Y, H:i A',trim($date_sent_received));

		$chat = array(
			"fullname" => trim($username),
			"message" => trim($message),
			"date_sent_received" => $date_obj->format('Y-m-d h:i:s'),
			"date_created" => date("c")
		);

		log_message("debug",json_encode($chat));
		return $chat;
	}

	function test(){
		//echo strtotime(str_replace("/","-","25/02/2016, 3:07 PM"));
		$date = date_create_from_format('d/m/Y, H:i A', "25/02/2016, 3:07 PM");
		echo "<pre>";
		print_r($date);
		echo $date->format('Y-m-d h:i:s');
	}


	public function message_list()
	{
		//check login
		//$this->_is_logged_in();

		$config = array(
			'base_url' => $this->config->base_url("whatsapp/message_list"),
			'total_rows' => $this->Whatsapp_model->count_message(),
			'uri_segment' => 3,
		);

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['messages'] = $this->Whatsapp_model->find_all_message($this->pagination->per_page, $page);
		$data["links"] = $this->pagination->create_links();

		//render view
		$data['title'] = "Message List";
		$this->load->view('header', $data);
		$this->load->view("whatsapp/message_list", $data);
		$this->load->view('footer');
	}
}