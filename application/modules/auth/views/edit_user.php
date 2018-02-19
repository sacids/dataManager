<div class="container" id="content-middle">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit user</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/users_list') ?>">Users</a></li>
                <li class="active">Edit user</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open(uri_string(), 'role="form"'); ?>
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
                            <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                            <?= anchor('auth/users_list', 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                    </div><!--./col-sm-6 -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>User Groups <span style="color: red;">*</span></label><br/>
                            <?php foreach ($groups as $group): ?>
                                <?php
                                $gID = $group['id'];
                                $checked = null;
                                $item = null;
                                foreach ($currentGroups as $grp) {
                                    if ($gID == $grp->id) {
                                        $checked = ' checked="checked"';
                                        break;
                                    }
                                }
                                ?>
                                <input type="checkbox" name="groups[]"
                                       value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                                <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <?php endforeach ?>
                        </div>
                    </div><!--./col-sm-6 -->
                    <?= form_close(); ?>

                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div><!--./col-sm-12 -->
    </div><!--./row -->
</div><!--./container -->