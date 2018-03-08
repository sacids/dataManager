<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add New Permission</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/accesscontrol') ?>">User Permissions</a></li>
                <li class="active">Add New Permission</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open("auth/accesscontrol/new_permission") ?>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Permission name <span style="color: red">*</span></label>
                            <?= form_input($name) ?>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <?= form_textarea($description) ?>
                        </div>

                        <div class="form-group">
                            <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                            <?= anchor('auth/accesscontrol', 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                    </div><!--./col-md-6 -->
                    <?= form_close() ?>

                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div><!--./row -->
</div><!--./container -->
