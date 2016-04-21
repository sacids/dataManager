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
        $this->db->select('fb.id, fb.instance_id, fb.message, fb.date_created, xf.title, uf.first_name as uf_fname,
         uf.last_name as uf_lname, ut.first_name as ut_fname, ut.last_name as ut_lname')
            ->join(self::$table_name_xform . " xf", 'xf.form_id = fb.form_id')
            ->join(self::$table_name_user . " uf", 'uf.id = fb.user_from')
            ->join(self::$table_name_user . " ut", 'ut.id = fb.user_to')
            ->group_by('fb.instance_id')
            ->select_max('fb.id')
            ->order_by('fb.date_created', 'DESC');
        return $this->db->get(self::$table_name . " fb")->result();
    }

    function search_feedback($name = NULL, $from = NULL, $to = NULL)
    {
        if ($name != NULL)
            $this->db->like("xf.title", $name);

        if ($from != NULL)
            $this->db->where("fb.user_from", $from);

        if ($to != NULL)
            $this->db->where("fb.user_to", $to);

        $this->db->select('fb.id, fb.instance_id, fb.message, fb.date_created, xf.title, uf.first_name as uf_fname,
         uf.last_name as uf_lname, ut.first_name as ut_fname, ut.last_name as ut_lname')
            ->join(self::$table_name_xform . " xf", 'xf.form_id = fb.form_id')
            ->join(self::$table_name_user . " uf", 'uf.id = fb.user_from')
            ->join(self::$table_name_user . " ut", 'ut.id = fb.user_to')
            //->group_by('fb.instance_id')
            //->select_max('fb.id')
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
        $this->db->select('fb.message, fb.date_created, fb.sender, uf.first_name as fname, uf.last_name as lname')
            ->join(self::$table_name_user . " uf", 'uf.id = fb.user_from');
        //->order_by('fb.date_created', 'DESC');
        return $this->db->get_where(self::$table_name . " fb", array('instance_id' => $instance_id))->result();


    }

    /**
     * @param $user_id
     * @param $form_id
     * @param null $last_id
     * @return mixed
     */
    function get_feedback($user_id, $form_id = NULL, $last_id = NULL)
    {
        if ($last_id != NULL)
            $this->db->where('id > ', $last_id);

        if ($form_id != NULL)
            $this->db->where('form_id', $form_id);

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
}