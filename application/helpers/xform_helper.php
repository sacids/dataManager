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
	
	function sanitize_col_name($string){

		$string = str_replace('-', '_', $string); // Replaces all spaces with underscore.
		$string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.
   		$string = preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
   		$string	= preg_replace('/_+/', '_', $string); // Replaces multiple underscore with single one.
   		$string = strtolower($string); // add prefix and lowercase string

   		return $string;

	}


	function ascii_val($string){

		$string	= strtolower($string);
		$letters = $string;// preg_replace('~[^a-z][0-9]~i', '', $string); // remove non alpha
		$sum = 0;
		for ($i = 0; $i < strlen($letters); $i++){
			$sum += ord($letters[$i]); // 96 == ord('a') - 1
		}

		return $sum;
	}

	function condense_col_name($string){

		$tmp	= explode('_',$string);
		$pre	= '';
		foreach($tmp as $parts){
			$pre	.= substr($parts,0,1);
		}

		return $pre;
	}
	
	/* NOT NEEDED NOW AS SYMPTOMS NAMES ARE CODED


	function condense_col_name($string){

		$tmp	= explode('_',$string);
		$pre	= '';
		foreach($tmp as $parts){
			$pre	.= substr($parts,0,1);
		}

		return $pre;
	}
	
	function ascii_val($string){
		
		$string	= strtolower($string);
		$leters	= $letters = preg_replace('~[^a-z]~i', '', $string); // remove non alpha
		$sum = 0;
		for ($i = 0; $i < strlen($letters); $i++){
			$sum += ord($letters[$i]) - 96; // 96 == ord('a') - 1
		}
		
		return $sum;
		
	}


	function map_field_name($arr){

		$type	= $arr['type'];
		$holder	= array();

		$col_name		= 'col_'.microtime();
		$field_name		= sanitize_col_name($arr['field_name']);
		$field_label	= $arr['label'];

		$tmp			= array('col_name' => $col_name,'field_name' => $field_name,'field_label' => $field_label );
		array_push($holder,$tmp);

		if($type == 'select'){
			foreach($arr['option'] as $key => $val){

				$tmp	= array();
				$tmp['col_name']	= $col_name.$key;
				$tmp['field_name']	= $field_name.'_'.sanitize_col_name($val);
				$tmp['field_label']	= $val;

				array_push($holder,$tmp);
			}

		}

		return $holder;
	}

	*/
}