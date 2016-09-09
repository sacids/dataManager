<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3>Dashboard</h3>
            </div>

            <div class="row">

                <div class="col-sm-3 col-xl-3">
                    <a href="<?php echo site_url('auth/users_list') ?>">
                        <div class="panel panel-tile info-block info-block-bg-system">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-5 ph10 text-center ">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="col-xs-7 pl35 prn text-center">
                                        <h2><?php echo $active_users; ?></h2>
                                        <h6>Active users</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3">
                    <a href="<?php echo site_url('xform/forms') ?>">
                        <div class="panel panel-tile info-block info-block-bg-success">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-5 text-center ">
                                        <i class="fa fa-file-excel-o"></i>
                                    </div>
                                    <div class="col-xs-7 pl35 prn text-center">
                                        <h2><?php echo $published_forms; ?></h2>
                                        <h6>Published forms</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3 col-xl-3">
                    <a href="<?php echo site_url('campaign/lists') ?>">
                        <div class="panel panel-tile info-block info-block-bg-info">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-5 ph10 text-center ">
                                        <i class="fa fa-bullhorn"></i>
                                    </div>
                                    <div class="col-xs-7 pl35 prn text-center">
                                        <h2><?php echo $active_campaign; ?></h2>
                                        <h6>Active campaign</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3 col-xl-3">
                    <a href="<?php echo site_url('feedback/lists') ?>">
                        <div class="panel panel-tile info-block info-block-bg-warning">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-5 ph10 text-center ">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="col-xs-7 pl35 prn text-center">
                                        <h2><?php echo $new_feedback; ?></h2>
                                        <h6>User chats</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Submitted Forms</h3>

                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Overall</h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($submitted_forms as $form) {
                                    echo '<p>' . $form->title . ' - <b>' . $form->overall_form . '</b></p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= date('F Y'); ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($submitted_forms as $form) {
                                    echo '<p>' . $form->title . ' - <b>' . $form->monthly_form . '</b></p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php
                                $today = date('Y-m-d');
                                $last = date('Y-m-d', strtotime("-7 day", strtotime($today)));
                                ?>
                                <h3 class="panel-title">
                                    <?= date('M j', strtotime($last)) . ' - ' . date('M j, Y', strtotime($today)) ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($submitted_forms as $form) {
                                    echo '<p>' . $form->title . ' - <b>' . $form->weekly_form . '</b></p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php $today = date('Y-m-d'); ?>
                                <h3 class="panel-title"><?= date('F j, Y', strtotime($today)) ?></h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($submitted_forms as $form) {
                                    echo '<p>' . $form->title . ' - <b>' . $form->daily_form . '</b></p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
</div>

