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


    function find_all()
    {
        $this->db->select('fb.id, fb.instance_id, fb.message, fb.date_created, xf.title, user.first_name as uf_fname,
         user.last_name as uf_lname')
            ->join(self::$table_name_xform . " xf", 'xf.form_id = fb.form_id')
            ->join(self::$table_name_user . " user", 'user.id = fb.user_id')
            ->where("fb.message", "Tumepokea fomu yako")
            ->order_by('fb.date_created', 'DESC');
        return $this->db->get(self::$table_name . " fb")->result();
    }

    function search_feedback($name = NULL, $user_id = NULL)
    {
        if ($name != NULL)
            $this->db->like("xf.title", $name);

        if ($user_id != NULL)
            $this->db->where("fb.user_id", $user_id);

        $this->db->select('fb.id, fb.instance_id, fb.message, fb.date_created, xf.title, user.first_name as uf_fname,
         user.last_name as uf_lname')
            ->join(self::$table_name_xform . " xf", 'xf.form_id = fb.form_id')
            ->join(self::$table_name_user . " user", 'user.id = fb.user_id')
            ->where("fb.message", "Tumepokea fomu yako")
            ->order_by('fb.date_created', 'DESC');
        return $this->db->get(self::$table_name . " fb")->result();
    }

    /**
     * @param $user_id
     * @param $form_id
     * @param null $instance
     * @return mixed
     */
    function get_feedback_details_by_instance($instance_id)
    {
        return $this->db->limit(1)
            ->get_where(self::$table_name, array('instance_id' => $instance_id))->row();
    }

    /**
     * @param $user_id
     * @param $form_id
     * @param null $instance
     * @return mixed
     */
    function get_feedback_by_instance($instance_id)
    {
        $this->db->select('fb.message, fb.date_created, fb.sender, user.first_name as fname, user.last_name as lname')
            ->join(self::$table_name_user . " user", 'user.id = fb.user_id')
            ->order_by('fb.date_created', 'ASC');
        return $this->db->get_where(self::$table_name . " fb", array('instance_id' => $instance_id))->result();


    }

    /**
     * @param $user_id
     * @param $form_id
     * @param $instance_id
     * @return mixed
     */
    function get_feedback($user_id, $instance_id = NULL)
    {
        if ($instance_id != NULL)
            $this->db->where('instance_id', $instance_id);

        $this->db->where('user_id', $user_id);
        return $this->db->get(self::$table_name)->result();
    }

    /**
     * @param $user_id
     * @param $last_id
     * @return mixed
     */
    function get_feedback_notification($user_id, $last_id = NULL)
    {
        if ($last_id != NULL)
            $this->db->where('id > ', $last_id);

        $this->db->where('user_id', $user_id);
        return $this->db->get(self::$table_name)->result();
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


    //forms feedback
    function get_forms_feedback($user_id)
    {
        return $this->db->order_by('date_created', 'DESC')
            ->get_where(self::$table_name, array('user_id' => $user_id, 'message' => "Tumepokea fomu yako"))->result();
    }

    function get_form_name($form_id)
    {
        $query = $this->db->get_where(self::$table_name_xform, array('form_id' => $form_id))->row();
        return $query->title;
    }
}