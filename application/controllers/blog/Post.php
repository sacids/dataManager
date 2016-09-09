<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 10:31
 */
class Post extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->load->model("blog/Post_model");
	}

	public function index()
	{
		$this->posts();
	}

	public function posts()
	{
		$data['title'] = "Afyadata Blog";
		$data['posts'] = $this->Post_model->find_all();

		$this->load->view("blog/blog_header", $data);
		$this->load->view("blog/posts_view", $data);
		$this->load->view("blog/blog_footer", $data);
	}

	public function post_details($post_id)
	{

		if (!$post_id)
			redirect("blog/post/");

		$data['title'] = "Afyadata Blog";
		$data['post'] = $this->Post_model->find_by_id($post_id);
		$data['recent_posts'] = $this->Post_model->find_all(5);

		$this->load->view("blog/blog_header", $data);
		$this->load->view("blog/single_post_view", $data);
		$this->load->view("blog/blog_footer");
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
			$this->load->view("blog/new_post");
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

			$this->load->view("blog/blog_header", $data);
			$this->load->view("blog/edit_post", $data);
			$this->load->view("blog/blog_footer");

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