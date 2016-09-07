<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 5/27/2016
 * Time: 3:32 PM
 */
class Migration_Campaign_modification extends CI_Migration
{

    public function up()
    {
        //add column type field
        $add_field['featured'] = array(
            'type' => 'ENUM("no","yes")',
            'default' => 'no',
            'null' => FALSE,
        );

        $this->dbforge->add_column('campaign', $add_field);



    }

    public function down()
    {
        $this->dbforge->drop_table('campaign', TRUE);
        
    }

}