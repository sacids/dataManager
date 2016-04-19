<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 4/15/2016
 * Time: 1:45 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Updates_form_management extends CI_Migration
{

	public function up()
	{
		$this->dbforge->drop_table('archive_xforms', TRUE);

		//todo add status for xforms to indicate deleted,archived

		$xform_tbl_new_column = array(
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => 'published' //published,unpublished,deleted,archived
			)
		);
		$this->dbforge->add_column("xforms", $xform_tbl_new_column);
		//Access field should have groups as well G{id}G
	}

	public function down()
	{
		//create archieved_xforms table
		$this->dbforge->drop_column("xforms","status");
	}
}
