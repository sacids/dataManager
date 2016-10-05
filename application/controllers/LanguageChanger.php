<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 22-Sep-16
 * Time: 11:41
 */
class LanguageChanger extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function switchLang($language = "")
	{
		$language = ($language != "") ? $language : "swahili";
		$this->session->set_userdata('site_lang', $language);
		redirect($_SERVER['HTTP_REFERER']);
	}
}