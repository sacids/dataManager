<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017. Southern African Center for Infectious disease Surveillance (SACIDS)
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
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Renfrid
 * Date: 5/5/17
 * Time: 12:13 PM
 */
class Projects extends MX_Controller
{
	private $controller;
	private $data;
	private $user_id;

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		$this->load->model(array('Project_model'));
		$this->user_id = $this->session->userdata("user_id");
		$this->controller = $this->router->fetch_class();
	}

	/**
	 * Check login
	 *
	 * @return response
	 */
	function _is_logged_in()
	{
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	}

	/**
	 * @param $method_name
	 * Check if user has permission
	 */
	function has_allowed_perm($method_name)
	{
		if (!perms_role($this->controller, $method_name)) {
			show_error("You are not allowed to view this page", 401, "Unauthorized");
		}
	}

	//list projects
	function lists()
	{
		$this->data['title'] = "List projects";

		//check if logged in
		$this->_is_logged_in();

		//check permission
		//$this->has_allowed_perm($this->router->fetch_method());

		$config = array(
			'base_url'    => $this->config->base_url("projects/lists"),
			'total_rows'  => $this->Project_model->count_projects(),
			'uri_segment' => 3,
		);

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$this->data['project_list'] = $this->Project_model->get_project_list($this->pagination->per_page, $page);
		$this->data["links"] = $this->pagination->create_links();

		//render view
		$this->load->view('header', $this->data);
		$this->load->view("lists");
		$this->load->view('footer');
	}

	//add new project
	function add_new()
	{
		$this->data['title'] = "Add new project";

		//check if logged in
		$this->_is_logged_in();

		//check permission
		//$this->has_allowed_perm($this->router->fetch_method());

		//form validation
		$this->form_validation->set_rules('name', 'Title', 'required|trim');
		$this->form_validation->set_rules('description', 'Description', 'required|trim');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'title'       => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'created_at'  => date('Y-m-d H:i:s'),
				'owner'       => $this->user_id
			);
			$id = $this->db->insert('projects', $data);

			if ($id) {
				$this->session->set_flashdata('message', display_message('Project added'));
				redirect('projects/lists', 'refresh');
			} else {
				$this->session->set_flashdata('message', display_message('Failed to add project', 'danger'));
				redirect('projects/add_new', 'refresh');
			}
		}

		//populate data
		$this->data['name'] = array(
			'name'        => 'name',
			'id'          => 'name',
			'type'        => 'text',
			'value'       => $this->form_validation->set_value('name'),
			'class'       => 'form-control',
			'placeholder' => 'Enter project title'
		);

		$this->data['description'] = array(
			'name'        => 'description',
			'id'          => 'description',
			'type'        => 'text area',
			'value'       => $this->form_validation->set_value('description'),
			'rows'        => '5',
			'class'       => 'form-control',
			'placeholder' => 'Enter project description'
		);

		//render view
		$this->load->view('header', $this->data);
		$this->load->view("add_new");
		$this->load->view('footer');
	}


	//edit project
	function edit($project_id)
	{
		$this->data['title'] = "Edit project";

		//check if logged in
		$this->_is_logged_in();

		//check permission
		//$this->has_allowed_perm($this->router->fetch_method());

		$project = $this->Project_model->get_project_by_id($project_id);

		//form validation
		$this->form_validation->set_rules('name', 'Title', 'required|trim');
		$this->form_validation->set_rules('description', 'Description', 'required|trim');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'title'       => $this->input->post('name'),
				'description' => $this->input->post('description')
			);
			$this->db->update('projects', $data, array('id' => $project_id));

			$this->session->set_flashdata('message', display_message('Project updated'));
			redirect('projects/lists', 'refresh');
		}

		//populate data
		$this->data['name'] = array(
			'name'  => 'name',
			'id'    => 'name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('name', $project->title),
			'class' => 'form-control'
		);

		$this->data['description'] = array(
			'name'  => 'description',
			'id'    => 'description',
			'type'  => 'text area',
			'value' => $this->form_validation->set_value('description', $project->description),
			'rows'  => '5',
			'class' => 'form-control'
		);

		//render view
		$this->load->view('header', $this->data);
		$this->load->view("edit");
		$this->load->view('footer');
	}

	public function forms($project_id = NULL)
	{
		$project_forms = NULL;
		if ($project_id) {
			$project_forms = $this->Project_model->find_project_forms($project_id);
			$project_forms_count = $this->Project_model->count_project_forms($project_id);
		}

		if ($this->input->is_ajax_request()) {
			if ($project_forms != NULL) {
				echo json_encode(['status' => "success", "forms_count" => $project_forms_count, "forms" => $project_forms]);
			} else {
				echo json_encode(['status' => "success", "forms_count" => $project_forms_count]);
			}
		} else {
			$this->data['forms'] = $project_forms;
		}
	}
}