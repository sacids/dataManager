<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 22-Sep-16
 * Time: 11:36
 */
class LanguageLoader
{
	function initialize()
	{
		$ci =& get_instance();
		$ci->load->helper('language');

		$siteLanguage = $ci->session->userdata('site_lang');
		if ($siteLanguage) {
			$ci->lang->load('auth', $siteLanguage);
			$ci->lang->load('ion_auth', $siteLanguage);
			$ci->lang->load('sacids', $siteLanguage);
			$ci->lang->load('nav_menu', $siteLanguage);
		} else {
			$ci->lang->load('auth', 'english');
			$ci->lang->load('ion_auth', "english");
			$ci->lang->load('sacids', "english");
			$ci->lang->load('nav_menu', "english");
		}
	}
}