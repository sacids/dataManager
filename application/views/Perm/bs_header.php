<nav class="navbar navbar-inverse  navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#afyadata_Navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="http://afyadata.sacids.org/demo/dashboard" class="navbar-brand"><img src="http://afyadata.sacids.org/demo/assets/public/images/logo.png" alt="AfyaData" height="26"/></a>
        </div>
        <div class="collapse navbar-collapse" id="afyadata_Navbar">
            <ul class="nav navbar-nav ad_nav">
                <?php
                    // check if administrator
                    if ($this->session->userdata ( "user_id" ) == 1) {
                        display_administrator_menu();
                    }

                    // display other menu's
                    display_menu($this);
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right ad_nav">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>
    </div>
</nav>



<?php

    function display_administrator_menu(){
        ?>
        <li class="">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">Administration<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li>
                    <a class="link"
                       target="list_wrp"
                       label="Manage Permission"
                       args="table_id=1&perm_id=1"
                       action="<?php echo site_url("perm/manage_table") ?>">
                        <i class="material-icons md-dark">domain</i> Manage Permissions
                    </a>
                </li>
                <li>
                    <a class="link"
                       target="list_wrp"
                       label="Manage Filters"
                       args="table_id=7&perm_id=1"
                       action="<?php echo site_url("perm/manage_table") ?>">
                        <i class="material-icons md-dark">filter_list</i> Manage Filters
                    </a>
                <li>
                    <a class="link"
                       target="list_wrp"
                       label="Manage Tables"
                       args="table_id=3&perm_id=1"
                       action="<?php echo site_url("perm/manage_table") ?>">
                        <i class="material-icons md-light"> view_list</i>Manage Tables
                    </a>
                </li>

                <li>
                    <a class="link"
                       target="list_wrp"
                       label="Manage Users"
                       args="table_id=5&perm_id=1"
                       action="<?php echo site_url("perm/manage_table") ?>">
                        <i class="material-icons md-light" > account_circle</i> Manage Users
                    </a>
                </li>
                <li>
                    <a class="link"
                       target="list_wrp"
                       label="Manage Groups"
                       args="table_id=6&perm_id=1"
                       action="<?php echo site_url("perm/manage_table") ?>">
                        <i class="material-icons md-light " >group</i> Manage Groups
                    </a>
                </li>
                <li>
                    <a class="link"
                       target="list_wrp"
                       label="Manage Modules"
                       args="table_id=4&perm_id=1"
                       action="<?php echo site_url("perm/manage_table") ?>">
                        <i class="material-icons md-light">dashboard</i>  Manage Modules
                    </a>
                </li>
            </ul>
        </li>
        <?php
    }

    function display_menu($obj){

        foreach($obj->data['modules'] as $val){

            $module_id		= $val['id'];
            if($module_id == 1) continue;
            $module_title	= $val['title'];

            $label 	= $obj->Perm_model->get_tasks ($module_id);
            $parts	= array();

            echo '	<li class="">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$module_title.'<span class="caret"></span></a>
								<ul class="dropdown-menu">';

            foreach ( $label as $k => $v ) {

                $type = $v['perm_type'];
                $title = $v['title'];
                $icon = $v['icon_font'];

                //print_r($v);
                if (empty($icon)) $icon = 'open_in_new';

                $args = $v['perm_data'];
                $json = json_decode($v['perm_data'], true);
                $json['perm_id'] = $v['id'];


                $post_args = http_build_query($json);
                if ($type == 'table') {
                    $url = 'perm/manage_table';
                    $post_args = http_build_query($json);
                } else {
                    //echo 'chocho';
                    //print_r($v);
                    parse_str($post_args, $parts);
                    $url = $v['perm_data'];
                }

                echo '	<li><a href="#" target="' . $v ['perm_target'] . '" action="' . site_url($url) . '" args=\'' . $post_args . '\' label="' . $title . '">
									<i class="material-icons md-light">' . $icon . '</i>
									' . $title . '
								</li>';
            }

            echo '</ul></li>';
        }
    }

?>