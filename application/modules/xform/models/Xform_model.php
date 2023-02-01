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
     * Currently logged in user id
     *
     * @var int
     */
    private $user_id;

    /**
     * Table name for xform definitions
     *
     * @var string
     */
    public static $xform_table_name = "xforms"; //default value

    /**
     * Table name for archived/deleted xforms //default value
     *
     * @var string
     */
    private static $archive_xform_table_name = "archive_xformx";

    /**
     * @var string
     */
    private static $xform_fieldname_map_table_name = "xform_fieldname_map";


    /**
     * Xform_model constructor.
     */
    public function __construct()
    {
        $this->initialize_table();
        $this->user_id = get_current_user_id();
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
            log_message("debug", "Data insert success!");
            return $this->db->insert_id();
        } else {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            log_message("debug", $statement . ", error " . json_encode($error));
            return FALSE;
        }
    }

    /**
     * @param array $form_details associative array of form details with keys match db field names
     * @return int form_id for the created form
     */
    public function create_xform($form_details)
    {
        $this->db->insert(self::$xform_table_name, $form_details);
        return $this->db->insert_id();
    }

    /**
     * @param int $xform_id the row that needs to be updated
     * @param string $form_id
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
     * @param null $filter_condition
     * @return mixed returns list of forms available.
     */
    public function get_form_list($user_id = NULL, $limit = 30, $offset = 0, $status = NULL, $filter_condition = null)
    {
        if ($user_id != NULL)
            $this->db->where("user_id", $user_id);

        if ($status != NULL)
            $this->db->where("status", $status);

        if ($filter_condition != null) {
            $this->db->where($filter_condition, "", false);
        }

        $this->db->limit($limit, $offset);
        return $this->db->get(self::$xform_table_name)->result();
    }

    /**
     * @param bool $user_id
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function find_forms_by_permission($user_id = FALSE, $limit = 30, $offset = 0)
    {
        //If no user_id was passed use the current users id
        $user_id || $user_id = $this->session->userdata('user_id');

        //User permission
        $user_perm = "P" . $user_id . "P";

        //check if user is in a group with permission to view the forms
        $user_groups = $this->auth->get_users_groups($user_id)->result();

        if ($user_groups) {
            foreach ($user_groups as $ug) {
                $perm = "G" . $ug->id . "G";
                $this->db->or_like("perms", $perm);
            }
        }
        $this->db->or_like("perms", $user_perm);
        $this->db->limit($limit, $offset);
        return $this->db->get(self::$xform_table_name)->result();
    }

    /**
     * @param array $perms
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @param null $push
     * @return mixed
     */
    public function get_form_list_by_perms($perms, $limit = 30, $offset = 0, $status = NULL, $push = NULL)
    {
        if (is_array($perms)) {
            $this->db->group_start();
            foreach ($perms as $key => $value) {
                $this->db->or_like("perms", $value);
            }
            $this->db->group_end();
        } else {
            $this->db->where("perms", $perms);
        }

        if ($status != NULL)
            $this->db->where("status", $status);

        if ($push != NULL)
            $this->db->where("push", $push);

        $this->db->limit($limit, $offset);
        return $this->db->get(self::$xform_table_name)->result();
    }

    /**
     * @param null $user_id
     * @param null $name
     * @param null $access
     * @param null $status
     * @param int $limit
     * @param int $offset
     * @param null $filter_condition
     * @return mixed
     */
    public function search_forms($user_id = NULL, $name = NULL, $access = NULL, $status = NULL, $limit = 30, $offset = 0, $filter_condition = null)
    {

        if ($filter_condition != null) {
            $this->db->where($filter_condition, "", false);
        }

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
     * @param $jr_form_id
     * @return mixed
     */
    function get_form_by_jr_form_id($jr_form_id)
    {
        return $this->db
            ->get_where(self::$xform_table_name, array('jr_form_id' => $jr_form_id))->row();
    }

    /**
     * @param $id
     * @return mixed
     */
    function get_form_by_id($id)
    {
        return $this->db
            ->get_where(self::$xform_table_name, array('id' => $id))->row();
    }

    /**
     * Finds a table field with point data type
     *
     * @param $table_name
     * @return string|bool column name or FALSE
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
     * @param $data
     * @return TRUE or FALSE
     * @internal param $table_name
     */
    public function insert_into_map($data)
    {
        return $this->db->insert_batch(self::$xform_fieldname_map_table_name, $data);
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
     * @param null $perm_conditions
     * @return mixed returns data from tables created by uploading xform definitions files.
     */
    public function find_form_data($table_name, $limit = 500, $offset = 0, $perm_conditions = null)
    {
        if ($perm_conditions != null) {
            if ($perm_conditions != null) {
                $this->db->where($perm_conditions, "", false);
            }
        }

        $this->db->limit($limit, $offset);
        $this->db->order_by("id", "DESC");
        return $this->db->get($table_name)->result();
    }

    /**
     * @param $table_name
     * @param int $limit
     * @param int $offset
     * @param null $perm_conditions
     * @return mixed returns data from tables created by uploading xform definitions files.
     */
    public function find_all_form_data($table_name, $perm_conditions = null)
    {
        if ($perm_conditions != null) {
            if ($perm_conditions != null) {
                $this->db->where($perm_conditions, "", false);
            }
        }

        $this->db->order_by("id", "DESC");
        return $this->db->get($table_name)->result();
    }



    //search form data
    public function search_form_data($table_name, $perm_conditions = null, $start_at = null, $end_at = null)
    {
        if ($perm_conditions != null) {
            if ($perm_conditions != null) {
                $this->db->where($perm_conditions, "", false);
            }
        }

        if ($start_at != null && $end_at != null) {
            $this->db->where('submitted_at BETWEEN "' . date('Y-m-d', strtotime($start_at)) . '" and "' . date('Y-m-d', strtotime($end_at)) . '"');
        }

        $this->db->order_by("id", "DESC");
        return $this->db->get($table_name)->result();
    }

    /**
     * @param $table_name
     * @param array $selected_columns
     * @param int $limit
     * @param int $offset
     * @param null $perm_conditions
     * @return mixed
     */
    public function find_form_data_by_fields($table_name, $selected_columns = array(), $limit = 30, $offset = 0, $perm_conditions = null)
    {
        $this->db->select(implode(",", array_keys($selected_columns)));
        $this->db->limit($limit, $offset);
        $this->db->order_by("id", "DESC");

        if ($perm_conditions != null) {
            $this->db->where($perm_conditions, "", false);
        }

        return $this->db->get($table_name)->result();
    }

    //search form data by fields
    public function search_form_data_by_fields($table_name, $selected_columns = array(), $perm_conditions = null, $start_at = null, $end_at = null)
    {
        $this->db->select(implode(",", array_keys($selected_columns)));
        $this->db->order_by("id", "DESC");

        if ($perm_conditions != null) {
            $this->db->where($perm_conditions, "", false);
        }

        if ($start_at != null && $end_at != null) {
            $this->db->where('submitted_at BETWEEN "' . date('Y-m-d', strtotime($start_at)) . '" and "' . date('Y-m-d', strtotime($end_at)) . '"');
        }

        return $this->db->get($table_name)->result();
    }


    /**
     * @param $table_name
     * @param $entry_id
     * @return mixed
     */
    public function find_form_data_by_id($table_name, $entry_id)
    {
        $this->db->where("id", $entry_id);
        $this->db->from($table_name);
        return $this->db->get()->row(1);
    }

    /**
     * @param $table_name
     * @param null $perm_conditions
     * @return mixed
     */
    public function count_all_records($table_name, $perm_conditions = null)
    {
        $this->db->from($table_name);

        if ($perm_conditions != null) {
            if ($perm_conditions != null) {
                $this->db->where($perm_conditions, "", false);
            }
        }

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
     * @param $table_name
     * @param int $limit
     * @param int $offset
     * @return array of lat,lon,info
     */

    public function get_geospatial_data($table_name, $limit = 30, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get($table_name);
        return ($query->num_rows() == 0) ? FALSE : $query->result_array();
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
     * @param $hide_show_status
     * @return mixed
     */
    public function get_fieldname_map($table_name, $hide_show_status = null)
    {
        if ($hide_show_status != NULL) {
            $this->db->where("hide", $hide_show_status);
        }

        $this->db->where('table_name', $table_name);
        $this->db->from(self::$xform_fieldname_map_table_name);
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

    /**
     * @param $form_id
     * @return mixed
     */
    public function get_form_definition_filename($form_id)
    {
        $this->db->select('filename')->where('form_id', $form_id)->from('xforms');
        return $this->db->get()->row(1)->filename;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function add_to_field_name_map($data)
    {
        $q = $this->db->insert_string(self::$xform_fieldname_map_table_name, $data);
        $q = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $q);
        return $this->db->query($q);
    }

    /**
     * @param $details
     * @return mixed
     */
    public function create_field_name_map($details)
    {
        return $this->db->insert(self::$xform_fieldname_map_table_name, $details);
    }

    /**
     * @param $table_name
     * @param $column_name
     * @return bool
     */
    public function xform_table_column_exists($table_name, $column_name)
    {
        return $this->db
            ->where("table_name", $table_name)
            ->where("col_name", $column_name)
            ->get(self::$xform_fieldname_map_table_name)->num_rows();
    }

    /**
     * Updates multiple field maps
     *
     * @param $details
     * @return mixed
     */
    public function update_field_name_maps($details)
    {
        return $this->db->update_batch(self::$xform_fieldname_map_table_name, $details, "id");
    }

    /**
     * Returns mapped and actual table column names for a particular xform table
     *
     * @param $form_id = which is equivalent to table name
     * @param null $hide_show_status
     * @param null $chart_use
     * @return mixed
     */
    public function find_all_field_name_maps($form_id, $hide_show_status = NULL, $chart_use = NULL)
    {
        $this->db->where("table_name", $form_id);
        if ($hide_show_status != NULL) {
            $this->db->where("hide", $hide_show_status);
        }

        if ($chart_use != NULL) {
            $this->db->where("chart_use", $chart_use);
        }
        return $this->db->get(self::$xform_fieldname_map_table_name)->result();
    }

    /**
     * @param $xform_id
     * @param $fields
     * @return mixed
     */
    public function update_field_map_labels($xform_id, $fields)
    {
        $this->db->trans_start();
        foreach ($fields as $key => $value) {
            $this->db->where("table_name", $xform_id);
            $this->db->where("col_name", $key);
            $this->db->set("field_label", $value);
            $this->db->update(self::$xform_fieldname_map_table_name);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * @param $table_name
     * @param $entry_id
     * @return mixed
     */
    public function delete_form_data($table_name, $entry_id)
    {
        $this->db->where("id", $entry_id);
        $this->db->limit(1);
        return $this->db->delete($table_name);
    }

    /**
     * @return mixed
     */
    function count_searchable_form()
    {
        $this->where_condition('xforms_config', 'user_id');

        return $this->db->get('xforms_config')->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return mixed
     */
    function get_searchable_form_list($num, $start)
    {
        $this->where_condition('xforms_config', 'user_id');

        return $this->db
            ->limit($num, $start)
            ->get('xforms_config')->result();
    }


    /**
     * @param string $table_name which is form_id (xform instance id)
     * @param string $date_column the name of the date column
     * @param string $duration possible values are today, yesterday,last7days, month, last_month, year, last_year
     * @return mixed
     */
    public function find_submissions_count_by_duration($table_name, $date_column, $duration = "month")
    {
        if ($duration == "today") {
            $date = date("Y-m-d");
            $this->db->select("HOUR({$date_column}) AS `{$date_column}`,COUNT(*) AS submissions_count ", FALSE);
            $this->db->where("DATE(DATE_FORMAT(`{$date_column}`,'%Y-%m-%d')) =", "'" . $date . "'", FALSE);
            $this->db->group_by("HOUR(`{$date_column}`)");
        }

        if ($duration == "yesterday") {
            $date = new DateTime();
            $date->sub(new DateInterval('P1D'));
            $this->db->select("HOUR({$date_column}) AS `{$date_column}`,COUNT(*) AS submissions_count ", FALSE);
            $this->db->where("DATE(DATE_FORMAT(`{$date_column}`,'%Y-%m-%d')) =", "'" . $date->format("Y-m-d") . "'", FALSE);
            $this->db->group_by("HOUR(`{$date_column}`)");
        }

        if ($duration == "last7days") {
            $this->db->select("DATE_FORMAT(`{$date_column}`,'%Y-%m-%d') AS `{$date_column}`,COUNT(*) AS submissions_count ", FALSE);
            $this->db->where("DATE(DATE_FORMAT(`{$date_column}`,'%Y-%m-%d')) >=", "DATE(NOW()) - INTERVAL 7 DAY", FALSE);
            $this->db->group_by("DATE(DATE_FORMAT(`{$date_column}`,'%Y-%m-%d'))");
        }

        if ($duration == "month") {
            $this->db->select("DATE_FORMAT(`{$date_column}`,'%Y-%m-%d') AS `{$date_column}`,COUNT(*) AS submissions_count ", FALSE);
            $this->db->where("MONTH(`{$date_column}`) ", "MONTH(CURDATE())", FALSE);
            $this->db->group_by("DATE(DATE_FORMAT(`{$date_column}`,'%Y-%m-%d'))");
        }

        if ($duration == "last_month") {
            $this->db->select("DATE_FORMAT(`{$date_column}`,'%Y-%m-%d') AS `{$date_column}`,COUNT(*) AS submissions_count ", FALSE);
            $this->db->where("YEAR(`{$date_column}`) ", " YEAR(CURRENT_DATE - INTERVAL 1 MONTH)", FALSE);
            $this->db->where("MONTH(`{$date_column}`) ", " MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", FALSE);
            $this->db->group_by("DATE(DATE_FORMAT(`{$date_column}`,'%Y-%m-%d'))");
        }

        if ($duration == "year") {
            $this->db->select("MONTHNAME(`{$date_column}`) AS `{$date_column}`,COUNT(*) AS submissions_count ", FALSE);
            $this->db->where("YEAR(`{$date_column}`) ", " YEAR(CURRENT_DATE)", FALSE);
            $this->db->group_by("MONTHNAME(`{$date_column}`)");
            $this->db->order_by("MONTHNAME(`{$date_column}`)", "ASC");
        }

        if ($duration == "last_year") {
            $this->db->select("MONTHNAME(`{$date_column}`) AS `{$date_column}`,COUNT(*) AS submissions_count ", FALSE);
            $this->db->where("(YEAR(`{$date_column}`))", " (YEAR(CURRENT_DATE) - 1)", FALSE);
            $this->db->group_by("MONTHNAME(`{$date_column}`)");
            $this->db->order_by("MONTHNAME(`{$date_column}`)", "ASC");
        }
        return $this->db->get($table_name)->result();
    }


    /**
     * @param $table_name
     * @param $count_columns
     * @param $group_by
     * @return bool
     */
    public function get_count_by_columns($table_name, $count_columns, $group_by)
    {
        if (is_array($count_columns)) {
        } else {

            $this->db->select($group_by);
            if ($count_columns == null) {
                return false;
            }
            $this->db->select_sum($count_columns, $count_columns);
        }

        $this->db->group_by($group_by);
        return $this->db->get($table_name)->result();
    }

    /**
     * @param $table_name
     * @param $field_type
     */
    public function find_form_map_by_field_type($table_name, $field_type)
    {
        $this->db->where("table_name", $table_name);
        $this->db->where("field_type", $field_type);
        return $this->db->get(self::$xform_fieldname_map_table_name)->row();
    }
}
