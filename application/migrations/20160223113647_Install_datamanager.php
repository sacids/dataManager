<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/15/2016
 * Time: 9:46 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_datamanager extends CI_Migration
{

	public function up()
	{


		// Drop table 'users_groups' if it exists
		$this->dbforge->drop_table('users_groups', TRUE);

		// Table structure for table 'users_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users_groups');

		// Dumping data for table 'users_groups'
		$data = array(
			array(
				'id' => '1',
				'user_id' => '1',
				'group_id' => '1',
			),
			array(
				'id' => '2',
				'user_id' => '1',
				'group_id' => '2',
			)
		);
		$this->db->insert_batch('users_groups', $data);


		// Drop table 'groups' if it exists
		$this->dbforge->drop_table('groups', TRUE);

		// Table structure for table 'groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('groups');

		// Dumping data for table 'groups'
		$data = array(
			array(
				'id' => '1',
				'name' => 'admin',
				'description' => 'Administrator'
			),
			array(
				'id' => '2',
				'name' => 'members',
				'description' => 'General User'
			)
		);
		$this->db->insert_batch('groups', $data);


		// Drop table 'users' if it exists
		$this->dbforge->drop_table('users', TRUE);

		// Table structure for table 'users'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'digest_password' => array(
				'type' => "VARCHAR",
				'constraint' => 255
			),
			'salt' => array(
				'type' => 'VARCHAR',
				'constraint' => '40'
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			),
			'activation_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'remember_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'last_login' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'active' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'company' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE
			)

		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users');

		// Dumping data for table 'users'
		$data = array(
			'id' => '1',
			'ip_address' => '127.0.0.1',
			'username' => 'admin',
			'password' => '$2y$08$Vrbcwo2zOjND1iHIjl8v5u95M1OByh5I.eCvEU/Y1gph81layyt1.',
			'digest_password' => 'f148100e1483c8438ecff8873f324caa',
			'salt' => '',
			'email' => 'admin@sacids.org',
			'activation_code' => '',
			'forgotten_password_code' => NULL,
			'created_on' => '1268889823',
			'last_login' => '1268889823',
			'active' => '1',
			'first_name' => 'Admin',
			'last_name' => 'istrator',
			'company' => 'SACIDS',
			'phone' => '+2557',
		);
		$this->db->insert('users', $data);


		// Drop table 'login_attempts' if it exists
		$this->dbforge->drop_table('login_attempts', TRUE);

		// Table structure for table 'login_attempts'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'login' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null', TRUE
			),
			'time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('login_attempts');


		// Drop table 'ci_sessions' if it exists
		$this->dbforge->drop_table('ci_sessions', TRUE);

		$this->dbforge->add_field(
			array(
				'id' => array(
					'type' => 'VARCHAR',
					'constraint' => 40
				),
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 45
				),
				'timestamp' => array(
					'type' => 'INT',
					'constraint' => 10,
					'unsigned' => TRUE
				),
				'data' => array(
					'type' => 'BLOB',
					'null' => FALSE
				)
			)
		);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table("ci_sessions");

		// Drop table 'xforms' if it exists
		$this->dbforge->drop_table('xforms', TRUE);

		$this->dbforge->add_field(
			array(
				'id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
				'form_id' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'description' => array(
					'type' => 'TEXT'
				),
				'title' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'filename' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'date_created' => array(
					'type' => 'DATETIME'
				),
				'last_updated' => array(
					'type' => 'TIMESTAMP',
					'null' => TRUE
				)
			)
		);

		$this->dbforge->add_key("id", TRUE);
		$this->dbforge->create_table("xforms");
		$this->db->query('ALTER TABLE xforms  ADD UNIQUE INDEX (form_id)');
		$this->db->query('ALTER TABLE xforms  ADD UNIQUE INDEX (filename)');


		// Drop table 'archive_xforms' if it exists
		$this->dbforge->drop_table('archive_xforms', TRUE);

		$this->dbforge->add_field(
			array(
				'id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
				'form_id' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'description' => array(
					'type' => 'TEXT'
				),
				'title' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'filename' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'date_created' => array(
					'type' => 'DATETIME'
				),
				'last_updated' => array(
					'type' => 'TIMESTAMP',
					'null' => TRUE
				)
			)
		);

		$this->dbforge->add_key("id", TRUE);
		$this->dbforge->create_table("archive_xform");
		$this->db->query('ALTER TABLE xforms  ADD UNIQUE INDEX (filename)');

		// Drop table 'submission_form' if it exists
		$this->dbforge->drop_table('submission_form', TRUE);

		$this->dbforge->add_field(
			array(
				'id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
				'user_id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE
				),
				'device_id' => array(
					'type' => 'VARCHAR',
					'constraint' => 100
				),
				'file_name' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'submitted_on' => array(
					'type' => 'DATETIME'
				),
				'status' => array(
					'type' => 'TINYINT',
					'constraint' => 1
				)
			)
		);

		$this->dbforge->add_key("id", TRUE);
		$this->dbforge->create_table("submission_form");
		$this->db->query('ALTER TABLE submission_form  ADD UNIQUE INDEX (file_name)');


		// Drop table 'feedback' if it exists
		$this->dbforge->drop_table('feedback', TRUE);

		$this->dbforge->add_field(
			array(
				'id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
				'form_id' => array(
					'type' => 'VARCHAR',
					'constraint' => 100
				),
				'user_id' => array(
					'type' => 'INT',
					'constraint' => 11
				),
				'message' => array(
					'type' => 'TEXT',
					'null' => FALSE
				),
				'date_created' => array(
					'type' => 'DATETIME'
				),
				'viewed' => array(
					'type' => 'VARCHAR',
					'constraint' => 100
				)
			)
		);

		$this->dbforge->add_key("id", TRUE);
		$this->dbforge->create_table("feedback");
	}

	public function down()
	{
		$this->dbforge->drop_table('users', TRUE);
		$this->dbforge->drop_table('groups', TRUE);
		$this->dbforge->drop_table('users_groups', TRUE);
		$this->dbforge->drop_table('login_attempts', TRUE);

		$this->dbforge->drop_table('ci_sessions', TRUE);
		$this->dbforge->drop_table('xforms', TRUE);
		$this->dbforge->drop_table('submission_form', TRUE);
		$this->dbforge->drop_table('feedback', TRUE);
	}
}