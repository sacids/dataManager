<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/7/2016
 * Time: 10:58 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Table_modifications extends CI_Migration
{
	public function up()
	{
		$field = array(
			'country_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
			),
		);
		$this->dbforge->add_column('users', $field);

		$fields = array(
			'viewed' => array(
				'name' => 'viewed_by',
				'type' => 'TEXT',
			),
		);
		$this->dbforge->modify_column('feedback', $fields);

		$fields = array(
			'instance_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'sender' => array( //data collector(user) or server(AI)
				'type' => 'VARCHAR',
				'constraint' => 10,
			)
		);
		$this->dbforge->add_column('feedback', $fields);

		// Add access column to control who can see the forms
		$xform_tbl_new_columns = array(
			'access' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => 'private'
			)
		);
		$this->dbforge->add_column("xforms", $xform_tbl_new_columns);
		$this->dbforge->add_column("archive_xforms", $xform_tbl_new_columns);
	}

	public function down()
	{
		$fields = array(
			'viewed_by' => array(
				'name' => 'viewed',
				'type' => 'VARCHAR',
				'constraint' => 100
			),
		);
		//$this->dbforge->modify_column('feedback', $fields);
		//$this->dbforge->drop_column('feedback', 'instance_id');
		//$this->dbforge->drop_column('feedback', 'sender');
		//$this->dbforge->drop_column('users', 'country_code');
		//$this->dbforge->drop_column('xforms', 'access');
		//$this->dbforge->drop_column('archive_xforms', 'access');
	}
}