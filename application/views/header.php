<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/31/2016
 * Time: 10:13 AM
 */
?>

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

    <title>AfyaData | <?php if (!empty($title)) echo $title; else "AfyaData Manager"; ?></title>

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

    <!-- Font awesome css -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

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
                       aria-expanded="false">Forms <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('xform/forms', "List forms"); ?></li>
                        <li><?php echo anchor('xform/add_new', "Add new form"); ?></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Manage users <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('auth/users_list', "List Users"); ?></li>
                        <li><?php echo anchor('auth/create_user', "Create User"); ?></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Manage user groups</li>
                        <li><?php echo anchor('auth/group_list', "List Groups"); ?></li>
                        <li><?php echo anchor('auth/create_group', "Create Group"); ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">OHKR <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Manage diseases</li>
                        <li><?php echo anchor('ohkr/disease_list', "List diseases"); ?></li>
                        <li><?php echo anchor('ohkr/add_new_disease', "Add new disease"); ?></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Manage symptoms</li>
                        <li><?php echo anchor('ohkr/symptoms_list', "List symptoms"); ?></li>
                        <li><?php echo anchor('ohkr/add_new_symptom', "Add new symptoms"); ?></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Manage species</li>
                        <li><?php echo anchor('ohkr/species_list', "List species"); ?></li>
                        <li><?php echo anchor('ohkr/add_new_specie', "Add new specie"); ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Manage Campaign <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('campaign/lists', "List Campaign"); ?></li>
                        <li><?php echo anchor('campaign/add_new', "Add New Campaign"); ?></li>
                    </ul>
                </li>

                <li><?php echo anchor('whatsapp/message_list', "WhatsApp db"); ?></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Blog <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('blog/post/new_post', "New Post"); ?></li>
                        <li><?php echo anchor('blog/post/list_posts', "All Posts"); ?></li>
                    </ul>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li><?php echo anchor('feedback/lists', "Chats"); ?></li>

                <li class="">
                    <a href="./" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><?php echo ucfirst($this->session->userdata("username")) ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('auth/profile', "My Profile"); ?></li>
                        <li><?php echo anchor('auth/change_password', "Change password"); ?></li>
                        <li><?php echo anchor('auth/logout', "Logout"); ?></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>