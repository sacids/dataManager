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
		if ($this->config->item("table_xform"))
			self::$xform_table_name = $this->config->item("table_xform");

		if ($this->config->item("table_archive_xform"))
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
	 * @return id for the created form
	 */
	public function create_xform($form_details)
	{
		$this->db->insert(self::$xform_table_name, $form_details);
		return $this->db->insert_id();
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
	 * @param null int $user_id
	 * @param int $limit
	 * @param int $offset
	 * @param null string $status
	 * @return mixed returns list of forms available.
	 */
	public function get_form_list($user_id = NULL, $limit = 30, $offset = 0, $status = NULL)
	{
		if ($user_id != NULL)
			$this->db->where("user_id", $user_id);

		if ($status != NULL)
			$this->db->where("status", $status);
		$this->db->limit($limit, $offset);
		return $this->db->get(self::$xform_table_name)->result();
	}

	public function search_forms($user_id = NULL, $name = NULL, $access = NULL, $status = NULL, $limit = 30, $offset = 0)
	{
		if ($user_id != NULL)
			$this->db->where("user_id", $user_id);

		if ($name != NULL)
			$this->db->like("title", $name);

		if ($access != NULL)
			$this->db->where("access", $access);

		if ($status == NULL)
			$this->db->where("status!=", "archived");
		else
			$this->db->where("status", $status);
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
		$sql .= " WHERE table_schema = '{$this->db->database}' ";
		$sql .= " AND table_name = '{$table_name}' ";
		$sql .= " AND DATA_TYPE = 'point'";

		$query = $this->db->query($sql);

		log_message('debug', 'get point field query ' . $this->db->last_query());

		return ($query->num_rows() == 1) ? $query->row(1)->COLUMN_NAME : FALSE;
	}
	
	/**
	 * Inserts field name and corresponding label into field name map
	 *
	 * @param $table_name
	 * @param $data
	 * @return TRUE or FALSE
	 */
	public function insert_into_map($data)
	{
		return $this->db->insert_batch('xform_fieldname_map', $data);
		
	}
	
	/**
	 * Returns result array for all fields of particular table
	 *
	 * @param $table_name
	 * @return result array
	 */
	

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
	public function find_by_xform_id($xform_id)
	{
		$this->db->where("form_id", $xform_id);
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
	 * @param $xform_id
	 * @return mixed
	 */
	public function archive_form($xform_id)
	{
		$this->db->limit(1);
		$this->db->where("id", $xform_id);
		$this->db->set("last_updated", "NOW()", FALSE);
		$this->db->set("status", "archived");
		return $this->db->update(self::$xform_table_name);
	}

	/**
	 * @param $xform_id
	 * @return mixed
	 */
	public function restore_xform_from_archive($xform_id)
	{
		$this->db->limit(1);
		$this->db->where("id", $xform_id);
		$this->db->set("last_updated", "NOW()", FALSE);
		$this->db->set("status", "published");
		return $this->db->update(self::$xform_table_name);
	}

	/**
	 * @param $xform_archive_data
	 * @return mixed
	 */
	public function create_archive($xform_archive_data)
	{
		return $this->db->insert(self::$archive_xform_table_name, $xform_archive_data);
	}

	/**
	 * @param $table_name
	 * @param int $limit
	 * @param int $offset
	 * @return mixed returns data from tables created by uploading xform definitions files.
	 */
	public function find_form_data($table_name, $limit = 30, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get($table_name)->result();
	}

	/**
	 * @param $table_name
	 * @return mixed
	 */
	public function count_all_records($table_name)
	{
		$this->db->from($table_name);
		return $this->db->count_all_results();
	}


	/**
	 * @param $table_name
	 * @return mixed return an object of fields of the specified table
	 */
	public function find_table_columns($table_name)
	{
		return $this->db->list_fields($table_name);
	}

	/**
	 * @param $table_name
	 * @return mixed returns table fields/columns with metadata object
	 */
	public function find_table_columns_data($table_name)
	{
		return $this->db->field_data($table_name);
	}


	/**
	 * $param $table_name
	 * $param info text to be displayer per point
	 * $param $cond sql condition (without the where)
	 *
	 * @return list of lat,lon,info
	 */

	public function get_geospatial_data($table_name, $cond = TRUE)
	{

		//$this->db->where($cond);
		$query = $this->db->get($table_name);
		if ($query->num_rows() == 0) return FALSE;

		return $query->result_array();
	}

	/**
	 * @param $table_name
	 * @param $axis_column
	 * @param string $function
	 * @param null $group_by_column
	 * @return mixed
	 */
	public function get_graph_data($table_name, $axis_column, $function = "COUNT", $group_by_column = NULL)
	{

		if ($function == "COUNT") {
			$this->db->select("`{$axis_column}`, `{$group_by_column}`,COUNT(" . $axis_column . ") AS `" . strtolower($function) . "`");

			//TODO Check field type before grouping
			if ($group_by_column != NULL) {
				$this->db->group_by($group_by_column);
			} else {
				$this->db->group_by($axis_column);
			}
		}

		if ($function == "SUM") {
			$this->db->select("`{$axis_column}`, `{$group_by_column}`, SUM(" . $axis_column . ") AS `" . strtolower($function) . "`");
			//TODO Check field type before grouping
			if ($group_by_column != NULL) {
				$this->db->group_by($group_by_column);
			} else {
				$this->db->group_by($axis_column);
			}
		}

		$this->db->from($table_name);
		return $this->db->get()->result();
	}

	/**
	 * @param $xform_table_name
	 * @param $data
	 * @return mixed
	 */
	public function insert_xform_data($xform_table_name, $data)
	{
		return $this->db->insert($xform_table_name, $data);
	}

	
	/**
	 * @param $table_name
	 * @return mixed
	 */
	public function get_fieldname_map($table_name)
	{
		$this->db->where('table_name',$table_name);
		$this->db->from('xform_fieldname_map');
		return $this->db->get()->result_array();
	}

	/**
	 * @return int
	 */
	public function count_all_xforms($status = NULL)
	{
		if ($status != NULL)
			$this->db->where("status", $status);
		$this->db->from(self::$xform_table_name);
		return $this->db->count_all_results();
	}
}