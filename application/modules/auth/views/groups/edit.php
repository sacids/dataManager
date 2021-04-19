<!-- Begin Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit role</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('auth/groups/lists') ?>">Role</a></li>
                <li class="breadcrumb-item active">Edit role</li>
            </ol>


            <div class="row">
                <div class="col-lg-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="pure-form">
                        <?= form_open(uri_string()); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Role Name <span style="color: red;">*</span></label>
                                    <?= form_input($group_name); ?>
                                    <span class="red"><?= form_error('group_name'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Description <span style="color: red;">*</span></label>
                                    <?= form_textarea($group_description); ?>
                                    <span class="red"><?= form_error('group_description'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?= form_submit('submit', 'Save', array('class' => "btn btn-primary btn-sm")); ?>
                                    <?= anchor('auth/groups/lists', 'Cancel', 'class="btn btn-danger btn-sm"') ?>
                                </div>
                            </div>
                        </div>
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