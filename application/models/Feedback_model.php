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

    function __construct()
    {
        parent::__construct();
    }

    function find_all()
    {
        $this->db->join(self::$table_name_user . " u", 'u.id = f.user_id')
            ->order_by('f.date_created', 'DESC')
            ->group_by('f.form_id')
            ->group_by('f.user_id');
        return $this->db->get(self::$table_name . " f")->result();
    }

    /**
     * @param $user_id
     * @param $form_id
     * @param null $instance
     * @return mixed
     */
    function get_feedback_by_instance($user_id, $form_id = NULL)
    {

        if ($form_id != NULL)
            $this->db->where('form_id', $form_id);

        $this->db->where('user_id', $user_id);
        return $this->db->get(self::$table_name)->result();
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