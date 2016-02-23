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
	 *
	 * @var string
	 */
	private static $xform_table_name = "xforms"; //default value

	/**
	 * Table name for archived/deleted xforms
	 *
	 * @var string
	 */
	private static $archive_xform_table_name = "archive_xformx"; //default value


	public function __construct()
	{
		$this->initialize_table();
	}

	/**
	 * Initializes table names from configuration files
	 */
	private function initialize_table()
	{
		self::$xform_table_name = $this->config->item("table_xform");
		log_message("debug", "Xform table => " . $this->config->item("table_xform"));
		self::$archive_xform_table_name = $this->config->item("table_archive_xform");
	}

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
	 * @param int    xform_id the row that needs to be updated
	 * @param string form_id
	 * @return bool
	 */
	public function update_form_id($xform_id, $form_id)
	{

		$data = array('form_id' => $form_id);
		$this->db->where('id', $xform_id);
		return $this->db->update(self::$xform_table_name, $data);
	}

	/**
	 * @param $form_id
	 * @param $form_details
	 * @return mixed
	 */
	public function update_form($form_id, $form_details)
	{
		$this->db->where('id', $form_id);
		return $this->db->update(self::$xform_table_name, $form_details);
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
	 *
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

	/**
	 * @param $form_id
	 * @return mixed
	 */
	public function find_by_id($form_id)
	{
		$this->db->where("id", $form_id);
		return $this->db->get(self::$xform_table_name)->row();
	}

	/**
	 * @param $xform_id
	 * @return mixed
	 */
	public function delete_form($xform_id)
	{
		$this->db->limit(1);
		$this->db->where("id", $xform_id);
		return $this->db->delete(self::$xform_table_name);
	}

	/**
	 * @param $xform_archive_data
	 * @return mixed
	 */
	public function create_archive($xform_archive_data)
	{
		return $this->db->insert(self::$archive_xform_table_name, $xform_archive_data);
	}
}