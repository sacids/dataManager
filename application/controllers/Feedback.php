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
		//get form_id and last_feedback_id
		$username = $this->input->get("username");
		$form_id = $this->input->get('form_id');
		$last_id = $this->input->get('last_id');

		$user = $this->User_model->find_by_username($username);
		$feedback = $this->Feedback_model->get_feedback($user->id, $form_id, $last_id);

		if ($feedback) {
			$response = array("feedback" => $feedback, "status" => "success");
			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
		} else {
			$response = array("status" => "success", "message" => "No content");
			$this->output
				->set_status_header(204)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
		}
	}

	function post_feedback()
	{
		$username = $this->input->post("username");

		$user = $this->User_model->find_by_username($username);


		if ($user) {
			$feedback = array(
				"user_id" => $user->id,
				"form_id" => $this->input->post("form_id"),
				"message" => $this->input->post("message"),
				"created_at" => date("c")
			);

			if ($this->Feedback_model->create_feedback($feedback)) {
				$response = array("message" => "Feedback was received successfully", "status" => "success");
				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
					->_display();
			} else {
				$response = array(
					"status" => "failed",
					"message" => "Unknown error occured"
				);
				$this->output
					->set_status_header(400)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
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
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
		}
	}
}