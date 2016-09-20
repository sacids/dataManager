<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>AfyaData - Taarifa kwa wakati!</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.png"/>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link
        href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
        rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/font-awesome/css/font-awesome.min.css"
          type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/login.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= anchor("", '<img src="' . base_url() . 'assets/public/images/logo_default.png" alt="AfyaData" height="30"/>', 'class="navbar-brand"') ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="btn-link"><a href="#" class="btn btn-sm btn-maroon">Download App</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>


<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">

            <div class="col-sm-7">
                <h2 class="title">AFYADATA | Taarifa kwa wakati!</h2>

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

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>

            </div>
        </div>

    </div>
</div>


<!-- jQuery -->
<script src="<?= base_url() ?>assets/bootstrap/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
