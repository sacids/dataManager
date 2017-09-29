<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 27/09/2017
 * Time: 12:10
 */

class Report_model extends CI_Model
{
    private static $table_name = "idsr_reports";

    public function find_all_reports($limit = 30, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get(self::$table_name)->result();
    }

    public function find_by_id($report_id)
    {
        $this->db->where("id", $report_id);
        return $this->db->get(self::$table_name)->row(1);
    }


    public function execute_query($query, $condition = null)
    {
        if ($condition != null) {
            return $this->db->query($query . " " . $condition)->result();
        } else {
            return $this->db->query($query . " GROUP BY _xf_20de688d974183449850b0d32a15de47")->result();
        }
    }
}