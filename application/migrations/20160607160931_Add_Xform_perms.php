<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 07-Jun-16
 * Time: 16:10
 */
class Migration_Add_Xform_perms extends CI_Migration
{
	public function up()
	{
		//Add perms field for handling permissions for individual user and user groups
		$xform_tbl_new_column = array(
			'perms' => array(
				'type'    => 'TEXT'
			)
		);
		$this->dbforge->add_column("xforms", $xform_tbl_new_column);
	}

	public function down()
	{
		$this->dbforge->drop_column("xforms", "perms");
	}
}