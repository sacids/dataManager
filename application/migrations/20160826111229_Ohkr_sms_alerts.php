<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 26-Aug-16
 * Time: 11:13
 */
class Migration_Ohkr_sms_alerts extends CI_Migration
{
	public function up()
	{
		$this->dbforge->drop_table('ohkr_response_sms', TRUE);
		$this->dbforge->add_field(array(
			'id'            => array(
				'type'           => 'INT',
				'constraint'     => '11',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'disease_id'    => array(
				'type'       => 'INT',
				'unsigned'   => TRUE,
				'constraint' => '11',
				'null'       => FALSE
			),
			'group_id'      => array(
				'type'       => 'mediumint',
				'unsigned'   => TRUE,
				'constraint' => 8,
				'null'       => FALSE
			),
			'message'       => array(
				'type' => "TEXT",
				'null' => FALSE
			),
			'type'          => array(
				'type'    => 'ENUM("TEXT","IMAGE","AUDIO","VIDEO")',
				'default' => "TEXT",
				'null'    => FALSE
			),
			'media_url'     => array(
				'type' => 'TEXT'
			),
			'date_created'  => array(
				'type' => 'DATETIME',
				'null' => FALSE
			),
			'date_modified' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'status'          => array(
				'type'    => 'ENUM("Enabled","Disabled")',
				'default' => "Enabled",
				'null'    => FALSE
			)
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ohkr_response_sms');
		$this->db->query('ALTER TABLE ohkr_response_sms ADD CONSTRAINT fk_ohkr_disease_id FOREIGN KEY(disease_id) REFERENCES ohkr_diseases(id) ON DELETE CASCADE ON UPDATE CASCADE;');
		$this->db->query('ALTER TABLE ohkr_response_sms ADD CONSTRAINT fk_tbl_group_id FOREIGN KEY(group_id) REFERENCES groups(id) ON DELETE CASCADE ON UPDATE CASCADE;');


		$this->dbforge->drop_table('ohkr_sent_sms', TRUE);
		$this->dbforge->add_field(array(
			'id'              => array(
				'type'           => 'INT',
				'constraint'     => '11',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'response_msg_id' => array(
				'type'       => 'INT',
				'unsigned'   => TRUE,
				'constraint' => '11',
				'null'       => FALSE
			),
			'phone_number'    => array(
				'type'       => 'VARCHAR',
				'constraint' => 45,
				'null'       => FALSE
			),
			'date_sent'       => array(
				'type' => 'DATETIME',
				'null' => FALSE
			),
			'date_delivered'  => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'status'          => array(
				'type' => "ENUM('PENDING','SENT','DELIVERED','REJECTED')",
				'null' => FALSE
			),
			'infobip_msg_id'  => array(
				'type' => 'TEXT',
				'null' => FALSE
			)
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ohkr_sent_sms');
		$this->db->query('ALTER TABLE ohkr_sent_sms ADD CONSTRAINT fk_respons_msg_id FOREIGN KEY(response_msg_id) REFERENCES ohkr_response_sms(id) ON DELETE CASCADE ON UPDATE CASCADE;');
	}


	public function down()
	{
		$this->dbforge->drop_table('ohkr_sent_sms', TRUE);
		$this->dbforge->drop_table('ohkr_response_sms', TRUE);
	}
}