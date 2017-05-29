<?php

/**
 * Feedback Model class
 *
 * @package     Campaign_model
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Campaign_model extends CI_Model
{

    private $user_id;

    /**
     * Campaign table name
     *
     * @var string
     */
    private static $table_name = "campaign";
    private static $xform_table_name = "xforms";

    public function __construct()
    {
        parent::__construct();

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
     * @return mixed
     */
    function count_active_campaign()
    {
        $this->where_condition('campaign', 'owner');

        return $this->db->get('campaign')->num_rows();
    }


    /**
     * @param $campaign_details
     * @return id for the created campaign
     */
    public function create_campaign($campaign_details)
    {
        $this->db->insert(self::$table_name, $campaign_details);
        return $this->db->insert_id();
    }

    /**
     * @param $num
     * @param $start
     * @return mixed
     */
    public function get_campaign($num, $start)
    {
        $this->where_condition('campaign', 'owner');

        return $this->db
            ->limit($num, $start)
            ->get(self::$table_name . " campaign")
            ->result();
    }

    /**
     * @param $campaign_id
     * @return mixed
     */
    public function get_campaign_by_id($campaign_id)
    {
        return $this->db
            ->get_where(self::$table_name, array('id' => $campaign_id))->row();
    }


    public function update_campaign($id, $campaign)
    {
        $this->db->where("id", $id);
        return $this->db->update(self::$table_name, $campaign);
    }

    public function delete_campaign($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete(self::$table_name);
    }


    /**
     * @param null
     * @return mixed
     */
    public function get_campaign_list()
    {
        return $this->db->get(self::$table_name)->result();
    }

    /**
     * @param $xform_id
     * @return mixed
     */
    public function find_by_xform_id($xform_id)
    {
        $this->db->where("form_id", $xform_id);
        $query = $this->db->get(self::$xform_table_name)->row();

        if (!empty($query->title)) {
            return $query->title;
        } else {
            return "";
        }

    }

}