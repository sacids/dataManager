<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 6/20/2016
 * Time: 3:42 PM
 */
class Feedback extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * get Feedback Api
	 */
	function get_feedback()
	{
		//$this->output->enable_profiler(TRUE);

		$username = $this->input->get("username");
		$date_created = $this->input->get("date_created");
		$lang = $this->input->get('language');

		//check if no username
		if (!$username) {
			$response = array("status" => "failed", "message" => "Required username");
			echo json_encode($response);
			exit;
		}


		$user = $this->User_model->find_by_username($username);
		log_message("debug", "username getting forms feedback is " . $username);

		if ($user) {
			//TODO: call function for permission, return chat user (form_id) needed to see
			$my_perms = $this->Perm_model->get_my_perms($user->id);
			$cond = "FALSE OR (`perms` LIKE '%" . implode("%' OR `perms` LIKE '%", $my_perms) . "%')";

			$where = ' where ' . $cond;
			$table_name = 'xforms';

			//Perms module
			$perms = $this->db->query('SELECT * FROM ' . $table_name . ' ' . $where)->result();


			$i = 1;
			foreach ($perms as $perm) {
				$where_perm[$i] = $perm->form_id;
				$i++;
			}

			//Feedback Mapping
			$feedback_mapping = $this->Feedback_model->get_feedback_mapping($user->id);

			//check if mapping is not empty
			if ($feedback_mapping) {
				$where_array = explode(',', $feedback_mapping->users);
			} else {
				$where_array = $user->id;
			}

			//feedback List
			$feedback_list = $this->Feedback_model->get_feedback_list($where_perm, $where_array, $date_created);

			foreach ($feedback_list as $value) {
				$first_name = $this->User_model->find_by_id($value->user_id)->first_name;
				$last_name = $this->User_model->find_by_id($value->user_id)->last_name;
				$chr_name = $first_name . ' ' . $last_name;
				$username = $this->User_model->find_by_id($user->id)->username;
				$form_name = $this->Xform_model->find_by_xform_id($value->form_id)->title;

				//get reply user
				if ($value->reply_by != 0) {
					$reply_user = $this->Feedback_model->get_reply_user($value->reply_by);
				} else {
					$reply_user = $value->reply_by;
				}

				$feedback[] = array(
					'id'           => $value->id,
					'form_id'      => $value->form_id,
					'instance_id'  => $value->instance_id,
					'title'        => $form_name,
					'message'      => $value->message,
					'sender'       => $value->sender,
					'user'         => $username,
					'chr_name'     => $chr_name,
					'date_created' => $value->date_created,
					'status'       => $value->status,
					'reply_by'     => $reply_user
				);
			}

			$response = array("feedback" => $feedback, "status" => "success");

		} else {
			$response = array("status" => "failed", "message" => "User does not exist");
		}
		echo json_encode($response);
	}


	/**
	 * get Feedback Api
	 */
	function get_notification_feedback()
	{
		$username = $this->input->get("username");
		$date_created = $this->input->get("date_created");
		$lang = $this->input->get('language');

		//check if no username
		if (!$username) {
			$response = array("status" => "failed", "message" => "Required username");
			echo json_encode($response);
			exit;
		}

		$user = $this->User_model->find_by_username($username);
		log_message("debug", "username getting forms feedback is " . $username);

		if ($user) {
			//TODO: call function for permission, return chat user (form_id) needed to see
			$my_perms = $this->Perm_model->get_my_perms($user->id);
			$cond = "FALSE OR (`perms` LIKE '%" . implode("%' OR `perms` LIKE '%", $my_perms) . "%')";

			$where = ' where ' . $cond;
			$table_name = 'xforms';

			//Perms module
			$perms = $this->db->query('SELECT * FROM ' . $table_name . ' ' . $where)->result();

			$i = 1;
			foreach ($perms as $perm) {
				$where_perm[$i] = $perm->form_id;
				$i++;
			}

			//Feedback Mapping
			$feedback_mapping = $this->Feedback_model->get_feedback_mapping($user->id);

			//check if mapping is not empty
			if ($feedback_mapping) {
				$where_array = explode(',', $feedback_mapping->users);
			} else {
				$where_array = $user->id;
			}
			//feedback list
			$feedback_list = $this->Feedback_model->get_feedback_list($where_perm, $where_array, $date_created);
			$feedback = [];
			foreach ($feedback_list as $value) {
				$username = $this->User_model->find_by_id($value->user_id)->first_name;
				$reply_user = $this->Feedback_model->get_reply_user($value->reply_by);
				$form_name = $this->Xform_model->find_by_xform_id($value->form_id)->title;

				$feedback[] = array(
					'id'           => $value->id,
					'form_id'      => $value->form_id,
					'instance_id'  => $value->instance_id,
					'title'        => $form_name,
					'message'      => $value->message,
					'sender'       => $value->sender,
					'user'         => $username,
					'date_created' => $value->date_created,
					'status'       => $value->status,
					'reply_by'     => $reply_user
				);
			}

			$response = array("feedback" => $feedback, "status" => "success");
		} else {
			$response = array("status" => "failed", "message" => "User does not exist");
		}
		echo json_encode($response);
	}


	/**
	 * post Feedback Api
	 */
	function post_feedback()
	{
		$username = $this->input->post("username");
		$instance_id = $this->input->post("instance_id");
		$lang = $this->input->post('language');

		//check if no username
		if (!$username) {
			$response = array("status" => "failed", "message" => "Required username");
			echo json_encode($response);
			exit;
		}

		//get user details
		$user = $this->User_model->find_by_username($username);
		log_message("debug", "User posting feedback is " . $username);

		if ($user) {
			//query details from feedback
			$query = $this->db->get_where('feedback', array('instance_id' => $instance_id))->row();

			//update all feedback from this user
			$this->Feedback_model->update_user_feedback($instance_id, 'server');

			$feedback = array(
				"user_id"      => $query->user_id,
				"instance_id"  => $instance_id,
				"form_id"      => $this->input->post('form_id'),
				"message"      => $this->input->post("message"),
				'sender'       => $this->input->post("sender"),
				"date_created" => date('Y-m-d H:i:s'),
				"status"       => $this->input->post("status"),
				"reply_by"     => 0
			);

			if ($this->Feedback_model->create_feedback($feedback)) {
				$response = array("message" => "Feedback was received successfully", "status" => "success");

			} else {
				$response = array("status" => "failed", "message" => "Unknown error occured");

			}
		} else {
			$response = array("status" => "failed", "message" => "user does not exist");

		}
		echo json_encode($response);
	}

	/**
	 * Form Feedback Api
	 */
	function get_form_details()
	{
		$table_name = $this->input->get('table_name');
		$instance_id = $this->input->get('instance_id');
		$lang = $this->input->get('language');

		if ($table_name == NULL || $instance_id == NULL) {
			$response = array("status" => "failed", "message" => "Invalid table name or instance Id");

		} else {
			$this->table_name = $table_name;
			$this->instance_id = $instance_id;

			// get definition file name
			$form_details = $this->Feedback_model->get_form_details($table_name);
			$file_name = $form_details->filename;
			$this->xform_comm->set_defn_file($this->config->item("form_definition_upload_dir") . $file_name);
			$this->xform_comm->load_xml_definition($this->config->item("xform_tables_prefix"));
			$form_definition = $this->xform_comm->get_defn();
			$form_data = $this->get_form_data($form_definition, $this->get_fieldname_map($table_name));
			if ($form_data) {
				$response = array("form_details" => $form_data, "status" => "success");
			} else {
				$response = array("status" => "failed", "message" => "Nothing found");
			}
		}

		echo json_encode($response);
	}

	function get_form_data($structure, $map)
	{
		$data = $this->Feedback_model->get_feedback_form_details($this->table_name, $this->instance_id);
		if (!$data) return FALSE;
		$holder = array();
		// print_r($map);
		//print_r($structure);
		$ext_dirs = array(
			'jpg'  => "images",
			'jpeg' => "images",
			'png'  => "images",
			'3gpp' => 'audio',
			'amr'  => 'audio',
			'3gp'  => 'video',
			'mp4'  => 'video');

		$c = 1;
		$id = $data->id;

		foreach ($structure as $val) {
			$tmp = array();
			$field_name = $val['field_name'];
			$type = $val['type'];
			if (!array_key_exists('label', $val)) {
				$label = $field_name;
			} else {
				$label = $val['label'];
			}
			if (array_key_exists($field_name, $map)) {
				$field_name = $map[$field_name]['col_name'];
			}
			$l = $data->$field_name;
			if ($type == 'select1') {
				$l = $val['option'][$l];
			}
			if ($type == 'binary') {
				// check file extension
				$value = explode('.', $l);
				$file_extension = end($value);
				if (array_key_exists($file_extension, $ext_dirs)) {
					$l = site_url('assets/forms/data') . '/' . $ext_dirs[$file_extension] . '/' . $l;
				}
			}
			if ($type == 'select') {
				$tmp1 = explode(" ", $l);
				$arr = array();
				foreach ($tmp1 as $item) {
					$item = trim($item);
					array_push($arr, $val['option'][$item]);
				}
				$l = implode(",", $arr);
			}
			if (substr($label, 0, 5) == 'meta_') continue;
			$tmp['id'] = $id . $c++;
			$tmp['label'] = $label;
			$tmp['type'] = $type;
			$tmp['value'] = $l;
			array_push($holder, $tmp);
		}
		return $holder;
	}

	private function get_fieldname_map($table_name)
	{
		$tmp = $this->Xform_model->get_fieldname_map($table_name);
		$map = array();
		foreach ($tmp as $part) {
			$key = $part['field_name'];
			$map[$key] = $part;
		}
		return $map;
	}

}