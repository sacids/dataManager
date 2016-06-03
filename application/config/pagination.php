<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$config['per_page'] = 30;
$config['num_links'] = 10;
$config['display_pages'] = TRUE;

$config['num_tag_open'] = "<li>";
$config['num_tag_close'] = "</li>";

$config['cur_tag_open'] = "<li><span><strong>";
$config['cur_tag_close'] = "</strong></span></li>";

$config['full_tag_open'] = '<ul class="pagination pull-right">';
$config['full_tag_close'] = '</ul>';

$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = 'Prev';
$config['next_link'] = 'Next';
$config['last_link'] = 'Last &raquo;';