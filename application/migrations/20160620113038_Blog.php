<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 11:30
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Blog extends CI_Migration
{
	public function up()
	{
		// Drop table 'blog_posts' if it exists
		$this->dbforge->drop_table('blog_posts', TRUE);

		$this->dbforge->add_field(array(
			'id'            => array(
				'type'           => 'INT',
				'constraint'     => '11',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'user_id'       => array(
				'type'       => 'mediumint',
				'constraint' => '8',
				'unsigned'   => TRUE
			),
			'alias'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => FALSE
			),
			'title'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => FALSE
			),
			'content'       => array(
				'type' => 'TEXT'
			),
			'status'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '15',
				'default'    => 'draft'
			),
			'date_created'  => array(
				'type' => "DATETIME",
				'null' => FALSE
			),
			'date_modified' => array(
				'type' => "DATETIME",
				'null' => FALSE
			)
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('blog_posts');
		$this->db->query('ALTER TABLE blog_posts ADD CONSTRAINT fk_blog_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;');

	}

	public function down()
	{
		$this->dbforge->drop_table('blog_posts', TRUE);
	}
}