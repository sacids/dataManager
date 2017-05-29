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
        //add owner
        $field = array(
            'owner' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
        );
        $this->dbforge->add_column('campaign', $field);

        //add owner
        $field = array(
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
        );
        $this->dbforge->add_column('whatsapp', $field);

        //add owner
        $field = array(
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
        );
        $this->dbforge->add_column('xforms_config', $field);
    }

    public function down()
    {

    }

}