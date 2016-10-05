<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 4/21/2016
 * Time: 5:19 PM
 */
class Migration_whatsapp_database extends CI_Migration
{

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'fullname' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE
			),
			'message' => array(
				'type' => 'TEXT'
			),
			'date_sent_received' => array(
				'type' => "DATETIME",
				'null' => FALSE
			),
			'date_created' => array(
				'type' => "DATETIME",
				'null' => FALSE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('whatsapp');
	}


	public function down()
	{
		$this->dbforge->drop_table('whatsapp', TRUE);
	}
}