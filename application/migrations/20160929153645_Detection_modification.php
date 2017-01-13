<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 29-Sep-16
 * Time: 15:36
 */
class Migration_Detection_modification extends CI_Migration
{
	public function up()
	{
		$this->dbforge->drop_table('ohkr_detected_diseases', TRUE);
		$this->dbforge->add_field(array(
			'id'            => array(
				'type'           => 'INT',
				'constraint'     => '11',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'form_id'       => array(
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => FALSE
			),
			'disease_id'    => array(
				'type'       => 'INT',
				'unsigned'   => TRUE,
				'constraint' => '11',
				'null'       => FALSE
			),
			'instance_id'   => array(
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => FALSE
			),
			'location'      => array(
				'type'       => "VARCHAR",
				'constraint' => 45,
				'null'       => FALSE
			),
			'date_detected' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ohkr_detected_diseases');
		$this->db->query('ALTER TABLE ohkr_detected_diseases ADD CONSTRAINT fk_ohkr_dd_disease_id FOREIGN KEY(disease_id) REFERENCES ohkr_diseases(id) ON DELETE CASCADE ON UPDATE CASCADE;');
		echo "Migration script to create ohkr_detected_diseases table finished running";
	}

	public function down()
	{
		$this->dbforge->drop_table('ohkr_detected_diseases', TRUE);
	}
}