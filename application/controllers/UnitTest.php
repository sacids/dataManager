<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 4/4/2016
 * Time: 1:19 PM
 */
class UnitTest extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->model("User_model");
	}


	public function index()
	{

		$this->unit->run($this->User_model->find_by_username("demo"), "is_object", "Find user by username user exists");
		$this->unit->run($this->User_model->find_by_username("demo"), "is_null", "Find user by username user not exists");

		$this->load->view("tests");
	}

}