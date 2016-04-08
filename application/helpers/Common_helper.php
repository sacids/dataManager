<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 2/1/2016
 * Time: 9:46 AM
 */


/**
 * Check if user can access Module
 * access_module function
 *
 * @param  int module_id Input int
 * @return boolean TRUE or FALSE
 */

if (!function_exists("access_module")) {

	function access_module($module_id)
	{
		$CI = &get_instance();
		$user_id = $CI->session->userdata('user_id');
		$user_group = $CI->ion_auth_model->get_users_groups($user_id)->row();

		//get access level
		$check = $CI->db->get_where('access_level',
			array('group_id' => $user_group->id, 'module_id' => $module_id, 'allow' => 1))->result();

		//check if query exceed 0
		if (count($check) > 0) {
			return TRUE;
		}
		return FALSE;
	}
}

/**
 *  Check if user has roles
 * has_role function
 *
 * @param  int    module_id    Input int
 * @param  String role_link    Input string
 * @return boolean TRUE or FALSE
 */

if (!function_exists("access_level")) {

	function access_level($module_id, $perm_slug)
	{
		$CI = &get_instance();
		$user_id = $CI->session->userdata('user_id');
		$user_group = $CI->ion_auth_model->get_users_groups($user_id)->row();

		//get access level
		$check = $CI->db->get_where('access_level',
			array('group_id' => $user_group->id, 'module_id' => $module_id, 'perm_slug' => $perm_slug, 'allow' => 1))->result();

		if (count($check) > 0) {
			return TRUE;
		}

		return FALSE;
	}

}

if (!function_exists("display_message")) {
	function display_message($message, $message_type = "success")
	{

		if ($message_type == "success") {
			return '<div class="alert alert-success">' . $message . '</div>';
		}

		if ($message_type == "info") {
			return '<div class="alert alert-info">' . $message . '</div>';
		}

		if ($message_type == "warning") {
			return '<div class="alert alert-warning">' . $message . '</div>';
		}

		if ($message_type == "danger") {
			return '<div class="alert alert-danger">' . $message . '</div>';
		}
	}
}