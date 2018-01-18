<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 15/01/2018
 * Time: 11:59
 */

class Migration_Dhis2_Support extends CI_Migration
{
    public function up()
    {
        $add_field_to_xforms = [
            'allow_dhis'    => array(
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0
            ),
            'dhis_data_set' => array(
                'type'       => 'VARCHAR',
                'constraint' => 150
            ),
            'org_unit_id'   => array(
                'type'       => 'VARCHAR',
                'constraint' => 150
            ),
            'period_type'   => array(
                'type'       => 'VARCHAR',
                'constraint' => 20
            ),
        ];

        $this->dbforge->add_column('xforms', $add_field_to_xforms);

        $add_field_to_xform_filename_map['dhis_data_element'] = array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
        );

        $this->dbforge->add_column('xform_fieldname_map', $add_field_to_xform_filename_map);
    }

    public function down()
    {
        $this->dbforge->drop_column('xforms', 'allow_dhis');
        $this->dbforge->drop_column('xforms', 'dhis_data_set');
        $this->dbforge->drop_column('xforms', 'org_unit_id');
        $this->dbforge->drop_column('xforms', 'period_type');
        $this->dbforge->drop_column('xform_fieldname_map', 'dhis_data_element');
    }
}