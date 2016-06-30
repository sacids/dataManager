<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 27-Jun-16
 * Time: 20:12
 */
class Migration_Update_xforms_table extends CI_Migration
{

	public function up()
	{
		$field = array(
			'jr_form_id' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
			),
		);
		$this->dbforge->add_column("xforms", $field);
	}

	public function down()
	{
		$this->dbforge->drop_column('xforms', 'jr_form_id');
	}
}