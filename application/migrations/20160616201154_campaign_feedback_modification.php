<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 5/27/2016
 * Time: 3:32 PM
 */
class Migration_Campaign_feedback_modification extends CI_Migration
{

    public function up()
    {
        //modify column end_date in campaign
        $field_modify = array(
            'end_date' => array(
                'name' => 'date_created',
                'type' => 'DATETIME',
                'null' => FALSE
            ),
        );
        $this->dbforge->modify_column('campaign', $field_modify);

        //add column type field
        $add_field['type'] = array(
            'type' => 'ENUM("general","form")',
            'default' => 'general',
            'null' => FALSE,
        );

        $this->dbforge->add_column('campaign', $add_field);

        // Add status column
        $feedback_new_column = array(
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'default' => 'pending'
            )
        );

        $this->dbforge->add_column("feedback", $feedback_new_column);

    }

    public function down()
    {
        //drop created table
        $this->dbforge->drop_table('feedback', TRUE);
        $this->dbforge->drop_table('campaign', TRUE);
    }

}