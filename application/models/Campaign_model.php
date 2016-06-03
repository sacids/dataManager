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
     * @param null
     * @return mixed
     */
    public function get_campaign()
    {
        return $this->db->select('cmp.id, cmp.title as c_title, cmp.icon, cmp.type, cmp.date_created, xform.title as x_title')
            ->join(self::$xform_table_name . " xform", "xform.form_id = cmp.form_id", "left")
            ->get(self::$table_name . " cmp")->result();
    }

    /**
     * @param $campaign_id
     * @return mixed
     */
    public function get_campaign_by_id($campaign_id)
    {
        return $this->db->select('cmp.id, cmp.title as c_title, cmp.icon, cmp.type, cmp.date_created,
        cmp.form_id, cmp.description, xform.title as x_title')
            ->join(self::$xform_table_name . " xform", "xform.form_id = cmp.form_id", "left")
            ->get_where(self::$table_name . " cmp", array('cmp.id' => $campaign_id))
            ->row();
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