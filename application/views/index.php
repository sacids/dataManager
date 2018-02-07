<section class="bg-light-grey">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 main">
                <div id="header-title">
                    <h3 class="title">Dashboard</h3>
                </div>

                <div class="row">
                    <div class="col-sm-9">
                        <!-- Graphic timeline of submission -->
                        <div class="">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b>Graphical recent submission</b></div>
                                <div class="panel-body">

                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#overall">Overall</a></li>
                                        <li><a data-toggle="tab" href="#monthly">Monthly</a></li>
                                        <li><a data-toggle="tab" href="#weekly">Weekly</a></li>
                                        <li><a data-toggle="tab" href="#daily">Daily</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="overall" class="tab-pane fade in active">
                                            <div id="overall-graph" style="height: 330px;"></div>
                                        </div>
                                        <div id="monthly" class="tab-pane fade in">
                                            <div id="monthly-graph" style="height: 330px;"></div>
                                        </div>
                                        <div id="weekly" class="tab-pane fade in">
                                            <div id="weekly-graph" style="height: 330px;"></div>
                                        </div>
                                        <div id="daily" class="tab-pane fade in">
                                            <div id="daily-graph" style="height: 330px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="" style="height: inherit;">
                            <a href="<?= site_url('auth/users_list') ?>">
                                <div class="panel panel-tile info-block">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-5 ph10 text-center ">
                                                <i class="fa fa-users"></i>
                                            </div>
                                            <div class="col-xs-7">
                                                <h2><?= (isset($active_users) ? $active_users : '0'); ?></h2>
                                                <h6>Data collectors</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="<?= site_url('xform/forms') ?>">
                                <div class="panel panel-tile info-block">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-5 text-center ">
                                                <i class="fa fa-file-excel-o"></i>
                                            </div>
                                            <div class="col-xs-7">
                                                <h2><?= (isset($published_forms) ? $published_forms : '0') ?></h2>
                                                <h6>Published forms</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="<?= site_url('campaign/lists') ?>">
                                <div class="panel panel-tile info-block">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-5 ph10 text-center ">
                                                <i class="fa fa-bullhorn"></i>
                                            </div>
                                            <div class="col-xs-7">
                                                <h2><?= (isset($active_campaign) ? $active_campaign : '0') ?></h2>
                                                <h6>Active campaign</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="<?= site_url('feedback/lists') ?>">
                                <div class="panel panel-tile info-block">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-5 ph10 text-center ">
                                                <i class="fa fa-comments"></i>
                                            </div>
                                            <div class="col-xs-7">
                                                <h2><?= (isset($new_feedback) ? number_format($new_feedback) : '0'); ?></h2>
                                                <h6>User chats</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-9">
                        <!-- Latest user chats -->
                        <div class="">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b>Recent user chats</b></div>
                                <div class="panel-body">
                                    <div class="card-chat">
                                        <ul>
                                            <?php foreach ($feedback as $value) { ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <span class="name"><?= $value->first_name . ' ' . $value->last_name ?></span>
                                                            <span
                                                                    class="time"><?= time_ago($value->date_created); ?></span>
                                                            <br>
                                                            <span class="msg"><?= $value->message ?></span>
                                                            <br/><span
                                                                    class="pull-right"><?= anchor('feedback/user_feedback/' . $value->instance_id, 'Conversation', 'class="btn btn-primary btn-xs"') ?></span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-sm-3">
                        <!-- Table timeline of submission -->
                        <div class="">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b>Mostly detected diseases</b></div>
                                <div class="panel-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script type="text/javascript">

    //TODO: make function to be called within view

    //Overall data
    $(function () {
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });

        $('#overall-graph').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Overall form submitted'
                },
                xAxis: {
                    categories: <?php echo $form_title;?>
                },
                yAxis: {
                    title: {
                        text: 'Form submitted'
                    }
                },
                series: [{
                    name: '<?php echo 'Submitted forms'; ?>',
                    data: <?php echo $overall_data;?>
                }],
                credits: {
                    enabled: false
                }
            }
        );
    });

    //Monthly data
    $(function () {
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });

        $('#monthly-graph').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Monthly form submitted'
                },
                xAxis: {
                    categories: <?php echo $form_title;?>
                },
                yAxis: {
                    title: {
                        text: 'Form submitted'
                    }
                },
                series: [{
                    name: '<?php echo 'Submitted forms'; ?>',
                    data: <?php echo $monthly_data;?>
                }],
                credits: {
                    enabled: false
                }
            }
        );
    });

    //Weekly data
    $(function () {
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });

        $('#weekly-graph').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Weekly form submitted'
                },
                xAxis: {
                    categories: <?php echo $form_title;?>
                },
                yAxis: {
                    title: {
                        text: 'Form submitted'
                    }
                },
                series: [{
                    name: '<?php echo 'Submitted forms'; ?>',
                    data: <?php echo $weekly_data;?>
                }],
                credits: {
                    enabled: false
                }
            }
        );
    });

    //Weekly data
    $(function () {
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });

        $('#daily-graph').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Daily form submitted'
                },
                xAxis: {
                    categories: <?php echo $form_title;?>
                },
                yAxis: {
                    title: {
                        text: 'Form submitted'
                    }
                },
                series: [{
                    name: '<?php echo 'Submitted forms'; ?>',
                    data: <?php echo $daily_data;?>
                }],
                credits: {
                    enabled: false
                }
            }
        );
    });
</script>

