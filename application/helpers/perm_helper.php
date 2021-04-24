<?php

/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 7/22/17
 * Time: 3:06 PM
 */

//perm class
if (!function_exists("perms_class")) {
    function perms_class($controller)
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');

        //get perms_class details
        $class = $CI->perms_class_model->get_by(['class' => $controller]);

        if ($class) {
            $user_groups = $CI->users_group_model->find_all(['user_id' => $user_id]);

            foreach ($user_groups as $val) {
                //perms_groups
                $perm_group = $CI->perms_group_model->get_by(['group_id' => $val->group_id]);

                if ($perm_group) {
                    $classes = explode(',', $perm_group->classes);

                    if (in_array($class->id, $classes)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}


//perm role
if (!function_exists("perms_role")) {
    function perms_role($controller, $perm_slug)
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');

        //get perms_class details
        $class = $CI->perms_class_model->get_by(['class' => $controller]);

        if ($class) {
            //get method
            $method = $CI->perms_method_model->get_by(['class_id' => $class->id, 'method' => $perm_slug]);

            if ($method) {
                $user_groups = $CI->users_group_model->find_all(['user_id' => $user_id]);

                foreach ($user_groups as $group) {
                    //perms_groups
                    $perm_group = $CI->perms_group_model->get_by(['group_id' => $group->group_id]);

                    if ($perm_group) {
                        $perms = explode(',', $perm_group->perms);

                        if (in_array($method->id, $perms)) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
