<?php
/**
 * AfyaData
 *  
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016. Southern African Center for Infectious disease Surveillance (SACIDS)
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
 * @package	    AfyaData
 * @author	    AfyaData Dev Team
 * @copyright	Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license	    http://opensource.org/licenses/MIT	MIT License
 * @link	    https://afyadata.sacids.org
 * @since	    Version 1.0.0
 */

class Tools extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// can only be called from the command line
		if (!$this->input->is_cli_request()) {
			exit ('Direct access is not allowed. This is a command line tool, use the terminal');
		}

		$this->load->dbforge();
	}

	public function message($to = 'World')
	{
		echo "Hello {$to}!" . PHP_EOL;
	}

	public function help()
	{
		$result = "The following are the available command line interface commands\n\n";
		$result .= "php index.php tools migration \"file_name\"         Create new migration file\n";
		$result .= "php index.php tools base_migrate \"table prefix\"         Create new migration file\n";
		$result .= "php index.php tools migrate [\"version_number\"]    Run all migrations. The version number is optional.\n";
		// $result .= "php index.php tools seeder \"file_name\" Creates a new seed file.\n";
		// $result .= "php index.php tools seed \"file_name\" Run the specified seed file.\n";

		echo $result . PHP_EOL;
	}

	public function base_migrate($prefix)
	{
		$this->make_migration_base($prefix);
	}

	public function migration($name)
	{
		$this->make_migration_file($name);
	}

	public function migrate($version = NULL)
	{
		$this->load->library('migration');

		if ($version != NULL) {
			if ($this->migration->version($version) === FALSE) {
				show_error($this->migration->error_string());
			} else {
				echo "Migrations run successfully" . PHP_EOL;
			}

			return;
		}

		if ($this->migration->latest() === FALSE) {
			show_error($this->migration->error_string());
		} else {
			echo "Migrations run successfully" . PHP_EOL;
		}
	}

	public function seeder($name)
	{
		$this->make_seed_file($name);
	}

	public function seed($name)
	{
		$seeder = new Seeder ();

		$seeder->call($name);
	}

	protected function make_migration_file($name)
	{
		$date = new DateTime ();
		$timestamp = $date->format('YmdHis');

		$table_name = strtolower($name);

		$path = APPPATH . "migrations/$timestamp" . "_" . "$name.php";

		$my_migration = fopen($path, "w") or die ("Unable to create migration file!");

		$migration_template = "<?php

		class Migration_$name extends CI_Migration {

		public function up() {
			\$this->dbforge->add_field(array(
			'id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'auto_increment' => TRUE
			)
			));
			\$this->dbforge->add_key('id', TRUE);
			\$this->dbforge->create_table('$table_name');
		}
	
		public function down() {
		\$this->dbforge->drop_table('$table_name');
		}

	}";

		fwrite($my_migration, $migration_template);

		fclose($my_migration);

		echo "$path migration has successfully been created." . PHP_EOL;
	}

	public function make_migration_base($prefix)
	{
		$date = new DateTime ();
		$timestamp = $date->format('YmdHis');
		$len = strlen($prefix);
		$path = APPPATH . "migrations/$timestamp" . "_base_" . "$prefix.php";
		$my_migration = fopen($path, "w") or die ("Unable to create migration file!");

		$tables = array();
		$tmp = $this->db->list_tables();

		foreach ($tmp as $table) {
			if (substr($table, 0, $len) == $prefix) {
				array_push($tables, $table);
			}
		}

		// print_r($tables); //."\n";
		// return;

		$up = '';
		$down = '';
		$insert = '';
		foreach ($tables as $table) {

			// check if table exists

			// get fields
			$q = $this->get_create_table_query($table);
			// No result means the table name was invalid
			if ($q === FALSE) {
				continue;
			}
			$up .= "\n\t\t" . '## Create Table ' . $table . "\n";
			$up .= "\t\t" . '$this->db->query(\'' . $q . '\');' . "\n";

			$down .= "\t\t" . '### Drop table ' . $table . ' ##' . "\n";
			$down .= "\t\t" . '$this->dbforge->drop_table("' . $table . '", TRUE);' . "\n";

			// inserting data
			$q = $this->db->query("SELECT * FROM `" . $table . "`");
			if ($q->num_rows() != 0) {

				$insert = "\t\t" . '### Insert data into table ' . $table . ' ##' . "\n";
				$insert .= "\t\t" . '$data	= array(' . "\n";

				foreach ($q->result_array() as $row) {
					$insert .= "\t\t\t" . 'array(' . "\n";
					foreach ($row as $k => $v) {
						$insert .= "\t\t\t\t'" . $k . "' => '" . $v . "',\n";
					}
					$insert .= "\t\t\t),\n";
				};
				$insert .= "\t\t);\n";
				$insert .= "\t\t" . '$this->db->insert_batch("' . $table . '",$data);' . "\n";
				$up .= $insert;
			}
		}

		$this->create_migration_file($my_migration, $prefix, $up, $down);
	}

	private function get_create_table_query($table)
	{
		$q = 'show create table ' . $table;
		$q = $this->db->query($q);
		if ($r = $q->result_array()) {
			$r = $r [0] ['Create Table'];
		} else {
			$r = FALSE;
		}
		return $r;
	}

	private function create_migration_file($file, $prefix, $up, $down)
	{

		$return = '<?php ';
		$return .= 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');' . "\n\n";
		$return .= 'class Migration_base_' . $prefix . ' extends CI_Migration {' . "\n";
		$return .= "\n\t" . 'public function up() {' . "\n";
		$return .= $up;
		$return .= "\n\t" . ' }' . "\n";
		$return .= "\n\t" . 'public function down()';
		$return .= "\t" . '{' . "\n";
		$return .= $down . "\n";
		$return .= "\t" . '}' . "\n" . '}';
		// # write the file, or simply return if write_file false

		fwrite($file, $return);
		fclose($file);
		echo "Create file migration with success!";
		return TRUE;
	}
}