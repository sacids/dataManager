<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/16/2016
 * Time: 5:28 PM
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('shorten_column_name')) {
	function shorten_column_name($long_column_name, $length_to_retain = 64)
	{

		$column_start = substr($long_column_name, 0, floor($length_to_retain / 2));

		//$column_ending = substr(md5($long_column_name), -15);

		$long_column_name_parts = explode("_", $long_column_name);

		$first_letters = "";

		foreach ($long_column_name_parts as $value) {
			$first_letters .= substr($value, 0, 1);
		}
		$column_ending = strtolower($first_letters);

		return $column_start . "_" . $column_ending;
	}
}