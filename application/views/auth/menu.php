<div id="content-middle-home">
    <div class="container_12" id="content-middle" style="border: 1px solid #fff;">
        <div id="header-title" style="border-top:  1px solid #fff;border-left:  1px solid #fff;">
            <div style="width: auto; float: left; display: inline-block;">
                <img src="<?php echo base_url(); ?>media/images/users.png"/>
                <h1>Manage Users</h1>
                <h3><?php echo $title; ?></h3>
            </div>
            <div style="clear: both;"></div>
        </div>

        <div>
            <div class="grid_2" id="leftmenu" style=" padding-top: 10px; width: 200px;margin-left: -0.5px;">
                <ul id="nav">
                    <li><a href="#">Manage Users</a>
                        <ul>
                            <li><a href="<?php echo site_url('auth/create_user'); ?>">Create User</a></li>
                            <li><a href="<?php echo site_url('auth/users_list'); ?>">User List</a></li>
                        </ul>
                    </li>

                    <li><a href="#">Manage Groups</a>
                        <ul>
                            <li><a href="<?php echo site_url('auth/create_group'); ?>">Create Group</a></li>
                            <li><a href="<?php echo site_url('auth/group_list'); ?>">Group List</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
