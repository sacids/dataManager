<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 31/10/2017
 * Time: 09:33
 */

class Migration_AclModule extends CI_Migration
{

    public function up()
    {
        $this->dbforge->drop_table('acl_permissions', TRUE);

        $fields = array(
            'id'           => array(
                'type'     => 'INT',
            ),
            'title'        => array(
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ),
            'description'  => array(
                'type' => 'TEXT',
            ),
            'date_created' => array(
                'type' => 'DATETIME'
            ),
        );
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('acl_permissions');


        $this->dbforge->drop_table('acl_filters', TRUE);

        $fields = array(
            'id'                 => array(
                'type' => 'INT',
            ),
            'permission_id'      => array(
                'type' => 'INT',
            ),
            'name'               => array(
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ), 'table_name'      => array(
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ),
            'description'        => array(
                'type' => 'TEXT',
            ), 'where_condition' => array(
                'type' => 'TEXT',
            ),
            'date_added'         => array(
                'type' => 'DATETIME'
            ),
        );
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('acl_filters');
        $this->db->query('ALTER TABLE acl_filters ADD CONSTRAINT fk_acl_permission_id FOREIGN KEY(permission_id) REFERENCES acl_permissions(id) ON DELETE CASCADE ON UPDATE CASCADE;');


        //acl_users_permissions

        $this->dbforge->drop_table('acl_users_permissions', TRUE);

        $fields = array(
            'id'            => array(
                'type' => 'INT',
            ),
            'user_id'       => array(
                'type'     => 'INT',
                'unsigned' => true
            ),
            'permission_id' => array(
                'type' => 'INT',
            ),
            'date_added'    => array(
                'type' => 'DATETIME'
            ),
        );
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('acl_users_permissions');

        /*$this->db->query('ALTER TABLE acl_users_permissions ADD CONSTRAINT fk_acl_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;');*/

        $this->db->query('ALTER TABLE acl_users_permissions ADD CONSTRAINT fk_acl_perm_id FOREIGN KEY(permission_id) REFERENCES acl_permissions(id) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function down(){

    }
}