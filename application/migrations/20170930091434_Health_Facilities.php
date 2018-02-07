<?php

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 30/09/2017
 * Time: 09:14
 */
class Migration_Health_Facilities extends CI_Migration
{
    public function up()
    {

        //table health facilities
        $this->dbforge->drop_table('health_facilities', TRUE);

        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => true
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'address' => array(
                'type' => 'TEXT'
            ),
            'latitude' => array(
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
            'longitude' => array(
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
            'district' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'created_at' => array(
                'type' => 'DATETIME'
            ),
        );
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('health_facilities');


        //add column type field in users table
        $add_field['facility'] = array(
            'type' => 'INT',
            'constraint' => 11
        );

        $this->dbforge->add_column('users', $add_field);

        //table app_version
        //table health facilities
        $this->dbforge->drop_table('app_version', TRUE);

        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => true
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'version' => array(
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
            'status' => array(
                'type' => 'ENUM("active", "inactive")',
                'default' => 'inactive',
            )
        );
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('app_version');

    }

    public function down()
    {

    }
}