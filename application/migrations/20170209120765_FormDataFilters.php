<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 09-Feb-17
 * Time: 12:07
 */
class Migration_FormDataFilters extends CI_Migration
{

    public function up()
    {
        $this->dbforge->drop_table('xform_filters', TRUE);
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'xform_id' => array(
                'type' => 'int',
                'constraint' => '11',
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'db_column_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE
            ),
            'human_readable_name' => array(
                'type' => "VARCHAR",
                'constraint' => 200,
                'null' => FALSE
            ),
            'date_created' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '11',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('xform_filters');
        $this->db->query('ALTER TABLE xform_filters ADD CONSTRAINT fk_xform_id FOREIGN KEY(xform_id) REFERENCES xforms(id) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function down()
    {
        $this->dbforge->drop_table('xform_filters', TRUE);
    }
}