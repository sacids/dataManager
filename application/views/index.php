<section class="bg-light-grey">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 main">
                <div id="header-title">
                    <h3 class="title"><?= $this->lang->line("nav_item_dashboard") ?></h3>
                </div>

                <div class="row">
                    <div class="col-sm-9">
                        <!-- Graphic timeline of submission -->
                        <div class="">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b><?= $this->lang->line("label_graphical_submission") ?></b>
                                </div>
                                <div class="panel-body">

                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab"
                                                              href="#overall"><?= $this->lang->line("label_graph_period_overall") ?></a>
                                        </li>
                                        <li><a data-toggle="tab"
                                               href="#monthly"><?= $this->lang->line("label_graph_period_monthly") ?></a>
                                        </li>
                                        <li><a data-toggle="tab"
                                               href="#weekly"><?= $this->lang->line("label_graph_period_weekly") ?></a>
                                        </li>
                                        <li><a data-toggle="tab"
                                               href="#daily"><?= $this->lang->line("label_graph_period_daily") ?></a>
                                        </li>
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
                            <div class="panel panel-tile info-block">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-5 ph10 text-center ">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="col-xs-7">
                                            <h2><?= (isset($active_users) ? $active_users : '0'); ?></h2>
                                            <h6><?= $this->lang->line("label_data_collectors") ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div><!--./panel -->

                            <div class="panel panel-tile info-block">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-5 text-center ">
                                            <i class="fa fa-file-excel-o"></i>
                                        </div>
                                        <div class="col-xs-7">
                                            <h2><?= (isset($published_forms) ? $published_forms : '0') ?></h2>
                                            <h6><?= $this->lang->line("label_published_forms") ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div><!--./panel -->

                            <div class="panel panel-tile info-block">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-5 ph10 text-center ">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        <div class="col-xs-7">
                                            <h2><?= (isset($active_campaign) ? $active_campaign : '0') ?></h2>
                                            <h6><?= $this->lang->line("label_active_campaigns") ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div><!--./panel -->

                            <div class="panel panel-tile info-block">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-5 ph10 text-center ">
                                            <i class="fa fa-comments"></i>
                                        </div>
                                        <div class="col-xs-7">
                                            <h2><?= (isset($new_feedback) ? number_format($new_feedback) : '0'); ?></h2>
                                            <h6><?= $this->lang->line("label_user_chats") ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div><!--./panel -->
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-9">
                        <!-- Latest user chats -->
                        <div class="">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b><?= $this->lang->line("label_recent_user_chats") ?></b>
                                </div>
                                <div class="panel-body">
                                    <div class="card-chat">
                                        <ul>
                                            <?php foreach ($feedback as $value) { ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <span class="title"><?= strtoupper($value->title) ?></span>
                                                            <br>
                                                            <span class="name"><?= ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) ?></span>
                                                            <span
                                                                    class="time"><?= '<i class="fa fa-clock-o"></i> ' . time_ago($value->date_created); ?></span>
                                                            <br>
                                                            <span class="msg"><?= $value->message ?></span>
                                                            <br/><span
                                                                    class="pull-right"><?= anchor('feedback/user_feedback/' . $value->instance_id, '<i class="fa fa-comments-o fa-lg "></i>') ?></span>
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
                                <div class="panel-heading">
                                    <b><?= $this->lang->line("label_frequently_detected_disease") ?></b></div>
                                <div class="panel-body">
                                        <?php if (isset($detected_diseases) && $detected_diseases) { ?>
                                        <ul class="list-group">
                                            <?php foreach ($detected_diseases as $value) { ?>
                                                <li class="list-group-item"><?= $value->disease->title ?></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
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
                    text: '<?=$this->lang->line("label_graph_title")?>'
                },
                xAxis: {
                    categories: <?php echo $form_title;?>
                },
                yAxis: {
                    title: {
                        text: '<?=$this->lang->line("label_form_submitted")?>'
                    }
                },
                series: [{
                    name: '<?php echo $this->lang->line("label_graph_series_name"); ?>',
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

