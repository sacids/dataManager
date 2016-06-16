<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 5/27/2016
 * Time: 3:32 PM
 */
class Migration_Ohkr_table_modification extends CI_Migration
{

    public function up()
    {
        //renaming table
        $this->dbforge->rename_table('ohkr_scd', 'ohkr_disease_symptoms');

    }

    public function down()
    {

    }

}