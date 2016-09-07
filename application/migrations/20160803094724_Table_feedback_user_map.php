<?php
/**
 * Created by PhpStorm.
 * User: Renfrid Ngolongolo
 * Date: 8/3/2016
 * Time: 9:47 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Table_feedback_user_map extends CI_Migration
{

    public function up()
    {
        // Drop table 'feedback_user_map' if it exists
        $this->dbforge->drop_table('feedback_user_map', TRUE);
        // Table structure for table 'diseases'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE
            ),
            'users' => array(
                'type' => "TEXT",
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('feedback_user_map');
    }


    public function down()
    {
        $this->dbforge->drop_table('feedback_user_map', TRUE);
    }
}