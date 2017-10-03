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
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/creative.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/css/form.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/css/afyadata.css" type="text/css">

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery.easing.min.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery.fittext.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap/js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url() ?>assets/bootstrap/js/creative.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <?php if (isset($events_map)): ?>
        <style type="text/css">
            #map {
                margin-top: 0px;
                min-height: 500px;
                height: 100%;
                background-color: gainsboro;
            }

            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .container-full {
                margin: 0;
                width: 100%;
                padding: 0;
                height: 100%;
                z-index: -1;
            }

            #mainNav {
                background-color: rgba(255, 255, 255, 0.3);
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function () {

                $("#hideShowEventDataArea").hide();

                $("#closeDataAreaBtn").on("click", function (e) {
                    e.preventDefault();
                    $("#hideShowEventDataArea").hide(1000);
                });

                var tableName = $("#availablePublicForms option:eq(1)").val();

                $("a#eventsListView").on("click", function (e) {
                    e.preventDefault();
                    $("#hideShowEventDataArea").toggle(1000);
                    loadReportedEvents(tableName, null);
                });

                function loadReportedEvents(tableName, currentPage = null) {
                    var dataUrl = "<?= base_url("welcome/get_events") ?>";

                    if (currentPage !== null) {
                        dataUrl += "/" + currentPage;
                    }

                    $.ajax({
                        url: dataUrl,
                        type: "post",
                        dataType: 'json',
                        data: {
                            table_name: tableName
                        },
                        success: function (data) {
                            $("#notificationBar").html("");

                            var html = '<div class=""> <h3 class="title">Events</h3>';

                            if (data.status == "success" && data.events_count > 0) {
                                var reportedEvents = data.events;
                                var table = '<table class="table table-responsive table-bordered">';

                                table += "<tr class='bg-primary'>" +
                                    "<th>Event</th>" +
                                    "<th>Symptoms</th>" +
                                    "<th>Date</th>" +
                                    "</tr>";

                                $.each(reportedEvents, function (i, singleEvent) {
                                    table += "<tr>" +
                                        "<td>" + singleEvent._xf_72485ff63b11061b01c236b9c62b58bd + "</td>" +
                                        "<td>" + singleEvent._xf_300dd0bbe98836946e681905250e2390 + "</td>" +
                                        "<td>" + singleEvent.meta_start + "</td>" +
                                        "</tr>";
                                });

                                table += '</table>';
                                html += table;

                                if (data.links.trim()) {
                                    html += '<div style="margin-top: 0px;">' + data.links + '</div>';
                                }
                            }
                            html += '</div>';

                            $("div#content-area").html(html);
                            $("div#eventsDataArea").html(html);
                            $("#hideShowEventDataArea").show("slow");

                            if (data.links.trim()) {
                                $("li.pagination-link a").on("click", function (e) {
                                    e.preventDefault();
                                    var currentPage = $(this).attr("data-ci-pagination-page");
                                    loadReportedEvents(tableName, currentPage);
                                });
                            }
                        },
                        beforeSend: function () {
                            $("#formsListArea").html("");
                            $("#notificationBar").html('<?=display_message("<i class=\"fa fa-spinner fa-refresh fa-spin fa-1x\" aria-hidden=\"true\"></i> Getting forms, Please wait... ")?>');
                        },
                        error: function () {
                        },
                    });
                }

                $("#availablePublicForms").change(function () {
                    var selectedTableId = $(this).val();
                    loadReportedEvents(selectedTableId);
                });
            });

        </script>
    <?php endif; ?>

</head>

<body id="page-top">

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
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
                <?php if (isset($about_page) && $about_page): ?>
                    <li><a class="page-scroll" href="#about">About AfyaData</a></li>
                    <li><a class="page-scroll" href="#features">Features</a></li>
                    <li><a class="page-scroll" href="#involved">Get Involved</a></li>
                    <li><a class="page-scroll" href="#contact">Contact</a></li>
                <?php else: ?>
                    <li><?= anchor("welcome/about", "Learn more", 'class="page-scroll"') ?></li>
                <?php endif; ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($events_map)): ?>
                    <li class="btn-link"><?= anchor("#eventsModal", '<i class="fa fa-list"></i>', 'class="btn btn-sm btn-dark-orange" id="eventsListView" data-toggle="modal" data-target="#eventsModal"') ?></li>
                <?php endif; ?>

                <?php if (!$this->ion_auth->logged_in()): ?>
                    <li class="btn-link"><?= anchor("auth/login", 'Login', 'class="btn btn-sm btn-dark-orange"') ?></li>
                    <li class="btn-link"><?= anchor("auth/sign_up", 'Sign up', 'class="btn btn-sm btn-maroon"') ?></li>
                <?php else: ?>
                    <li class="btn-link"><?= anchor("auth/logout", 'Logout', 'class="btn btn-sm btn-maroon"') ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>