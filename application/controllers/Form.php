<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package	    AfyaData
 * @author	    AfyaData Dev Team
 * @copyright	Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license	    http://opensource.org/licenses/MIT	MIT License
 * @link	    https://afyadata.sacids.org
 * @since	    Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/10/2016
 * Time: 9:51 AM
 */

class Form extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'Xform_model',
			'User_model'
		));
	}

	function index()
	{
		$data['title'] = $this->lang->line("heading_form_list");
		$data['forms'] = $this->Xform_model->get_form_list($this->session->userdata("user_id"));

		$this->load->view("form/index", $data);
	}

	function edit_form($xform_id)
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		if (!$xform_id) {
			$this->session->set_flashdata("message", $this->lang->line("select_form_to_edit"));
			redirect("xform/forms");
			exit;
		}

		$data['title'] = $this->lang->line("heading_edit_form");
		$data['form'] = $form = $this->Xform_model->find_by_id($xform_id);

		$this->form_validation->set_rules("title", $this->lang->line("validation_label_form_title"), "required");
		$this->form_validation->set_rules("access", $this->lang->line("validation_label_form_access"), "required");

		if ($this->form_validation->run() === FALSE) {
			$this->load->view("form/edit_form", $data);
		} else {

			if ($form) {
				$new_form_details = array(
					"title" => $this->input->post("title"),
					"description" => $this->input->post("description"),
					"access" => $this->input->post("access"),
					"last_updated" => date("c")
				);

				if ($this->Xform_model->update_form($xform_id, $new_form_details)) {
					$this->session->set_flashdata("message", $this->lang->line("form_update_successful"));
				} else {
					$this->session->set_flashdata("message", $this->lang->line("form_update_failed"));
				}
				redirect("xform/forms");
			} else {
				$this->session->set_flashdata("message", $this->lang->line("unknown_error_occurred"));
				redirect("xform/forms");
			}
		}
	}

	function delete_xform($xform_id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		if (!$xform_id) {
			$this->session->set_flashdata("message", $this->lang->line("select_form_to_delete"));
			redirect("xform/forms");
			exit;
		}

		$xform = $this->Xform_model->find_by_id($xform_id);
		$archive_xform_data = (array)$xform;
		$archive_xform_data['filename'] = time() . "_" . $xform->filename; //appended timestamp to avoid overriding existing files
		$archive_xform_data['last_updated'] = date("c"); //todo time form deleted

		$this->db->trans_start();
		$this->Xform_model->create_archive($archive_xform_data);

		$this->Xform_model->delete_form($xform_id);
		$this->db->trans_complete();

		if ($this->db->trans_status()) {

			$file_to_move = $this->config->item("form_definition_upload_dir") . $xform->filename;
			$file_destination = $this->config->item("form_definition_archive_dir") . $archive_xform_data['filename'];

			if (file_exists($file_to_move)) {

				if (rename($file_to_move, $file_destination))
					log_message("debug", "Move form definition file " . $xform->filename . " to " . $file_destination);
				else
					log_message("debug", "Failed to move form definition file " . $xform->filename);
			}

			$this->session->set_flashdata("message", $this->lang->line("form_delete_successful"));
		} else {
			$this->session->set_flashdata("message", $this->lang->line("error_failed_to_delete_form"));
		}
		redirect("xform/forms");
	}

	function form_data($form_id)
	{

		if (!$form_id) {
			$this->session->set_flashdata("message", $this->lang->line("select_form_to_delete"));
			redirect("xform/forms");
			exit;
		}

		$form = $this->Xform_model->find_by_id($form_id);

		if ($form) {
			// check if form_id ~ form data table is not empty or null
			$data['title'] = $form->title . " form";
			$data['table_fields'] = $this->Xform_model->find_table_columns($form->form_id);
			$data['form_data'] = $this->Xform_model->find_form_data($form->form_id);

			$this->load->view("form/form_data_details", $data);

		} else {
			// form does not exist
		}
	}

	function add_new()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		$data['title'] = $this->lang->line("heading_add_new_form");

		$this->form_validation->set_rules("title", $this->lang->line("validation_label_form_title"), "required|is_unique[xforms.title]");
		$this->form_validation->set_rules("access", $this->lang->line("validation_label_form_access"), "required");

		if ($this->form_validation->run() === FALSE) {
			$this->load->view("form/add_new", $data);
		} else {

			$form_definition_upload_dir = $this->config->item("form_definition_upload_dir");

			if (!empty($_FILES['userfile']['name'])) {

				$this->load->library('upload');
				$config['upload_path'] = $form_definition_upload_dir;
				$config['allowed_types'] = 'xml';
				$config['max_size'] = '1024';
				$config['remove_spaces'] = TRUE;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload()) {
					$this->session->set_flashdata("msg", "<div class='warning'>" . $this->upload->display_errors("", "") . "</div>");
					redirect("xform/add_new");
				} else {
					$xml_data = $this->upload->data();
					$filename = $xml_data['file_name'];

					//TODO Check if file already exist and prompt user.

					$form_details = array(
						"user_id" => $this->session->userdata("user_id"),
						"title" => $this->input->post("title"),
						"description" => $this->input->post("description"),
						"filename" => $filename,
						"date_created" => date("c"),
						"access" => $this->input->post("access")
					);

					$this->db->trans_start();
					$this->Xform_model->create_xform($form_details);
					//get last insert id
					$xform_id = $this->db->insert_id();
					//set form_id to current table_name variable
					$this->Xform_model->update_form_id($xform_id, $this->table_name);
					$this->db->trans_complete();

					if ($this->db->trans_status()) {
						//TODO Check if form is built from ODK Aggregate Build to avoid errors during initialization
						$this->_initialize($filename); // create form table.

						//TODO perform error checking,
						$this->session->set_flashdata("message", $this->lang->line("form_upload_successful"));
					} else {
						$this->session->set_flashdata("message", $this->lang->line("form_upload_failed"));
					}
					redirect("xform/add_new");
				}

			} else {
				$this->session->set_flashdata("msg", $this->lang->line("form_saving_failed"));
				redirect("xform/add_new");
			}
		}
	}
}