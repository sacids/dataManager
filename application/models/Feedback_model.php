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

	/**
	 * @param $user_id
	 * @param $form_id
	 * @param null $last_id
	 * @return mixed
	 */
	function get_feedback($user_id, $form_id, $last_id = NULL)
	{
		if ($last_id != NULL)
			$this->db->where('id > ', $last_id);

		$this->db->where('user_id', $user_id);
		$this->db->where('form_id', $form_id);
		return $this->db->get(self::$table_name)->result();
	}

	/**
	 * @param $feedback array of feedback information.
	 * @return mixed
	 */
	function create_feedback($feedback)
	{
		return $this->db->insert(self::$table_name, $feedback);
	}
}