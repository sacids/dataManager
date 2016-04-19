<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_base_perm extends CI_Migration {

	public function up() {

		## Create Table perm_config
		$this->db->query('CREATE TABLE `perm_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perm_tree_id` int(11) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `filters` text NOT NULL,
  `perms` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1');

		## Create Table perm_filter
		$this->db->query('CREATE TABLE `perm_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `table_name` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1');

		## Create Table perm_filter_config
		$this->db->query('CREATE TABLE `perm_filter_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perm_filter_id` int(11) NOT NULL,
  `field_name` varchar(150) NOT NULL,
  `oper` varchar(50) NOT NULL,
  `field_value` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `perm_tree_id` (`perm_filter_id`),
  CONSTRAINT `futaYatima_filter` FOREIGN KEY (`perm_filter_id`) REFERENCES `perm_filter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1');

		## Create Table perm_module
		$this->db->query('CREATE TABLE `perm_module` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `tables` text NOT NULL,
  `perms` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1');
		### Insert data into table perm_module ##
		$data	= array(
			array(
				'id' => '1',
				'title' => 'Administration',
				'tables' => 'perm_module, perm_tree, groups, users, users_groups, perm_tables, perm_tables_con',
				'perms' => 'P1P',
			),
		);
		$this->db->insert_batch("perm_module",$data);

		## Create Table perm_tables
		$this->db->query('CREATE TABLE `perm_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1');
		### Insert data into table perm_tables ##
		$data	= array(
			array(
				'id' => '1',
				'module_id' => '1',
				'label' => 'Manage Permissions',
				'table_name' => 'perm_tree',
				'description' => 'Perm tree',
			),
			array(
				'id' => '2',
				'module_id' => '1',
				'label' => 'Edit Opt Permission',
				'table_name' => 'perm_tree',
				'description' => 'Editing opt permission for manage permissions',
			),
			array(
				'id' => '3',
				'module_id' => '1',
				'label' => 'manage tables',
				'table_name' => 'perm_tables',
				'description' => 'manage tables',
			),
			array(
				'id' => '4',
				'module_id' => '1',
				'label' => 'module',
				'table_name' => 'perm_module',
				'description' => '',
			),
			array(
				'id' => '5',
				'module_id' => '1',
				'label' => 'Users',
				'table_name' => 'users',
				'description' => '',
			),
			array(
				'id' => '6',
				'module_id' => '1',
				'label' => 'Groups',
				'table_name' => 'groups',
				'description' => '',
			),
			array(
				'id' => '7',
				'module_id' => '1',
				'label' => 'New Filter',
				'table_name' => 'perm_filter',
				'description' => 'Adding new filter',
			),
			array(
				'id' => '8',
				'module_id' => '1',
				'label' => 'Perm filter config',
				'table_name' => 'perm_filter_config',
				'description' => '',
			),
			array(
				'id' => '9',
				'module_id' => '1',
				'label' => 'Users in group',
				'table_name' => 'users_groups',
				'description' => 'list users in group',
			),
			array(
				'id' => '10',
				'module_id' => '1',
				'label' => 'Groups users',
				'table_name' => 'users_groups',
				'description' => 'list groups user is belonged to',
			),
		);
		$this->db->insert_batch("perm_tables",$data);

		## Create Table perm_tables_conf
		$this->db->query('CREATE TABLE `perm_tables_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL,
  `field_name` varchar(150) NOT NULL,
  `field_property` varchar(150) NOT NULL,
  `field_value` varchar(150) NOT NULL,
  `display_marks` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `table_id` (`table_id`),
  CONSTRAINT `futaYatima` FOREIGN KEY (`table_id`) REFERENCES `perm_tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1');
		### Insert data into table perm_tables_conf ##
		$data	= array(
			array(
				'id' => '20',
				'table_id' => '2',
				'field_name' => 'perm_type',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '21',
				'table_id' => '2',
				'field_name' => 'perm_data',
				'field_property' => 'hidden',
				'field_value' => 'gghh',
				'display_marks' => '',
			),
			array(
				'id' => '22',
				'table_id' => '5',
				'field_name' => 'ip_address',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '24',
				'table_id' => '1',
				'field_name' => 'perm_target',
				'field_property' => 'dropdown',
				'field_value' => 'detail_wrp,list_wrp',
				'display_marks' => '',
			),
			array(
				'id' => '25',
				'table_id' => '1',
				'field_name' => 'parent_id',
				'field_property' => 'hidden',
				'field_value' => '0',
				'display_marks' => '',
			),
			array(
				'id' => '26',
				'table_id' => '1',
				'field_name' => 'module_id',
				'field_property' => 'hidden',
				'field_value' => '3',
				'display_marks' => '',
			),
			array(
				'id' => '28',
				'table_id' => '1',
				'field_name' => 'perm_type',
				'field_property' => 'dropdown',
				'field_value' => 'table,controller',
				'display_marks' => '',
			),
			array(
				'id' => '29',
				'table_id' => '1',
				'field_name' => 'perms',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '30',
				'table_id' => '1',
				'field_name' => 'perm_data',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '31',
				'table_id' => '1',
				'field_name' => 'module_id',
				'field_property' => 'db_dropdown',
				'field_value' => 'perm_module:id:title',
				'display_marks' => '',
			),
			array(
				'id' => '32',
				'table_id' => '1',
				'field_name' => 'table_name',
				'field_property' => 'CI db_func',
				'field_value' => 'name=select_tables',
				'display_marks' => '',
			),
			array(
				'id' => '33',
				'table_id' => '7',
				'field_name' => 'table_name',
				'field_property' => 'CI db_func',
				'field_value' => 'name=select_tables',
				'display_marks' => '',
			),
			array(
				'id' => '34',
				'table_id' => '7',
				'field_name' => 'description',
				'field_property' => 'textarea',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '35',
				'table_id' => '8',
				'field_name' => 'oper',
				'field_property' => 'dropdown',
				'field_value' => '>,=,<',
				'display_marks' => '',
			),
			array(
				'id' => '36',
				'table_id' => '2',
				'field_name' => 'parent_id',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '37',
				'table_id' => '2',
				'field_name' => 'module_id',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '38',
				'table_id' => '2',
				'field_name' => 'title',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '39',
				'table_id' => '2',
				'field_name' => 'icon_font',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '41',
				'table_id' => '2',
				'field_name' => 'perm_target',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '44',
				'table_id' => '5',
				'field_name' => 'ip_address',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '45',
				'table_id' => '5',
				'field_name' => 'digest_password',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '46',
				'table_id' => '5',
				'field_name' => 'salt',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '47',
				'table_id' => '5',
				'field_name' => 'activation_code',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '48',
				'table_id' => '5',
				'field_name' => 'forgotten_password_code',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '53',
				'table_id' => '5',
				'field_name' => 'password',
				'field_property' => 'password',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '62',
				'table_id' => '3',
				'field_name' => 'module_id',
				'field_property' => 'db_dropdown',
				'field_value' => 'perm_module:id:title',
				'display_marks' => '',
			),
			array(
				'id' => '63',
				'table_id' => '3',
				'field_name' => 'table_name',
				'field_property' => 'CI db_func',
				'field_value' => 'name=select_tables',
				'display_marks' => '',
			),
			array(
				'id' => '64',
				'table_id' => '4',
				'field_name' => 'tables',
				'field_property' => 'CI db_func',
				'field_value' => 'name=list_tables',
				'display_marks' => '',
			),
			array(
				'id' => '65',
				'table_id' => '9',
				'field_name' => 'group_id',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '66',
				'table_id' => '9',
				'field_name' => 'user_id',
				'field_property' => 'db_dropdown',
				'field_value' => 'users:id:username',
				'display_marks' => '',
			),
			array(
				'id' => '67',
				'table_id' => '10',
				'field_name' => 'user_id',
				'field_property' => 'hidden',
				'field_value' => '',
				'display_marks' => '',
			),
			array(
				'id' => '68',
				'table_id' => '10',
				'field_name' => 'group_id',
				'field_property' => 'db_dropdown',
				'field_value' => 'groups:id:name',
				'display_marks' => '',
			),
		);
		$this->db->insert_batch("perm_tables_conf",$data);

		## Create Table perm_tabs
		$this->db->query('CREATE TABLE `perm_tabs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `table_action_id` int(11) NOT NULL,
  `args` text NOT NULL,
  `perms` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `table_action_id` (`table_action_id`),
  KEY `table_id` (`table_id`),
  CONSTRAINT `table_id_cascades` FOREIGN KEY (`table_id`) REFERENCES `perm_tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1');
		### Insert data into table perm_tabs ##
		$data	= array(
			array(
				'id' => '9',
				'table_id' => '1',
				'title' => 'edit',
				'icon' => 'edit',
				'table_action_id' => '1',
				'args' => '{"match":"id","oper":"=","to":"id","rend":"edit"}',
				'perms' => '',
			),
			array(
				'id' => '10',
				'table_id' => '3',
				'title' => 'edit',
				'icon' => 'edit',
				'table_action_id' => '3',
				'args' => '{"match":"id","oper":"like","to":"id","rend":"edit"}',
				'perms' => '',
			),
			array(
				'id' => '11',
				'table_id' => '3',
				'title' => 'setup',
				'icon' => 'settings',
				'table_action_id' => '0',
				'args' => 'perm/setup_table',
				'perms' => 'perm/setup_table',
			),
			array(
				'id' => '12',
				'table_id' => '3',
				'title' => 'tabs',
				'icon' => 'tab',
				'table_action_id' => '0',
				'args' => 'perm/set_table_actions',
				'perms' => '',
			),
			array(
				'id' => '13',
				'table_id' => '1',
				'title' => 'setup',
				'icon' => 'settings',
				'table_action_id' => '0',
				'args' => 'perm/setup_perms',
				'perms' => '',
			),
			array(
				'id' => '17',
				'table_id' => '7',
				'title' => 'Filter',
				'icon' => 'filter_list',
				'table_action_id' => '0',
				'args' => 'perm/filter_config',
				'perms' => '',
			),
			array(
				'id' => '19',
				'table_id' => '1',
				'title' => 'List Perms',
				'icon' => 'list',
				'table_action_id' => '0',
				'args' => 'perm/set_list_perms',
				'perms' => '',
			),
			array(
				'id' => '20',
				'table_id' => '1',
				'title' => 'Tab Perms',
				'icon' => 'view_quilt',
				'table_action_id' => '0',
				'args' => 'perm/set_tab_perms',
				'perms' => '',
			),
			array(
				'id' => '21',
				'table_id' => '1',
				'title' => 'Option Perms',
				'icon' => 'perm_identity',
				'table_action_id' => '0',
				'args' => 'perm/set_option_perms',
				'perms' => '',
			),
			array(
				'id' => '24',
				'table_id' => '1',
				'title' => 'Add Perms ',
				'icon' => 'control_point',
				'table_action_id' => '0',
				'args' => 'perm/set_add_perms',
				'perms' => '',
			),
			array(
				'id' => '25',
				'table_id' => '1',
				'title' => 'Del Perms',
				'icon' => 'delete',
				'table_action_id' => '0',
				'args' => 'perm/set_del_perms',
				'perms' => '',
			),
			array(
				'id' => '30',
				'table_id' => '5',
				'title' => 'Groups',
				'icon' => 'group',
				'table_action_id' => '10',
				'args' => '{"match":"id","oper":"=","to":"user_id","rend":"list"}',
				'perms' => '',
			),
			array(
				'id' => '32',
				'table_id' => '6',
				'title' => 'users',
				'icon' => 'account_circle',
				'table_action_id' => '9',
				'args' => '{"match":"id","oper":"=","to":"group_id","rend":"list"}',
				'perms' => '',
			),
		);
		$this->db->insert_batch("perm_tabs",$data);

		## Create Table perm_tree
		$this->db->query('CREATE TABLE `perm_tree` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(5) unsigned NOT NULL,
  `module_id` int(5) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `icon_font` varchar(50) NOT NULL,
  `perm_type` varchar(50) NOT NULL,
  `perm_target` varchar(50) NOT NULL,
  `perm_data` text,
  `perms` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');

	 }

	public function down()	{
		### Drop table perm_config ##
		$this->dbforge->drop_table("perm_config", TRUE);
		### Drop table perm_filter ##
		$this->dbforge->drop_table("perm_filter", TRUE);
		### Drop table perm_filter_config ##
		$this->dbforge->drop_table("perm_filter_config", TRUE);
		### Drop table perm_module ##
		$this->dbforge->drop_table("perm_module", TRUE);
		### Drop table perm_tables ##
		$this->dbforge->drop_table("perm_tables", TRUE);
		### Drop table perm_tables_conf ##
		$this->dbforge->drop_table("perm_tables_conf", TRUE);
		### Drop table perm_tabs ##
		$this->dbforge->drop_table("perm_tabs", TRUE);
		### Drop table perm_tree ##
		$this->dbforge->drop_table("perm_tree", TRUE);

	}
}