<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$config['per_page']           = 100;
$config['num_links']          = 10;
$config['full_tag_open']      = '<ul class="inline-flex -space-x-px">';
$config['full_tag_close']     = '</ul><!--pagination-->';
$config['first_link']         = '&lsaquo; First';
$config['first_tag_open']     = '<li class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">';
$config['first_tag_close']    = '</li>';
$config['last_link']          = 'Last &raquo;';
$config['last_tag_open']      = '<li class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">';
$config['last_tag_close']     = '</li>';
$config['next_link']          = 'Next &rsaquo;';
$config['next_tag_open']      = '<li class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">';
$config['next_tag_close']     = '</li>';
$config['prev_link']          = '&lsaquo; Prev';
$config['prev_tag_open']      = '<li class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300  hover:bg-gray-100 hover:text-gray-700">';
$config['prev_tag_close']     = '</li>';
$config['cur_tag_open']       = '<li class="px-3 py-2 leading-tight text-gray-500 bg-blue-50 border border-gray-300 hover:bg-gray-100 hover:text-gray-700"><a href="" class="active">';
$config['cur_tag_close']      = '</a></li>';
$config['num_tag_open']       = '<li class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">';
$config['num_tag_close']      = '</li>';