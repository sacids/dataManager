<?php




// table for users
$config['users']['table']			= 'users';
$config['users']['pri_key']			= 'id';
$config['users']['display']			= 'username';


// table for groups
$config['group']['table']			= 'groups';
$config['group']['pri_key']			= 'id';
$config['group']['display']			= 'name';

// table for user_groups
$config['user_group']['table']		= 'users_groups';
$config['user_group']['user_id']	= 'user_id';
$config['user_group']['group_id']	= 'group_id';


// tables
$config['section_table']			= 'perm_sections';
$config['tree_table']				= 'perm_tree';
