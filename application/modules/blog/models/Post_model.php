<?php
/**
 * AfyaData
 *  
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package	    AfyaData
 * @author	    AfyaData Dev Team
 * @copyright	Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license	    http://opensource.org/licenses/MIT	MIT License
 * @link	    https://afyadata.sacids.org
 * @since	    Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 11:05
 */
class Post_model extends CI_Model
{
	private static $table_name = "blog_posts";
	private static $table_name_users = "users";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $post
	 * @return mixed
	 */
	public function create($post)
	{
		$this->db->insert(self::$table_name, $post);
		return $this->db->insert_id();
	}

	/**
	 * @param int $limit
	 * @param int $offset
	 * @return mixed
	 */
	public function find_all($limit = 30, $offset = 0)
	{
		$this->db->select("u.first_name,u.last_name,u.username,p.*");
		$this->db->from(self::$table_name." p");
		$this->db->join(self::$table_name_users." u","u.id = p.user_id");
		$this->db->limit($limit, $offset);
		$this->db->order_by("date_created", "DESC");
		return $this->db->get()->result();
	}

	/**
	 * @param $post_id
	 * @return string
	 */
	public function find_by_id($post_id)
	{
		$this->db->select("u.first_name,u.last_name,u.username,p.*");
		$this->db->from(self::$table_name." p");
		$this->db->join(self::$table_name_users." u","u.id = p.user_id");
		$this->db->where("p.id", $post_id);
		return $this->db->get()->row(1);
	}
	
	public function update($post_id, $updated_details)
	{
		$this->db->where("id", $post_id);
		$this->db->limit(1);
		return $this->db->update(self::$table_name, $updated_details);
	}
}