<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">My Profile</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">My profile</li>
            </ol>

            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div id="header-title" style="" class="text-center">
                        <div style="width: auto; float: left; display: inline-block;">
                            <img src="<?php echo base_url(); ?>assets/public/images/profile.png"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9">
                    <div class="table table-responsive">

                        <div class="panel panel-default">
                            <div class="panel-heading"><b>About me</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-responsive table-hover">
                                    <tr>
                                        <td>Name</td>
                                        <td><?php echo $fname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Username</td>
                                        <td><?php echo $username; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Phone</td>
                                        <td><?php echo $phone; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td><?php echo $phone; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><?php
                                            if ($status == '1') {
                                                echo 'Active';
                                            } else {
                                                echo 'Inactive';
                                            }
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <td>Created on</td>
                                        <td><?php echo $created; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last Login</td>
                                        <td><?php echo $last_login; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
