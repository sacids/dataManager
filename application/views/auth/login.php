<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AfyaData | <?php if (!empty($title)) echo $title; else "AfyaData Manager"; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.png"/>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link
        href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
        rel='stylesheet' type='text/css'>
    <link
        href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/bootstrap/font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/login.css" type="text/css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.png" type="image/png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body>
<div class="overlay"></div>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= anchor("dashboard", '<img src="' . base_url() . 'assets/public/images/logo.png" alt="AfyaData" height="30"/>', 'class="navbar-brand"') ?>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url(); ?>afyaDataV1-Beta.apk" download>
                        <button class="btn btn-danger">Download App</button>
                    </a></li>
            </ul>
        </div>

    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">

            <div class="col-sm-7">
                <h2 class="title">AFYADATA Manager</h2>

                <p class="text-faded">Afyadata Manager is a tool that analyzes all the data collected from the field
                    and intelligently sends feedback to the data collector and sends an alert to higher authority
                    officials if any abnormal pattern is discovered in the data collected, this tool provides a
                    graphical
                    user interface for involved health stakeholders to analyze and visualizing data collected via
                    Afyadata
                    mobile app for android.</p>

            </div>

            <div class="col-sm-5">
                <div class="default-padding">
                    <div class="panel panel-default ">
                        <div class="panel-body">
                            <div id="infoMessage" style="color: red;"><?php echo $message; ?></div>
                            <form action="<?php echo site_url('auth/login'); ?>" class="form-horizontal" role="form"
                                  method="post" accept-charset="utf-8">

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input class="form-control" id="identity" placeholder="Username" required=""
                                               type="text" name="identity">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input class="form-control" id="password" placeholder="Password" required=""
                                               name="password" type="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class=" col-lg-12">
                                        <button type="submit" class="btn btn-danger btn-small btn-block">Login</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-6">
                                        <a href="<?= site_url() ?>auth/forgot_password">Forgot password</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>


            </div>
        </div>

    </div>
</div>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
</body>
</html>