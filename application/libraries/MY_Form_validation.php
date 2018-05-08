<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 25/09/2017
 * Time: 17:14
 */
class MY_Form_validation extends CI_Form_validation
{
    function run($module = '', $group = '')
    {
        (is_object($module)) AND $this->CI =& $module;
        return parent::run($group);
    }
}