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
        return $this->db->get(self::$table_name)->result();
    }

    /**
     * @param $campaign_id
     * @return mixed
     */
    public function get_campaign_by_id($campaign_id)
    {
        return $this->db->get_where(self::$table_name, array('id' => $campaign_id))->row();
    }

}