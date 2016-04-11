<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Feedback Model class
 *
 * @package     Feedback_model
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Feedback_model extends CI_Model
{

	/**
	 * Feedback table name
	 *
	 * @var string
	 */
	private static $table_name = "feedback";

	function __construct()
	{
		parent::__construct();
	}

	function find_all()
	{
		$this->db->join('users', 'users.id = feedback.user_id')
			->order_by('date_created','ASC')
			->group_by('feedback.user_id');
		return $this->db->get(self::$table_name)->result();
	}

	/**
	 * @param $user_id
	 * @param $form_id
	 * @param null $last_id
	 * @return mixed
	 */
	function get_feedback($user_id, $form_id = NULL, $last_id = NULL)
	{
		if ($last_id != NULL)
			$this->db->where('id > ', $last_id);

		if ($form_id != NULL)
			$this->db->where('form_id', $form_id);

		$this->db->where('user_id', $user_id);
		return $this->db->get(self::$table_name)->result();
	}

	/**
	 * @param $feedback array of feedback information.
	 * @return mixed
	 * @author Godluck Akyoo
	 */
	function create_feedback($feedback)
	{
		return $this->db->insert(self::$table_name, $feedback);
	}
}