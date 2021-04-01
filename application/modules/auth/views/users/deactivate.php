<!-- Begin Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Deactivate User</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('users/lists') ?>">Users</a></li>
                <li class="breadcrumb-item active">Deactivate user</li>
            </ol>

            <div class="row">
                <div class="col-lg-12">
                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="pure-form">
                        <?= form_open(uri_string()); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First name <span style="color: red;">*</span></label>
                                    <?php echo form_input($first_name); ?>
                                </div>
                            </div>
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last name <span style="color: red;">*</span></label>
                                    <?php echo form_input($last_name); ?>
                                </div>
                            </div>
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Deactivate <span style="color: red;">*</span></label><br />
                                    <?php echo lang('deactivate_confirm_y_label', 'confirm'); ?>
                                    <input type="radio" name="confirm" value="yes" checked="checked" /><br />

                                    <?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
                                    <input type="radio" name="confirm" value="no" />
                                </div>
                            </div>
                        </div>
                        <!--./row -->

                        <?php echo form_hidden($csrf); ?>
                        <?php echo form_hidden(array('id' => $user->id)); ?>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                                    <?= anchor('auth/users/lists', 'Cancel', 'class="btn btn-warning"') ?>
                                </div>
                            </div>
                        </div>
                        <!--./row -->
                        <?= form_close(); ?>
                    </div>
                    <!--./pure-form -->
                </div>
                <!--./col-lg-12 -->
            </div>
            <!--./row -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->