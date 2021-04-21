<?php defined('BASEPATH') or exit('No direct script access allowed');
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

if (!function_exists("display_projects")) {
    function display_projects()
    {
        $ci = &get_instance();
        $filter_conditions = null;
        if (!$ci->ion_auth->is_admin()) {
            $filter_conditions = $ci->Acl_model->find_user_permissions(get_current_user_id(), Project_model::$table_name);
            $projects = $ci->Project_model->get_project_list(50, 0, get_current_user_id(), $filter_conditions);
        } else {
            $projects = $ci->Project_model->get_project_list(50, 0);
        }

        if (!empty($projects)) {
            foreach ($projects as $project) {
                echo "<li>" . anchor('projects/forms/' . $project->id, $project->title) . "</li>";
            }
        }
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

//display first name and last name
if (!function_exists('display_full_name')) {
    function display_full_name()
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');
        $User = $CI->User_model->find_by_id($user_id);
        echo ucfirst($User->first_name) . ' ' . ucfirst($User->last_name);
    }
}

//time ago
if (!function_exists('time_ago')) {
    function time_ago($date)
    {
        if (empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $unix_date = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
}


if (!function_exists('array_utf8_encode')) {
    /**
     * Encode array to utf8 recursively
     * @param $dat
     * @return array|string
     */
    function array_utf8_encode($dat)
    {
        if (is_string($dat))
            return utf8_encode($dat);
        if (!is_array($dat))
            return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
            $ret[$i] = array_utf8_encode($d);
        return $ret;
    }
}

if (!function_exists("get_flashdata")) {
    function get_flashdata()
    {
        $CI = &get_instance();
        return (($CI->session->flashdata("message") != "")) ? $CI->session->flashdata("message") : "";
    }
}

if (!function_exists("set_flashdata")) {
    function set_flashdata($flash_message)
    {
        $CI = &get_instance();
        $CI->session->set_flashdata("message", $flash_message);
    }
}

if (!function_exists("get_current_user_id")) {
    function get_current_user_id()
    {
        $CI = &get_instance();
        return $CI->session->userdata("user_id");
    }
}

//display name from phone
if(!function_exists('get_collector_name_from_phone')){
    function get_collector_name_from_phone($phone){
        $CI = &get_instance();

        $User = $CI->User_model->get_by(['username' => $phone]);
        if($User)
            $name = ucfirst($User->first_name) . ' ' . ucfirst($User->last_name);
        else
            $name = "";  

        return $name;
    }
}
