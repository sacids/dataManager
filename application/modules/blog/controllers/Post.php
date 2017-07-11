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
 * @package	    AfyaData
 * @author	    AfyaData Dev Team
 * @copyright	Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license	    http://opensource.org/licenses/MIT	MIT License
 * @link	    https://afyadata.sacids.org
 * @since	    Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 10:31
 */
class Post extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->load->model("Post_model");
	}

	public function index()
	{
		$this->posts();
	}

	public function posts()
	{
		$data['title'] = "Afyadata Blog";
		$data['posts'] = $this->Post_model->find_all();

		$this->load->view("blog_header", $data);
		$this->load->view("posts_view", $data);
		$this->load->view("blog_footer", $data);
	}

	public function post_details($post_id)
	{

		if (!$post_id)
			redirect("blog/post/");

		$data['title'] = "Afyadata Blog";
		$data['post'] = $this->Post_model->find_by_id($post_id);
		$data['recent_posts'] = $this->Post_model->find_all(5);

		$this->load->view("blog_header", $data);
		$this->load->view("single_post_view", $data);
		$this->load->view("blog_footer");
	}

	public function new_post()
	{
		//check session

		$data['title'] = "Afyadata Blog";

		$this->form_validation->set_rules("title", "Title", "required");
		$this->form_validation->set_rules("content", "Content", "");
		$this->form_validation->set_rules("status", "Status", "");

		if ($this->form_validation->run() === FALSE) {

			$this->load->view('header', $data);
			$this->load->view("new_post");
			$this->load->view('footer');
		} else {

			$post_details = array(
				"user_id"      => $this->session->userdata("user_id"),
				"title"        => $this->input->post("title"),
				"alias"        => str_replace(array(" ", "&", "."), "-", $this->input->post("title")),
				"content"      => $this->input->post("content"),
				"status"       => $this->input->post("status"),
				"date_created" => date("c")
			);

			if ($post_id = $this->Post_model->create($post_details)) {
				$this->session->set_flashdata("message", display_message("Posted was created"));
				redirect("blog/post/edit_post/" . $post_id, "refresh");
			} else {
				$this->session->set_flashdata("message", display_message("An error occurred"), "danger");
			}
		}
	}

	public function edit_post($post_id)
	{
		if (!$post_id)
			redirect("blog/post/");

		$data['title'] = "Afyadata Blog";

		$this->form_validation->set_rules("title", "Title", "required");
		$this->form_validation->set_rules("content", "Content", "");
		$this->form_validation->set_rules("status", "Status", "");

		if ($this->form_validation->run() === FALSE) {
			$data['post'] = $this->Post_model->find_by_id($post_id);

			$this->load->view("blog_header", $data);
			$this->load->view("edit_post", $data);
			$this->load->view("blog_footer");

		} else {

			$post_details = array(
				"user_id"       => $this->session->userdata("user_id"),
				"title"         => $this->input->post("title"),
				"alias"         => str_replace(array(" ", "&", "."), "-", $this->input->post("title")),
				"content"       => $this->input->post("content"),
				"status"        => $this->input->post("status"),
				"date_modified" => date("c")
			);

			if ($this->Post_model->update($post_id, $post_details)) {
				$this->session->set_flashdata("message", display_message("Posted was updated"));
			} else {
				$this->session->set_flashdata("message", display_message("Failed to update post"), "danger");
			}
			redirect("blog/post/edit_post/" . $post_id, "refresh");
		}
	}
}