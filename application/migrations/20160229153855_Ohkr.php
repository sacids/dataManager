<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/29/2016
 * Time: 3:38 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Ohkr extends CI_Migration
{

	public function up()
	{
		// Drop table 'species' if it exists
		$this->dbforge->drop_table('species', TRUE);
		// Table structure for table 'diseases'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE
			),
			'date_created' => array(
				'type' => "DATETIME",
				'null' => FALSE
			)
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('species');

		// Drop table 'diseases' if it exists
		$this->dbforge->drop_table('diseases', TRUE);

		// Table structure for table 'diseases'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE
			),
			'description' => array(
				'type' => 'TEXT'
			),
			'date_created' => array(
				'type' => "DATETIME",
				'null' => FALSE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('diseases');

		// Drop table 'symptoms' if it exists
		$this->dbforge->drop_table('symptoms', TRUE);

		// Table structure for table 'symptoms'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE
			),
			'description' => array(
				'type' => 'TEXT'
			),
			'date_created' => array(
				'type' => "DATETIME",
				'null' => FALSE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('symptoms');

		// Drop table 'diseases_symptoms' if it exists
		$this->dbforge->drop_table('diseases_symptoms', TRUE);

		// Table structure for table 'diseases_symptoms'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'specie_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE
			),
			'disease_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE
			),
			'symptom_id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE
			),
			"importance" => array(
				'type' => 'DOUBLE'
			),
			'date_created' => array(
				"type" => 'DATETIME',
				'null' => FALSE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('diseases_symptoms');

		$this->db->query('ALTER TABLE diseases_symptoms ADD CONSTRAINT fk_specie_id FOREIGN KEY(specie_id) REFERENCES species(id) ON DELETE CASCADE ON UPDATE CASCADE;');
		$this->db->query('ALTER TABLE diseases_symptoms ADD CONSTRAINT fk_disease_id FOREIGN KEY(disease_id) REFERENCES diseases(id) ON DELETE CASCADE ON UPDATE CASCADE;');
		$this->db->query('ALTER TABLE diseases_symptoms ADD CONSTRAINT fk_symptom_id FOREIGN KEY(symptom_id) REFERENCES symptoms(id) ON DELETE CASCADE ON UPDATE CASCADE;');
	}


	public function down()
	{
		$this->dbforge->drop_table('diseases_symptoms', TRUE);
		$this->dbforge->drop_table('species', TRUE);
		$this->dbforge->drop_table('diseases', TRUE);
		$this->dbforge->drop_table('symptoms', TRUE);
	}
}