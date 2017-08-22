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

		$this->db->query("CREATE TABLE `ad_build_AfyaData_Demo_1500530768`( `id` int(20) UNSIGNED NOT NULL, `meta_instanceID` varchar(300) DEFAULT NULL, `_xf_72485ff63b11061b01c236b9c62b58bd` varchar(300) DEFAULT NULL, `_xf_300dd0bbe98836946e681905250e2390` text, `_xf_742d9217ff0a76a9689033e1334f681a` enum('1','0') NOT NULL DEFAULT '0', `_xf_0be9ec0d9e25d39c69153d6885e33100` enum('1','0') NOT NULL DEFAULT '0', `_xf_2447a0936af14f6ca2034c51ffe43285` enum('1','0') NOT NULL DEFAULT '0', `_xf_cccd8fdfcdf5157f6ac8d243e4584e51` enum('1','0') NOT NULL DEFAULT '0', `_xf_83c8fd1cbc52bbe2d73240654838e957` varchar(300) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4` varchar(150) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_point` point DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_lat` decimal(38,10) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_lng` decimal(38,10) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_acc` decimal(38,10) DEFAULT NULL, `_xf_c6a6184e0be6372480cae841cc28dba4_alt` decimal(38,10) DEFAULT NULL, `meta_instanceName` varchar(300) DEFAULT NULL, `meta_start` datetime DEFAULT NULL, `meta_end` datetime DEFAULT NULL, `meta_username` varchar(300) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1; INSERT INTO `ad_build_AfyaData_Demo_1500530768` (`id`, `meta_instanceID`, `_xf_72485ff63b11061b01c236b9c62b58bd`, `_xf_300dd0bbe98836946e681905250e2390`, `_xf_742d9217ff0a76a9689033e1334f681a`, `_xf_0be9ec0d9e25d39c69153d6885e33100`, `_xf_2447a0936af14f6ca2034c51ffe43285`, `_xf_cccd8fdfcdf5157f6ac8d243e4584e51`, `_xf_83c8fd1cbc52bbe2d73240654838e957`, `_xf_c6a6184e0be6372480cae841cc28dba4`, `_xf_c6a6184e0be6372480cae841cc28dba4_point`, `_xf_c6a6184e0be6372480cae841cc28dba4_lat`, `_xf_c6a6184e0be6372480cae841cc28dba4_lng`, `_xf_c6a6184e0be6372480cae841cc28dba4_acc`, `_xf_c6a6184e0be6372480cae841cc28dba4_alt`, `meta_instanceName`, `meta_start`, `meta_end`, `meta_username`) VALUES (1, 'uuid:68a20b08-42e0-4d09-9eef-35133016f8b7', 'Death', 'Diarrhea fever vomiting coughing', '1', '1', '1', '1', '1503304208419.jpg', '-6.828741757303798 37.67192742669136 484.2932970720519 48.0', '\0\0\0\0\0\0\0+Ìá­¡P\eÀavÉ·ÖB@', '-6.8287417573', '37.6719274267', '48.0000000000', '484.2932970721', '# : Death', '2017-08-21 11:29:17', '2017-08-21 11:31:09', '255712404118'), (2, 'uuid:9cc49476-3a3d-4ed7-82ee-b770e34cd3cd', 'Illness', 'Diarrhea fever vomiting', '1', '1', '1', '0', NULL, '-6.8016854 37.6953087 0.0 20.0', '\0\0\0\0\0\0\0¹zí4\eÀèàÿØB@', '-6.8016854000', '37.6953087000', '20.0000000000', '0.0000000000', '# : Illness', '2017-08-21 11:31:45', '2017-08-21 11:32:03', '255712404118'), (3, 'uuid:ac045c46-71d2-4727-8fb9-101cb726e315', 'Sickness', 'Diarrhea vomiting', '1', '0', '1', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '# : Sickness', '2017-08-21 11:32:05', '2017-08-21 11:32:19', '255712404118'), (4, 'uuid:e078d983-49ea-4a15-8151-35575ad80c21', 'Ugonjwa ', 'Diarrhea fever vomiting', '1', '1', '1', '0', '1503304371928.jpg', '-6.8287045 37.6704106 0.0 2114.0', '\0\0\0\0\0\0\0/1–é—P\eÀ$ò¸ÐÕB@', '-6.8287045000', '37.6704106000', '2114.0000000000', '0.0000000000', '# : Ugonjwa ', '2017-08-21 11:32:22', '2017-08-21 11:33:02', '255712404118'), (5, 'uuid:c71a76a5-b924-48e7-ba91-d80ebc7d161c', 'Health Map Test', 'fever vomiting coughing', '0', '1', '1', '1', '1503304588977.jpg', '-6.82886577330771 37.67200341999138 488.3493673205362 4.0', '\0\0\0\0\0\0\0~…t0ÂP\eÀáÔC5ÖB@', '-6.8288657733', '37.6720034200', '4.0000000000', '488.3493673205', '# : Godluck Akyoo', '2017-08-21 11:33:24', '2017-08-21 11:37:27', '255712404118');");
	}

	public function down()
	{

	}

}