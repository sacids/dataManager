<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 14/03/2018
 * Time: 13:28
 */

class Newsletter_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data
     * @return bool
     */
    function create_newsletter_story($data)
    {
        return $this->db->insert('newsletter_stories', $data);
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    function update_newsletter_story($data, $id)
    {
        return $this->db->update('newsletter_stories', $data, array('id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete_newsletter_story($id)
    {
        return $this->db->delete('newsletter_stories', array('id' => $id));
    }

    /**
     * @param $edition_id
     * @return mixed
     */
    function delete_newsletter_stories_by_edition($edition_id)
    {
        return $this->db->delete('newsletter_stories', array('edition_id' => $edition_id));
    }

    /**
     * @return int
     */
    function count_newsletter_stories()
    {
        return $this->db->get('newsletter_stories')->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return array
     */
    function get_newsletter_stories_list($num, $start)
    {
        return $this->db
            ->limit($num, $start)
            ->order_by('date_created', 'DESC')
            ->get('newsletter_stories')->result();
    }

    /**
     * @param null $keyword
     * @return array
     */
    function search_newsletter_stories_list($keyword = null)
    {
        if ($keyword != null)
            $this->db->like('title', $keyword);

        return $this->db
            ->order_by('date_created', 'DESC')
            ->get('newsletter_stories')->result();
    }

    /**
     * @param $id
     * @return mixed
     */
    function get_newsletter_story_by_id($id)
    {
        return $this->db->get_where('newsletter_stories', array('id' => $id))->row();
    }

    /**
     * @param $alias
     * @return mixed
     */
    function get_newsletter_story_by_alias($alias)
    {
        return $this->db->get_where('newsletter_stories', array('alias' => $alias))->row();
    }

    /**
     * @param $edition_id
     * @return mixed
     */
    function get_newsletter_stories_by_edition($edition_id)
    {
        return $this->db->get_where('newsletter_stories', array('edition_id' => $edition_id))->result();
    }

    /**
     * @param $data
     * @return bool
     */
    function create_newsletter_edition($data)
    {
        return $this->db->insert('newsletter_edition', $data);
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    function update_newsletter_edition($data, $id)
    {
        return $this->db->update('newsletter_edition', $data, array('id' => $id));
    }

    function delete_newsletter_edition($id)
    {
        return $this->db->delete('newsletter_edition', array('id' => $id));
    }

    /**
     * @return int
     */
    function count_newsletter_edition()
    {
        return $this->db->get('newsletter_edition')->num_rows();
    }

    /**
     * @param $num
     * @param $start
     * @return array
     */
    function get_newsletter_edition_list($num, $start)
    {
        return $this->db
            ->limit($num, $start)
            ->order_by('date_created', 'DESC')
            ->get('newsletter_edition')->result();
    }

    /**
     * @return array
     */
    function find_all_edition()
    {
        return $this->db
            ->order_by('date_created', 'DESC')
            ->get('newsletter_edition')->result();
    }

    /**
     * @param $id
     * @return mixed
     */
    function get_newsletter_edition_by_id($id)
    {
        return $this->db->get_where('newsletter_edition', array('id' => $id))->row();
    }
}