<?php
/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 1/19/2017
 * Time: 11:08 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Permission extends CI_Migration
{

    function up()
    {
        // Drop table 'perms_module' if it exists
        $this->dbforge->drop_table('perms_module', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => FALSE
            ),
            'controller' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('perms_module');

        // Drop table 'perms' if it exists
        $this->dbforge->drop_table('perms', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => FALSE
            ),
            'perm_slug' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            ),
            'module_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('perms');

        // Drop table 'perms_group' if it exists
        $this->dbforge->drop_table('perms_group', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'group_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            'module_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            'perm_slug' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            ),
            'allow' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('perms_group');

        // Drop table 'district' if it exists
        $this->dbforge->drop_table('district', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            ),
            'code' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('district');
    }

    public function down()
    {
        $this->dbforge->drop_table('perms_module', TRUE);
        $this->dbforge->drop_table('perms', TRUE);
        $this->dbforge->drop_table('perms_group', TRUE);
        $this->dbforge->drop_table('district', TRUE);
    }

}