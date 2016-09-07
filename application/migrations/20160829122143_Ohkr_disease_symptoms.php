<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 8/29/2016
 * Time: 12:11 PM
 */
class Migration_Ohkr_disease_symptoms extends CI_Migration
{
    public function up()
    {
        $this->dbforge->rename_table('ohkr_scd', 'ohkr_disease_symptoms');
    }

    public function down()
    {
        $this->dbforge->drop_column("ohkr_disease_symptoms","specie_id");
        $this->dbforge->drop_column("ohkr_disease_symptoms","date_created");
    }
}