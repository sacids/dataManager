<?php
class Migration_xform_fieldname_map extends CI_Migration {
	public function up() {
		$this->dbforge->add_field ( array (
				'id' => array (
						'type' => 'INT',
						'constraint' => 11,
						'auto_increment' => TRUE 
				),
				'table_name' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => FALSE
				),
				'type' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => FALSE
				),
				'col_name' => array(
						'type' => 'VARCHAR',
						'constraint' => '64',
						'null' => FALSE
				),
				'field_name' => array(
						'type' => 'TEXT',
						'null' => FALSE
				),
				'field_label' => array(
						'type' => 'TEXT',
						'null' => FALSE
				)
		) );
		$this->dbforge->add_key ( 'id', TRUE );
		$this->dbforge->create_table ( 'xform_fieldname_map' );
	}
	public function down() {
		$this->dbforge->drop_table ( 'xform_fieldname_map' );
	}
}