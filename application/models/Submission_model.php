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

    /**
     * Submission_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initialize_table();
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
     * @return mixed
     */
    function count_published_forms()
    {
        return $this->db->get_where('xforms', array('status' => 'published'))->num_rows();
    }

    /**
     * @return mixed
     */
    function get_submitted_forms()
    {
        return $this->db->get_where('xforms', array('status' => 'published'))->result();
    }

    /**
     * @param $form_id
     * @return mixed
     */
    function count_overall_submitted_forms($form_id)
    {
        return $this->db->get($form_id)->num_rows();
    }

    /**
     * @param $form_id
     */
    function count_monthly_submitted_forms($form_id)
    {
        return $this->db
            ->get_where($form_id, array('MONTH(meta_start)' => date('m')))->num_rows();
    }

    /**
     * @param $form_id
     * @return mixed
     */
    function count_weekly_submitted_forms($form_id)
    {
        $today = date('Y-m-d');
        $last = date('Y-m-d', strtotime("-7 day", strtotime($today)));

        $this->db->where("meta_start BETWEEN '$last%' AND '$today%'", NULL, FALSE);
        return $this->db->get($form_id)->num_rows();
    }


    function count_daily_submitted_forms($form_id)
    {
        $today = date('Y-m-d');
        return $this->db->get_where($form_id, array('DATE(meta_start)' => $today))->num_rows();
    }


}