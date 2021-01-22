<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AfyaData - Addressing one health security at community level through technology!</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/bootstrap/img/favicon.png" />

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link
        href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
        rel='stylesheet' type='text/css'>
    <link
        href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/bootstrap/font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/creative.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top">AfyaData</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a class="page-scroll" href="#about">About AfyaData</a></li>
                <li><a class="page-scroll" href="#features">Features</a></li>
                <li>
                    <a class="page-scroll" href="<?php echo base_url(); ?>afyaDataV1-Beta.apk" download>Download App</a>
                </li>
                <li><a class="page-scroll" target="_blank" href="<?php echo site_url('auth/login');?>">Go to demo</a></li>
                <li><a class="page-scroll" href="#contact">Contact</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<header>
    <div class="overlay"></div>
    <div class="header-content">
        <div class="header-content-inner">
            <h1>AfyaData</h1>
            <hr>
            <p>Afya Data is a mobile app inspired by ODK Collect, developed by Southern African Centre for Infectious Disease.

                Surveillance (SACIDS) for collecting, submitting, receiving and/or tracking feedback of submitted health data.</p>
            <!--<a href="<?php echo site_url('auth/login'); ?>" class="btn btn-primary btn-xl page-scroll">Go to demo</a>-->
        </div>
    </div>
</header>

<section class="bg-primary" id="about">
    <div class="container">
        <div class="row">

            <div class="col-lg-6">
                <h2 class="section-heading">AfyaData Manager</h2>

                <p class="text-faded">Afyadata Manager is a tool that analyzes all the data collected from the field and
                    intelligently sends feedback to the data collector and sends an alert to higher authority officials
                    if any abnormal pattern is discovered in the data collected, this tool provides a graphical user
                    interface for involved health stakeholders to analyze and visualizing data collected via Afyadata
                    mobile app for android.</p>

                <strong>How does AfyaData Manager works?</strong>
                <p class="text-faded">This application works together with the android AfyaData App, where you use
                    the mobile app to collect data in the field and later on you send them to the server
                    (Afyadata Manager application) for further processing. When the data gets into the server
                    it is analyzed immediately using the natural intelligence build in to detect any indicators
                    of abnormal pattern, if found an alert is sent immediately to respective health
                    experts / respond team and sending tips back to the data collector while further actions are
                    to be taken. </p>


            </div>

            <div class="col-lg-6">
                <h2 class="section-heading">AfyaData Mobile</h2>

                <p class="text-faded">This is open source tools for collecting, submitting data from health facilities
                    to the main server and receiving feedback from main server. This customized version of ODK Collect
                    which have best form management modules. This app works together with server side which accepts
                    data, storing to the database and analyzing the database for making decision from submitted
                    data.</p>

                <strong>How does AfyaData Mobile works?</strong>
                <p class="text-faded">The app works as a client, where by users from field can collect and submit
                    data to the central server via Internet connection as well as receiving feedback of submitted
                    data from the server/experts. While collecting data, phone can be offline without affecting
                    the process also has a capability of including GPS location and photo to a collected data. </p>


            </div>
        </div>
    </div>
</section>

<section id="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">AfyaData Features</h2>
                <hr class="primary">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-th-list wow bounceIn text-primary"></i>
                    <h3>Forms Management</h3>
                    <p class="text-muted">Involves add new form, list available forms and delete form in AfyaData
                        Manager</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-cloud-upload wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3>Forms Submission</h3>
                    <p class="text-muted">Involves submitting form data from AfyaData Mobile to AfyaData Manager.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-comments-o wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3>Feedbacks</h3>
                    <p class="text-muted">Involves getting feedback in AfyaData Mobile of submitted data from AfyaData
                        Manager.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-line-chart wow bounceIn text-primary" data-wow-delay=".3s"></i>
                    <h3>Data Visualization</h3>
                    <p class="text-muted">Involved graphical and mapping representation of submmitted data in AfyaData
                        Manager.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="no-padding" id="portfolio">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo base_url();?>assets/bootstrap/img/screenshots/afyadataone.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                AfyaData
                            </div>
                            <div class="project-name">
                                Addressing one health security at community level through technology!
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo base_url();?>assets/bootstrap/img/screenshots/afyadatatwo.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                AfyaData
                            </div>
                            <div class="project-name">
                                Addressing one health security at community level through technology!
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo base_url();?>assets/bootstrap/img/screenshots/afyadatathree.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                AfyaData
                            </div>
                            <div class="project-name">
                                Addressing one health security at community level through technology!
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

<aside class="bg-primary">
    <div class="container text-center">
        <div class="call-to-action">
            <h2>Addressing one health security at community level through technology!</h2>
            <a href="<?php echo base_url(); ?>afyaDataV1-Beta.apk" class="btn btn-default btn-xl wow tada">
                <i class="fa fa-android fa-lg"></i> Download App Now!</a>
        </div>
    </div>
</aside>

<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading">Let's Get In Touch!</h2>
                <hr class="primary">
                <p>Need assistance on using AfyaData? That's great! Give us a call or send us an email and we
                    will get back to you as soon as possible!</p>
            </div>
            <div class="col-lg-4 col-lg-offset-2 text-center">
                <i class="fa fa-phone fa-3x wow bounceIn"></i>
                <p>+255 783 555 386</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                <p><a href="mailto:afyadata@sacids.org">afyadata@sacids.org</a></p>
            </div>
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="assets/bootstrap/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="assets/bootstrap/js/jquery.easing.min.js"></script>
<script src="assets/bootstrap/js/jquery.fittext.js"></script>
<script src="assets/bootstrap/js/wow.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="assets/bootstrap/js/creative.js"></script>

</body>

</html>
