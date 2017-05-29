<div class="container" id="content-middle">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Change Password</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Change password</li>
            </ol>

            <div class="col-sm-12">
                <?php if (validation_errors() != "") {
                    echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                } else if ($this->session->flashdata('message') != "") {
                    echo $this->session->flashdata('message');
                } ?>

                <?php echo form_open("auth/change_password", 'role="form"'); ?>
                <div class="form-group">
                    <?php echo lang('change_password_old_password_label', 'old_password'); ?>
                    <?php echo form_input($old_password); ?>
                </div>

                <div class="form-group">
                    <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?></label>
                    <?php echo form_input($new_password); ?>
                </div>

                <div class="form-group">
                    <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?>
                    <?php echo form_input($new_password_confirm); ?>
                </div>

                <?php echo form_input($user_id); ?>

                <div class="form-group">
                    <?php echo form_submit('submit', lang('change_password_submit_btn'), "class='btn btn-primary'"); ?>
                </div>
                <?php echo form_close(); ?>

            </div>
        </div>

    </div>
</div>



