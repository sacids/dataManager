<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 27/09/2017
 * Time: 17:10
 */

class Migration_IDSR_Reports extends CI_Migration
{
    public function up()
    {
        $this->dbforge->drop_table('idsr_reports', TRUE);

        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => true
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 45
            ),
            'chart_title' => array(
                'type' => 'VARCHAR',
                'constraint' => 45
            ),
            'sql_query' => array(
                'type' => 'TEXT',
                'constraint' => 255
            ),
            'chart_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 45,
                'default' => 'column'
            ),
            'where_condition' => array(
                'type' => "TEXT"
            ),
            'group_by_column' => array(
                'type' => "TEXT"
            ),
            'report_type' => array(
                'type' => "VARCHAR",
                'constraint' => 45,
                'default' => 'single_disease' //Specifies if is single disease or any other type that requires different data layout for high charts
            ),
        );
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('idsr_reports');
    }

    public function down()
    {
        $this->dbforge->drop_table('idsr_reports', TRUE);
    }
}