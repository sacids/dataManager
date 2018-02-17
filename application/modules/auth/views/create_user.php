<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $this->lang->line("create_user_heading") ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('auth/users_list') ?>">Users</a></li>
                <li class="active"><?= $this->lang->line("create_user_heading") ?></li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    echo validation_errors();
                    echo get_flashdata();
                    ?>

                    <?= form_open('auth/create_user', 'role="form"'); ?>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>First name <span style="color: red;">*</span></label>
                            <?= form_input($first_name); ?>
                        </div> <!-- /form-group -->

                        <div class="form-group">
                            <label>Last name <span style="color: red;">*</span></label>
                            <?= form_input($last_name); ?>
                        </div>


                        <div class="form-group">
                            <label>Email <span style="color: red;">*</span></label>
                            <?= form_input($email); ?>
                        </div> <!-- /form-group -->

                        <div class="form-group">
                            <label>Phone <span style="color: red;">*</span></label>
                            <?= form_input($phone); ?>
                        </div>


                        <div class="form-group">
                            <div class="form-group">
                                <label>Username <span style="color: red;">*</span></label>
                                <?= form_input($identity); ?>
                            </div>
                        </div> <!-- /form-group -->

                        <div class="form-group">
                            <label>Password <span style="color: red;">*</span></label>
                            <?= form_password($password); ?>
                        </div> <!-- /form-group -->


                        <div class="form-group">
                            <label>Confirm Password <span style="color: red;">*</span></label>
                            <?= form_password($password_confirm); ?>
                        </div>

                        <div class="form-group">
                            <?= form_submit('submit', 'Create', array('class' => "btn btn-primary")); ?>
                            <?= anchor('auth/users_list', 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                    </div><!--./col-sm-6 -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>User Groups <span style="color: red;">*</span></label><br/>
                            <?php
                            $serial = 1;
                            foreach ($group_list as $group) { ?>
                                <input type="checkbox" name="group[]"
                                       value="<?= $group->id; ?>" <?= set_checkbox('group_id', $group->id); ?>>
                                <?= ucfirst($group->name) . '<br />';
                                $serial++;
                            } ?>
                        </div>
                    </div><!--./col-sm-6 -->
                    <?= form_close(); ?>

                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div><!--./col-sm-12 -->
    </div><!--./row -->
</div><!--./container -->