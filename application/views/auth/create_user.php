<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?php echo $this->lang->line("create_user_heading") ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('auth/users_list') ?>">Manage users</a></li>
                <li class="active">Create new user</li>
            </ol>


            <div class="col-sm-12">
                <?php if (validation_errors() != "") {
                    echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                } else if ($this->session->flashdata('message') != "") {
                    echo $this->session->flashdata('message');
                } ?>

                <?php echo form_open('auth/create_user', 'role="form"'); ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>First name <span style="color: red;">*</span></label>
                        <?php echo form_input($first_name); ?>
                    </div>

                    <div class="form-group">
                        <label>Last name <span style="color: red;">*</span></label>
                        <?php echo form_input($last_name); ?>
                    </div>


                    <div class="form-group">
                        <label>Email <span style="color: red;">*</span></label>
                        <?php echo form_input($email); ?>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <?php echo form_input($phone); ?>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Username <span style="color: red;">*</span></label>
                        <?php echo form_input($identity); ?>
                    </div>

                    <div class="form-group">
                        <label>Group <span style="color: red;">*</span></label>
                        <?php
                        $group_options = array();
                        foreach ($group_list as $value) {
                            $group_options[$value->id] = $value->name;
                        }
                        $group_options = array('' => 'Choose group') + $group_options;
                        echo form_dropdown('group', $group_options, set_value('group'), 'class="form-control"'); ?>
                    </div>

                    <div class="form-group">
                        <label>Password <span style="color: red;">*</span></label>
                        <?php echo form_password($password); ?>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password <span style="color: red;">*</span></label>
                        <?php echo form_password($password_confirm); ?>
                    </div>

                    <div class="form-group">
                        <?php echo form_submit('submit', 'Create user', array('class' => "btn btn-primary")); ?>
                        <?php echo form_submit('cancel', 'Cancel', array('class' => "btn btn-warning")); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>