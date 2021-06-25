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

    <!--chosen select -->
    <link href="<?= base_url('assets/plugins/chosen_v1.8.7/chosen.css') ?>" rel="stylesheet">

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- Leaflet, marker cluster js and css -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js"></script>

    <!--./marker -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.0/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/afyadata.css'); ?>" type="text/css">
    <link href="<?= base_url('assets/css/navbar-fixed-top.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/form.css'); ?>" type="text/css">

    <!--js -->
    <script src="<?= base_url('assets/js/jquery-1.12.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/afyadata.js'); ?>"></script>

    <!-- Chosen JavaScript -->
    <script type="text/javascript" src="<?= base_url('assets/plugins/chosen_v1.8.7/chosen.jquery.js') ?>"></script>

    <script type="application/javascript">
        $(document).ready(function() {
            $('.chosen-select').chosen();
            $('.chosen-select-deselect').chosen({
                allow_single_deselect: true
            });
        });
    </script>
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
                    <?php if (perms_role('Projects', 'lists')) { ?>
                        <li><?php echo anchor('projects/lists', $this->lang->line("nav_item_list_projects")); ?></li>
                    <?php } ?>

                    <?php if ($this->ion_auth->is_admin()) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Brucella <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('brucella/lists', 'Stats'); ?></li>
                                <li><?php echo anchor('brucella/lists', 'Lab Results'); ?></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (perms_class('Ohkr')) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line("nav_item_ohkr") ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php if (perms_role('Ohkr', 'species_list')) { ?>
                                    <li><?php echo anchor('ohkr/species', $this->lang->line("nav_item_list_species")); ?></li>
                                <?php } ?>

                                <?php if (perms_role('Ohkr', 'disease_list')) { ?>
                                    <li><?php echo anchor('ohkr/diseases', $this->lang->line("nav_item_list_disease")); ?></li>
                                <?php } ?>

                                <?php if (perms_role('Ohkr', 'symptoms_list')) { ?>
                                    <li><?php echo anchor('ohkr/symptoms', $this->lang->line("nav_item_list_symptoms")); ?></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php }  ?>

                    <?php if (perms_role('Feedback', 'lists')) {  ?>
                        <li><?php echo anchor('feedback/lists', $this->lang->line("nav_item_chats")); ?></li>
                    <?php }  ?>

                    <?php if (perms_role('Whatsapp', 'message_list')) {  ?>
                        <li><?= anchor('feedback/whatsapp/message_list', 'Whatsapp') ?></li>
                    <?php }  ?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line("nav_item_language") ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo anchor('languageChanger/switchLang/english', $this->lang->line("nav_item_language_english")); ?></li>
                            <li><a href="#">Portuguese</a></li>
                        </ul>
                    </li>

                    <?php if ($this->ion_auth->is_admin()) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line("nav_item_manage_users") ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php if (perms_role('Users', 'lists')) {  ?>
                                    <li><?php echo anchor('auth/users/lists', $this->lang->line("nav_item_list_users")); ?></li>
                                <?php }  ?>

                                <?php if (perms_role('Groups', 'lists')) {  ?>
                                    <li><?php echo anchor('auth/groups/lists', $this->lang->line("nav_item_list_groups")); ?></li>
                                <?php }  ?>
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