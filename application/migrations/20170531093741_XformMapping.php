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
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 31-May-17
 * Time: 09:37
 */
class Migration_XformMapping extends CI_Migration
{
	public function up()
	{
		$field = array(
			'hide' => array(
				'type'       => 'TINYINT',
				'constraint' => 1,
				'default'    => 0
			),
		);
		$this->dbforge->add_column('xform_fieldname_map', $field);

		$this->db->query("CREATE TABLE `ad_build_AfyaData_Demo_1500530768`( `id` int(20) UNSIGNED NOT NULL, `meta_instanceID` varchar(300) DEFAULT NULL, `_xf_72485ff63b11061b01c236b9c62b58bd` varchar(300) DEFAULT NULL, `_xf_300dd0bbe98836946e681905250e2390` text, `_xf_742d9217ff0a76a9689033e1334f681a` enum('1','0') NOT NULL DEFAULT '0', `_xf_0be9ec0d9e25d39c69153d6885e33100` enum('1','0') NOT NULL DEFAULT '0', `_xf_2447a0936af14f6ca2034c51ffe43285` enum('1','0') NOT NULL DEFAULT '0', `_xf_cccd8fdfcdf5157f6ac8d243e4584e51` enum('1','0') NOT NULL DEFAULT '0', `_xf_83c8fd1cbc52bbe2d73240654838e957` varchar(300) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4` varchar(150) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_point` point DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_lat` decimal(38,10) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_lng` decimal(38,10) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_acc` decimal(38,10) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_alt` decimal(38,10) DEFAULT NULL, `meta_instanceName` varchar(300) DEFAULT NULL, `meta_start` datetime DEFAULT NULL, `meta_end` datetime DEFAULT NULL, `meta_username` varchar(300) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	public function down()
	{

	}

}