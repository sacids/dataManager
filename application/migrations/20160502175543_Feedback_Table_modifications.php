<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 5/2/2016
 * Time: 5:47 PM
 */
class Feedback_Table_modifications extends CI_Migration
{

    public function up()
    {

        $fields = array(
            'user_id' => array(
                'name' => 'user_from',
                'type' => 'INT',
                'constraint' => 11
            ),
        );
        $this->dbforge->modify_column('feedback', $fields);

        $field = array(
            'user_to' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
        );
        $this->dbforge->add_column('feedback', $field);
    }

    public function down()
    {
        $fields = array(
            'user_from' => array(
                'name' => 'user_id',
                'type' => 'INT',
                'constraint' => 11
            ),
        );

        $this->dbforge->modify_column('feedback', $fields);
    }
}