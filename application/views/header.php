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
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.png" />

    <title>AfyaData - <?= (!empty($title)) ? $title : config_item("site_name"); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Font awesome css -->
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- Leaflet, marker cluster js and css -->
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/public/leaflet/dist/leaflet.markercluster-src.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/leaflet/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/leaflet/dist/MarkerCluster.Default.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/afyadata.css'); ?>" type="text/css">
    <link href="<?= base_url('assets/css/navbar-fixed-top.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/form.css'); ?>" type="text/css">

    <!--js -->
    <script src="<?= base_url('assets/js/jquery-1.12.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/afyadata.js'); ?>"></script>
</head>

<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?= anchor("dashboard", '<img src="' . base_url() . 'assets/public/images/logo.png" alt="AfyaData" height="25"/>', 'class="navbar-brand"') ?>

            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line("nav_item_projects") ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php

                            $projects = $this->session->userdata("projects");

                            if (!empty($projects)) {
                                foreach ($projects as $project) {
                                    echo "<li>" . anchor('projects/forms/' . $project->id, $project->title) . "</li>";
                                }
                            }

                            ?>
                            <li><?php echo anchor('projects/lists', $this->lang->line("nav_item_list_projects")); ?></li>
                            <li><?php echo anchor('projects/add_new', $this->lang->line("nav_item_add_new_project")); ?></li>
                        </ul>
                    </li>

                    <?php //if (perm_module('Feedback')) { 
                    ?>
                    <li><?php echo anchor('feedback/lists', $this->lang->line("nav_item_chats")); ?></li>
                    <?php //} 
                    ?>

                    <?php //if (perm_module('Ohkr')) { 
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line("nav_item_ohkr") ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('ohkr/diseases', $this->lang->line("nav_item_list_disease")); ?></li>
                            <li><?php echo anchor('ohkr/symptoms', $this->lang->line("nav_item_list_symptoms")); ?></li>
                            <li><?php echo anchor('ohkr/species', $this->lang->line("nav_item_list_species")); ?></li>
                        </ul>
                    </li>
                    <?php //} 
                    ?>


                    <?php //if (perm_module('Blog')) { 
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('blog/post/new_post', "New Post"); ?></li>
                            <li><?php echo anchor('blog/post/list_posts', "All Posts"); ?></li>
                        </ul>
                    </li>
                    <?php //} 
                    ?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line("nav_item_language") ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo anchor('languageChanger/switchLang/english', $this->lang->line("nav_item_language_english")); ?></li>
                            <li><?php echo anchor('languageChanger/switchLang/swahili', $this->lang->line("nav_item_language_swahili")); ?></li>
                        </ul>
                    </li>

                    <?php if ($this->ion_auth->is_admin()) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line("nav_item_manage_users") ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('auth/users_list', $this->lang->line("nav_item_list_users")); ?></li>
                                <li><?php echo anchor('auth/group_list', $this->lang->line("nav_item_list_groups")); ?></li>
                                <li class="divider"></li>
                                <li><?php echo anchor('auth/accesscontrol', $this->lang->line("nav_item_acl")); ?></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <li class="">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-circle" aria-hidden="true"></i> <?php display_full_name(); ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('auth/profile', $this->lang->line("nav_item_my_profile")); ?></li>
                            <li><?php echo anchor('auth/change_password', $this->lang->line("nav_item_change_password")); ?></li>
                            <li class="divider"></li>
                            <li><?= anchor('auth/logout', '<i class="fa fa-sign-out fa-fw"></i>' . $this->lang->line("nav_item_logout")); ?></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>