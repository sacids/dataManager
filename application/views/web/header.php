<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>AfyaData - <?= isset($title) ? $title : 'Taarifa Kwa Wakati!' ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>"/>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- Font awesome css -->
    <link href="<?= base_url('assets/bootstrap/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet"
          type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/animate.min.css') ?>" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/creative.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/public/css/form.css') ?>" type="text/css">


    <!-- jQuery -->
    <script src="<?= base_url('assets/bootstrap/js/jquery.js') ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url('assets/bootstrap/js/creative.js') ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

    <!-- Plugin JavaScript -->
    <script src="<?= base_url('assets/bootstrap/js/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap/js/jquery.fittext.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap/js/wow.min.js') ?>"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top">
<nav id="mainNav" class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= anchor("", '<img src="' . base_url('assets/public/images/logo_default.png') . '" alt="AfyaData" height="30"/>', 'class="navbar-brand"') ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><?= anchor("about", "About AfyaData", 'class="page-scroll"') ?></li>
                <li><?= anchor("about", "Public Forms", 'class="page-scroll"') ?></li>
                <li><?= anchor("newsletters/stories", "Newsletter Stories", 'class="page-scroll"') ?></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="btn-link"><?= anchor("auth/login", '<i class="fa fa-sign-in"></i> Login', 'class="btn btn-maroon"') ?></li>
                <!--<li class="btn-link"><?= anchor("auth/sign_up", '<i class="fa fa-user-plus"></i> Sign up', 'class="btn btn-maroon"') ?></li>-->
            </ul>
        </div>
    </div>
</nav>