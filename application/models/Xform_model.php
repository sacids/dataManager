<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 2/4/2016
 * Time: 9:44 AM
 */
class Xform_model extends CI_Model
{
    /**
     * Table name for xform definitions
     * @var string
     */
    private static $xform_table_name = "xforms";

    /**
     * @param $statement
     * @return bool
     */
    public function create_table($statement)
    {

        if ($this->db->simple_query($statement)) {
            log_message("debug", "Success!");
            return TRUE;
        } else {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            log_message("debug", $statement . ", error " . json_encode($error));
            return FALSE;
        }
    }

    /**
     * @param $statement
     * @return bool
     */
    public function insert_data($statement)
    {
        if ($this->db->simple_query($statement)) {
            log_message("debug", "Success!");
            return TRUE;
        } else {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            log_message("debug", $statement . ", error " . json_encode($error));
        }
    }

    /**
     * @param $form_details an array of form details with keys match db field names
     * @return mixed
     */
    public function create_xform($form_details)
    {
        return $this->db->insert(self::$xform_table_name, $form_details);
    }
    
    /**
     * @param int xform_id the row that needs to be updated
     * @param string form_id 
     * @return bool
     */
    public function update_form_id($xform_id, $form_id){
    	
    	$data	= array('form_id' => $form_id);
    	$this->db->where('id',$xform_id);
    	return $this->db->update('xforms',$data);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed returns list of forms available.
     */
    public function get_form_list($limit = 30, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get(self::$xform_table_name)->result();
    }


    /**
     * Finds a table field with point data type
     * @param $table_name
     * @return field name or FALSE
     */
    public function get_point_field($table_name)
    {

        $sql = " SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS ";
        $sql .= " WHERE table_name = '{$table_name}' ";
        $sql .= " AND DATA_TYPE = 'point'";

        $query = $this->db->query($sql);

        return ($query->num_rows() == 1) ? $query->row(1)->COLUMN_NAME : FALSE;
    }
}