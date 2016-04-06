<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *Form Feedback Class
 *
 * @package     Data
 * @category    Controller
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Feedback extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Feedback_model', 'User_model'));
		$this->load->library('form_auth');
		$this->load->helper(array('url', 'string'));
		log_message('debug', 'Feedback controller initialized');

		//$this->output->enable_profiler(TRUE);
	}


	/**
	 * XML submission class
	 *
	 * @return response
	 */

	function get_feedback()
	{

		//TODO Returning feedback instance_id
		//get form_id and last_feedback_id
		$username = $this->input->get("username");
		$instance_id = $this->input->get('instance_id'); // todo get feedback by instance id
		$form_id = $this->input->get('form_id');
		$last_id = $this->input->get('last_id');

		if (!$username) {
			$response = array("status" => "failed", "message" => "Required username");
			$this->output
				->set_status_header(400)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response))
				->_display();
		}

		$user = $this->User_model->find_by_username($username);
		log_message("debug", "username getting feedback is " . $username);
		if ($user) {
			if ($form_id)
				$feedback = $this->Feedback_model->get_feedback($user->id, $form_id, $last_id);
			else
				$feedback = $this->Feedback_model->get_feedback($user->id); //Todo add last id later

			if ($feedback) {
				$response = array("feedback" => $feedback, "status" => "success");
				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response))
					->_display();
			} else {
				$response = array("status" => "success", "message" => "No content");
				$this->output
					->set_status_header(204)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response))
					->_display();
			}
		} else {
			$response = array("status" => "failed", "message" => "User does not exist");
			$this->output
				->set_status_header(400)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response))
				->_display();
		}

	}

	function post_feedback()
	{
		$username = $this->input->post("username");

		log_message("debug", "User posting feedback is " . $username);
		$user = $this->User_model->find_by_username($username);

		if ($user) {
			$feedback = array(
				"user_id" => $user->id,
				"instance_id" => $this->input->post("instance_id"),
				"form_id" => $this->input->post("form_id"),
				"message" => $this->input->post("message"),
				'sender' => $this->input->post("sender"),
				"date_created" => date("c")
			);

			if ($this->Feedback_model->create_feedback($feedback)) {
				$response = array("message" => "Feedback was received successfully", "status" => "success");
				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response))
					->_display();
			} else {
				$response = array(
					"status" => "failed",
					"message" => "Unknown error occured"
				);
				$this->output
					->set_status_header(400)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response))
					->_display();
			}
		} else {
			$response = array(
				"status" => "failed",
				"message" => "user does not exist"
			);
			$this->output
				->set_status_header(400)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response))
				->_display();
		}
	}
}