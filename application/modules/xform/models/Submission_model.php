<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/8/2016
 * Time: 9:42 AM
 */
class Submission_model extends CI_Model
{
    /**
     * @var string default table name, if left blank, the value from config file will be used
     */
    private static $table_name = "submission_form";

    public static $xform_table_name = "xforms";

    private $user_id;

    /**
     * Submission_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initialize_table();

        $this->user_id = $this->session->userdata('user_id');
    }

    /**
     * @param $table_name
     * @param $column
     */
    function where_condition($table_name, $column)
    {
        if (!$this->ion_auth->in_group('admin')) {
            $this->db->where($table_name . '.' . $column, $this->user_id);
        }
    }

    /**
     * Initializes table names from configuration files
     */
    private function initialize_table()
    {
        if ($this->config->item("table_form_submission"))
            self::$table_name = $this->config->item("table_form_submission");
    }

    /**
     * @param $data array with corresponding table fields
     * @return int id of the form data inserted
     */
    public function create($data)
    {
        $this->db->insert(self::$table_name, $data);
        return $this->db->insert_id();
    }

    /**
     * @param $submission_id
     * @return mixed
     */
    public function delete_submission($submission_id)
    {
        $this->db->where("id", $submission_id);
        return $this->db->delete(self::$table_name);
    }

    /**
     * @param null $filter_condition
     * @return mixed
     */
    function count_published_forms($filter_condition = null)
    {
        if ($filter_condition != null)
            $this->db->where($filter_condition, "", false);

        return $this->db->get_where('xforms', array('status' => 'published'))->num_rows();
    }

    /**
     * @param null $filter_condition
     * @return mixed
     */
    function get_submitted_forms($filter_condition = null)
    {
        if ($filter_condition != null)
            $this->db->where($filter_condition, "", false);

        return $this->db->get_where('xforms', array('status' => 'published'))->result();
    }

    /**
     * @param $table_name
     * @return mixed
     */
    function count_overall_submitted_forms($table_name)
    {
        return $this->db->get($table_name)->num_rows();
    }

    /**
     * @param $table_name
     * @return int
     */
    function count_monthly_submitted_forms($table_name)
    {
        return $this->db->get_where($table_name, ['MONTH(submitted_at)' => date('m'), 'YEAR(submitted_at)' => date('Y')])->num_rows();
    }

    /**
     * @param $table_name
     * @return mixed
     */
    function count_weekly_submitted_forms($table_name)
    {
        $today = date('Y-m-d');
        $last = date('Y-m-d', strtotime("-7 day", strtotime($today)));

        return $this->db
            ->where("submitted_at BETWEEN '$last%' AND '$today%'", NULL, FALSE)
            ->get($table_name)->num_rows();
    }

    /**
     * @param $table_name
     * @return int
     */
    function count_daily_submitted_forms($table_name)
    {
        return $this->db
            ->get_where($table_name, array('DATE(submitted_at)' => date('Y-m-d')))->num_rows();
    }

    //get submitted forms
    function get_submitted_forms_by_CHW($table_name, $meta_username)
    {
        if ($this->db->field_exists('meta_username', $table_name)) {
            return $this->db->get_where($table_name, ['meta_username' => $meta_username])->num_rows();
        } else {
            return 0;
        }
    }
}
