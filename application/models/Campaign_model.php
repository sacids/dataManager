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

    function count_active_campaign()
    {
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
     * @param null
     * @return mixed
     */
    public function get_campaign()
    {
        return $this->db->select('campaign.id, campaign.title as campaign_title, campaign.icon, campaign.featured, campaign.type,
                        campaign.date_created, campaign.jr_form_id, campaign.description, xform.title as xform_title')
            ->join(self::$xform_table_name . " xform", "xform.jr_form_id = campaign.jr_form_id", "left")
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
            ->select('campaign.id, campaign.title as campaign_title, campaign.icon, campaign.featured, campaign.type,
                        campaign.date_created, campaign.jr_form_id, campaign.description, xform.title as xform_title')
            ->join(self::$xform_table_name . " xform", "xform.jr_form_id = campaign.jr_form_id", "left")
            ->get_where(self::$table_name . " campaign", array('campaign.id' => $campaign_id))
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