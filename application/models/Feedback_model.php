<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Feedback Model class
 *
 * @package     Feedback_model
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Feedback_model extends CI_Model
{

    /**
     * Feedback table name
     *
     * @var string
     */
    private static $table_name = "feedback";
    private static $table_name_user = "users";
    private static $table_name_xform = "xforms";

    function __construct()
    {
        parent::__construct();
    }

    function count_new_feedback()
    {
        return $this->db->get('feedback')->num_rows();
    }

    /**
     * @param $feedback array of feedback information.
     * @return mixed
     * @author Godluck Akyoo
     */
    function create_feedback($feedback)
    {
        return $this->db->insert(self::$table_name, $feedback);
    }

    /**
     * @return mixed
     */
    function count_feedback()
    {
        return $this->db
            ->where_in("(SELECT max(id) FROM feedback GROUP BY instance_id)")
            ->get('feedback')->num_rows();
    }


    /**
     * @param $num
     * @param $start
     * @return mixed
     */
    function find_all($num, $start)
    {
        return $this->db
            ->select('feedback.id, feedback.instance_id, feedback.message, feedback.date_created,
                    users.first_name, users.last_name, users.username, xforms.title')
            ->limit($num, $start)
            ->order_by('feedback.id', 'DESC')
            ->where_in("(SELECT MAX(feedback.id) FROM feedback GROUP BY instance_id)")
            ->join('users', 'users.id = feedback.user_id')
            ->join('xforms', 'xforms.form_id = feedback.form_id')
            ->get(self::$table_name)
            ->result();
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
            ->select('feedback.id, feedback.instance_id, feedback.message, feedback.date_created,
                    users.first_name, users.last_name, users.username, xforms.title')
            ->order_by('feedback.id', 'DESC')
            ->where_in("(SELECT MAX(feedback.id) FROM feedback GROUP BY instance_id)")
            ->join('users', 'users.id = feedback.user_id')
            ->join('xforms', 'xforms.form_id = feedback.form_id')
            ->get(self::$table_name)
            ->result();
    }

    /**
     * @param  $instance_id
     * @return mixed
     */
    function get_feedback_details_by_instance($instance_id)
    {
        return $this->db->limit(1)
            ->get_where(self::$table_name, array('instance_id' => $instance_id))->row();
    }

    /**
     * @param $instance_id
     * @return mixed
     */
    function get_feedback_by_instance($instance_id)
    {
        $this->db->select('feedback.message, feedback.date_created, feedback.sender,
                                user.first_name as fname, user.last_name as lname')
            ->join(self::$table_name_user . " user", 'user.id = feedback.user_id')
            ->order_by('feedback.date_created', 'ASC');
        return $this->db->get_where(self::$table_name . " feedback", array('instance_id' => $instance_id))->result();


    }

    //function to update user feedback
    function update_user_feedback($instance_id, $sender)
    {
        $query = $this->db->get_where('feedback',
            array('instance_id' => $instance_id, 'sender' => $sender, 'status' => 'pending'))->result();

        foreach ($query as $value) {
            if (!empty($value->id)) {
                $this->db->update('feedback', array('status' => 'delivered'), array('id' => $value->id));
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
        $query = $this->db->get_where('users', array('id' => $user_id))->row();
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
                //$this->db->like("(form_id LIKE '$value' OR form_id LIKE '$value')");
            }
            $this->db->group_end();
        } else {
            $this->db->where("form_id", $where_perm);
        }


        if ($date_created != null)
            $this->db->where('date_created >', $date_created);


        $query = $this->db
            ->where_in('user_id', $where_array)
            ->get(self::$table_name)
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
        if ($date_created != null)
            $this->db->where('date_created >', $date_created);

        return $this->db
            ->get_where(self::$table_name, array('user_id' => $user_id, 'sender' => 'server'))->result();
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
        return $this->db->get_where('xforms', array('form_id' => $table_name))->row();
    }
}