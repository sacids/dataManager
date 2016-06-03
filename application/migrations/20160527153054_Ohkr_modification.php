<?php

/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 5/27/2016
 * Time: 3:32 PM
 */
class Migration_Ohkr_modification extends CI_Migration
{

    public function up()
    {
        //rename table to start with ohkr
        $this->dbforge->rename_table('species', 'ohkr_species');
        $this->dbforge->rename_table('diseases', 'ohkr_diseases');
        $this->dbforge->rename_table('symptoms', 'ohkr_symptoms');
        $this->dbforge->rename_table('diseases_symptoms', 'ohkr_scd');

        //modify columns in species
        $specie_field = array(
            'name' => array(
                'name' => 'title',
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
        );
        $this->dbforge->modify_column('ohkr_species', $specie_field);


        //add and modify column in disease
        $disease_add_field = array(
            'specie_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'scd' => array(
                'type' => 'TEXT'
            )
        );
        $this->dbforge->add_column('ohkr_diseases', $disease_add_field);

        $disease_modify_field = array(
            'name' => array(
                'name' => 'title',
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
        );
        $this->dbforge->modify_column('ohkr_diseases', $disease_modify_field);


        //add and modify symptoms
        $symptom_add_field = array(
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
            ),
        );
        $this->dbforge->add_column('ohkr_symptoms', $symptom_add_field);

        $symptom_modify_field = array(
            'name' => array(
                'name' => 'title',
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
        );
        $this->dbforge->modify_column('ohkr_symptoms', $symptom_modify_field);


        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'disease_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE
            ),
            'question' => array(
                'type' => 'TEXT'
            ),
            'answer' => array(
                'type' => 'TEXT'
            )

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ohkr_faq');
    }

    public function down()
    {
        //drop columns
        $this->dbforge->drop_column("ohkr_species","date_created");
        $this->dbforge->drop_column("ohkr_diseases","date_created");
        $this->dbforge->drop_column("ohkr_symptoms","date_created");
        $this->dbforge->drop_column("ohkr_scd","specie_id");
        $this->dbforge->drop_column("ohkr_scd","date_created");

        //drop created table
        $this->dbforge->drop_table('ohkr_faq', TRUE);
    }

}