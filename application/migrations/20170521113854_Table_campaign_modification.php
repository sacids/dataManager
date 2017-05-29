<?php
/**
 * Created by PhpStorm.
 * User: renfrid
 * Date: 5/5/17
 * Time: 3:41 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Table_campaign_modification extends CI_Migration
{
    public function up()
    {
        // Drop table 'project' if it exists
        $this->dbforge->drop_table('xforms_config', TRUE);

        // Table structure for table 'project'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'xform_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE
            ),
            'search_fields' => array(
                'type' => "TEXT"
            ),
            'user_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('xforms_config');


        //add owner
        $field = array(
            'owner' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
        );
        $this->dbforge->add_column('campaign', $field);

        //add user_id
        $field = array(
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
        );
        $this->dbforge->add_column('whatsapp', $field);
    }

    public function down()
    {

    }

}