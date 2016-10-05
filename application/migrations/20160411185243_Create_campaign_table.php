<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/29/2016
 * Time: 3:38 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Create_campaign_table extends CI_Migration
{

    public function up()
    {
        // Drop table 'campaign' if it exists
        $this->dbforge->drop_table('campaign', TRUE);
        // Table structure for table 'campaign'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
            'description' => array(
                'type' => 'TEXT'
            ),
            'icon' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'form_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'end_date' => array(
                'type' => "DATETIME",
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('campaign');


    }


    public function down()
    {
        $this->dbforge->drop_table('campaign', TRUE);
    }
}