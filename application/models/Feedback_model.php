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
     * @param null
     * @return mixed
     */
    function find_all()
    {
        return $this->db->query("SELECT feedback.id, feedback.instance_id,feedback.message,
                                      feedback.date_created,users.username,xforms.title FROM feedback
              join xforms on xforms.form_id=feedback.form_id
              join users on users.id=feedback.user_id
              where feedback.id in (SELECT max(id) FROM feedback GROUP BY instance_id ) order by feedback.id desc ")->result();
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

        return $this->db->query("SELECT feedback.id, feedback.instance_id,feedback.message,feedback.date_created,users.username,xforms.title
              FROM feedback
              join xforms on xforms.form_id=feedback.form_id
              join users on users.id=feedback.user_id
              where feedback.id in (SELECT max(id) FROM feedback GROUP BY instance_id )
              order by feedback.id desc ")->result();
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
     * @param null
     * @return mixed
     */
    function get_feedback_list($user_id)
    {
        return $this->db->get_where(self::$table_name, array('user_id' => $user_id))->result();
    }

    /**
     * @param $user_id
     * @param $last_id
     * @return mixed
     */
    function get_feedback_notification($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('sender', 'server');
        $this->db->where('status', 'pending');
        return $this->db->get(self::$table_name)->result();
    }


    function get_feedback_form_details($table_name, $instance_id){
        return $this->db->limit(1)
            ->get_where($table_name, array('meta_instanceID' => $instance_id))->row();
    }
}