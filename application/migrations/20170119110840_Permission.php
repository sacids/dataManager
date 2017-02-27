<?php
/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 1/19/2017
 * Time: 11:08 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Permission extends CI_Migration
{

    function up()
    {
        // Drop table 'perms_module' if it exists
        $this->dbforge->drop_table('perms_module', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => FALSE
            ),
            'controller' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('perms_module');

        // Dumping data for table 'perms_module'
        $data = array(
            array(
                'id' => '1',
                'name' => 'Form Management',
                'controller' => 'Xform',
            ),
            array(
                'id' => '2',
                'name' => 'OHKR',
                'controller' => 'Ohkr',
            ),
            array(
                'id' => '3',
                'name' => 'Campaign Management',
                'controller' => 'Campaign',
            ),
            array(
                'id' => '4',
                'name' => 'Feedback',
                'controller' => 'Feedback',
            ),
            array(
                'id' => '5',
                'name' => 'Whatsapp db',
                'controller' => 'Whatsapp',
            ),
            array(
                'id' => '6',
                'name' => 'Manage Users',
                'controller' => 'Auth',
            )
        );
        $this->db->insert_batch('perms_module', $data);

        // Drop table 'perms' if it exists
        $this->dbforge->drop_table('perms', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => FALSE
            ),
            'perm_slug' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            ),
            'module_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('perms');

        // Dumping data for table 'perms'
        $data = array(
            array(
                'name' => 'List forms',
                'perm_slug' => 'forms',
                'module_id' => '1'
            ),
            array(
                'name' => 'Add form',
                'perm_slug' => 'add_new',
                'module_id' => '1'
            ),
            array(
                'name' => 'Edit form',
                'perm_slug' => 'edit_form',
                'module_id' => '1'
            ),
            array(
                'name' => 'Archive form',
                'perm_slug' => 'archive_form',
                'module_id' => '1'
            ),
            array(
                'name' => 'Restore form',
                'perm_slug' => 'restore_from_archive',
                'module_id' => '1'
            ),
            array(
                'name' => 'Form data',
                'perm_slug' => 'form_data',
                'module_id' => '1'
            ),
            array(
                'name' => 'Export excel data',
                'perm_slug' => 'excel_export_form_data',
                'module_id' => '1'
            ),
            array(
                'name' => 'Export csv data',
                'perm_slug' => 'csv_export_form_data',
                'module_id' => '1'
            ),
            array(
                'name' => 'Export XML data',
                'perm_slug' => 'xml_export_form_data',
                'module_id' => '1'
            ),
            array(
                'name' => 'Map fields',
                'perm_slug' => 'map_fields',
                'module_id' => '1'
            ),
            array(
                'name' => 'Delete entry',
                'perm_slug' => 'delete_entry',
                'module_id' => '1'
            ),
            array(
                'name' => 'Disease list',
                'perm_slug' => 'disease_list',
                'module_id' => '2'
            ),
            array(
                'name' => 'Add disease',
                'perm_slug' => 'add_new_disease',
                'module_id' => '2'
            ),
            array(
                'name' => 'Edit disease',
                'perm_slug' => 'edit_disease',
                'module_id' => '2'
            ),
            array(
                'name' => 'Delete disease',
                'perm_slug' => 'delete_disease',
                'module_id' => '2'
            ),
            array(
                'name' => 'Species list',
                'perm_slug' => 'species_list',
                'module_id' => '2'
            ),
            array(
                'name' => 'Add new specie',
                'perm_slug' => 'add_new_specie',
                'module_id' => '2'
            ),
            array(
                'name' => 'Edit specie',
                'perm_slug' => 'edit_specie',
                'module_id' => '2'
            ),
            array(
                'name' => 'Delete specie',
                'perm_slug' => 'delete_specie',
                'module_id' => '2'
            ),
            array(
                'name' => 'Symptom list',
                'perm_slug' => 'symptoms_list',
                'module_id' => '2'
            ),
            array(
                'name' => 'Add new symptom',
                'perm_slug' => 'add_new_symptom',
                'module_id' => '2'
            ),
            array(
                'name' => 'Edit symptom',
                'perm_slug' => 'edit_sysmptom',
                'module_id' => '2'
            ),
            array(
                'name' => 'Delete symptom',
                'perm_slug' => 'delete_symptom',
                'module_id' => '2'
            ),
            array(
                'name' => 'Disease symptoms list',
                'perm_slug' => 'disease_symptoms_list',
                'module_id' => '2'
            ),
            array(
                'name' => 'Add disease symptom',
                'perm_slug' => 'add_disease_symptom',
                'module_id' => '2'
            ),
            array(
                'name' => 'Edit disease symptom',
                'perm_slug' => 'edit_disease_symptom',
                'module_id' => '2'
            ),
            array(
                'name' => 'Delete disease symptom',
                'perm_slug' => 'delete_disease_symptom',
                'module_id' => '2'
            ),
            array(
                'name' => 'Campaign list',
                'perm_slug' => 'lists',
                'module_id' => '3'
            ),
            array(
                'name' => 'Add campaign',
                'perm_slug' => 'add_new',
                'module_id' => '3'
            ),
            array(
                'name' => 'Edit campaign',
                'perm_slug' => 'edit',
                'module_id' => '3'
            ),
            array(
                'name' => 'Change campaign image',
                'perm_slug' => 'change_icon',
                'module_id' => '3'
            ),
            array(
                'name' => 'Feedback list',
                'perm_slug' => 'lists',
                'module_id' => '4'
            ),
            array(
                'name' => 'User feedback list',
                'perm_slug' => 'user_feedback',
                'module_id' => '4'
            ),
            array(
                'name' => 'Message list',
                'perm_slug' => 'message_list',
                'module_id' => '5'
            ),
            array(
                'name' => 'Export CSV data',
                'perm_slug' => 'csv_export_data',
                'module_id' => '5'
            ),
            array(
                'name' => 'Users list',
                'perm_slug' => 'users_list',
                'module_id' => '6'
            ),
            array(
                'name' => 'Create new user',
                'perm_slug' => 'create_user',
                'module_id' => '6'
            ),
            array(
                'name' => 'Edit user',
                'perm_slug' => 'edit_user',
                'module_id' => '6'
            ),
            array(
                'name' => 'Activate user',
                'perm_slug' => 'activate',
                'module_id' => '6'
            ),
            array(
                'name' => 'Deactivate user',
                'perm_slug' => 'deactivate',
                'module_id' => '6'
            ),
            array(
                'name' => 'Group list',
                'perm_slug' => 'group_list',
                'module_id' => '6'
            ),
            array(
                'name' => 'Create group',
                'perm_slug' => 'create_group',
                'module_id' => '6'
            ),
            array(
                'name' => 'Edit group',
                'perm_slug' => 'edit_group',
                'module_id' => '6'
            ),
            array(
                'name' => 'Group permission',
                'perm_slug' => 'perms_group',
                'module_id' => '6'
            ),
        );
        $this->db->insert_batch('perms', $data);


        // Drop table 'perms_group' if it exists
        $this->dbforge->drop_table('perms_group', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'group_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            'module_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            'perm_slug' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            ),
            'allow' => array(
                'type' => "INT",
                'constraint' => '11',
                'unsigned' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('perms_group');

        // Drop table 'district' if it exists
        $this->dbforge->drop_table('district', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            ),
            'code' => array(
                'type' => "VARCHAR",
                'constraint' => '50',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('district');

        // Dumping data for table 'district'
        $data = array(
            array(
                'id' => '1',
                'name' => 'Ngorongoro',
                'code' => 'Ngorongoro',
            ),
            array(
                'id' => '2',
                'name' => 'Morogoro mjini',
                'name' => 'Morogoro_mjini',
            )
        );
        $this->db->insert_batch('district', $data);

        //drop table if exist 'xforms_config'
        $this->dbforge->drop_table('xforms_config', TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'xform_id' => array(
                'type' => "INT",
                'constraint' => '11',
                'null' => FALSE
            ),
            'search_fields' => array(
                'type' => "TEXT",
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('xforms_config');

    }

    public function down()
    {
        $this->dbforge->drop_table('perms_module', TRUE);
        $this->dbforge->drop_table('perms', TRUE);
        $this->dbforge->drop_table('perms_group', TRUE);
        $this->dbforge->drop_table('district', TRUE);
        $this->dbforge->drop_table('xforms_config', TRUE);
    }

}