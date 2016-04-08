<?php
class Migration_Perms extends CI_Migration {
	public function up() {
		$this->dbforge->add_field ( array (
				'id' => array (
						'type' => 'INT',
						'constraint' => 5,
						'unsigned' => TRUE,
						'auto_increment' => TRUE 
				),
				'parent_id' => array (
						'type' => 'INT',
						'constraint' => '5',
						'unsigned' => TRUE 
				),
				'module_id' => array (
						'type' => 'INT',
						'constraint' => '5',
						'unsigned' => TRUE 
				),
				'title' => array (
						'type' => 'VARCHAR',
						'constraint' => '150',
						'null' => FALSE 
				),
				'perm_type' => array (
						'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => FALSE 
				),
				'perm_target' => array (
						'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => FALSE 
				),
				'perm_data' => array (
						'type' => 'TEXT',
						'null' => TRUE 
				),
				'perms' => array (
						'type' => 'TEXT',
						'null' => TRUE 
				) 
		) );
		$this->dbforge->add_key ( 'id', TRUE );
		$this->dbforge->create_table ( 'perm_tree' );
		
		// dumping initial data
		$data = array (
				'id' => '1',
				'parent_id' => '0',
				'module_id' => '0',
				'title' => 'ROOT',
				'perm_type' => 0 
		);
		
		$this->db->insert ( 'perm_tree', $data );
	}
	public function down() {
		$this->dbforge->drop_table ( 'perm_tree' );
	}
}