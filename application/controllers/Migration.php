<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/15/2016
 * Time: 8:43 AM
 */
class Migration extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->input->is_cli_request())
			show_404();

		$this->load->library("migration");
		$this->load->dbforge();
	}

	public function latest()
	{
		if ($this->migration->current() === FALSE) {
			echo $this->migration->error_string();
		}

		$this->migration->latest();
		echo $this->migration->error_string();
	}
}