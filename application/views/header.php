<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.png"/>

    <title>AfyaData - <?php if (!empty($title)) echo $title; else "Taarifa kwa wakati!"; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- Leaflet, marker cluster js and css -->
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css"/>
    <script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
    <script type="text/javascript"
            src="<?php echo base_url(); ?>assets/public/leaflet/dist/leaflet.markercluster-src.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/leaflet/dist/MarkerCluster.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/leaflet/dist/MarkerCluster.Default.css"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/css/afyadata.css" type="text/css">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/afyadata.js"></script>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?= base_url() ?>assets/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>assets/bootstrap/css/navbar-fixed-top.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/css/form.css" type="text/css">

    <!-- Font awesome css -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <script src="<?php echo base_url(); ?>assets/public/js/jquery-1.12.1.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= anchor("dashboard", '<img src="' . base_url() . 'assets/public/images/logo.png" alt="AfyaData" height="30"/>', 'class="navbar-brand"') ?>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><?= $this->lang->line("nav_item_projects") ?> <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('projects/lists', $this->lang->line("nav_item_list_projects")); ?></li>
                        <li><?php echo anchor('projects/add_new', $this->lang->line("nav_item_add_new_project")); ?></li>
                    </ul>
                </li>

                <?php /*if (perm_module('Xform')) { */ ?><!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><? /*= $this->lang->line("nav_item_forms") */ ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php /*echo anchor('xform/forms', $this->lang->line("nav_item_list_forms")); */ ?></li>
                            <li><?php /*echo anchor('xform/add_new', $this->lang->line("nav_item_add_new_form")); */ ?></li>
                            <li><?php /*echo anchor('xform/searchable_form_lists', $this->lang->line("nav_item_searchable_form")); */ ?></li>
                        </ul>
                    </li>
                --><?php /*} */ ?>

                <?php if (perm_module('Feedback')) { ?>
                    <li><?php echo anchor('feedback/lists', $this->lang->line("nav_item_chats")); ?></li>
                <?php } ?>

                <?php if (perm_module('Ohkr')) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><?= $this->lang->line("nav_item_ohkr") ?> <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header"><?= $this->lang->line("nav_item_manage_diseases") ?></li>
                            <li><?php echo anchor('ohkr/disease_list', $this->lang->line("nav_item_list_disease")); ?></li>
                            <li><?php echo anchor('ohkr/add_new_disease', $this->lang->line("nav_item_add_disease")); ?></li>
                            <li class="divider"></li>
                            <li class="dropdown-header"><?= $this->lang->line("nav_item_manage_symptoms") ?></li>
                            <li><?php echo anchor('ohkr/symptoms_list', $this->lang->line("nav_item_list_symptoms")); ?></li>
                            <li><?php echo anchor('ohkr/add_new_symptom', $this->lang->line("nav_item_create_symptom")); ?></li>
                            <li class="divider"></li>
                            <li class="dropdown-header"><?= $this->lang->line("nav_item_manage_species") ?></li>
                            <li><?php echo anchor('ohkr/species_list', $this->lang->line("nav_item_list_species")); ?></li>
                            <li><?php echo anchor('ohkr/add_new_specie', $this->lang->line("nav_item_create_species")); ?></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (perm_module('Campaign')) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><?= $this->lang->line("nav_item_manage_campaign") ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('campaign/lists', $this->lang->line("nav_item_list_campaign")); ?></li>
                            <li><?php echo anchor('campaign/add_new', $this->lang->line("nav_item_create_campaign")); ?></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php //if (perm_module('Campaign')) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Newsletter Posts
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('blog/post/lists', 'Posts List'); ?></li>
                        <li><?php echo anchor('blog/post/add_new', 'Add New Post'); ?></li>
                    </ul>
                </li>
                <?php //} ?>

                <?php if (perm_module('Whatsapp')) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">WhatsApp db
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('whatsapp/message_list', 'List message'); ?></li>
                            <li><?php echo anchor('whatsapp/import', 'Import file'); ?></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (perm_module('Blog')) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Blog <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('blog/post/new_post', "New Post"); ?></li>
                            <li><?php echo anchor('blog/post/list_posts', "All Posts"); ?></li>
                        </ul>
                    </li>
                <?php } ?>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Lang<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('languageChanger/switchLang/english', 'English'); ?></li>
                        <li><?php echo anchor('languageChanger/switchLang/swahili', 'Swahili'); ?></li>
                    </ul>
                </li>

                <?php if ($this->ion_auth->is_admin()) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><?= $this->lang->line("nav_item_manage_users") ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('auth/users_list', $this->lang->line("nav_item_list_users")); ?></li>
                            <li><?php echo anchor('auth/create_user', $this->lang->line("nav_item_create_user")); ?></li>
                            <li class="divider"></li>
                            <li class="dropdown-header"><?= $this->lang->line("nav_item_manage_facilities") ?></li>
                            <li><?php echo anchor('facilities/lists', $this->lang->line("nav_item_list_facilities")); ?></li>
                            <li><?php echo anchor('facilities/add_new', $this->lang->line("nav_item_add_facility")); ?></li>
                            <li class="divider"></li>
                            <li class="dropdown-header"><?= $this->lang->line("nav_item_manage_user_groups") ?></li>
                            <li><?php echo anchor('auth/group_list', $this->lang->line("nav_item_list_groups")); ?></li>
                            <li><?php echo anchor('auth/create_group', $this->lang->line("nav_item_create_group")); ?></li>
                            <li class="divider"></li>
                            <li class="dropdown-header"><?= $this->lang->line("nav_item_manage_permission") ?></li>
                            <li><?php echo anchor('auth/module_list', $this->lang->line("nav_item_list_module")); ?></li>
                            <li><?php echo anchor('auth/permission_list', $this->lang->line("nav_item_list_permission")); ?></li>
                            <li class="dropdown-submenu">
                                <?php echo anchor('auth/accesscontrol', $this->lang->line("nav_item_acl"), 'tabindex="-1"'); ?>
                                <ul class="dropdown-menu">
                                    <li><?php echo anchor('auth/accesscontrol', "Permissions" . $this->lang->line("")); ?></li>
                                    <li><?php echo anchor('auth/accesscontrol/new_filter', "Add filter" . $this->lang->line("")); ?></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <li class="">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><?php display_full_name(); ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('auth/profile', $this->lang->line("nav_item_my_profile")); ?></li>
                        <li><?php echo anchor('auth/change_password', $this->lang->line("nav_item_change_password")); ?></li>
                        <li><?php echo anchor('auth/logout', $this->lang->line("nav_item_logout")); ?></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>