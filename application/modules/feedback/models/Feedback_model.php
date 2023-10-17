<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Feedback Model class
 *
 * @package     Feedback_model
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends CI_Model
{
    /**
     * Feedback table name
     *
     * @var string
     */
    private static $table_name_feedback = "feedback";
    private static $table_name_users = "users";
    private static $table_name_xform = "xforms";

    function __construct()
    {
        parent::__construct();
    }

    function count_new_feedback()
    {
        return $this->db->get_where(self::$table_name_feedback, array('status' => 'pending'))->num_rows();
    }

    /**
     * @param $feedback array of feedback information.
     * @return mixed
     * @author Godluck Akyoo
     */
    function create_feedback($feedback)
    {
        return $this->db->insert(self::$table_name_feedback, $feedback);
    }

    /**
     * @return mixed
     */
    function count_feedback()
    {
        return $this->db->query('SELECT max(id) FROM ' . self::$table_name_feedback . ' GROUP BY instance_id')->num_rows();
    }


    /**
     * @param $limit
     * @param $offset
     * @return mixed
     */
    function find_all($limit = 30, $offset = 0)
    {
        return $this->db->query("
             SELECT fb.id, fb.form_id, fb.instance_id, fb.message, fb.sender, fb.date_created,xforms.title,
             users.first_name, users.last_name, users.username
             FROM " . self::$table_name_feedback . " fb
             JOIN " . self::$table_name_xform . " ON fb.form_id = xforms.form_id
             JOIN " . self::$table_name_users . " ON fb.user_id = users.id
             WHERE fb.id IN ( SELECT MAX(fb.id) FROM " . self::$table_name_feedback . " fb GROUP BY instance_id)
             ORDER BY fb.id DESC LIMIT $limit OFFSET $offset")->result();
    }


    /**
     * @param form_name
     * @param $username
     * @return mixed
     */
    function search_feedback($name = NULL, $username = NULL)
    {
        if ($name != NULL)
            $this->db->like("xforms.title", $name);

        if ($username != NULL)
            $this->db->like("users.username", $username);

        return $this->db
            ->select('feedback.id, feedback.form_id, feedback.instance_id, feedback.message, feedback.date_created,
                    users.first_name, users.last_name, users.username, xforms.title')
            ->order_by('feedback.id', 'DESC')
            ->where_in("(SELECT MAX(feedback.id) FROM feedback GROUP BY instance_id)")
            ->join(self::$table_name_users, 'users.id = feedback.user_id')
            ->join(self::$table_name_xform, 'xforms.form_id = feedback.form_id')
            ->get(self::$table_name_feedback)
            ->result();
    }

    /**
     * @param  $instance_id
     * @return mixed
     */
    function get_feedback_details_by_instance($instance_id)
    {
        return $this->db->limit(1)
            ->get_where(self::$table_name_feedback, array('instance_id' => $instance_id))->row();
    }

    /**
     * @param $instance_id
     * @return mixed
     */
    function get_feedback_by_instance($instance_id)
    {
        return $this->db
            ->order_by('feedback.date_created', 'ASC')
            ->get_where(self::$table_name_feedback . " feedback", array('instance_id' => $instance_id))->result();
    }

    //function to update user feedback
    function update_user_feedback($instance_id, $sender)
    {
        $query = $this->db->get_where(self::$table_name_feedback,
            array('instance_id' => $instance_id, 'sender' => $sender, 'status' => 'pending'))->result();

        foreach ($query as $value) {
            if (!empty($value->id)) {
                $this->db->update(self::$table_name_feedback, array('status' => 'delivered'), array('id' => $value->id));
            } else {
                //Do nothing
            }
        }
    }

    /**
     * @param $user_id
     * @return mixed
     */
    function get_reply_user($user_id)
    {
        $query = $this->db->get_where(self::$table_name_users, array('id' => $user_id))->row();
        if (!empty($query->id)) {
            return $query->last_name;
        } else {
            return 'admin';
        }
    }


    /**
     * @param $user_id
     * @return mixed
     */
    function get_feedback_mapping($user_id)
    {
        return $this->db->get_where('feedback_user_map', array('user_id' => $user_id))->row();
    }


    /**
     * @param $where_array
     * @param $where_perm
     * @param $date_created
     * @return mixed
     */
    function get_feedback_list($where_perm, $where_array, $date_created = NULL)
    {

        if (is_array($where_perm)) {
            $this->db->group_start();
            foreach ($where_perm as $key => $value) {
                $this->db->or_like("form_id", $value);
            }
            $this->db->group_end();
        } else {
            $this->db->where("form_id", $where_perm);
        }

        if ($date_created != NULL)
            $this->db->where('date_created >', $date_created);


        $query = $this->db
            ->where_in('user_id', $where_array)
            ->get(self::$table_name_feedback)
            ->result();

        return $query;
    }

    /**
     * @param $user_id
     * @param $date_created
     * @return mixed
     */
    function get_feedback_notification($user_id, $date_created = NULL)
    {
        if ($date_created != NULL)
            $this->db->where('date_created >', $date_created);

        return $this->db
            ->get_where(self::$table_name_feedback, array('user_id' => $user_id, 'sender' => 'server'))->result();
    }


    /**
     * @param $table_name
     * @param $instance_id
     * @return mixed
     */
    function get_feedback_form_details($table_name, $instance_id)
    {
        return $this->db->limit(1)->get_where($table_name, array('meta_instanceID' => $instance_id))->row();
    }

    /**
     * @param $table_name
     * @return mixed
     */
    function get_form_details($table_name)
    {
        return $this->db->get_where(self::$table_name_xform, array('form_id' => $table_name))->row();
    }

    function find_by_xform_id($xform_id, $limit = 30, $offset = 0)
    {
        $this->db->select("f.*, u.first_name,u.last_name");
        $this->db->limit($limit, $offset);
        $this->db->where("form_id", $xform_id);
        $this->db->order_by("id", "DESC");
        $this->db->join(self::$table_name_users . " u", "u.id=f.user_id");
        return $this->db->get(self::$table_name_feedback . " f")->result();
    }
}