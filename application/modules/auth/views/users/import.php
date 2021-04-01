<section>
    <div class="container" id="content-middle">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 main">
                <div id="header-title">
                    <h3 class="title">Import Users</h3>
                </div>

                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li>
                        <?php if (get_current_user_level_id() == 3)
                            echo '<a href="' . site_url('dashboard/stats') . '"><i class="fa fa-home"></i> Dashboard</a>';
                        else
                            echo '<a href="' . site_url('dashboard') . '"><i class="fa fa-home"></i> Dashboard</a>';
                        ?>
                    </li>
                    <li><a href="<?= site_url('auth/users/lists') ?>">Users</a></li>
                    <li class="active">Import users</li>
                </ol>

                <div class="row">
                    <div class="col-lg-2">
                        <?php $this->load->view('auth/menu') ?>
                    </div>
                    <div class="col-lg-10">
                        <?php if (validation_errors() != "") {
                            echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                        }
                        if ($this->session->flashdata('message') != "") {
                            echo $this->session->flashdata('message');
                        }
                        if ($error != '') {
                            echo '<div class="alert alert-danger fade in">' . $error . '</div>';
                        } ?>

                        <?= form_open_multipart('auth/users/import', 'class="form-horizontal" role="form"'); ?>
                        <div class="pure-form">
                            <div style="display: inline-block; float: right; padding-right: 10px;">
                                <a href="<?= base_url(); ?>assets/uploads/import_users_sample.xls" download>Download
                                    Template (.xls)</a>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Users File <span style="color: red;">*</span></label>
                                        <?php echo form_input($attachment); ?>
                                    </div>
                                </div>
                            </div> <!-- /.row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?= form_submit('submit', 'Import', array('class' => "btn btn-primary")); ?>
                                        <?= anchor('auth/users/lists', 'Cancel', 'class="btn btn-warning"') ?>
                                    </div>
                                </div>
                            </div> <!-- /.row -->
                        </div><!-- /.pure-form -->
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

